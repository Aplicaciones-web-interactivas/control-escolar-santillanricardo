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

    <div class="max-w-lg mx-auto p-6">
        <div class="bg-white shadow rounded p-6">
            <h2 class="text-xl font-bold mb-4">Editar Horario</h2>
            <form action="{{ route('update.horario', $horario->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label class="block mb-1 text-sm font-medium text-gray-900">Materia</label>
                    <select name="materia_id" class="bg-gray-50 border border-blue-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" required>
                        @foreach ($materias as $materia)
                            <option value="{{ $materia->id }}" {{ $horario->materia_id == $materia->id ? 'selected' : '' }}>
                                {{ $materia->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block mb-1 text-sm font-medium text-gray-900">Usuario</label>
                    <select name="user_id" class="bg-gray-50 border border-blue-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" required>
                        @foreach ($usuarios as $usuario)
                            <option value="{{ $usuario->id }}" {{ $horario->user_id == $usuario->id ? 'selected' : '' }}>
                                {{ $usuario->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block mb-1 text-sm font-medium text-gray-900">Día</label>
                    <select name="dia" class="bg-gray-50 border border-blue-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" required>
                        @foreach (['Lunes','Martes','Miércoles','Jueves','Viernes','Sábado'] as $dia)
                            <option value="{{ $dia }}" {{ $horario->dia == $dia ? 'selected' : '' }}>{{ $dia }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block mb-1 text-sm font-medium text-gray-900">Hora inicio</label>
                    <input type="time" name="hora_inicio" value="{{ $horario->hora_inicio }}" class="bg-gray-50 border border-blue-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" required>
                </div>
                <div class="mb-4">
                    <label class="block mb-1 text-sm font-medium text-gray-900">Hora fin</label>
                    <input type="time" name="hora_fin" value="{{ $horario->hora_fin }}" class="bg-gray-50 border border-blue-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" required>
                </div>
                <div class="flex gap-3">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold text-sm px-5 py-2.5 rounded-lg">Actualizar</button>
                    <a href="{{ route('index.horario') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold text-sm px-5 py-2.5 rounded-lg">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection