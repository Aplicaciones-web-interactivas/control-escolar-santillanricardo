@extends('layouts.app')
@section('content')

<div class="min-h-screen bg-blue-50">

    <nav class="bg-white border-b border-blue-100 shadow-sm px-8 py-4 flex justify-between items-center">
        <div class="flex gap-6">
            <a href="{{ route('dashboard') }}" class="text-sm font-semibold text-blue-600 hover:text-blue-800">Home</a>
            <a href="{{ route('index.materia') }}" class="text-sm font-semibold text-blue-600 hover:text-blue-800">Materias</a>
            <a href="{{ route('index.horario') }}" class="text-sm font-semibold text-blue-600 hover:text-blue-800">Horarios</a>
            <a href="{{ route('index.grupo') }}" class="text-sm font-semibold text-blue-600 hover:text-blue-800">Grupos</a>
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

        <div class="bg-white shadow rounded p-6 mb-6">
            <h2 class="text-xl font-bold mb-4">Agregar Horario</h2>
            <form action="{{ route('save.horario') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block mb-1 text-sm font-medium text-gray-900">Materia</label>
                    <select name="materia_id" class="bg-gray-50 border border-blue-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" required>
                        <option value="">Selecciona una materia</option>
                        @foreach ($materias as $materia)
                            <option value="{{ $materia->id }}">{{ $materia->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block mb-1 text-sm font-medium text-gray-900">Usuario</label>
                    <select name="user_id" class="bg-gray-50 border border-blue-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" required>
                        <option value="">Selecciona un usuario</option>
                        @foreach ($usuarios as $usuario)
                            <option value="{{ $usuario->id }}">{{ $usuario->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block mb-1 text-sm font-medium text-gray-900">Día</label>
                    <select name="dia" class="bg-gray-50 border border-blue-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" required>
                        <option value="">Selecciona un día</option>
                        @foreach (['Lunes','Martes','Miércoles','Jueves','Viernes','Sábado'] as $dia)
                            <option value="{{ $dia }}">{{ $dia }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block mb-1 text-sm font-medium text-gray-900">Hora inicio</label>
                    <input type="time" name="hora_inicio" class="bg-gray-50 border border-blue-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" required>
                </div>
                <div class="mb-4">
                    <label class="block mb-1 text-sm font-medium text-gray-900">Hora fin</label>
                    <input type="time" name="hora_fin" class="bg-gray-50 border border-blue-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" required>
                </div>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold text-sm px-5 py-2.5 rounded-lg">Guardar</button>
            </form>
        </div>

        <div class="bg-white shadow rounded p-6">
            <h2 class="text-xl font-bold mb-4">Lista de Horarios</h2>
            <table class="w-full text-sm text-left text-gray-700">
                <thead class="bg-blue-50">
                    <tr>
                        <th class="px-4 py-2 text-blue-700">Materia</th>
                        <th class="px-4 py-2 text-blue-700">Usuario</th>
                        <th class="px-4 py-2 text-blue-700">Día</th>
                        <th class="px-4 py-2 text-blue-700">Hora inicio</th>
                        <th class="px-4 py-2 text-blue-700">Hora fin</th>
                        <th class="px-4 py-2 text-blue-700">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($horarios as $horario)
                    <tr class="border-b hover:bg-blue-50">
                        <td class="px-4 py-2">{{ $horario->materia->nombre }}</td>
                        <td class="px-4 py-2">{{ $horario->user->nombre }}</td>
                        <td class="px-4 py-2">{{ $horario->dia }}</td>
                        <td class="px-4 py-2">{{ $horario->hora_inicio }}</td>
                        <td class="px-4 py-2">{{ $horario->hora_fin }}</td>
                        <td class="px-4 py-2 flex gap-4">
                            <a href="{{ route('horarios.edit', $horario->id) }}" class="text-blue-500 hover:text-blue-700 font-medium">Editar</a>
                            <form action="{{ route('eliminar.horario', $horario->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700 font-medium">Eliminar</button>
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