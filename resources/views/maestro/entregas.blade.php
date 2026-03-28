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

    <div class="max-w-5xl mx-auto p-6">

        <div class="bg-white shadow rounded p-6 mb-6">
            <h2 class="text-xl font-bold text-blue-800">{{ $tarea->titulo }}</h2>
            <p class="text-sm text-gray-500 mt-1">{{ $tarea->descripcion }}</p>
            <p class="text-sm text-gray-500 mt-1">Fecha de entrega: {{ $tarea->fecha_entrega }}</p>
        </div>

        <div class="bg-white shadow rounded p-6">
            <h2 class="text-xl font-bold mb-4">Entregas</h2>
            <table class="w-full text-sm text-left text-gray-700">
                <thead class="bg-blue-50">
                    <tr>
                        <th class="px-4 py-2 text-blue-700">Alumno</th>
                        <th class="px-4 py-2 text-blue-700">Archivo</th>
                        <th class="px-4 py-2 text-blue-700">Fecha</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($entregas as $entrega)
                    <tr class="border-b hover:bg-blue-50">
                        <td class="px-4 py-2">{{ $entrega->user->nombre }}</td>
                        <td class="px-4 py-2">
                            <a href="{{ asset('storage/' . $entrega->archivo) }}"
                                target="_blank"
                                class="text-blue-500 hover:text-blue-700 font-medium">
                                Ver PDF
                            </a>
                        </td>
                        <td class="px-4 py-2">{{ $entrega->created_at->format('d/m/Y') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="px-4 py-4 text-center text-gray-400">No hay entregas aún.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="mt-4">
                {{ $entregas->links() }}
            </div>
        </div>

        <div class="mt-4">
            <a href="{{ route('maestro.tareas') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold text-sm px-5 py-2.5 rounded-lg">Regresar</a>
        </div>

    </div>
</div>

@endsection