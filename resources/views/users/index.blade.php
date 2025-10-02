@extends('layouts.sidebar')

@section('styles')
    <style>
        body {
            background-color: #F4F4F2;
            /* Blanco */
        }

        .header {
            color: #037E8C;
            /* Verde botella */
        }

        .btn-create {
            background-color: #13C0E5;
            /* Celeste */
            color: white;
        }

        .btn-create:hover {
            background-color: #037E8C;
            /* Verde botella */
        }

        .alert-success {
            background-color: #d1e7dd;
            /* Verde claro */
            border-color: #c3e6cb;
            /* Verde más oscuro */
        }

        .alert-error {
            background-color: #f8d7da;
            /* Rojo claro */
            border-color: #f5c6cb;
            /* Rojo más oscuro */
        }

        .info-admin {
            background-color: #e7f3fe;
            /* Azul claro */
            border-left: 5px solid #2196F3;
            /* Azul */
        }

        .info-user {
            background-color: #d1e7dd;
            /* Verde claro */
            border-left: 5px solid #198754;
            /* Verde */
        }

        .table thead th {
            background-color: #e9ecef;
            /* Gris claro */
        }

        .table tbody tr.inactive {
            background-color: #f8d7da;
            /* Rojo claro */
        }
    </style>
@endsection

@section('content')

    <div class="container py-5">
        <h2 class="header mb-4">Gestión de Usuarios</h2>

        <div class="d-flex justify-content-between mb-4">
            <h2 class="font-semibold text-xl">Gestión de Usuarios</h2>
            @if (auth()->user()->rol === 'administrador')
                <a href="{{ route('users.create') }}" class="btn btn-create">Crear Usuario</a>
            @endif
        </div>

        <div class="bg-white shadow-sm rounded-lg p-4">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if (session('error'))
                <div class="alert alert-error">{{ session('error') }}</div>
            @endif

            <!-- Información según rol -->
            @if (auth()->user()->rol === 'administrador')
                <div class="alert info-admin">
                    <p class="mb-0"><strong>Vista de Administrador:</strong> Puedes ver todos los usuarios (activos e
                        inactivos)</p>
                </div>
            @else
                <div class="alert info-user">
                    <p class="mb-0"><strong>Vista de
                            {{ ucfirst(str_replace('_', ' ', auth()->user()->rol)) }}:</strong> Solo usuarios activos
                    </p>
                </div>
            @endif

            <div class="overflow-auto">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>CI</th>
                            <th>Nombre Completo</th>
                            <th>Email</th>
                            <th>Rol</th>
                            @if ($showInactiveUsers)
                                <th>Estado</th>
                            @endif
                            <th>Teléfono</th>
                            <th>Fecha Ingreso</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                            <tr class="{{ $user->estado === 'inactivo' ? 'inactive' : '' }}">
                                <td>{{ $user->ci }}</td>
                                <td>
                                    {{ $user->name }} {{ $user->apellido }}
                                    @if ($user->estado === 'inactivo')
                                        <span class="text-danger">(Inactivo)</span>
                                    @endif
                                </td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    <span
                                        class="badge 
    @if ($user->rol === 'administrador') bg-purple-100 text-purple-800
    @elseif($user->rol === 'trabajadora_social') bg-blue-100 text-blue-800
    @elseif($user->rol === 'abogado') bg-green-100 text-green-800
    @elseif($user->rol === 'psicologo') bg-yellow-100 text-yellow-800 @endif">
                                        {{ ucfirst(str_replace('_', ' ', $user->rol)) }}
                                    </span>

                                </td>
                                @if ($showInactiveUsers)
                                    <td>{{ $user->estado }}</td>
                                @endif
                                <td>{{ $user->telefono ?? 'N/A' }}</td>
                                <td>{{ $user->fecha_ingreso ? \Carbon\Carbon::parse($user->fecha_ingreso)->format('d/m/Y') : 'N/A' }}
                                </td>
                                <td>
                                    <div class="d-flex">
                                        @if (auth()->user()->rol === 'administrador')
                                            <a href="{{ route('users.edit', $user) }}"
                                                class="btn btn-warning btn-sm me-2">Editar</a>

                                            <form action="{{ route('users.toggle-status', $user) }}" method="POST"
                                                class="me-2">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit"
                                                    class="btn {{ $user->estado === 'activo' ? 'btn-danger' : 'btn-success' }} btn-sm">
                                                    {{ $user->estado === 'activo' ? 'Desactivar' : 'Activar' }}
                                                </button>
                                            </form>

                                            @if ($user->id !== auth()->id())
                                                <form action="{{ route('users.destroy', $user) }}" method="POST"
                                                    onsubmit="return confirm('¿Estás seguro de eliminar este usuario?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="btn btn-danger btn-sm">Eliminar</button>
                                                </form>
                                            @endif
                                        @else
                                            <span class="text-muted">Sin permisos</span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted">No hay usuarios para mostrar.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Estadísticas (solo para admins) -->
            @if (auth()->user()->rol === 'administrador')
                <div class="mt-4 d-flex justify-content-between">
                    <div class="bg-success text-white p-3 rounded">
                        <h5>Usuarios Activos</h5>
                        <p class="mb-0">{{ $users->where('estado', 'activo')->count() }}</p>
                    </div>
                    <div class="bg-danger text-white p-3 rounded">
                        <h5>Usuarios Inactivos</h5>
                        <p class="mb-0">{{ $users->where('estado', 'inactivo')->count() }}</p>
                    </div>
                    <div class="bg-info text-white p-3 rounded">
                        <h5>Total Usuarios</h5>
                        <p class="mb-0">{{ $users->count() }}</p>
                    </div>
                </div>
            @endif

        </div>
    </div>
@endsection
