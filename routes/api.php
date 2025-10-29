<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\FinancialProductController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


/**
* RUTAS PROTEGIDAS
*/
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    // CRUD ROLES
    Route::get('/roles', [RoleController::class, 'index']);
    Route::post('/roles', [RoleController::class, 'store']);
    Route::put('/roles', [RoleController::class, 'update']);
    Route::delete('/roles', [RoleController::class, 'destroy']);
    // CRUD PRODUCTOS FINANCIEROS
    Route::get('/financialproducts', [FinancialProductController::class, 'index']);
    Route::post('/financialproducts', [FinancialProductController::class, 'store']);
    Route::put('/financialproducts', [FinancialProductController::class, 'update']);
    Route::delete('/financialproducts', [FinancialProductController::class, 'destroy']);
    // CRUD USUARIOS - EMPLEADOS
    Route::get('/users', [UserController::class, 'index']);
    Route::post('/user/{id}', [UserController::class, 'show']);
    Route::post('/user', [UserController::class, 'store']);
    Route::put('/user', [UserController::class, 'update']);
    Route::delete('/user', [UserController::class, 'destroy']);
});

/**
* RUTAS PUBLICAS
*/
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

