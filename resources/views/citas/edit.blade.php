@extends('layouts.sidebar')

@section('content')
    <div class="container py-4" style="background-color: #F4F4F2; border-radius: 12px;">
        <div class="mx-auto p-4 shadow" style="max-width: 800px; background-color: white; border-radius: 12px;">
            <h2 class="text-center mb-4" style="color: #037E8C;">
                <i class="bi bi-pencil-square"></i> Editar Cita
            </h2>

            {{-- Mensajes de error --}}
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>¡Error!</strong> Por favor corrige los siguientes errores:
                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            {{-- Mensaje de sesión --}}
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form action="{{ route('citas.update', $cita) }}" method="POST" id="formEditarCita">
                @csrf
                @method('PUT')

                {{-- Datos del Paciente --}}
                <div class="mb-4">
                    <h5 class="border-bottom pb-2" style="color: #037E8C;">
                        <i class="bi bi-person-fill"></i> Datos del Paciente
                    </h5>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label" style="color: #037E8C;">
                            Nombre <span class="text-danger">*</span>
                        </label>
                        <input 
                            type="text" 
                            name="nombre" 
                            class="form-control shadow-sm @error('nombre') is-invalid @enderror" 
                            value="{{ old('nombre', $cita->nombre) }}"
                            required
                            maxlength="50"
                            pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+"
                            title="Solo se permiten letras y espacios"
                        >
                        @error('nombre')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label" style="color: #037E8C;">
                            Apellido Paterno <span class="text-danger">*</span>
                        </label>
                        <input 
                            type="text" 
                            name="apellido_paterno" 
                            class="form-control shadow-sm @error('apellido_paterno') is-invalid @enderror"
                            value="{{ old('apellido_paterno', $cita->apellido_paterno) }}"
                            required
                            maxlength="50"
                            pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+"
                            title="Solo se permiten letras y espacios"
                        >
                        @error('apellido_paterno')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label" style="color: #037E8C;">
                            Apellido Materno <span class="text-danger">*</span>
                        </label>
                        <input 
                            type="text" 
                            name="apellido_materno" 
                            class="form-control shadow-sm @error('apellido_materno') is-invalid @enderror"
                            value="{{ old('apellido_materno', $cita->apellido_materno) }}"
                            required
                            maxlength="50"
                            pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+"
                            title="Solo se permiten letras y espacios"
                        >
                        @error('apellido_materno')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Datos de la Cita --}}
                <div class="mb-4 mt-4">
                    <h5 class="border-bottom pb-2" style="color: #037E8C;">
                        <i class="bi bi-calendar-check"></i> Datos de la Cita
                    </h5>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label" style="color: #037E8C;">
                            Fecha de Atención <span class="text-danger">*</span>
                        </label>
                        <div class="input-group shadow-sm">
                            <span class="input-group-text" style="background-color: #13C0E5; color: white;">
                                <i class="bi bi-calendar-event"></i>
                            </span>
                            <input 
                                type="date" 
                                name="proxima_atencion" 
                                id="fecha_atencion"
                                class="form-control @error('proxima_atencion') is-invalid @enderror"
                                value="{{ old('proxima_atencion', $cita->proxima_atencion) }}"
                                required
                            >
                            @error('proxima_atencion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <small class="text-muted">Fecha actual: {{ $cita->proxima_atencion }}</small>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label" style="color: #037E8C;">
                            Hora <span class="text-danger">*</span>
                        </label>
                        <div class="input-group shadow-sm">
                            <span class="input-group-text" style="background-color: #7EC544; color: white;">
                                <i class="bi bi-clock"></i>
                            </span>
                            <input 
                                type="time" 
                                name="hora" 
                                id="hora_atencion"
                                class="form-control @error('hora') is-invalid @enderror"
                                value="{{ old('hora', $cita->hora) }}"
                                required
                                min="08:00"
                                max="18:00"
                            >
                            @error('hora')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <small class="text-muted">Horario: 08:00 - 18:00</small>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-4">
                        <label class="form-label" style="color: #037E8C;">
                            Psicólogo Asignado <span class="text-danger">*</span>
                        </label>
                        <select 
                            name="usuario_id" 
                            class="form-select shadow-sm @error('usuario_id') is-invalid @enderror" 
                            required
                        >
                            <option value="">-- Seleccione un psicólogo --</option>
                            @foreach ($psicologos as $p)
                                <option 
                                    value="{{ $p->id }}" 
                                    {{ old('usuario_id', $cita->usuario_id) == $p->id ? 'selected' : '' }}
                                >
                                    {{ $p->name }} {{ $p->apellido }}
                                </option>
                            @endforeach
                        </select>
                        @error('usuario_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-4">
                        <label class="form-label" style="color: #037E8C;">
                            Estado de la Cita <span class="text-danger">*</span>
                        </label>
                        <select 
                            name="estado" 
                            id="estado_cita"
                            class="form-select shadow-sm @error('estado') is-invalid @enderror"
                            required
                        >
                            <option value="Pendiente" {{ old('estado', $cita->estado) == 'Pendiente' ? 'selected' : '' }}>
                                🕐 Pendiente
                            </option>
                            <option value="Confirmada" {{ old('estado', $cita->estado) == 'Confirmada' ? 'selected' : '' }}>
                                ✅ Confirmada
                            </option>
                            <option value="Cancelada" {{ old('estado', $cita->estado) == 'Cancelada' ? 'selected' : '' }}>
                                ❌ Cancelada
                            </option>
                        </select>
                        @error('estado')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        
                        {{-- Badge de estado actual --}}
                        <small class="d-block mt-2">
                            Estado actual: 
                            @php
                                $badgeClass = match($cita->estado) {
                                    'Confirmada' => 'bg-success',
                                    'Cancelada' => 'bg-danger',
                                    default => 'bg-warning text-dark'
                                };
                            @endphp
                            <span class="badge {{ $badgeClass }}">{{ $cita->estado }}</span>
                        </small>
                    </div>
                </div>

                {{-- Información de auditoría --}}
                <div class="alert alert-light border" role="alert">
                    <small class="text-muted">
                        <i class="bi bi-info-circle"></i>
                        <strong>Información de registro:</strong><br>
                        Creada: {{ $cita->created_at->format('d/m/Y H:i') }}<br>
                        Última modificación: {{ $cita->updated_at->format('d/m/Y H:i') }}
                    </small>
                </div>

                {{-- Botones de Acción --}}
                <div class="d-flex justify-content-center gap-3 mt-4">
                    <button 
                        type="submit" 
                        class="btn text-white px-4 shadow-sm" 
                        style="background-color: #13C0E5;"
                    >
                        <i class="bi bi-save"></i> Actualizar Cita
                    </button>
                    <a 
                        href="{{ route('citas.index') }}" 
                        class="btn text-white px-4 shadow-sm" 
                        style="background-color: #037E8C;"
                    >
                        <i class="bi bi-x-circle"></i> Cancelar
                    </a>
                    {{-- <button 
                        type="button" 
                        class="btn btn-danger px-4 shadow-sm" 
                        data-bs-toggle="modal" 
                        data-bs-target="#modalEliminar"
                    >
                        <i class="bi bi-trash"></i> Eliminar
                    </button> --}}
                </div>
            </form>
        </div>
    </div>

    {{-- Modal de Confirmación de Eliminación --}}
    <div class="modal fade" id="modalEliminar" tabindex="-1" aria-labelledby="modalEliminarLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">

    <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="modalEliminarLabel">
                        <i class="bi bi-exclamation-triangle"></i> Confirmar Eliminación
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="mb-2">¿Está seguro que desea eliminar esta cita?</p>
                    <p class="text-muted mb-2">
                        <strong>Paciente:</strong> {{ $cita->nombre }} {{ $cita->apellido_paterno }} {{ $cita->apellido_materno }}<br>
                        <strong>Fecha:</strong> {{ \Carbon\Carbon::parse($cita->proxima_atencion)->format('d/m/Y') }} - {{ $cita->hora }}
                    </p>
                    <div class="alert alert-warning mt-3 mb-0">
                        <small><i class="bi bi-exclamation-circle"></i> Esta acción no se puede deshacer.</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x"></i> Cancelar
                    </button>
                    <button type="button" class="btn btn-danger" id="btnConfirmarEliminar">
                        <i class="bi bi-trash"></i> Sí, Eliminar
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Formulario oculto para eliminar --}}
    <form id="formEliminar" action="{{ route('citas.destroy', $cita) }}" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>

    @push('styles')
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
        @endpush
        
        @push('scripts')
        
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Configurar fecha mínima (hoy)
                const hoy = new Date().toISOString().split('T')[0];
                document.getElementById('fecha_atencion').setAttribute('min', hoy);

                // Inicializar Flatpickr
                flatpickr("#fecha_atencion", {
                    dateFormat: "Y-m-d",
                    locale: "es",
                    minDate: "today",
                    maxDate: new Date().fp_incr(90),
                    disable: [
                        function(date) {
                            return (date.getDay() === 0); // Deshabilitar domingos
                        }
                    ],
                    onChange: function(selectedDates, dateStr, instance) {
                        console.log('Fecha actualizada:', dateStr);
                    }
                });

                // Validación del horario
                const form = document.getElementById('formEditarCita');
                form.addEventListener('submit', function(e) {
                    const hora = document.getElementById('hora_atencion').value;
                    if (hora) {
                        const [horas, minutos] = hora.split(':');
                        const horaNum = parseInt(horas);
                        
                        if (horaNum < 8 || horaNum >= 18) {
                            e.preventDefault();
                            alert('Por favor seleccione una hora entre 08:00 y 18:00');
                            return false;
                        }
                    }

                    // Confirmación de actualización
                    const confirmacion = confirm('¿Está seguro que desea actualizar esta cita?');
                    if (!confirmacion) {
                        e.preventDefault();
                        return false;
                    }
                });

                // Auto-capitalización de nombres
                const camposTexto = ['nombre', 'apellido_paterno', 'apellido_materno'];
                camposTexto.forEach(campo => {
                    const input = document.querySelector(`input[name="${campo}"]`);
                    if (input) {
                        input.addEventListener('blur', function() {
                            this.value = this.value
                                .toLowerCase()
                                .split(' ')
                                .map(word => word.charAt(0).toUpperCase() + word.slice(1))
                                .join(' ');
                        });
                    }
                });

                // Indicador visual de cambio de estado
                const selectEstado = document.getElementById('estado_cita');
                if (selectEstado) {
                    selectEstado.addEventListener('change', function() {
                        const estadoOriginal = '{{ $cita->estado }}';
                        if (this.value !== estadoOriginal) {
                            this.classList.add('border-warning');
                            this.classList.add('border-3');
                        } else {
                            this.classList.remove('border-warning');
                            this.classList.remove('border-3');
                        }
                    });
                }

                // Manejar eliminación
                const btnConfirmarEliminar = document.getElementById('btnConfirmarEliminar');
                if (btnConfirmarEliminar) {
                    btnConfirmarEliminar.addEventListener('click', function() {
                        // Cerrar el modal
                        const modal = bootstrap.Modal.getInstance(document.getElementById('modalEliminar'));
                        modal.hide();
                        
                        // Enviar el formulario de eliminación
                        document.getElementById('formEliminar').submit();
                    });
                }

                // Debug: verificar que Bootstrap está cargado
                if (typeof bootstrap === 'undefined') {
                    console.error('Bootstrap no está cargado correctamente');
                }
            });
        </script>
    @endpush
@endsection