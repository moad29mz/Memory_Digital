<?php

use App\Http\Controllers\MemoryController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    
    Route::resource('memories', MemoryController::class);
    Route::post('/memories/search', [MemoryController::class, 'search'])->name('memories.search');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', function () {
        return view('profile.edit');
    })->name('profile.edit');
});

Route::get('/lang/{locale}', function ($locale) {
    if (in_array($locale, ['ar', 'fr', 'en'])) {
        session(['locale' => $locale]);
    }
    return redirect()->back();
})->name('lang.switch');

Route::get('/memories/{memory}/history', [MemoryController::class, 'history'])->name('memories.history');

Route::get('/statistics', [MemoryController::class, 'statistics'])->name('statistics');

require __DIR__.'/auth.php';
