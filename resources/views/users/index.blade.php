<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Gestión de Usuarios') }}
            </h2>
            @if (auth()->user()->rol === 'administrador')
                <a href="{{ route('users.create') }}"
                   class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                   Crear Usuario
                </a>
            @endif
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                            {{ session('error') }}
                        </div>
                    @endif

                    <!-- Información según rol -->
                    @if (auth()->user()->rol === 'administrador')
                        <div class="mb-4 p-3 bg-blue-50 rounded-lg">
                            <p class="text-sm text-blue-800">
                                <strong>Vista de Administrador:</strong> Puedes ver todos los usuarios (activos e inactivos)
                            </p>
                        </div>
                    @else
                        <div class="mb-4 p-3 bg-green-50 rounded-lg">
                            <p class="text-sm text-green-800">
                                <strong>Vista de {{ ucfirst(str_replace('_', ' ', auth()->user()->rol)) }}:</strong>
                                Solo usuarios activos
                            </p>
                        </div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="min-w-full table-auto">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="px-4 py-2 text-left">CI</th>
                                    <th class="px-4 py-2 text-left">Nombre Completo</th>
                                    <th class="px-4 py-2 text-left">Email</th>
                                    <th class="px-4 py-2 text-left">Rol</th>
                                    @if ($showInactiveUsers)
                                        <th class="px-4 py-2 text-left">Estado</th>
                                    @endif
                                    <th class="px-4 py-2 text-left">Teléfono</th>
                                    <th class="px-4 py-2 text-left">Fecha Ingreso</th>
                                    <th class="px-4 py-2 text-left">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($users as $user)
                                    <tr class="border-b {{ $user->estado === 'inactivo' ? 'bg-red-50' : '' }}">
                                        <td class="px-4 py-2">{{ $user->ci }}</td>
                                        <td class="px-4 py-2">
                                            {{ $user->name }} {{ $user->apellido }}
                                            @if ($user->estado === 'inactivo')
                                                <span class="text-red-500 text-xs">(Inactivo)</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-2">{{ $user->email }}</td>
                                        <td class="px-4 py-2">
                                            <span class="px-2 py-1 rounded-full text-xs
                                                @if ($user->rol === 'administrador') bg-purple-100 text-purple-800
                                                @elseif($user->rol === 'trabajadora_social') bg-blue-100 text-blue-800
                                                @elseif($user->rol === 'abogado') bg-green-100 text-green-800
                                                @elseif($user->rol === 'psicologo') bg-yellow-100 text-yellow-800 @endif">
                                                {{ ucfirst(str_replace('_', ' ', $user->rol)) }}
                                            </span>
                                        </td>
                                        @if ($showInactiveUsers)
                                            <td class="px-4 py-2">{{ $user->estado }}</td>
                                        @endif
                                        <td class="px-4 py-2">{{ $user->telefono ?? 'N/A' }}</td>
                                        <td class="px-4 py-2">
                                            {{ $user->fecha_ingreso ? \Carbon\Carbon::parse($user->fecha_ingreso)->format('d/m/Y') : 'N/A' }}
                                        </td>
                                        <td class="px-4 py-2">
                                            <div class="flex space-x-2">
                                                @if (auth()->user()->rol === 'administrador')
                                                    <a href="{{ route('users.edit', $user) }}"
                                                       class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-xs">
                                                       Editar
                                                    </a>

                                                    <form action="{{ route('users.toggle-status', $user) }}"
                                                          method="POST" class="inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit"
                                                                class="px-3 py-1 rounded text-xs text-white
                                                                @if ($user->estado === 'activo') bg-red-500 hover:bg-red-600
                                                                @else bg-green-500 hover:bg-green-600 @endif">
                                                            @if ($user->estado === 'activo')
                                                                Desactivar
                                                            @else
                                                                Activar
                                                            @endif
                                                        </button>
                                                    </form>

                                                    @if ($user->id !== auth()->id())
                                                        <form action="{{ route('users.destroy', $user) }}"
                                                              method="POST" class="inline"
                                                              onsubmit="return confirm('¿Estás seguro de eliminar este usuario?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                    class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-xs">
                                                                Eliminar
                                                            </button>
                                                        </form>
                                                    @endif
                                                @else
                                                    <span class="text-gray-500 text-xs">Sin permisos</span>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="px-4 py-8 text-center text-gray-500">
                                            No hay usuarios para mostrar.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Estadísticas (solo para admins) -->
                    @if (auth()->user()->rol === 'administrador')
                        <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="bg-green-100 p-4 rounded">
                                <h3 class="font-semibold text-green-800">Usuarios Activos</h3>
                                <p class="text-2xl font-bold text-green-600">
                                    {{ $users->where('estado', 'activo')->count() }}
                                </p>
                            </div>
                            <div class="bg-red-100 p-4 rounded">
                                <h3 class="font-semibold text-red-800">Usuarios Inactivos</h3>
                                <p class="text-2xl font-bold text-red-600">
                                    {{ $users->where('estado', 'inactivo')->count() }}
                                </p>
                            </div>
                            <div class="bg-blue-100 p-4 rounded">
                                <h3 class="font-semibold text-blue-800">Total Usuarios</h3>
                                <p class="text-2xl font-bold text-blue-600">
                                    {{ $users->count() }}
                                </p>
                            </div>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
