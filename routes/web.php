<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\CreditController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return redirect('login');
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
    
    Route::get('users', [UserController::class, 'index'])->name('users');
    Route::post('users', [UserController::class, 'store']);
    Route::put('users', [UserController::class, 'update']);
    Route::delete('users', [UserController::class, 'destroy']);


    Route::get('roles', [RoleController::class, 'index'])->name('roles');
    Route::post('roles', [RoleController::class, 'store']);
    Route::put('roles', [RoleController::class, 'update']);
    Route::delete('roles', [RoleController::class, 'destroy']);
    
    Route::get('clients', [ClientController::class, 'index'])->name('clients');
    Route::post('clients', [ClientController::class, 'store']);
    Route::put('clients', [ClientController::class, 'update']);
    Route::delete('clients', [ClientController::class, 'destroy']);
    
    Route::get('reports', [ReportController::class, 'index'])->name('reports');
});

Route::get('/auth/google', [AuthenticatedSessionController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [AuthenticatedSessionController::class, 'handleGoogleCallback']);

Route::get('/auth/github', [AuthenticatedSessionController::class, 'redirectToGithub'])->name('auth.github');
Route::get('/auth/github/callback', [AuthenticatedSessionController::class, 'handleGithubCallback']);

require __DIR__ . '/auth.php';

