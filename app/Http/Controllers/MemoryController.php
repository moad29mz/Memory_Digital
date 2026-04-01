<?php

namespace App\Http\Controllers;

use App\Models\Memory;
use App\Models\MemoryHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        ]);

        $memory = Memory::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'description' => $request->description,
            'emotion' => $request->emotion,
            'media_path' => null,
            'media_type' => null,
        ]);

        // تسجيل التاريخ والوقت
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
        ]);

        $oldData = $memory->toArray();

        $memory->update([
            'title' => $request->title,
            'description' => $request->description,
            'emotion' => $request->emotion,
        ]);

        // تسجيل التعديل مع التاريخ والوقت
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

        // تسجيل الحذف مع التاريخ والوقت
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

        $memories = $query->orderBy('created_at', 'desc')->get();

        return view('memories.index', compact('memories'));
    }
}