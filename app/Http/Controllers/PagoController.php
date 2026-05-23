<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class PagoController extends Controller
{
    public function crearSesion()
    {
        if (!session('user_id')) {
            return redirect()->route('login')
                ->withErrors(['login' => 'Debes iniciar sesión para pagar.']);
        }

        $carrito = session()->get('carrito', []);

        if (!is_array($carrito) || count($carrito) === 0) {
            return redirect()->route('carrito.index')
                ->with('success', 'Tu carrito está vacío.');
        }

        Stripe::setApiKey(config('services.stripe.secret'));

        $lineItems = [];

        foreach ($carrito as $item) {
            if (!is_array($item)) {
                continue;
            }

            $precioUsd = round($item['precio'] / 3.75, 2);
            $unitAmount = (int) round($precioUsd * 100);

            $lineItems[] = [
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => $item['titulo'],
                    ],
                    'unit_amount' => $unitAmount,
                ],
                'quantity' => $item['cantidad'],
            ];
        }

        $checkoutSession = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => $lineItems,
            'mode' => 'payment',
            'success_url' => route('pago.exitoso') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('pago.cancelado'),
        ]);

        return redirect($checkoutSession->url);
    }

    public function exitoso(Request $request)
    {
        if (!session('user_id')) {
            return redirect()->route('login');
        }

        $carrito = session()->get('carrito', []);

        if (!is_array($carrito) || count($carrito) === 0) {
            return redirect()->route('catalogo');
        }

        Stripe::setApiKey(config('services.stripe.secret'));

        $stripeSession = Session::retrieve($request->session_id);

        if ($stripeSession->payment_status !== 'paid') {
            return redirect()->route('carrito.index')
                ->with('success', 'El pago no fue confirmado.');
        }

        $total = collect($carrito)
            ->filter(fn ($item) => is_array($item))
            ->sum(fn ($item) => $item['precio'] * $item['cantidad']);

        DB::transaction(function () use ($carrito, $total, $stripeSession) {
            $idUsuario = session('user_id');

            $idPedido = DB::table('pedidos')->insertGetId([
                'id_usuario' => $idUsuario,
                'total' => $total,
                'metodo_pago' => 'Stripe',
                'referencia_pago' => $stripeSession->id,
                'estado' => 'COMPLETADO',
            ]);

            DB::table('pagos')->insert([
                'id_usuario' => $idUsuario,
                'metodo_pago' => 'Stripe',
                'referencia_pago' => $stripeSession->id,
                'monto' => $total,
                'estado' => 'COMPLETADO',
            ]);

            foreach ($carrito as $item) {
                if (!is_array($item)) {
                    continue;
                }

                DB::table('detalle_pedidos')->insert([
                    'id_pedido' => $idPedido,
                    'id_juego' => $item['id_juego'],
                    'cantidad' => $item['cantidad'],
                    'subtotal' => $item['precio'] * $item['cantidad'],
                ]);
            }
        });

        session()->forget('carrito');

        return redirect()->route('gracias');
    }

    public function cancelado()
    {
        return view('pago_cancelado');
    }
}
