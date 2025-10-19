<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\CreditController;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('dashboard', [CreditController::class, 'index'])->name('dashboard');
    Route::post('dashboard', [CreditController::class, 'store'])->name('dashboard.store');
    
    Route::get('users', function () { return view('users'); })->name('users');
    Route::get('customers', function () { return view('customers'); })->name('customers');
    Route::get('reports', function () { return view('reports'); })->name('reports');
});

Route::get('/auth/google', [AuthenticatedSessionController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [AuthenticatedSessionController::class, 'handleGoogleCallback']);

Route::get('/auth/github', [AuthenticatedSessionController::class, 'redirectToGithub'])->name('auth.github');
Route::get('/auth/github/callback', [AuthenticatedSessionController::class, 'handleGithubCallback']);

require __DIR__ . '/auth.php';

