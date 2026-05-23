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

        $request->validate([
            'titulo' => 'required|string|max:100|unique:juegos,titulo',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric|min:0',
            'categoria' => 'nullable|string|max:50',
            'imagen' => 'nullable|string|max:255',
            'stock' => 'required|integer|min:0',
        ]);

        Juego::create($request->only([
            'titulo',
            'descripcion',
            'precio',
            'categoria',
            'imagen',
            'stock',
        ]));

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

        $request->validate([
            'titulo' => 'required|string|max:100|unique:juegos,titulo,' . $juego->id_juego . ',id_juego',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric|min:0',
            'categoria' => 'nullable|string|max:50',
            'imagen' => 'nullable|string|max:255',
            'stock' => 'required|integer|min:0',
        ]);

        $juego->update($request->only([
            'titulo',
            'descripcion',
            'precio',
            'categoria',
            'imagen',
            'stock',
        ]));

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
