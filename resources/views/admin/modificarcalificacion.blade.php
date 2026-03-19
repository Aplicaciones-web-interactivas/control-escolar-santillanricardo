@extends('layouts.app')
@section('content')
    <div class="min-h-screen bg-blue-50">

        <x-navbar />

        <div class="max-w-lg mx-auto p-6">
            <div class="bg-white shadow rounded p-6">
                <h2 class="text-xl font-bold mb-4">Editar Calificación</h2>
                <form action="{{ route('update.calificacion', $calificacion->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <label class="block mb-1 text-sm font-medium text-gray-900">Grupo</label>
                        <select name="grupo_id"
                            class="bg-gray-50 border border-blue-300 text-gray-900 text-sm rounded-lg block w-full p-2.5"
                            required>
                            @foreach ($grupos as $grupo)
                                <option value="{{ $grupo->id }}"
                                    {{ $calificacion->grupo_id == $grupo->id ? 'selected' : '' }}>
                                    {{ $grupo->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="block mb-1 text-sm font-medium text-gray-900">Usuario</label>
                        <select name="user_id"
                            class="bg-gray-50 border border-blue-300 text-gray-900 text-sm rounded-lg block w-full p-2.5"
                            required>
                            @foreach ($usuarios as $usuario)
                                <option value="{{ $usuario->id }}"
                                    {{ $calificacion->user_id == $usuario->id ? 'selected' : '' }}>
                                    {{ $usuario->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="block mb-1 text-sm font-medium text-gray-900">Calificación</label>
                        <input type="number" name="calificacion" min="0" max="10" step="0.1"
                            value="{{ $calificacion->calificacion }}"
                            class="bg-gray-50 border border-blue-300 text-gray-900 text-sm rounded-lg block w-full p-2.5"
                            required>
                    </div>
                    <div class="flex gap-3">
                        <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-bold text-sm px-5 py-2.5 rounded-lg">Actualizar</button>
                        <a href="{{ route('index.calificacion') }}"
                            class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold text-sm px-5 py-2.5 rounded-lg">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
