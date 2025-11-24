@extends('layouts.sidebar')

@section('styles')
    <style>
        body {
            background-color: #F4F4F2;
            font-family: Arial, sans-serif;
        }

        h3 {
            color: #037E8C;
        }

        .table thead {
            background-color: #13C0E5;
            color: white;
        }

        .table tbody tr:nth-child(even) {
            background-color: #F4F4F2;
        }

        .table-hover tbody tr:hover {
            background-color: #7EC544;
            color: white;
        }

        .btn-primary {
            background-color: #13C0E5;
            border-color: #13C0E5;
            color: white;
        }

        .btn-primary:hover {
            background-color: #037E8C;
            border-color: #037E8C;
            color: white;
        }

        .btn-warning {
            background-color: #F4F4F2;
            color: #037E8C;
            border: 1px solid #037E8C;
        }

        .btn-warning:hover {
            background-color: #037E8C;
            color: white;
            border-color: #037E8C;
        }

        .btn-danger {
            background-color: #7EC544;
            color: white;
            border-color: #7EC544;
        }

        .btn-danger:hover {
            background-color: #037E8C;
            border-color: #037E8C;
            color: white;
        }

        .alert-success {
            background-color: #7EC544;
            color: white;
            border: none;
        }

        .alert-info {
            background-color: #13C0E5;
            color: white;
            border: none;
        }

        .text-primary {
            color: #037E8C !important;
        }
    </style>
@endsection

@section('content')
    <div class="container mt-4">
        <h3 class="text-center text-primary fw-bold mb-4">
            Fichas de Atención y Evaluación Psicológica
        </h3>

        {{-- Mensaje de éxito --}}
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="mb-3 text-end">
            <a href="{{ route('casos.fichaAtencionEvaluacion.create', $caso->id) }}" class="btn btn-primary">
                + Nueva Ficha
            </a>
        </div>

        @if ($fichas->count() > 0)
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-primary text-center">
                        <tr>
                            <th>ID</th>
                            <th>Fecha</th>
                            <th>Nombres y Apellidos</th>
                            <th>Edad</th>
                            <th>Motivo de consulta</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($fichas as $ficha)
                            <tr class="text-center">
                                <td>{{ $ficha->id }}</td>
                                <td>{{ $ficha->fecha->format('d-m-Y') }}</td>
                                <td>{{ $ficha->nombres_apellidos }}</td>
                                <td>{{ $ficha->edad }}</td>

                                <td>{{ Str::limit($ficha->motivo_consulta, 30) }}</td>
                                @auth
                                    @if (auth()->user()->role === 'administrador')
                                        <td>
                                            <a href="{{ route('casos.fichaAtencionEvaluacion.edit', ['caso' => $caso->id, 'ficha' => $ficha->id]) }}"
                                                class="btn btn-sm btn-warning">
                                                Editar
                                            </a>

                                            <form
                                                action="{{ route('casos.fichaAtencionEvaluacion.destroy', ['caso' => $caso->id, 'ficha' => $ficha->id]) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger"
                                                    onclick="return confirm('¿Desea eliminar esta ficha?')">
                                                    Eliminar
                                                </button>
                                            </form>
                                        </td>
                                    @endif
                                @endauth
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="alert alert-info text-center">
                No hay fichas registradas para este caso.
            </div>
        @endif
    </div>
@endsection
