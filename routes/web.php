<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\VentaController;

// Rutas de autenticación
Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

// Rutas protegidas por autenticación
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Usuarios
    Route::resource('usuarios', UsuarioController::class);

    // Productos
    Route::resource('productos', ProductoController::class);
    Route::post('productos/{producto}/stock', [ProductoController::class, 'updateStock'])->name('productos.stock');

    // Clientes
    Route::resource('clientes', ClienteController::class);
    Route::get('clientes/{cliente}/ventas', [ClienteController::class, 'ventas'])->name('clientes.ventas');

    // Ventas
    Route::resource('ventas', VentaController::class);
    Route::post('ventas/{venta}/estado', [VentaController::class, 'updateStatus'])->name('ventas.estado');
});
