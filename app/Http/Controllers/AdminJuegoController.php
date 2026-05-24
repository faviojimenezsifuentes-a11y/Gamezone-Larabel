<?php

namespace App\Http\Controllers;

use App\Models\Juego;
use Illuminate\Http\Request;

class AdminJuegoController extends Controller
{
    private function verificarAdmin()
    {
        if (!session('user_id')) {
            return redirect()->route('login')
                ->withErrors(['login' => 'Debes iniciar sesión para acceder al panel.']);
        }

        if (session('user.rol') !== 'admin') {
            return redirect()->route('catalogo')
                ->withErrors(['admin' => 'No tienes permisos para acceder al panel de administración.']);
        }

        return null;
    }

    private function limpiarDatos(Request $request): void
    {
        $request->merge([
            'titulo' => trim($request->titulo ?? ''),
            'categoria' => trim($request->categoria ?? ''),
            'imagen' => trim($request->imagen ?? ''),
        ]);
    }

    private function reglasValidacion(?Juego $juego = null): array
    {
        $id = $juego ? $juego->id_juego : null;

        return [
            'titulo' => 'required|string|max:100|unique:juegos,titulo,' . $id . ',id_juego',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric|min:0',
            'categoria' => 'nullable|string|max:50',
            'imagen' => [
                'nullable',
                'string',
                'max:500',
                'regex:/^(assets\/img\/juegos\/.+\.(jpg|jpeg|png|webp)|https?:\/\/.+)$/i',
            ],
            'stock' => 'required|integer|min:0',
        ];
    }

    private function mensajesValidacion(): array
    {
        return [
            'titulo.required' => 'Ingrese el título del juego.',
            'titulo.unique' => 'Ya existe un juego con ese título.',
            'precio.required' => 'Ingrese el precio del juego.',
            'precio.numeric' => 'El precio debe ser un número.',
            'precio.min' => 'El precio no puede ser negativo.',
            'stock.required' => 'Ingrese el stock del juego.',
            'stock.integer' => 'El stock debe ser un número entero.',
            'stock.min' => 'El stock no puede ser negativo.',
            'imagen.regex' => 'La imagen debe ser una ruta local válida o una URL http/https.',
        ];
    }

    public function index()
    {
        if ($redirect = $this->verificarAdmin()) {
            return $redirect;
        }

        $juegos = Juego::orderBy('titulo', 'asc')->get();

        return view('admin.juegos.index', compact('juegos'));
    }

    public function create()
    {
        if ($redirect = $this->verificarAdmin()) {
            return $redirect;
        }

        return view('admin.juegos.create');
    }

    public function store(Request $request)
    {
        if ($redirect = $this->verificarAdmin()) {
            return $redirect;
        }

        $this->limpiarDatos($request);

        $validated = $request->validate(
            $this->reglasValidacion(),
            $this->mensajesValidacion()
        );

        Juego::create($validated);

        return redirect()->route('admin.juegos.index')
            ->with('success', 'Juego creado correctamente.');
    }

    public function edit($id)
    {
        if ($redirect = $this->verificarAdmin()) {
            return $redirect;
        }

        $juego = Juego::findOrFail($id);

        return view('admin.juegos.edit', compact('juego'));
    }

    public function update(Request $request, $id)
    {
        if ($redirect = $this->verificarAdmin()) {
            return $redirect;
        }

        $juego = Juego::findOrFail($id);

        $this->limpiarDatos($request);

        $validated = $request->validate(
            $this->reglasValidacion($juego),
            $this->mensajesValidacion()
        );

        $juego->update($validated);

        return redirect()->route('admin.juegos.index')
            ->with('success', 'Juego actualizado correctamente.');
    }

    public function destroy($id)
    {
        if ($redirect = $this->verificarAdmin()) {
            return $redirect;
        }

        $juego = Juego::findOrFail($id);
        $juego->delete();

        return redirect()->route('admin.juegos.index')
            ->with('success', 'Juego eliminado correctamente.');
    }
}
