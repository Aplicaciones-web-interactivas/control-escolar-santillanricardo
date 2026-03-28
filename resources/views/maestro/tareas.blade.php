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
                <button class="bg-red-500 hover:bg-red-600 text-white text-sm font-bold px-4 py-2 rounded-lg">Cerrar sesión</button>
            </form>
        </nav>

        <div class="max-w-5xl mx-auto p-6">

            @if ($errors->any())
                <div class="bg-red-100 text-red-700 p-3 rounded mb-4">{{ $errors->first() }}</div>
            @endif

            @if (session('success'))
                <div class="bg-green-100 text-green-700 p-3 rounded mb-4">{{ session('success') }}</div>
            @endif

            {{-- Tareas activas --}}
            <div class="bg-white shadow rounded p-6 mb-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-bold">Tareas Asignadas</h2>
                    <button onclick="document.getElementById('modalTarea').classList.remove('hidden')"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-bold text-sm px-4 py-2 rounded-lg">
                        + Nueva Tarea
                    </button>
                </div>
                <table class="w-full text-sm text-left text-gray-700">
                    <thead class="bg-blue-50">
                        <tr>
                            <th class="px-4 py-2 text-blue-700">Título</th>
                            <th class="px-4 py-2 text-blue-700">Grupo</th>
                            <th class="px-4 py-2 text-blue-700">Fecha límite</th>
                            <th class="px-4 py-2 text-blue-700">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($tareasActivas as $tarea)
                            <tr class="border-b hover:bg-blue-50">
                                <td class="px-4 py-2">{{ $tarea->titulo }}</td>
                                <td class="px-4 py-2">{{ $tarea->grupo->nombre }}</td>
                                <td class="px-4 py-2">{{ $tarea->fecha_entrega }} {{ $tarea->hora_limite }}</td>
                                <td class="px-4 py-2 flex gap-4">
                                    <a href="{{ route('maestro.edit.tarea', $tarea->id) }}"
                                        class="text-blue-500 hover:text-blue-700 font-medium">Editar</a>
                                    <a href="{{ route('maestro.entregas', $tarea->id) }}"
                                        class="text-green-500 hover:text-green-700 font-medium">Ver entregas</a>
                                    <form action="{{ route('maestro.delete.tarea', $tarea->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('¿Estás seguro de eliminar esta tarea?')"
                                            class="text-red-500 hover:text-red-700 font-medium">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-4 text-center text-gray-400">No hay tareas activas.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="mt-4">{{ $tareasActivas->links() }}</div>
            </div>

            {{-- Tareas finalizadas --}}
            <div class="bg-white shadow rounded p-6">
                <h2 class="text-xl font-bold mb-4">Tareas Finalizadas</h2>
                <table class="w-full text-sm text-left text-gray-700">
                    <thead class="bg-blue-50">
                        <tr>
                            <th class="px-4 py-2 text-blue-700">Título</th>
                            <th class="px-4 py-2 text-blue-700">Grupo</th>
                            <th class="px-4 py-2 text-blue-700">Fecha límite</th>
                            <th class="px-4 py-2 text-blue-700">Entregas</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($tareasFinalizadas as $tarea)
                            <tr class="border-b hover:bg-blue-50">
                                <td class="px-4 py-2">{{ $tarea->titulo }}</td>
                                <td class="px-4 py-2">{{ $tarea->grupo->nombre }}</td>
                                <td class="px-4 py-2 text-red-500">{{ $tarea->fecha_entrega }} {{ $tarea->hora_limite }}</td>
                                <td class="px-4 py-2">
                                    <a href="{{ route('maestro.entregas', $tarea->id) }}"
                                        class="text-green-500 hover:text-green-700 font-medium">Ver entregas</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-4 text-center text-gray-400">No hay tareas finalizadas.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="mt-4">{{ $tareasFinalizadas->links() }}</div>
            </div>

        </div>
    </div>

    {{-- Modal agregar tarea --}}
    <div id="modalTarea" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-lg">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold">Nueva Tarea</h2>
                <button onclick="document.getElementById('modalTarea').classList.add('hidden')"
                    class="text-gray-400 hover:text-gray-600 text-xl font-bold">✕</button>
            </div>
            <form action="{{ route('maestro.save.tarea') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block mb-1 text-sm font-medium text-gray-900">Grupo</label>
                    <select name="grupo_id" class="bg-gray-50 border border-blue-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" required>
                        <option value="">Selecciona un grupo</option>
                        @foreach ($grupos as $grupo)
                            <option value="{{ $grupo->id }}">{{ $grupo->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block mb-1 text-sm font-medium text-gray-900">Título</label>
                    <input type="text" name="titulo"
                        class="bg-gray-50 border border-blue-300 text-gray-900 text-sm rounded-lg block w-full p-2.5"
                        placeholder="Ej. Tarea 1" required>
                </div>
                <div class="mb-4">
                    <label class="block mb-1 text-sm font-medium text-gray-900">Descripción</label>
                    <textarea name="descripcion" rows="3"
                        class="bg-gray-50 border border-blue-300 text-gray-900 text-sm rounded-lg block w-full p-2.5"
                        placeholder="Describe la tarea..." required></textarea>
                </div>
                <div class="mb-4">
                    <label class="block mb-1 text-sm font-medium text-gray-900">Fecha de entrega</label>
                    <input type="date" name="fecha_entrega"
                        class="bg-gray-50 border border-blue-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" required>
                </div>
                <div class="mb-4">
                    <label class="block mb-1 text-sm font-medium text-gray-900">Hora límite</label>
                    <input type="time" name="hora_limite"
                        class="bg-gray-50 border border-blue-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" required>
                </div>
                <div class="mb-4 flex items-center gap-2">
                    <input type="checkbox" name="envio_tardio" id="envio_tardio" class="w-4 h-4">
                    <label for="envio_tardio" class="text-sm font-medium text-gray-900">Permitir envío tardío</label>
                </div>
                <div class="flex gap-3">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold text-sm px-5 py-2.5 rounded-lg">Guardar</button>
                    <button type="button" onclick="document.getElementById('modalTarea').classList.add('hidden')"
                        class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold text-sm px-5 py-2.5 rounded-lg">Cancelar</button>
                </div>
            </form>
        </div>
    </div>

@endsection