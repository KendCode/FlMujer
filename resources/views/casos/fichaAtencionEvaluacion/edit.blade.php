@extends('layouts.sidebar')

@section('content')
    <div class="container mt-4">
        <h3 class="text-center text-primary fw-bold mb-4">
            Editar Ficha de Atención y Evaluación Psicológica
        </h3>


        <form
            action="{{ route('casos.fichaAtencionEvaluacion.update', ['caso' => $ficha->caso->id, 'ficha' => $ficha->id]) }}"
            method="POST" class="card shadow p-4">

            @csrf
            @method('PUT')

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
                <strong>Caso N°:</strong> {{ $ficha->caso->nro_registro ?? 'N/A' }} |
                <strong>Regional:</strong> {{ $ficha->caso->regional_recibe_caso ?? 'N/A' }}
            </div>


            {{-- Fecha --}}
            <div class="mb-3">
                <label class="form-label">Fecha:</label>
                <input type="date" name="fecha" class="form-control"
                    value="{{ old('fecha', $ficha->fecha->format('Y-m-d')) }}" required>
            </div>

            {{-- Nombres y Apellidos --}}
            <div class="mb-3">
                <label class="form-label">Nombres y Apellidos:</label>
                <input type="text" name="nombres_apellidos" class="form-control"
                    value="{{ old('nombres_apellidos', $ficha->nombres_apellidos) }}" readonly>
            </div>

            {{-- Busco ayuda --}}
            <div class="border rounded p-3 mb-3">
                <h5 class="text-primary fw-bold">2. ¿Buscó ayuda?</h5>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>¿Busco ayuda?</label><br>
                        <input type="radio" name="busco_ayuda" value="Si"
                            {{ old('busco_ayuda', $ficha->busco_ayuda) == 'Si' ? 'checked' : '' }}> Sí
                        <input type="radio" name="busco_ayuda" value="No" class="ms-2"
                            {{ old('busco_ayuda', $ficha->busco_ayuda) == 'No' ? 'checked' : '' }}> No
                        <input type="text" name="donde_busco_ayuda" class="form-control mt-2" placeholder="¿Dónde?"
                            value="{{ old('donde_busco_ayuda', $ficha->donde_busco_ayuda) }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>¿Recibió apoyo psicológico?</label><br>
                        <input type="radio" name="recibio_apoyo" value="Si"
                            {{ old('recibio_apoyo', $ficha->recibio_apoyo) == 'Si' ? 'checked' : '' }}> Sí
                        <input type="radio" name="recibio_apoyo" value="No" class="ms-2"
                            {{ old('recibio_apoyo', $ficha->recibio_apoyo) == 'No' ? 'checked' : '' }}> No
                        <input type="text" name="donde_apoyo" class="form-control mt-2" placeholder="¿Dónde?"
                            value="{{ old('donde_apoyo', $ficha->donde_apoyo) }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>¿Concluyó la terapia?</label><br>
                        <input type="radio" name="concluyo_terapia" value="Si"
                            {{ old('concluyo_terapia', $ficha->concluyo_terapia) == 'Si' ? 'checked' : '' }}> Sí
                        <input type="radio" name="concluyo_terapia" value="No" class="ms-2"
                            {{ old('concluyo_terapia', $ficha->concluyo_terapia) == 'No' ? 'checked' : '' }}> No
                        <input type="text" name="cuando_terapia" class="form-control mt-2" placeholder="¿Cuándo?"
                            value="{{ old('cuando_terapia', $ficha->cuando_terapia) }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Enfermedades en los últimos años:</label>
                        <input type="text" name="enfermedades" class="form-control"
                            value="{{ old('enfermedades', $ficha->enfermedades) }}">
                    </div>
                </div>
            </div>

            {{-- Motivo de consulta --}}
            <div class="mb-3">
                <label class="form-label fw-bold text-primary">3. Motivo de consulta:</label>
                <textarea name="motivo_consulta" class="form-control" rows="3">{{ old('motivo_consulta', $ficha->motivo_consulta) }}</textarea>
            </div>

            {{-- Descripción del caso --}}
            <div class="mb-3">
                <label class="form-label fw-bold text-primary">4. Descripción del caso:</label>
                <textarea name="descripcion_caso" class="form-control" rows="4">{{ old('descripcion_caso', $ficha->descripcion_caso) }}</textarea>
            </div>

            {{-- Pruebas psicológicas --}}
            <div class="mb-3">
                <label class="form-label fw-bold text-primary">5. Pruebas psicológicas:</label>
                <textarea name="pruebas_psicologicas" class="form-control" rows="3">{{ old('pruebas_psicologicas', $ficha->pruebas_psicologicas) }}</textarea>
            </div>

            {{-- Conducta observable --}}
            <div class="mb-3">
                <label class="form-label fw-bold text-primary">6. Conducta observable:</label>
                <textarea name="conducta_observable" class="form-control" rows="3">{{ old('conducta_observable', $ficha->conducta_observable) }}</textarea>
            </div>

            {{-- Conclusiones valorativas --}}
            <div class="mb-3">
                <label class="form-label fw-bold text-primary">7. Conclusiones valorativas:</label>
                <textarea name="conclusiones_valorativas" class="form-control" rows="3">{{ old('conclusiones_valorativas', $ficha->conclusiones_valorativas) }}</textarea>
            </div>

            {{-- Fases de intervención --}}
            <div class="mb-3">
                <label class="form-label fw-bold text-primary">8. Fases de intervención:</label>
                <textarea name="fases_intervencion" class="form-control" rows="3">{{ old('fases_intervencion', $ficha->fases_intervencion) }}</textarea>
            </div>

            {{-- Estrategia --}}
            <div class="mb-3">
                <label class="form-label fw-bold text-primary">9. Estrategia de intervención:</label><br>
                @foreach (['Individual', 'Pareja', 'Familia'] as $estrategia)
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="estrategia" value="{{ $estrategia }}"
                            {{ old('estrategia', $ficha->estrategia) == $estrategia ? 'checked' : '' }}>
                        <label class="form-check-label">{{ $estrategia }}</label>
                    </div>
                @endforeach
                <textarea name="detalle_estrategia" class="form-control mt-2" rows="3">{{ old('detalle_estrategia', $ficha->detalle_estrategia) }}</textarea>
            </div>

            {{-- Próxima atención y remito --}}
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label fw-bold text-primary">Fecha próxima atención:</label>
                    <input type="date" name="fecha_proxima" class="form-control"
                        value="{{ old('fecha_proxima', optional($ficha->fecha_proxima)->format('Y-m-d')) }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold text-primary">Tratamiento institucional (Remito a):</label><br>
                    @foreach (['Legal', 'Trabajo Social', 'Espiritual', 'Médico'] as $remito)
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="remito[]" value="{{ $remito }}"
                                {{ in_array($remito, old('remito', $ficha->remito ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">{{ $remito }}</label>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Botones --}}
            <div class="text-center">
                <button type="submit" class="btn btn-primary px-4">Actualizar Ficha</button>
                <a href="{{ route('casos.fichaAtencionEvaluacion.index', $ficha->caso->id) }}"
                    class="btn btn-secondary px-4 ms-2">Cancelar</a>

            </div>
        </form>
    </div>
@endsection
