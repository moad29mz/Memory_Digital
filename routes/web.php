<?php

use App\Http\Controllers\MemoryController;
use App\Http\Controllers\AuthController;
use App\Exports\MemoriesExport;
use App\Models\Memory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// الصفحة الرئيسية - Login
Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
    return view('auth.custom-login');
})->name('home');

// صفحة التسجيل
Route::get('/register', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
    return view('auth.custom-register');
})->name('register');

// معالجة Login
Route::post('/custom-login', [AuthController::class, 'login'])->name('custom.login');

// معالجة Register
Route::post('/custom-register', [AuthController::class, 'register'])->name('custom.register');

// تغيير اللغة
Route::get('/lang/{locale}', function ($locale) {
    if (in_array($locale, ['ar', 'fr', 'en'])) {
        session(['locale' => $locale]);
        app()->setLocale($locale);
    }
    return redirect()->back();
})->name('lang.switch');

// تسجيل الخروج
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/');
})->name('logout');

// Routes protected (بعد تسجيل الدخول)
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    
    Route::resource('memories', MemoryController::class);
    Route::post('/memories/search', [MemoryController::class, 'search'])->name('memories.search');
    Route::get('/statistics', [MemoryController::class, 'statistics'])->name('statistics');
    Route::get('/memories/{memory}/history', [MemoryController::class, 'history'])->name('memories.history');
    
    Route::get('/export/excel', function () {
        return Excel::download(new MemoriesExport, 'memories-' . date('Y-m-d') . '.xlsx');
    })->name('export.excel');
    
    Route::get('/export/pdf', function () {
        $memories = Memory::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();
        
        $pdf = Pdf::loadView('exports.memories-pdf', compact('memories'));
        return $pdf->download('memories-' . date('Y-m-d') . '.pdf');
    })->name('export.pdf');
});

require __DIR__.'/auth.php';