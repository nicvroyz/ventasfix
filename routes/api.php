<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ClienteController;
use App\Http\Controllers\Api\ProductoController;

/*
|--------------------------------------------------------------------------
| API Rutas
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Rutas de autenticación
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

// Rutas protegidas
Route::middleware('auth:sanctum')->group(function () {
    // Clientes
    Route::apiResource('clientes', ClienteController::class);

    // Productos
    Route::apiResource('productos', ProductoController::class);
    Route::post('productos/{producto}/stock', [ProductoController::class, 'updateStock']);
}); 