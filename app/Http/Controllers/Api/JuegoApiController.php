<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Juego;
use Illuminate\Http\Request;

class JuegoApiController extends Controller
{
    public function index()
    {
        $juegos = Juego::orderBy('titulo', 'asc')->get();

        return response()->json([
            'success' => true,
            'data' => $juegos
        ]);
    }

    public function show($id)
    {
        $juego = Juego::find($id);

        if (!$juego) {
            return response()->json([
                'success' => false,
                'message' => 'Juego no encontrado'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $juego
        ]);
    }

    public function categorias()
    {
        $categorias = Juego::select('categoria')
            ->whereNotNull('categoria')
            ->distinct()
            ->orderBy('categoria')
            ->pluck('categoria');

        return response()->json([
            'success' => true,
            'data' => $categorias
        ]);
    }

    public function porCategoria($categoria)
    {
        $juegos = Juego::where('categoria', $categoria)
            ->orderBy('titulo', 'asc')
            ->get();

        return response()->json([
            'success' => true,
            'categoria' => $categoria,
            'data' => $juegos
        ]);
    }
}
