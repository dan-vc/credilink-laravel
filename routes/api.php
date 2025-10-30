<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ClientController;
use App\Http\Controllers\Api\CreditController;
use App\Http\Controllers\Api\FinancialProductController;
use App\Http\Controllers\Api\PaymentsController;
use App\Http\Controllers\Api\ReportController;
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
    // CRUD CLIENTES
    Route::get('/clients', [ClientController::class, 'index']);
    Route::post('/client/{id}', [ClientController::class, 'show']);
    Route::post('/client', [ClientController::class, 'store']);
    Route::put('/client', [ClientController::class, 'update']);
    Route::delete('/client', [ClientController::class, 'destroy']);
    // CRUD CREDITOS
    Route::get('/credits', [CreditController::class, 'index']);
    Route::post('/credits/{id}', [CreditController::class, 'show']);
    Route::post('/credit', [CreditController::class, 'store']);
    Route::put('/creditstatus', [CreditController::class, 'changeStatus']);
    Route::put('/creditscalcapaid', [CreditController::class, 'calcPaidBalance']);
    // CRUD PAGOS
    Route::get('/payments', [PaymentsController::class, 'index']);
    Route::post('/payment/{id}', [PaymentsController::class, 'show']);
    Route::post('/showspayscredit/{id}', [PaymentsController::class, 'showsPaysCredit']);
    Route::put('/payment', [PaymentsController::class, 'payPayment']);
    Route::put('/paymentchangestatus', [PaymentsController::class, 'changeStatus']);
    // CRUD REPORTES
    Route::get('/reports', [ReportController::class, 'index']);
    Route::post('/report/{id}', [ReportController::class, 'show']);
    Route::post('/reportbyclient/{id}', [ReportController::class, 'showReportByClient']);
    Route::post('/reportbycredit/{id}', [ReportController::class, 'showReportByCredit']);
});

/**
* RUTAS PUBLICAS
*/
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

