<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function mostrarLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ], [
            'email.required' => 'Ingrese su correo.',
            'email.email' => 'Formato de correo inválido.',
            'password.required' => 'Ingrese su contraseña.',
        ]);

        $usuario = Usuario::where('correo', $request->email)->first();

        if (!$usuario) {
            return back()->withErrors([
                'login' => 'El correo no está registrado.',
            ])->withInput();
        }

        if (!Hash::check($request->password, $usuario->password)) {
            return back()->withErrors([
                'login' => 'Contraseña incorrecta.',
            ])->withInput();
        }

        session()->regenerate();

        session([
            'user_id' => $usuario->id_usuario,
            'user' => [
                'id_usuario' => $usuario->id_usuario,
                'nombre' => $usuario->nombre,
                'correo' => $usuario->correo,
                'rol' => $usuario->rol,
            ],
            'username' => $usuario->nombre,
        ]);

        return redirect()->route('catalogo');
    }

    public function mostrarRegistro()
    {
        return view('auth.register');
    }

    public function registrar(Request $request)
    {
        $request->validate([
            'username' => [
                'required',
                'string',
                'max:50',
                'regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/u',
            ],
            'email' => 'required|email|unique:usuarios,correo',
            'password' => [
                'required',
                'confirmed',
                'string',
                'min:8',
                'regex:/[A-Z]/',
                'regex:/[a-z]/',
                'regex:/[0-9]/',
                'regex:/[@$!%*#?&._-]/',
            ],
        ], [
            'username.required' => 'Ingrese su usuario.',
            'username.regex' => 'El nombre solo debe contener letras y espacios.',
            'email.required' => 'Ingrese su correo.',
            'email.email' => 'El correo ingresado no es válido.',
            'email.unique' => 'El correo ya está registrado.',
            'password.required' => 'Ingrese su contraseña.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
            'password.min' => 'La contraseña debe tener mínimo 8 caracteres.',
            'password.regex' => 'La contraseña debe incluir mayúscula, minúscula, número y carácter especial.',
        ]);

        $usuario = Usuario::create([
            'nombre' => $request->username,
            'apellido' => '',
            'correo' => $request->email,
            'telefono' => null,
            'password' => Hash::make($request->password),
        ]);

        session()->regenerate();

        session([
            'user_id' => $usuario->id_usuario,
            'user' => [
                'id_usuario' => $usuario->id_usuario,
                'nombre' => $usuario->nombre,
                'correo' => $usuario->correo,
                'rol' => $usuario->rol,
            ],
            'username' => $usuario->nombre,
        ]);

        return redirect()->route('catalogo');
    }

    public function logout(Request $request)
    {
        $request->session()->forget(['user_id', 'user', 'username']);

        return redirect()->route('catalogo');
    }
}
