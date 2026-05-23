<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JuegoController;
use App\Http\Controllers\CarritoController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PagoController;
use App\Http\Controllers\CompraController;
use App\Http\Controllers\AdminJuegoController;

Route::get('/', [JuegoController::class, 'catalogo'])->name('inicio');
Route::get('/catalogo', [JuegoController::class, 'catalogo'])->name('catalogo');
Route::get('/carrito', [CarritoController::class, 'index'])->name('carrito.index');
Route::post('/carrito/agregar', [CarritoController::class, 'agregar'])->name('carrito.agregar');
Route::post('/carrito/actualizar', [CarritoController::class, 'actualizar'])->name('carrito.actualizar');
Route::delete('/carrito/eliminar/{id_juego}', [CarritoController::class, 'eliminar'])->name('carrito.eliminar');
Route::delete('/carrito/vaciar', [CarritoController::class, 'vaciar'])->name('carrito.vaciar');
Route::get('/checkout', [PedidoController::class, 'checkout'])->name('checkout');
Route::get('/gracias', [PedidoController::class, 'gracias'])->name('gracias');
Route::get('/login', [AuthController::class, 'mostrarLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.procesar');

Route::get('/register', [AuthController::class, 'mostrarRegistro'])->name('register');
Route::post('/register', [AuthController::class, 'registrar'])->name('register.procesar');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/pago/crear-sesion', [PagoController::class, 'crearSesion'])->name('pago.crearSesion');
Route::get('/pago/exitoso', [PagoController::class, 'exitoso'])->name('pago.exitoso');
Route::get('/pago/cancelado', [PagoController::class, 'cancelado'])->name('pago.cancelado');
Route::get('/mis-compras', [CompraController::class, 'index'])->name('mis_compras');
Route::get('/admin/juegos', [AdminJuegoController::class, 'index'])->name('admin.juegos.index');
Route::get('/admin/juegos/crear', [AdminJuegoController::class, 'create'])->name('admin.juegos.create');
Route::post('/admin/juegos', [AdminJuegoController::class, 'store'])->name('admin.juegos.store');
Route::get('/admin/juegos/{id}/editar', [AdminJuegoController::class, 'edit'])->name('admin.juegos.edit');
Route::put('/admin/juegos/{id}', [AdminJuegoController::class, 'update'])->name('admin.juegos.update');
Route::delete('/admin/juegos/{id}', [AdminJuegoController::class, 'destroy'])->name('admin.juegos.destroy');
