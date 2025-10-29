<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


/**
 * RUTAS PROTEGIDAS
 */
Route::middleware('auth:sanctum')->group(function () {

    Route::get('/perfil', function (Request $request) {
        return apiResponse([
            'status' => 'success',
            'message' => 'Mostrando perfil',
            'data' => $request->user(),
            'error' => null,
        ], 200);
    });

    Route::post('/logout', [AuthController::class, 'logout']);
});

/**
 * RUTAS PUBLICAS
 */
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);



/*
return response()->json([
    'status' => 'success',
    'message' => 'Hola Laravel está funcionando correctamente',
    'data' => [
        ['id' => '0', 'nombre' => 'josue']
    ],
    'error' => null
]);
*/