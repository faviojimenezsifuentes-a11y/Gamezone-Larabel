<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\JuegoApiController;

Route::get('/juegos', [JuegoApiController::class, 'index']);
Route::get('/juegos/{id}', [JuegoApiController::class, 'show']);
Route::get('/categorias', [JuegoApiController::class, 'categorias']);
Route::get('/categorias/{categoria}/juegos', [JuegoApiController::class, 'porCategoria']);
