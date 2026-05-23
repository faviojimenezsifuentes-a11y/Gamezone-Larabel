<?php

namespace App\Http\Controllers;

use App\Models\Juego;
use App\Services\TipoCambioService;

class JuegoController extends Controller
{
    public function catalogo(TipoCambioService $tipoCambioService)
    {
        $juegos = Juego::orderBy('titulo', 'asc')->get();

        foreach ($juegos as $juego) {
            $juego->precio_dolares = $tipoCambioService->solesADolares((float) $juego->precio);
        }

        return view('catalogo', compact('juegos'));
    }
}
