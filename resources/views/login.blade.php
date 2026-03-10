@extends('layouts.app')
@section('content')

@if ($errors->any())
    <script>
        alert("{{ implode('\n', $errors->all()) }}");
    </script>
@endif

@if (session('success'))
    <script>
        alert("{{ session('success') }}");
    </script>
@endif

<div class="bg-blue-50 min-h-screen flex items-center justify-center p-6">

    <div class="w-full max-w-md">

        <div class="bg-white rounded-xl shadow-lg border border-blue-100 p-8">

            <h2 class="text-2xl font-bold text-blue-800 mb-2">Iniciar sesión</h2>
            <p class="text-sm text-blue-400 mb-6">Ingresa tus credenciales para continuar</p>

            <form method="POST" action="{{ route('login.post') }}" class="space-y-5">
                @csrf

                <div class="flex flex-col">
                    <label class="text-sm font-semibold text-blue-700 mb-1">Clave institucional</label>
                    <input type="text" name="clave_institucional" value="{{ old('clave_institucional') }}" placeholder="Ej. 2021123456"
                        class="px-4 py-2 border border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none text-sm">
                </div>

                <div class="flex flex-col">
                    <label class="text-sm font-semibold text-blue-700 mb-1">Contraseña</label>
                    <input type="password" name="password" placeholder="Tu contraseña"
                        class="px-4 py-2 border border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none text-sm">
                </div>

                <div class="pt-2">
                    <button type="submit"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg text-sm transition">
                        Iniciar sesión
                    </button>
                </div>
            </form>

            <p class="text-center text-sm text-gray-400 mt-6">
                ¿No tienes cuenta?
                <a href="{{ route('register') }}" class="text-blue-600 hover:underline font-medium">Regístrate</a>
            </p>

        </div>
    </div>

</div>

@endsection