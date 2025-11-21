@extends('layouts.sidebar')

@section('styles')
<style>
    body {
        background-color: #F4F4F2;
    }

    .card-custom {
        background: white;
        border-radius: 14px;
        border: none;
        box-shadow: 0 4px 14px rgba(0,0,0,0.08);
        padding: 25px;
    }

    .table thead {
        background: #037E8C;
        color: white;
    }

    .btn-success {
        background-color: #7EC544 !important;
        border-color: #7EC544 !important;
    }

    .btn-primary {
        background-color: #13C0E5 !important;
        border-color: #13C0E5 !important;
    }

    .btn-danger {
        background-color: #d9534f !important;
        border-color: #d9534f !important;
    }

    .btn-success:hover {
        background-color: #6db83c !important;
    }

    .btn-primary:hover {
        background-color: #0fa8c8 !important;
    }

    .btn-danger:hover {
        background-color: #c64542 !important;
    }

    .table img {
        border-radius: 6px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.15);
    }

    h2 {
        color: #037E8C;
        font-weight: bold;
    }
</style>
@endsection

@section('content')
<div class="container py-5">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Gestión de Actividades</h2>

        <a href="{{ route('admin.actividades.create') }}" class="btn btn-success">
            <i class="fas fa-plus"></i> Nueva Actividad
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success shadow-sm">{{ session('success') }}</div>
    @endif

    <div class="card-custom">
        <table class="table table-bordered align-middle text-center">
            <thead>
                <tr>
                    <th style="width: 35%;">Título</th>
                    <th style="width: 30%;">Imagen</th>
                    <th style="width: 35%;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($actividades as $actividad)
                <tr>
                    <td class="fw-semibold">{{ $actividad->titulo }}</td>

                    <td>
                        @if($actividad->imagen)
                            <img src="{{ asset('storage/'.$actividad->imagen) }}" width="90" height="70" style="object-fit: cover;">
                        @else
                            <span class="text-muted">Sin imagen</span>
                        @endif
                    </td>

                    <td>
                        <a href="{{ route('admin.actividades.edit', $actividad) }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-edit"></i> Editar
                        </a>

                        <form action="{{ route('admin.actividades.destroy', $actividad) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')

                            <button class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar actividad?')">
                                <i class="fas fa-trash-alt"></i> Eliminar
                            </button>
                        </form>
                    </td>

                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
