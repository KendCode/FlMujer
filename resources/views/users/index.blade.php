@extends('layouts.sidebar')

@section('styles')
<style>
    body {
        background-color: #f4f4f2;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .header {
        color: #037E8C;
        font-weight: 600;
        margin-bottom: 1.5rem;
    }

    .btn-create {
        background: linear-gradient(90deg, #00b894, #0984e3);
        color: #fff;
        font-weight: 500;
        border-radius: 0.5rem;
        transition: all 0.3s ease;
        padding: 0.5rem 1rem;
    }

    .btn-create:hover {
        background: linear-gradient(90deg, #0984e3, #00b894);
        color: #fff;
    }

    .alert-success {
        background-color: #d1e7dd;
        border-color: #c3e6cb;
        border-radius: 0.5rem;
    }

    .alert-error {
        background-color: #f8d7da;
        border-color: #f5c6cb;
        border-radius: 0.5rem;
    }

    .info-admin, .info-user {
        border-left: 5px solid;
        padding: 0.75rem 1rem;
        border-radius: 0.5rem;
        margin-bottom: 1rem;
    }

    .info-admin {
        background-color: #e7f3fe;
        border-color: #2196f3;
    }

    .info-user {
        background-color: #d1e7dd;
        border-color: #198754;
    }

    .table thead th {
        background-color: #e9ecef;
        font-weight: 600;
    }

    .badge {
        padding: 0.5em 0.75em;
        font-size: 0.85rem;
        border-radius: 0.5rem;
    }

    .bg-purple-100 { background-color: #e9d5ff; color: #6b21a8; }
    .bg-blue-100 { background-color: #dbeafe; color: #1e40af; }
    .bg-green-100 { background-color: #d1fae5; color: #065f46; }
    .bg-yellow-100 { background-color: #fef9c3; color: #78350f; }

    .stats-card {
        flex: 1;
        padding: 1rem;
        border-radius: 0.75rem;
        color: #fff;
        text-align: center;
        margin-right: 1rem;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }

    .stats-card:last-child {
        margin-right: 0;
    }

    .bg-success { background-color: #28a745; }
    .bg-danger { background-color: #dc3545; }
    .bg-info { background-color: #17a2b8; }

    .overflow-auto {
        max-height: 500px;
    }

    /* Estados activos/inactivos */
    .estado-activo {
        color: #28a745;
        font-weight: 600;
    }
    .estado-inactivo {
        color: #dc3545;
        font-weight: 600;
    }

    /* Botones de acciones mejorados */
    .actions-container {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
    }

    .btn-action {
        border-radius: 0.5rem;
        padding: 0.45rem 0.9rem;
        font-size: 0.85rem;
        min-width: 100px;
        transition: all 0.2s ease;
        text-align: center;
    }

    .btn-action:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.15);
    }

    .btn-edit {
        background-color: #00cded; /* morado */
        color: #fff;
        border: none;
    }
    .btn-edit:hover {
        background-color: #ffffff;
    }

    .btn-activate {
        background-color: #00b894; /* verde */
        color: #fff;
        border: none;
    }
    .btn-activate:hover {
        background-color: #a1ccc2;
    }

    .btn-deactivate {
        background-color: #30d6a4; /* rojo */
        color: #fff;
        border: none;
    }
    .btn-deactivate:hover {
        background-color: #ffffff;
    }

    .btn-delete {
        background-color: #fa0000; /* rosa */
        color: #fff;
        border: none;
    }
    .btn-delete:hover {
        background-color: #ffffff;
    }
</style>
@endsection

@section('content')
<div class="container py-3">
    <h2 class="header">Gestión de Usuarios</h2>

    <div class="d-flex justify-content-between mb-4">
        @if (auth()->user()->rol === 'administrador')
            <a href="{{ route('users.create') }}" class="btn btn-create shadow">Crear Usuario</a>
        @endif
    </div>

    <div class="bg-white shadow-sm rounded-lg p-4">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="alert alert-error">{{ session('error') }}</div>
        @endif

        @if (auth()->user()->rol === 'administrador')
            <div class="alert info-admin">
                <strong>Vista de Administrador:</strong> Puedes ver todos los usuarios (activos e inactivos)
            </div>
        @else
            <div class="alert info-user">
                <strong>Vista de {{ ucfirst(str_replace('_', ' ', auth()->user()->rol)) }}:</strong> Solo usuarios activos
            </div>
        @endif

        <div class="overflow-auto">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>CI</th>
                        <th>Nombre Completo</th>
                        <th>Email</th>
                        <th>Rol</th>
                        @if ($showInactiveUsers)<th>Estado</th>@endif
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
                                <span class="badge
                                    @if($user->rol==='administrador') bg-purple-100
                                    @elseif($user->rol==='trabajadora_social') bg-blue-100
                                    @elseif($user->rol==='abogado') bg-green-100
                                    @elseif($user->rol==='psicologo') bg-yellow-100 @endif">
                                    {{ ucfirst(str_replace('_', ' ', $user->rol)) }}
                                </span>
                            </td>
                            @if ($showInactiveUsers)
                                <td>
                                    <span class="{{ $user->estado === 'activo' ? 'estado-activo' : 'estado-inactivo' }}">
                                        {{ ucfirst($user->estado) }}
                                    </span>
                                </td>
                            @endif
                            <td>{{ $user->telefono ?? 'N/A' }}</td>
                            <td>{{ $user->fecha_ingreso ? \Carbon\Carbon::parse($user->fecha_ingreso)->format('d/m/Y') : 'N/A' }}</td>
                            <td>
                                <div class="actions-container">
                                    @if (auth()->user()->rol === 'administrador')
                                        <a href="{{ route('users.edit', $user) }}" class="btn btn-edit btn-action">Editar</a>

                                        <form action="{{ route('users.toggle-status', $user) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" 
                                                class="btn btn-action {{ $user->estado === 'activo' ? 'btn-deactivate' : 'btn-activate' }}">
                                                {{ $user->estado === 'activo' ? 'Desactivar' : 'Activar' }}
                                            </button>
                                        </form>

                                        @if ($user->id !== auth()->id())
                                            <form action="{{ route('users.destroy', $user) }}" method="POST"
                                                onsubmit="return confirm('¿Estás seguro de eliminar este usuario?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-delete btn-action">Eliminar</button>
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

        @if (auth()->user()->rol === 'administrador')
            <div class="mt-4 d-flex">
                <div class="stats-card bg-success">
                    <h5>Usuarios Activos</h5>
                    <p class="mb-0">{{ $users->where('estado', 'activo')->count() }}</p>
                </div>
                <div class="stats-card bg-danger">
                    <h5>Usuarios Inactivos</h5>
                    <p class="mb-0">{{ $users->where('estado', 'inactivo')->count() }}</p>
                </div>
                <div class="stats-card bg-info">
                    <h5>Total Usuarios</h5>
                    <p class="mb-0">{{ $users->count() }}</p>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
