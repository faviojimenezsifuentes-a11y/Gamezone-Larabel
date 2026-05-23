<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class CompraController extends Controller
{
    public function index()
    {
        if (!session('user_id')) {
            return redirect()->route('login')
                ->withErrors(['login' => 'Debes iniciar sesión para ver tus compras.']);
        }

        $idUsuario = session('user_id');

        $pedidos = DB::table('pedidos')
            ->where('id_usuario', $idUsuario)
            ->orderByDesc('fecha_pedido')
            ->get();

        foreach ($pedidos as $pedido) {
            $pedido->detalles = DB::table('detalle_pedidos')
                ->join('juegos', 'detalle_pedidos.id_juego', '=', 'juegos.id_juego')
                ->where('detalle_pedidos.id_pedido', $pedido->id_pedido)
                ->select(
                    'juegos.titulo',
                    'juegos.imagen',
                    'detalle_pedidos.cantidad',
                    'detalle_pedidos.subtotal'
                )
                ->get();
        }

        return view('mis_compras', compact('pedidos'));
    }
}
