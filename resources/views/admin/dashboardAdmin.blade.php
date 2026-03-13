@extends('layouts.app')
@section('content')

<div class="min-h-screen bg-blue-50">

    {{-- NavBar --}}
    <nav class="bg-white border-b border-blue-100 shadow-sm px-8 py-4 flex justify-between items-center">
        <div class="flex items-center gap-8">
            <div class="flex gap-6">
                <a href="{{ route('dashboard') }}" 
                   class="text-sm font-semibold text-blue-600 hover:text-blue-800 transition">Home</a>
                <a href="{{ route('index.materia') }}" 
                   class="text-sm font-semibold text-blue-600 hover:text-blue-800 transition">Materias</a>
                <a href="{{ route('index.horario') }}" 
                   class="text-sm font-semibold text-blue-600 hover:text-blue-800 transition">Horarios</a>
                <a href="{{ route('index.grupo') }}" 
                   class="text-sm font-semibold text-blue-600 hover:text-blue-800 transition">Grupos</a>
            </div>
        </div>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit"
                class="bg-red-500 hover:bg-red-600 text-white text-sm font-bold px-4 py-2 rounded-lg transition">
                Cerrar sesión
            </button>
        </form>
    </nav>

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