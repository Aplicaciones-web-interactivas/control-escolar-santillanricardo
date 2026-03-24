<nav class="bg-white border-b border-blue-100 shadow-sm px-8 py-4 flex justify-between items-center">
    <div class="flex gap-6">
        <a href="{{ route('dashboard') }}" class="text-sm font-semibold text-blue-600 hover:text-blue-800">Home</a>
        <a href="{{ route('index.materia') }}" class="text-sm font-semibold text-blue-600 hover:text-blue-800">Materias</a>
        <a href="{{ route('index.horario') }}" class="text-sm font-semibold text-blue-600 hover:text-blue-800">Horarios</a>
        <a href="{{ route('index.grupo') }}" class="text-sm font-semibold text-blue-600 hover:text-blue-800">Grupos</a>
        <a href="{{ route('index.calificacion') }}" class="text-sm font-semibold text-blue-600 hover:text-blue-800">Calificaciones</a>
        <a href="{{ route('index.inscripcion') }}" class="text-sm font-semibold text-blue-600 hover:text-blue-800">Inscripciones</a>
    </div>
    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button class="bg-red-500 hover:bg-red-600 text-white text-sm font-bold px-4 py-2 rounded-lg">Cerrar sesión</button>
    </form>
</nav>

@if (session('success'))
    <div class="bg-green-100 text-green-700 px-8 py-3 text-sm font-medium">
        {{ session('success') }}
    </div>
@endif