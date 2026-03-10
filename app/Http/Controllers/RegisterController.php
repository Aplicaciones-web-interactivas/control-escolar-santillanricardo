<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function showForm()
    {
        return view('registro');
    }

    public function register(Request $request)
    {
        $request->validate([
            'nombre'              => 'required|string|max:255',
            'clave_institucional' => 'required|string|unique:users',
            'password'            => 'required|string|min:8|confirmed',
        ], [
            'nombre.required'              => 'El nombre es obligatorio.',
            'clave_institucional.required' => 'La clave institucional es obligatoria.',
            'clave_institucional.unique'   => 'Esa clave institucional ya está registrada.',
            'password.required'            => 'La contraseña es obligatoria.',
            'password.min'                 => 'La contraseña debe tener mínimo 8 caracteres.',
            'password.confirmed'           => 'Las contraseñas no coinciden.',
        ]);

        User::create([
            'nombre'              => $request->nombre,
            'clave_institucional' => $request->clave_institucional,
            'password'            => $request->password,
        ]);

        return redirect('/')->with('success', 'Cuenta creada exitosamente');
    }
}
