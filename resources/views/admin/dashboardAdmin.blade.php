@extends('layouts.app')
@section('content')
    <div class="min-h-screen bg-blue-50">

        <x-navbar />

        {{-- Contenido --}}
        <div class="flex items-center justify-center mt-20 p-6">
            <div class="bg-white p-8 w-full max-w-md text-center">
                <h2 class="text-2xl font-bold text-blue-800 mb-2">
                    Bienvenido {{ Auth::user()->nombre }}
                </h2>
                <p class="text-sm text-blue-400">Selecciona una opción del menú para comenzar.</p>
            </div>
        </div>

    </div>
@endsection
