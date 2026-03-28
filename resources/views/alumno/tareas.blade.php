@extends('layouts.app')
@section('content')
    <div class="min-h-screen bg-blue-50">

        <nav class="bg-white border-b border-blue-100 shadow-sm px-8 py-4 flex justify-between items-center">
            <div class="flex gap-6">
                <a href="{{ route('alumno.dashboard') }}"
                    class="text-sm font-semibold text-blue-600 hover:text-blue-800">Home</a>
                <a href="{{ route('alumno.tareas') }}"
                    class="text-sm font-semibold text-blue-600 hover:text-blue-800">Tareas</a>
            </div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="bg-red-500 hover:bg-red-600 text-white text-sm font-bold px-4 py-2 rounded-lg">Cerrar
                    sesión</button>
            </form>
        </nav>

        <div class="max-w-5xl mx-auto p-6">

            @if (session('success'))
                <div class="bg-green-100 text-green-700 p-3 rounded mb-4">{{ session('success') }}</div>
            @endif

            @if ($errors->any())
                <div class="bg-red-100 text-red-700 p-3 rounded mb-4">{{ $errors->first() }}</div>
            @endif

            {{-- Tareas pendientes --}}
            <div class="bg-white shadow rounded p-6 mb-6">
                <h2 class="text-xl font-bold mb-4">Tareas Pendientes</h2>
                <table class="w-full text-sm text-left text-gray-700">
                    <thead class="bg-blue-50">
                        <tr>
                            <th class="px-4 py-2 text-blue-700">Título</th>
                            <th class="px-4 py-2 text-blue-700">Descripción</th>
                            <th class="px-4 py-2 text-blue-700">Fecha límite</th>
                            <th class="px-4 py-2 text-blue-700">Entregar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($tareasPendientes as $tarea)
                            <tr class="border-b hover:bg-blue-50">
                                <td class="px-4 py-2">{{ $tarea->titulo }}</td>
                                <td class="px-4 py-2">{{ $tarea->descripcion }}</td>
                                <td class="px-4 py-2">
                                    {{ $tarea->fecha_entrega }} {{ $tarea->hora_limite }}
                                    @php
                                        $limite = \Carbon\Carbon::parse(
                                            $tarea->fecha_entrega . ' ' . $tarea->hora_limite,
                                            'America/Mexico_City',
                                        );
                                        $ahora = now('America/Mexico_City');
                                        $diffSegundos = $ahora->diffInSeconds($limite, false);
                                        $horas = (int) ($diffSegundos / 3600);
                                        $minutos = (int) (($diffSegundos % 3600) / 60);
                                    @endphp

                                    @if ($ahora->greaterThan($limite))
                                        <span class="text-red-500 text-xs block">Plazo vencido
                                            {{ $tarea->envio_tardio ? '(tardío permitido)' : '' }}</span>
                                    @else
                                        <span class="text-green-500 text-xs block">
                                            @if ($horas > 0)
                                                Faltan {{ $horas }} hora{{ $horas != 1 ? 's' : '' }} y
                                                {{ $minutos }} minuto{{ $minutos != 1 ? 's' : '' }}
                                            @else
                                                Faltan {{ $minutos }} minuto{{ $minutos != 1 ? 's' : '' }}
                                            @endif
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-2">
                                    <form action="{{ route('alumno.entregar', $tarea->id) }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <input type="file" name="archivo" accept=".pdf"
                                            id="archivo_{{ $tarea->id }}" class="hidden" onchange="this.form.submit()">
                                        <button type="button"
                                            onclick="document.getElementById('archivo_{{ $tarea->id }}').click()"
                                            class="bg-blue-600 hover:bg-blue-700 text-white font-bold text-sm px-4 py-1.5 rounded-lg">
                                            Subir PDF
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-4 text-center text-gray-400">No hay tareas pendientes.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Tareas entregadas --}}
            <div class="bg-white shadow rounded p-6">
                <h2 class="text-xl font-bold mb-4">Tareas Entregadas</h2>
                <table class="w-full text-sm text-left text-gray-700">
                    <thead class="bg-blue-50">
                        <tr>
                            <th class="px-4 py-2 text-blue-700">Tarea</th>
                            <th class="px-4 py-2 text-blue-700">Archivo</th>
                            <th class="px-4 py-2 text-blue-700">Fecha</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($tareasEntregadas as $entrega)
                            <tr class="border-b hover:bg-blue-50">
                                <td class="px-4 py-2">{{ $entrega->tarea->titulo }}</td>
                                <td class="px-4 py-2">
                                    <a href="{{ asset('storage/' . $entrega->archivo) }}" target="_blank"
                                        class="text-blue-500 hover:text-blue-700 font-medium">
                                        Ver PDF
                                    </a>
                                </td>
                                <td class="px-4 py-2">{{ $entrega->created_at->format('d/m/Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-4 py-4 text-center text-gray-400">No has entregado tareas aún.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="mt-4">
                    {{ $tareasEntregadas->links() }}
                </div>
            </div>

        </div>
    </div>
@endsection
