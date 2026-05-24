<?php

namespace App\Http\Controllers;

use App\Models\Juego;
use Illuminate\Http\Request;

class CarritoController extends Controller
{
   public function agregar(Request $request)
{
    $request->validate([
        'id_juego' => 'required|integer|exists:juegos,id_juego',
        'cantidad' => 'required|integer|min:1',
    ]);

    $juego = Juego::findOrFail($request->id_juego);
    $stockDisponible = (int) $juego->stock;
    if ($stockDisponible <= 0) {
        return response()->json([
            'success' => false,
            'message' => 'Este juego no tiene stock disponible.',
        ], 422);
    }

    $carrito = session()->get('carrito', []);

    if (!is_array($carrito)) {
        $carrito = [];
    }

    $id = (string) $juego->id_juego;
    $cantidad = (int) $request->cantidad;

    $cantidadActual = isset($carrito[$id]) && is_array($carrito[$id])
        ? (int) $carrito[$id]['cantidad']
        : 0;

    $cantidadFinal = $cantidadActual + $cantidad;

    if ($cantidadFinal > $stockDisponible) {
        return response()->json([
            'success' => false,
            'message' => 'No puedes agregar más de ' . $stockDisponible . ' unidades disponibles.',
        ], 422);
    }

    if (isset($carrito[$id]) && is_array($carrito[$id])) {
        $carrito[$id]['cantidad'] = $cantidadFinal;
    } else {
        $carrito[$id] = [
            'id_juego' => $juego->id_juego,
            'titulo' => $juego->titulo,
            'precio' => $juego->precio,
            'imagen' => $juego->imagen,
            'cantidad' => $cantidad,
        ];
    }

    session()->put('carrito', $carrito);

    $totalItems = collect($carrito)
        ->filter(fn ($item) => is_array($item))
        ->sum('cantidad');

    return response()->json([
        'success' => true,
        'message' => 'Juego agregado al carrito',
        'total_items' => $totalItems,
    ]);
}

    public function index()
    {
        $carrito = session()->get('carrito', []);
        if(!is_array($carrito)){
            $carrito = [];
        }

        return view('carrito',[
            'carrito' => $carrito
        ]);
    }
    public function vaciar()
    {
        session()->forget('carrito');

        return redirect()->route('carrito.index')
            ->with('success', 'Carrito vaciado correctamente.');
    }
    public function eliminar($id_juego)
{
    $carrito = session()->get('carrito', []);

    $id = (string) $id_juego;

    if (isset($carrito[$id])) {
        unset($carrito[$id]);
        session()->put('carrito', $carrito);
    }

    return redirect()->route('carrito.index')
        ->with('success', 'Juego eliminado del carrito.');
}
    public function actualizar(Request $request)
{
    $request->validate([
        'id_juego' => 'required|integer|exists:juegos,id_juego',
        'cantidad' => 'required|integer|min:1',
    ]);

    $juego = Juego::findOrFail($request->id_juego);
    $cantidad = (int) $request->cantidad;
    $stock = (int) $juego->stock;

    if ($cantidad > $stock) {
        return response()->json([
            'success' => false,
            'message' => 'No hay stock suficiente. Solo quedan ' . $stock . ' unidades de ' . $juego->titulo . '.',
        ], 422);
    }

    $carrito = session()->get('carrito', []);
    $id = (string) $request->id_juego;

    if (isset($carrito[$id]) && is_array($carrito[$id])) {
        $carrito[$id]['cantidad'] = $cantidad;
        session()->put('carrito', $carrito);
    }

    $subtotal = 0;
    $total = 0;
    $totalItems = 0;

    foreach ($carrito as $item) {
        if (!is_array($item)) {
            continue;
        }

        $itemSubtotal = $item['precio'] * $item['cantidad'];
        $total += $itemSubtotal;
        $totalItems += $item['cantidad'];

        if ((int) $item['id_juego'] === (int) $request->id_juego) {
            $subtotal = $itemSubtotal;
        }
    }

    return response()->json([
        'success' => true,
        'message' => 'Carrito actualizado.',
        'subtotal' => number_format($subtotal, 2),
        'total' => number_format($total, 2),
        'total_items' => $totalItems,
    ]);
}
}
