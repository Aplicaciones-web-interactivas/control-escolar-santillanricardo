<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'clave_institucional' => 'required',
            'password'            => 'required',
        ], [
            'clave_institucional.required' => 'La clave institucional es obligatoria.',
            'password.required'            => 'La contraseña es obligatoria.',
        ]);

        $credentials = [
            'clave_institucional' => $request->clave_institucional,
            'password'            => $request->password,
        ];

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $rol = Auth::user()->role;

            if ($rol == 'admin') {
                return redirect('/dashboard');
            } elseif ($rol == 'maestro') {
                return redirect('/maestro/dashboard');
            } else {
                return redirect('/alumno/dashboard');
            }
        }

        return back()->withErrors([
            'clave_institucional' => 'Las credenciales no son correctas.',
        ]);
    }
}