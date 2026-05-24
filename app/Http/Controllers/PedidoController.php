<?php

namespace App\Http\Controllers;

class PedidoController extends Controller
{
    public function checkout()
    {
        if (!session('user_id')) {
            return redirect()->route('login')
                ->withErrors(['login' => 'Debes iniciar sesión para continuar con la compra.']);
        }

        $carrito = session()->get('carrito', []);

        if (!is_array($carrito) || count($carrito) === 0) {
            return redirect()->route('carrito.index')
                ->with('success', 'Tu carrito está vacío.');
        }

        foreach ($carrito as $item) {
            if (!is_array($item)) {
                continue;
            }

            $juego = \App\Models\Juego::find($item['id_juego']);

            if (!$juego) {
                return redirect()->route('carrito.index')
                    ->with('error', 'Uno de los juegos del carrito ya no existe.');
            }

            if ((int) $item['cantidad'] > (int) $juego->stock) {
                return redirect()->route('carrito.index')
                    ->with('error', 'No hay stock suficiente para ' . $juego->titulo . '. Solo quedan ' . $juego->stock . ' unidades.');
            }
        }

        $total = collect($carrito)
            ->filter(fn ($item) => is_array($item))
            ->sum(fn ($item) => $item['precio'] * $item['cantidad']);

        return view('checkout', compact('carrito', 'total'));
    }
    public function gracias()
    {
        return view('gracias');
    }
}
