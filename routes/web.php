<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Route::get('credits', function () { return view('credits'); })->name('credits');
    Route::get('users', function () { return view('users'); })->name('users');
    Route::get('customers', function () { return view('customers'); })->name('customers');
    Route::get('reports', function () { return view('reports'); })->name('reports');
});


require __DIR__.'/auth.php';
