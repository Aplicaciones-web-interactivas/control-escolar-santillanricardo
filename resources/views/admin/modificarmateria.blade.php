@extends('layouts.app')
@section('content')

<div class="max-w-lg mx-auto p-6">
    <div class="bg-white shadow rounded p-6">
        <h2 class="text-xl font-bold mb-4">Editar Materia</h2>

        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('update.materia', $materia->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label class="block mb-1 text-sm font-medium text-gray-900">Nombre</label>
                <input type="text" name="nombre" value="{{ $materia->nombre }}"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5"
                    required>
            </div>
            <div class="mb-4">
                <label class="block mb-1 text-sm font-medium text-gray-900">Clave</label>
                <input type="text" name="clave" value="{{ $materia->clave }}"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5"
                    required>
            </div>
            <div class="flex gap-3">
                <button type="submit"
                    class="text-white bg-blue-700 hover:bg-blue-800 font-medium rounded-lg text-sm px-5 py-2.5">
                    Actualizar
                </button>
                <a href="{{ route('index.materia') }}"
                    class="text-gray-700 bg-gray-200 hover:bg-gray-300 font-medium rounded-lg text-sm px-5 py-2.5">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>

@endsection