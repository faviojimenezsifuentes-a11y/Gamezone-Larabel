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

    $carrito = session()->get('carrito', []);

    if (!is_array($carrito)) {
        $carrito = [];
    }

    $id = (string) $juego->id_juego;
    $cantidad = (int) $request->cantidad;

    if (isset($carrito[$id]) && is_array($carrito[$id])) {
        $carrito[$id]['cantidad'] += $cantidad;
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
    public function actualizar ( Request $request)
    {
        $request->validate([
            'id_juego' => 'required|integer',
            'cantidad' => 'required|integer|min:1',
        ]);
        $carrito = session()->get('carrito', []);

        if (isset($carrito[$request->id_juego])){
            $carrito[$request->id_juego]['cantidad'] = $request->cantidad;
            session()->put('carrito','$carrito');
        }
        return redirect()->route('carrito.index')
        -> with('success','Carrito actualizado correctamente.');
    }
    public function eliminar($id_juego)
    {
        $carrito = session()->get('carrito',[]);
        if (isset($carrito[$id_juego])){
            unset($carrito[$id_juego]);
            session()->put('carrito',$carrito);
        }
        return redirect()->route('carrito.index')
        ->with('success','Juego eliminado correctamente del carrito.');
    }
    public function vaciar(){
        session()->forget('carrito');

        return redirect()->route('carrito.index')
        ->with('success','Carrito vacio correctamente.');
    }
}
