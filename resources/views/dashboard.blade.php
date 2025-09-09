<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Bienvenido, {{ Auth::user()->name }} {{ Auth::user()->apellido }} ({{ Auth::user()->rol }})
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <p class="text-gray-900 dark:text-gray-100">
                    {{ __("¡Has iniciado sesión correctamente!") }}
                </p>

                {{-- ✅ Mostrar link solo al administrador --}}
                @if(Auth::user()->rol === 'administrador')
                    <div class="mt-4">
                        <a href="{{ route('users.index') }}" 
                           class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Gestionar Usuarios
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
