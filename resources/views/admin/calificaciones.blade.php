@extends('layouts.app')
@section('content')
    <div class="min-h-screen bg-blue-50">

        <x-navbar />

        <div class="max-w-5xl mx-auto p-6">

            @if ($errors->any())
                <div class="bg-red-100 text-red-700 p-3 rounded mb-4">{{ $errors->first() }}</div>
            @endif

            <div class="bg-white shadow rounded p-6 mb-6">
                <h2 class="text-xl font-bold mb-4">Agregar Calificación</h2>
                <form action="{{ route('save.calificacion') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="block mb-1 text-sm font-medium text-gray-900">Grupo</label>
                        <select name="grupo_id"
                            class="bg-gray-50 border border-blue-300 text-gray-900 text-sm rounded-lg block w-full p-2.5"
                            required>
                            <option value="">Selecciona un grupo</option>
                            @foreach ($grupos as $grupo)
                                <option value="{{ $grupo->id }}">{{ $grupo->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="block mb-1 text-sm font-medium text-gray-900">Usuario</label>
                        <select name="user_id"
                            class="bg-gray-50 border border-blue-300 text-gray-900 text-sm rounded-lg block w-full p-2.5"
                            required>
                            <option value="">Selecciona un usuario</option>
                            @foreach ($usuarios as $usuario)
                                <option value="{{ $usuario->id }}">{{ $usuario->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="block mb-1 text-sm font-medium text-gray-900">Calificación</label>
                        <input type="number" name="calificacion" min="0" max="10" step="0.1"
                            class="bg-gray-50 border border-blue-300 text-gray-900 text-sm rounded-lg block w-full p-2.5"
                            placeholder="Ej. 8.5" required>
                    </div>
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-bold text-sm px-5 py-2.5 rounded-lg">Guardar</button>
                </form>
            </div>

            <div class="bg-white shadow rounded p-6">
                <h2 class="text-xl font-bold mb-4">Lista de Calificaciones</h2>
                <table class="w-full text-sm text-left text-gray-700">
                    <thead class="bg-blue-50">
                        <tr>
                            <th class="px-4 py-2 text-blue-700">Usuario</th>
                            <th class="px-4 py-2 text-blue-700">Grupo</th>
                            <th class="px-4 py-2 text-blue-700">Calificación</th>
                            <th class="px-4 py-2 text-blue-700">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($calificaciones as $calificacion)
                            <tr class="border-b hover:bg-blue-50">
                                <td class="px-4 py-2">{{ $calificacion->user->nombre }}</td>
                                <td class="px-4 py-2">{{ $calificacion->grupo->nombre }}</td>
                                <td class="px-4 py-2">{{ $calificacion->calificacion }}</td>
                                <td class="px-4 py-2 flex gap-4">
                                    <a href="{{ route('calificaciones.edit', $calificacion->id) }}"
                                        class="text-blue-500 hover:text-blue-700 font-medium">Editar</a>
                                    <form action="{{ route('eliminar.calificacion', $calificacion->id) }}" method="POST"
                                        style="display:inline;">
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
