@extends('layouts.app')
@section('content')
    <div class="min-h-screen bg-blue-50">

        <x-navbar />

        <div class="max-w-5xl mx-auto p-6">

            @if ($errors->any())
                <div class="bg-red-100 text-red-700 p-3 rounded mb-4">{{ $errors->first() }}</div>
            @endif

            <div class="bg-white shadow rounded p-6 mb-6">
                <h2 class="text-xl font-bold mb-4">Agregar Inscripción</h2>
                <form action="{{ route('save.inscripcion') }}" method="POST">
                    @csrf
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
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-bold text-sm px-5 py-2.5 rounded-lg">Guardar</button>
                </form>
            </div>

            <div class="bg-white shadow rounded p-6">
                <h2 class="text-xl font-bold mb-4">Lista de Inscripciones</h2>
                <table class="w-full text-sm text-left text-gray-700">
                    <thead class="bg-blue-50">
                        <tr>
                            <th class="px-4 py-2 text-blue-700">Usuario</th>
                            <th class="px-4 py-2 text-blue-700">Grupo</th>
                            <th class="px-4 py-2 text-blue-700">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($inscripciones as $inscripcion)
                            <tr class="border-b hover:bg-blue-50">
                                <td class="px-4 py-2">{{ $inscripcion->user->nombre }}</td>
                                <td class="px-4 py-2">{{ $inscripcion->grupo->nombre }}</td>
                                <td class="px-4 py-2 flex gap-4">
                                    <a href="{{ route('inscripciones.edit', $inscripcion->id) }}"
                                        class="text-blue-500 hover:text-blue-700 font-medium">Editar</a>
                                    <form action="{{ route('eliminar.inscripcion', $inscripcion->id) }}" method="POST"
                                        style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            onclick="return confirm('¿Estás seguro de eliminar esta inscripción?')"
                                            class="text-red-500 hover:text-red-700 font-medium">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-4 py-4 text-center text-gray-400">No hay registros.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="mt-4">
                    {{ $inscripciones->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
