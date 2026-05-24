<?php

namespace App\Http\Controllers;

use App\Models\Juego;
use App\Services\TipoCambioService;
use Illuminate\Http\Request;

class JuegoController extends Controller
{
    public function catalogo(Request $request, TipoCambioService $tipoCambioService)
    {
        $query = Juego::query();

        if ($request->filled('buscar')) {
            $query->where('titulo', 'like', '%' . $request->buscar . '%');
        }

        if ($request->filled('categoria')) {
            $query->where('categoria', $request->categoria);
        }

        if ($request->filled('disponible')) {
            $query->where('stock', '>', 0);
        }

        if ($request->orden === 'precio_asc') {
            $query->orderBy('precio', 'asc');
        } elseif ($request->orden === 'precio_desc') {
            $query->orderBy('precio', 'desc');
        } else {
            $query->orderBy('titulo', 'asc');
        }

        $juegos = $query->get();

        foreach ($juegos as $juego) {
            $juego->precio_dolares = $tipoCambioService->solesADolares((float) $juego->precio);
        }

        $categorias = Juego::select('categoria')
            ->whereNotNull('categoria')
            ->distinct()
            ->orderBy('categoria')
            ->pluck('categoria');

        return view('catalogo', compact('juegos', 'categorias'));
    }
}
