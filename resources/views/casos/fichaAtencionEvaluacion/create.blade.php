@extends('layouts.sidebar')

@section('content')
    <div class="container mt-4">
        <h3 class="text-center text-primary fw-bold mb-4">
            Ficha de Atención y Evaluación Psicológica
        </h3>

        <form action="{{ route('casos.fichaAtencionEvaluacion.store', $caso->id) }}" method="POST" class="card shadow p-4">
            @csrf

            {{-- Mostrar errores de validación --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Información del Caso --}}
            <div class="alert alert-info mb-3">
                <strong>Caso N°:</strong> {{ $caso->nro_registro ?? 'N/A' }} |
                <strong>Regional:</strong> {{ $caso->regional_recibe_caso ?? 'N/A' }}
            </div>

            {{-- Fecha y N° de Registro --}}
            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label">Fecha:</label>
                    <input type="date" name="fecha" class="form-control"
                        value="{{ old('fecha', now()->format('Y-m-d')) }}" required>
                </div>

                <div class="col-md-4">
                    <label class="form-label">N° de Registro:</label>
                    {{-- Solo lectura para usuario --}}
                    <input type="text" class="form-control" value="{{ $caso->nro_registro ?? '' }}" readonly>
                    {{-- Campo oculto que se envía --}}
                    <input type="hidden" name="nro_registro" value="{{ $caso->nro_registro ?? '' }}">
                    <small class="text-muted">El número de registro no se puede modificar</small>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Edad:</label>
                    @php
                        $edades = [
                            1 => 'Menor de 15 años',
                            2 => '16 a 20 años',
                            3 => '21 a 25 años',
                            4 => '26 a 30 años',
                            5 => '31 a 35 años',
                            6 => '36 a 50 años',
                            7 => 'Más de 50 años',
                        ];

                        // Valor actual de la ficha o caso
                        $edadSeleccionada = old('edad', $caso->paciente_edad_rango ?? null);
                    @endphp

                    <select name="edad" class="form-control" required>
                        <option value="">Seleccione un rango de edad</option>
                        @foreach ($edades as $key => $label)
                            <option value="{{ $key }}" {{ $edadSeleccionada == $key ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>

            </div>

            {{-- Nombres y Apellidos --}}
            <div class="mb-3">
                <label class="form-label">Nombres y Apellidos:</label>
                {{-- Solo lectura visible --}}
                <input type="text" class="form-control"
                    value="{{ trim(($caso->paciente_nombres ?? '') . ' ' . ($caso->paciente_apellidos ?? '')) }}" readonly>
                {{-- Campo oculto que se envía --}}
                <input type="hidden" name="nombres_apellidos"
                    value="{{ trim(($caso->paciente_nombres ?? '') . ' ' . ($caso->paciente_apellidos ?? '')) }}">
                <small class="text-muted">Obtenido del caso</small>
            </div>

            {{-- Busco Ayuda --}}
            <div class="border rounded p-3 mb-3">
                <h5 class="text-primary fw-bold">2. ¿Buscó ayuda?</h5>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>¿Buscó ayuda?</label><br>
                        <input type="radio" name="busco_ayuda" value="Si"
                            {{ old('busco_ayuda') == 'Si' ? 'checked' : '' }}> Sí
                        <input type="radio" name="busco_ayuda" value="No" class="ms-2"
                            {{ old('busco_ayuda') == 'No' ? 'checked' : '' }}> No
                        <input type="text" name="donde_busco_ayuda" class="form-control mt-2" placeholder="¿Dónde?"
                            value="{{ old('donde_busco_ayuda') }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>¿Recibió apoyo psicológico?</label><br>
                        <input type="radio" name="recibio_apoyo" value="Si"
                            {{ old('recibio_apoyo') == 'Si' ? 'checked' : '' }}> Sí
                        <input type="radio" name="recibio_apoyo" value="No" class="ms-2"
                            {{ old('recibio_apoyo') == 'No' ? 'checked' : '' }}> No
                        <input type="text" name="donde_apoyo" class="form-control mt-2" placeholder="¿Dónde?"
                            value="{{ old('donde_apoyo') }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>¿Concluyó la terapia?</label><br>
                        <input type="radio" name="concluyo_terapia" value="Si"
                            {{ old('concluyo_terapia') == 'Si' ? 'checked' : '' }}> Sí
                        <input type="radio" name="concluyo_terapia" value="No" class="ms-2"
                            {{ old('concluyo_terapia') == 'No' ? 'checked' : '' }}> No
                        <input type="text" name="cuando_terapia" class="form-control mt-2" placeholder="¿Cuándo?"
                            value="{{ old('cuando_terapia') }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Enfermedades en los últimos años:</label>
                        <input type="text" name="enfermedades" class="form-control" value="{{ old('enfermedades') }}">
                    </div>
                </div>
            </div>

            {{-- Motivo de consulta --}}
            <div class="mb-3">
                <label class="form-label fw-bold text-primary">3. Motivo de consulta:</label>
                <textarea name="motivo_consulta" class="form-control" rows="3">{{ old('motivo_consulta') }}</textarea>
            </div>

            {{-- Descripción del caso --}}
            <div class="mb-3">
                <label class="form-label fw-bold text-primary">4. Descripción del caso:</label>
                <textarea name="descripcion_caso" class="form-control" rows="4">{{ old('descripcion_caso') }}</textarea>
            </div>

            {{-- Pruebas psicológicas --}}
            <div class="mb-3">
                <label class="form-label fw-bold text-primary">5. Pruebas psicológicas:</label>
                <textarea name="pruebas_psicologicas" class="form-control" rows="3">{{ old('pruebas_psicologicas') }}</textarea>
            </div>

            {{-- Conducta observable --}}
            <div class="mb-3">
                <label class="form-label fw-bold text-primary">6. Conducta observable:</label>
                <textarea name="conducta_observable" class="form-control" rows="3">{{ old('conducta_observable') }}</textarea>
            </div>

            {{-- Conclusiones valorativas --}}
            <div class="mb-3">
                <label class="form-label fw-bold text-primary">7. Conclusiones valorativas:</label>
                <textarea name="conclusiones_valorativas" class="form-control" rows="3">{{ old('conclusiones_valorativas') }}</textarea>
            </div>

            {{-- Fases de intervención --}}
            <div class="mb-3">
                <label class="form-label fw-bold text-primary">8. Fases de intervención:</label>
                <textarea name="fases_intervencion" class="form-control" rows="3">{{ old('fases_intervencion') }}</textarea>
            </div>

            {{-- Estrategia de intervención --}}
            <div class="mb-3">
                <label class="form-label fw-bold text-primary">9. Estrategia de intervención a seguir:</label><br>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="estrategia" value="Individual"
                        {{ old('estrategia') == 'Individual' ? 'checked' : '' }}>
                    <label class="form-check-label">Individual</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="estrategia" value="Pareja"
                        {{ old('estrategia') == 'Pareja' ? 'checked' : '' }}>
                    <label class="form-check-label">Pareja</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="estrategia" value="Familia"
                        {{ old('estrategia') == 'Familia' ? 'checked' : '' }}>
                    <label class="form-check-label">Familia</label>
                </div>
                <textarea name="detalle_estrategia" class="form-control mt-2" rows="3" placeholder="Detalles adicionales...">{{ old('detalle_estrategia') }}</textarea>
            </div>

            {{-- Próxima atención y derivación --}}
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label fw-bold text-primary">Fecha de próxima atención:</label>
                    <input type="date" name="fecha_proxima" class="form-control" value="{{ old('fecha_proxima') }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold text-primary">Tratamiento institucional (Remito a):</label><br>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name="remito[]" value="Legal"
                            {{ in_array('Legal', old('remito', [])) ? 'checked' : '' }}>
                        <label class="form-check-label">Legal</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name="remito[]" value="Trabajo Social"
                            {{ in_array('Trabajo Social', old('remito', [])) ? 'checked' : '' }}>
                        <label class="form-check-label">Trabajo Social</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name="remito[]" value="Espiritual"
                            {{ in_array('Espiritual', old('remito', [])) ? 'checked' : '' }}>
                        <label class="form-check-label">Espiritual</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name="remito[]" value="Médico"
                            {{ in_array('Médico', old('remito', [])) ? 'checked' : '' }}>
                        <label class="form-check-label">Médico</label>
                    </div>
                </div>
            </div>

            {{-- Botones --}}
            <div class="text-center">
                <button type="submit" class="btn btn-primary px-4">Guardar Ficha</button>
                <a href="{{ route('casos.index', $caso->id) }}" class="btn btn-secondary px-4 ms-2">Cancelar</a>
            </div>
        </form>
    </div>
@endsection
