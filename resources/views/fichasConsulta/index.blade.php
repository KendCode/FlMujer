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
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
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
    table th {
        background-color: #E9ECEF;
        font-weight: bold;
        text-align: center;
    }
    table td {
        vertical-align: middle !important;
        font-size: 0.95rem;
    }
    .badge {
        font-size: 0.75rem;
        padding: 0.5em 0.7em;
    }
</style>
@endsection

@section('content')
<div class="container mt-5">
    <div class="card">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="mb-0">📋 Fichas de Consulta</h3>
            <a href="{{ route('fichasConsulta.create') }}" class="btn btn-primary">
                Nueva Ficha
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-hover text-center align-middle">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>CI</th>
                        <th>Paciente</th>
                        <th>Fecha</th>
                        <th>Institución Deriva</th>
                        <th>Problemática</th>
                        <th>Orientación</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($fichas as $ficha)
                        <tr>
                            <td>{{ $ficha->idFicha }}</td>
                            <td>{{ $ficha->ci }}</td>
                            <td>
                                <strong>{{ $ficha->nombre }}</strong><br>
                                {{ $ficha->apPaterno }} {{ $ficha->apMaterno }}
                                <br>
                                <small class="text-muted">Cel. {{ $ficha->numCelular ?? 'N/A' }}</small>
                            </td>
                            <td>
                                {{ \Carbon\Carbon::parse($ficha->fecha)->format('d/m/Y') }}
                            </td>
                            <td>{{ $ficha->instDeriva ?? 'N/A' }}</td>
                            <td>
                                {{-- Penal --}}
                                @if(!empty($ficha->Penal))
                                    <span class="badge bg-danger">Penal: {{ implode(', ', $ficha->Penal) }}</span><br>
                                @endif
                                {{-- Familiar --}}
                                @if(!empty($ficha->Familiar))
                                    <span class="badge bg-warning text-dark">Familiar: {{ implode(', ', $ficha->Familiar) }}</span><br>
                                @endif
                                {{-- Otros --}}
                                @if($ficha->OtrosProblemas)
                                    <span class="badge bg-info text-dark">Otros: {{ $ficha->OtrosProblemas }}</span>
                                @endif
                            </td>
                            <td>
                                @if($ficha->legal) <span class="badge bg-primary">Legal</span> @endif
                                @if($ficha->social) <span class="badge bg-success">Social</span> @endif
                                @if($ficha->psicologico) <span class="badge bg-secondary">Psicológico</span> @endif
                                @if($ficha->espiritual) <span class="badge bg-dark">Espiritual</span> @endif
                            </td>
                            <td>
                                <a href="{{ route('fichasConsulta.edit', $ficha->idFicha) }}" 
                                   class="btn btn-sm btn-primary">
                                   Editar
                                </a>

                                {{-- <form action="{{ route('fichasConsulta.destroy', $ficha->idFicha) }}" 
                                      method="POST" 
                                      style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="btn btn-sm btn-danger" 
                                            onclick="return confirm('¿Desea eliminar esta ficha?')">
                                        🗑 Eliminar
                                    </button>
                                </form> --}}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted">
                                🚫 No hay fichas registradas.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
