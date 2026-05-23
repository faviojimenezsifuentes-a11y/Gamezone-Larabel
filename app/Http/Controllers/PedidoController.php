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
