@extends('layouts.app')
@section('content')

<div class="min-h-screen bg-blue-50">

    <nav class="bg-white border-b border-blue-100 shadow-sm px-8 py-4 flex justify-between items-center">
        <div class="flex gap-6">
            <a href="{{ route('maestro.dashboard') }}" class="text-sm font-semibold text-blue-600 hover:text-blue-800">Home</a>
            <a href="{{ route('maestro.tareas') }}" class="text-sm font-semibold text-blue-600 hover:text-blue-800">Tareas</a>
        </div>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button class="bg-red-500 hover:bg-red-600 text-white text-sm font-bold px-4 py-2 rounded-lg">Cerrar sesión</button>
        </form>
    </nav>

    <div class="flex items-center justify-center mt-20 p-6">
        <div class="bg-white p-8 w-full max-w-md text-center">
            <h2 class="text-2xl font-bold text-blue-800 mb-2">
                Bienvenido, {{ Auth::user()->nombre }}
            </h2>
            <p class="text-sm text-blue-400">Panel de Maestro</p>
        </div>
    </div>

</div>

@endsection