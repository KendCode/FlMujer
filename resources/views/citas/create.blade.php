@extends('layouts.sidebar')

@section('content')
    <div class="container py-4" style="background-color: #F4F4F2; border-radius: 12px;">
        <div class="mx-auto p-4 shadow" style="max-width: 800px; background-color: white; border-radius: 12px;">
            <h2 class="text-center mb-4" style="color: #037E8C;">Registrar Nueva Cita</h2>

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

            <form action="{{ route('citas.store') }}" method="POST" id="formCita">
                @csrf

                {{-- Datos del Paciente --}}
                <div class="mb-4">
                    <h5 class="border-bottom pb-2" style="color: #037E8C;">
                        <i class="bi bi-person-fill"></i> Datos del Paciente
                    </h5>
                </div>
                @if (isset($caso))
                    <input type="hidden" name="caso_id" value="{{ $caso->id }}">
                @endif

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label" style="color: #037E8C;">
                            Nombre <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="nombre"
                            class="form-control shadow-sm @error('nombre') is-invalid @enderror"
                            value="{{ $caso->paciente_nombres ?? old('nombre') }}" required>
                        @error('nombre')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label" style="color: #037E8C;">
                            Apellido Paterno <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="apellido_paterno"
                            class="form-control shadow-sm @error('apellido_paterno') is-invalid @enderror"
                            value="{{ $caso->paciente_ap_paterno ?? old('apellido_paterno') }}" required>

                        @error('apellido_paterno')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label" style="color: #037E8C;">
                            Apellido Materno <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="apellido_materno"
                            class="form-control shadow-sm @error('apellido_materno') is-invalid @enderror"
                            value="{{ $caso->paciente_ap_materno ?? old('apellido_materno') }}">

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
                            <input type="date" name="proxima_atencion" id="fecha_atencion"
                                class="form-control @error('proxima_atencion') is-invalid @enderror"
                                value="{{ old('proxima_atencion') }}" required>
                            @error('proxima_atencion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <small class="text-muted">Solo de lunes a viernes</small>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label" style="color: #037E8C;">
                            Hora <span class="text-danger">*</span>
                        </label>
                        <div class="input-group shadow-sm">
                            <span class="input-group-text" style="background-color: #7EC544; color: white;">
                                <i class="bi bi-clock"></i>
                            </span>
                            <input type="time" name="hora" id="hora_atencion"
                                class="form-control @error('hora') is-invalid @enderror" value="{{ old('hora') }}"
                                required min="08:00" max="18:00">
                            @error('hora')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <small class="text-muted">Horario: 08:00 - 18:00</small>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label" style="color: #037E8C;">
                        Asignar Psicólogo <span class="text-danger">*</span>
                    </label>
                    <select name="usuario_id" id="psicologo_select" class="form-select shadow-sm @error('usuario_id') is-invalid @enderror"
                        required>
                        <option value="">-- Seleccione un psicólogo --</option>
                        @foreach ($psicologos as $p)
                            <option value="{{ $p->id }}" {{ old('usuario_id') == $p->id ? 'selected' : '' }}>
                                {{ $p->name }} {{ $p->apellido }}
                            </option>
                        @endforeach
                    </select>
                    @error('usuario_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Alerta de disponibilidad --}}
                <div id="alertaDisponibilidad" class="alert alert-warning d-none" role="alert">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                    <strong>Advertencia:</strong> <span id="mensajeDisponibilidad"></span>
                </div>

                {{-- Botones de Acción --}}
                <div class="d-flex justify-content-center gap-3 mt-4">
                    <button type="submit" class="btn text-white px-4 shadow-sm" style="background-color: #13C0E5;">
                        <i class="bi bi-save"></i> Guardar Cita
                    </button>
                    <a href="{{ route('citas.index') }}" class="btn text-white px-4 shadow-sm"
                        style="background-color: #037E8C;">
                        <i class="bi bi-x-circle"></i> Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>

    @push('styles')
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    @endpush

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
        <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/es.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Configurar fecha mínima (hoy)
                const hoy = new Date().toISOString().split('T')[0];
                document.getElementById('fecha_atencion').setAttribute('min', hoy);

                // Inicializar Flatpickr para mejor experiencia de usuario
                flatpickr("#fecha_atencion", {
                    dateFormat: "Y-m-d",
                    locale: "es",
                    minDate: "today",
                    maxDate: new Date().fp_incr(90), // Máximo 90 días adelante
                    disable: [
                        function(date) {
                            // Deshabilitar sábados (6) y domingos (0)
                            return (date.getDay() === 0 || date.getDay() === 6);
                        }
                    ],
                    onChange: function(selectedDates, dateStr, instance) {
                        console.log('Fecha seleccionada:', dateStr);
                        verificarDisponibilidad();
                    }
                });

                // Verificar disponibilidad cuando cambie la hora o el psicólogo
                document.getElementById('hora_atencion').addEventListener('change', verificarDisponibilidad);
                document.getElementById('psicologo_select').addEventListener('change', verificarDisponibilidad);

                // Función para verificar disponibilidad via AJAX
                function verificarDisponibilidad() {
                    const fecha = document.getElementById('fecha_atencion').value;
                    const hora = document.getElementById('hora_atencion').value;
                    const psicologoId = document.getElementById('psicologo_select').value;

                    // Limpiar alerta anterior
                    const alerta = document.getElementById('alertaDisponibilidad');
                    alerta.classList.add('d-none');

                    // Si no hay todos los datos, no validar
                    if (!fecha || !hora || !psicologoId) {
                        return;
                    }

                    // Verificar que sea día de semana (lunes a viernes)
                    const fechaObj = new Date(fecha + 'T00:00:00');
                    const diaSemana = fechaObj.getDay();
                    
                    if (diaSemana === 0 || diaSemana === 6) {
                        mostrarAlerta('Solo se pueden agendar citas de lunes a viernes', 'danger');
                        return;
                    }

                    // Realizar petición AJAX para verificar disponibilidad
                    fetch('{{ route("citas.verificar-disponibilidad") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            fecha: fecha,
                            hora: hora,
                            usuario_id: psicologoId
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (!data.disponible) {
                            mostrarAlerta(data.mensaje, 'danger');
                        }
                    })
                    .catch(error => {
                        console.error('Error al verificar disponibilidad:', error);
                    });
                }

                // Función para mostrar alertas
                function mostrarAlerta(mensaje, tipo = 'warning') {
                    const alerta = document.getElementById('alertaDisponibilidad');
                    const mensajeSpan = document.getElementById('mensajeDisponibilidad');
                    
                    alerta.classList.remove('d-none', 'alert-warning', 'alert-danger');
                    alerta.classList.add('alert-' + tipo);
                    mensajeSpan.textContent = mensaje;
                }

                // Validación adicional del formulario
                const form = document.getElementById('formCita');
                form.addEventListener('submit', function(e) {
                    // Validar horario
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

                    // Validar día de semana
                    const fecha = document.getElementById('fecha_atencion').value;
                    const fechaObj = new Date(fecha + 'T00:00:00');
                    const diaSemana = fechaObj.getDay();
                    
                    if (diaSemana === 0 || diaSemana === 6) {
                        e.preventDefault();
                        alert('Solo se pueden agendar citas de lunes a viernes');
                        return false;
                    }
                });

                // Convertir nombres a formato capitalizado
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
            });
        </script>
    @endpush
@endsection