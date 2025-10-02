@extends('layouts.sidebar')

@section('styles')
<style>
    body {
        background-color: #F4F4F2;
        font-family: Arial, sans-serif;
    }
    .card {
        border-radius: 1.5rem;
        border: none;
        background-color: #fff;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        padding: 2rem;
    }
    .btn-primary {
        background-color: #037E8C;
        border-color: #037E8C;
    }
    .btn-primary:hover {
        background-color: #025F66;
        border-color: #025F66;
    }
    .btn-danger {
        background-color: #D9534F;
        border-color: #D9534F;
    }
    .btn-danger:hover {
        background-color: #C9302C;
        border-color: #C9302C;
    }
    table th, table td {
        vertical-align: middle !important;
    }
</style>
@endsection

@section('content')
<div class="container mt-5">
    <div class="card">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3>Fichas de Consulta</h3>
            <a href="{{ route('fichasConsulta.create') }}" class="btn btn-primary">Nueva Ficha</a>
        </div>

        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>CI</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Fecha</th>
                        <th>Tipo</th>
                        <th>Orientación</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($fichas as $ficha)
                        <tr>
                            <td>{{ $ficha->idFicha }}</td>
                            <td>{{ $ficha->ci }}</td>
                            <td>{{ $ficha->nombre }}</td>
                            <td>{{ $ficha->apPaterno }} {{ $ficha->apMaterno }}</td>
                            <td>{{ $ficha->fecha->format('d/m/Y') }}</td>
                            <td>{{ $ficha->tipo }}</td>
                            <td>
                                @if($ficha->legal) Legal @endif
                                @if($ficha->social) | Social @endif
                                @if($ficha->psicologico) | Psicológico @endif
                                @if($ficha->espiritual) | Espiritual @endif
                            </td>
                            <td>
                                {{-- <a href="{{ route('fichasConsulta.edit', $ficha->idFicha) }}" class="btn btn-sm btn-primary">Editar</a> --}}

                                {{-- <form action="{{ route('fichas_consulta.destroy', $ficha->idFicha) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Desea eliminar esta ficha?')">Eliminar</button>
                                </form> --}}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">No hay fichas registradas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
