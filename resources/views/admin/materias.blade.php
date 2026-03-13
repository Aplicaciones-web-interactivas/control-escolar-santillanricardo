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

    <div class="max-w-4xl mx-auto p-6">

        {{-- Mensajes de error --}}
        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                {{ $errors->first() }}
            </div>
        @endif

        {{-- Formulario agregar materia --}}
        <div class="bg-white shadow rounded p-6 mb-6">
            <h2 class="text-xl font-bold mb-4">Agregar Materia</h2>
            <form action="{{ route('save.materias') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block mb-1 text-sm font-medium text-gray-900">Nombre</label>
                    <input type="text" name="nombre"
                        class="bg-gray-50 border border-blue-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 focus:ring-2 focus:ring-blue-500 outline-none"
                        placeholder="Matemáticas" required>
                </div>
                <div class="mb-4">
                    <label class="block mb-1 text-sm font-medium text-gray-900">Clave</label>
                    <input type="text" name="clave"
                        class="bg-gray-50 border border-blue-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 focus:ring-2 focus:ring-blue-500 outline-none"
                        placeholder="MAT101" required>
                </div>
                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-bold text-sm px-5 py-2.5 rounded-lg transition">
                    Guardar
                </button>
            </form>
        </div>

        {{-- Tabla de materias --}}
        <div class="bg-white shadow rounded p-6">
            <h2 class="text-xl font-bold mb-4">Lista de Materias</h2>
            <table class="w-full text-sm text-left text-gray-700">
                <thead class="bg-blue-50">
                    <tr>
                        <th class="px-4 py-2 text-blue-700">Nombre</th>
                        <th class="px-4 py-2 text-blue-700">Clave</th>
                        <th class="px-4 py-2 text-blue-700">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($materias as $materia)
                    <tr class="border-b hover:bg-blue-50 transition">
                        <td class="px-4 py-2">{{ $materia->nombre }}</td>
                        <td class="px-4 py-2">{{ $materia->clave }}</td>
                        <td class="px-4 py-2 flex gap-4 items-center">
                            <a href="{{ route('materias.edit', $materia->id) }}"
                                class="text-blue-500 hover:text-blue-700 font-medium">Editar</a>
                            <form action="{{ route('eliminar.materia', $materia->id) }}"
                                method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="text-red-500 hover:text-red-700 font-medium">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
</div>

@endsection