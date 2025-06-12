<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UsuarioController;
use App\Http\Controllers\Api\ProductoController;
use App\Http\Controllers\Api\ClienteController;
use App\Http\Controllers\Api\VentaController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Rutas públicas
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Rutas protegidas
Route::middleware('auth:sanctum')->group(function () {
    // Auth
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);

    // Usuarios
    Route::apiResource('usuarios', UsuarioController::class);

    // Productos
    Route::apiResource('productos', ProductoController::class);
    Route::post('productos/{producto}/stock', [ProductoController::class, 'updateStock']);

    // Clientes
    Route::apiResource('clientes', ClienteController::class);
    Route::get('clientes/{cliente}/ventas', [ClienteController::class, 'ventas']);

    // Ventas
    Route::apiResource('ventas', VentaController::class);
    Route::post('ventas/{venta}/estado', [VentaController::class, 'updateStatus']);
}); 