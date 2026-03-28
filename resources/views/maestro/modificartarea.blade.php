@extends('layouts.app')
@section('content')
    <div class="min-h-screen bg-blue-50">

        <nav class="bg-white border-b border-blue-100 shadow-sm px-8 py-4 flex justify-between items-center">
            <div class="flex gap-6">
                <a href="{{ route('maestro.dashboard') }}"
                    class="text-sm font-semibold text-blue-600 hover:text-blue-800">Home</a>
                <a href="{{ route('maestro.tareas') }}"
                    class="text-sm font-semibold text-blue-600 hover:text-blue-800">Tareas</a>
            </div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="bg-red-500 hover:bg-red-600 text-white text-sm font-bold px-4 py-2 rounded-lg">Cerrar
                    sesión</button>
            </form>
        </nav>

        <div class="max-w-lg mx-auto p-6">
            <div class="bg-white shadow rounded p-6">
                <h2 class="text-xl font-bold mb-4">Editar Tarea</h2>
                <form action="{{ route('maestro.update.tarea', $tarea->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <label class="block mb-1 text-sm font-medium text-gray-900">Grupo</label>
                        <select name="grupo_id"
                            class="bg-gray-50 border border-blue-300 text-gray-900 text-sm rounded-lg block w-full p-2.5"
                            required>
                            @foreach ($grupos as $grupo)
                                <option value="{{ $grupo->id }}" {{ $tarea->grupo_id == $grupo->id ? 'selected' : '' }}>
                                    {{ $grupo->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="block mb-1 text-sm font-medium text-gray-900">Título</label>
                        <input type="text" name="titulo" value="{{ $tarea->titulo }}"
                            class="bg-gray-50 border border-blue-300 text-gray-900 text-sm rounded-lg block w-full p-2.5"
                            required>
                    </div>
                    <div class="mb-4">
                        <label class="block mb-1 text-sm font-medium text-gray-900">Descripción</label>
                        <textarea name="descripcion" rows="3"
                            class="bg-gray-50 border border-blue-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" required>{{ $tarea->descripcion }}</textarea>
                    </div>
                    <div class="mb-4">
                        <label class="block mb-1 text-sm font-medium text-gray-900">Fecha de entrega</label>
                        <input type="date" name="fecha_entrega" value="{{ $tarea->fecha_entrega }}"
                            class="bg-gray-50 border border-blue-300 text-gray-900 text-sm rounded-lg block w-full p-2.5"
                            required>
                    </div>
                    <div class="mb-4">
                        <label class="block mb-1 text-sm font-medium text-gray-900">Hora límite</label>
                        <input type="time" name="hora_limite" value="{{ $tarea->hora_limite }}"
                            class="bg-gray-50 border border-blue-300 text-gray-900 text-sm rounded-lg block w-full p-2.5"
                            required>
                    </div>
                    <div class="mb-4 flex items-center gap-2">
                        <input type="checkbox" name="envio_tardio" id="envio_tardio" class="w-4 h-4"
                            {{ $tarea->envio_tardio ? 'checked' : '' }}>
                        <label for="envio_tardio" class="text-sm font-medium text-gray-900">Permitir envío tardío</label>
                    </div>
                    <div class="flex gap-3">
                        <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-bold text-sm px-5 py-2.5 rounded-lg">Actualizar</button>
                        <a href="{{ route('maestro.tareas') }}"
                            class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold text-sm px-5 py-2.5 rounded-lg">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
