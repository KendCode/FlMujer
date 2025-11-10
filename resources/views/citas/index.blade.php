@extends('layouts.sidebar')

@section('content')
<div class="container py-4" style="background-color: #F4F4F2; border-radius: 12px;">
    <h2 class="mb-4 text-center" style="color: #037E8C;">Gestión de Citas</h2>

    <div class="d-flex justify-content-between mb-3">
        <a href="{{ route('citas.create') }}" class="btn text-white" style="background-color: #13C0E5;">
            + Nueva Cita
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success text-center">{{ session('success') }}</div>
    @endif

    <div class="table-responsive">
        <table class="table table-hover align-middle text-center">
            <thead style="background-color: #037E8C; color: white;">
                <tr>
                    <th>Nombre Completo</th>
                    <th>Psicólogo</th>
                    <th>Próxima Atención</th>
                    <th>Hora</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($citas as $cita)
                <tr>
                    <td>{{ $cita->nombre }} {{ $cita->apellido_paterno }} {{ $cita->apellido_materno }}</td>
                    <td>{{ $cita->psicologo->name ?? 'No asignado' }}</td>
                    <td>
                        @php
                            \Carbon\Carbon::setLocale('es');
                            $fecha = \Carbon\Carbon::parse($cita->proxima_atencion);
                        @endphp
                        {{ ucfirst($fecha->translatedFormat('l d \d\e F')) }}
                    </td>
                    <td>{{ date('H:i', strtotime($cita->hora)) }}</td>
                    <td>
                        <span class="badge" style="background-color: #7EC544;">{{ ucfirst($cita->estado) }}</span>
                    </td>
                    <td>
                        <a href="{{ route('citas.edit', $cita) }}" 
                           class="btn btn-sm text-white" style="background-color: #13C0E5;">
                           Editar
                        </a>

                        <!-- Botón para abrir modal -->
                        <button class="btn btn-sm text-white" style="background-color: #E53E3E;"
                                data-bs-toggle="modal" data-bs-target="#deleteModal{{ $cita->id }}">
                            Eliminar
                        </button>

                        <!-- Modal de confirmación -->
                        <div class="modal fade" id="deleteModal{{ $cita->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content border-0 shadow" style="border-radius: 12px;">
                                    <div class="modal-header" style="background-color: #037E8C; color: white;">
                                        <h5 class="modal-title">Confirmar Eliminación</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body text-center">
                                        <p>¿Estás seguro de eliminar la cita de 
                                           <strong>{{ $cita->nombre }} {{ $cita->apellido_paterno }}</strong>?</p>
                                    </div>
                                    <div class="modal-footer justify-content-center">
                                        <button type="button" class="btn text-white" data-bs-dismiss="modal" style="background-color: #7EC544;">
                                            Cancelar
                                        </button>
                                        <form action="{{ route('citas.destroy', $cita) }}" method="POST" style="display:inline;">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn text-white" style="background-color: #E53E3E;">
                                                Eliminar
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Fin del modal -->
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
