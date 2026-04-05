<?php

namespace App\Http\Controllers;

use App\Models\Memory;
use App\Models\MemoryHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MemoryController extends Controller
{
    public function index()
    {
        $memories = Memory::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();
        return view('memories.index', compact('memories'));
    }

    public function create()
    {
        return view('memories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'emotion' => 'required|string',
            'media' => 'nullable|file|mimes:jpg,jpeg,png,gif,mp4,mp3,wav|max:20480', // 20MB max
        ]);

        $mediaPath = null;
        $mediaType = null;
        $mediaName = null;

        if ($request->hasFile('media')) {
            $file = $request->file('media');
            $mediaName = $file->getClientOriginalName();
            
            // تحديد نوع الملف
            $mimeType = $file->getMimeType();
            if (str_contains($mimeType, 'image')) {
                $mediaType = 'image';
            } elseif (str_contains($mimeType, 'video')) {
                $mediaType = 'video';
            } elseif (str_contains($mimeType, 'audio')) {
                $mediaType = 'audio';
            }
            
            $mediaPath = $file->store('memories', 'public');
        }

        $memory = Memory::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'description' => $request->description,
            'emotion' => $request->emotion,
            'media_path' => $mediaPath,
            'media_type' => $mediaType,
            'media_name' => $mediaName,
        ]);

        MemoryHistory::create([
            'memory_id' => $memory->id,
            'user_id' => Auth::id(),
            'action' => 'created',
            'old_data' => null,
            'new_data' => $memory->toArray(),
        ]);

        return redirect()->route('memories.index')
            ->with('success', 'تم إضافة الذكرى بنجاح');
    }

    public function edit(Memory $memory)
    {
        if ($memory->user_id !== Auth::id()) {
            abort(403);
        }
        return view('memories.edit', compact('memory'));
    }

    public function update(Request $request, Memory $memory)
    {
        if ($memory->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'emotion' => 'required|string',
            'media' => 'nullable|file|mimes:jpg,jpeg,png,gif,mp4,mp3,wav|max:20480',
        ]);

        $oldData = $memory->toArray();
        
        $updateData = [
            'title' => $request->title,
            'description' => $request->description,
            'emotion' => $request->emotion,
        ];

        if ($request->hasFile('media')) {
            // حذف الملف القديم إذا كان موجود
            if ($memory->media_path) {
                Storage::disk('public')->delete($memory->media_path);
            }
            
            $file = $request->file('media');
            $mediaName = $file->getClientOriginalName();
            
            $mimeType = $file->getMimeType();
            if (str_contains($mimeType, 'image')) {
                $updateData['media_type'] = 'image';
            } elseif (str_contains($mimeType, 'video')) {
                $updateData['media_type'] = 'video';
            } elseif (str_contains($mimeType, 'audio')) {
                $updateData['media_type'] = 'audio';
            }
            
            $updateData['media_path'] = $file->store('memories', 'public');
            $updateData['media_name'] = $mediaName;
        }

        $memory->update($updateData);

        MemoryHistory::create([
            'memory_id' => $memory->id,
            'user_id' => Auth::id(),
            'action' => 'updated',
            'old_data' => $oldData,
            'new_data' => $memory->toArray(),
        ]);

        return redirect()->route('memories.index')
            ->with('success', 'تم تعديل الذكرى بنجاح');
    }

    public function destroy(Memory $memory)
    {
        if ($memory->user_id !== Auth::id()) {
            abort(403);
        }

        // حذف الملف من التخزين
        if ($memory->media_path) {
            Storage::disk('public')->delete($memory->media_path);
        }

        MemoryHistory::create([
            'memory_id' => $memory->id,
            'user_id' => Auth::id(),
            'action' => 'deleted',
            'old_data' => $memory->toArray(),
            'new_data' => null,
        ]);

        $memory->delete();

        return redirect()->route('memories.index')
            ->with('success', 'تم حذف الذكرى بنجاح');
    }

    public function search(Request $request)
    {
        $query = Memory::where('user_id', Auth::id());

        if ($request->has('search') && $request->search) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->has('date') && $request->date) {
            $query->whereDate('created_at', $request->date);
        }

        if ($request->has('emotion') && $request->emotion) {
            $query->where('emotion', $request->emotion);
        }

        $memories = $query->orderBy('created_at', 'desc')->get();

        return view('memories.index', compact('memories'));
    }

    public function history(Memory $memory)
{
    if ($memory->user_id !== Auth::id()) {
        abort(403);
    }
    
    $histories = $memory->histories()
        ->with('user')
        ->orderBy('created_at', 'desc')
        ->get();
    
    return view('memories.history', compact('memory', 'histories'));
}

public function statistics()
{
    $userId = Auth::id();
    
    // إحصائيات عامة
    $totalMemories = Memory::where('user_id', $userId)->count();
    $totalImages = Memory::where('user_id', $userId)->where('media_type', 'image')->count();
    $totalVideos = Memory::where('user_id', $userId)->where('media_type', 'video')->count();
    $totalAudios = Memory::where('user_id', $userId)->where('media_type', 'audio')->count();
    
    // إحصائيات الحالة النفسية
    $emotionsStats = [
        'happy' => Memory::where('user_id', $userId)->where('emotion', 'happy')->count(),
        'sad' => Memory::where('user_id', $userId)->where('emotion', 'sad')->count(),
        'excited' => Memory::where('user_id', $userId)->where('emotion', 'excited')->count(),
        'nostalgic' => Memory::where('user_id', $userId)->where('emotion', 'nostalgic')->count(),
        'angry' => Memory::where('user_id', $userId)->where('emotion', 'angry')->count(),
        'calm' => Memory::where('user_id', $userId)->where('emotion', 'calm')->count(),
        'loved' => Memory::where('user_id', $userId)->where('emotion', 'loved')->count(),
    ];
    
    // الذكريات حسب الشهر
    $memoriesByMonth = Memory::where('user_id', $userId)
        ->selectRaw('MONTH(created_at) as month, COUNT(*) as count')
        ->groupBy('month')
        ->orderBy('month')
        ->get();
    
    // آخر 5 ذكريات مضافة
    $recentMemories = Memory::where('user_id', $userId)
        ->orderBy('created_at', 'desc')
        ->limit(5)
        ->get();
    
    return view('memories.statistics', compact(
        'totalMemories', 'totalImages', 'totalVideos', 'totalAudios',
        'emotionsStats', 'memoriesByMonth', 'recentMemories'
    ));
}
}