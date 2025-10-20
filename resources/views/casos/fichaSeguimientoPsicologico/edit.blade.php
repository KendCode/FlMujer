@extends('layouts.sidebar')

@section('content')
    <div class="container">
        <h3 class="mb-4">Editar Ficha de Seguimiento Psicológico</h3>

        <form action="{{ route('casos.fichaSeguimientoPsicologico.update', [$caso->id, $ficha->id]) }}" method="POST">
            
            @csrf
            @method('PUT')
            <input type="hidden" name="caso_id" value="{{ $caso->id }}">

            <h3 style="color: #037E8C; margin-bottom: 20px;">Ficha de Seguimiento Psicológico</h3>

            <div class="mb-3">
                <label for="fecha" class="form-label" style="color: #037E8C;">Fecha de la sesión</label>
                <input type="date" name="fecha" id="fecha" class="form-control" style="border-color: #7EC544;"
                    value="{{ old('fecha', $ficha->fecha) }}">
            </div>

            <div class="mb-3">
                <label for="nro_registro" class="form-label" style="color: #037E8C;">Número de registro</label>
                <input type="text" name="nro_registro" id="nro_registro" class="form-control"
                    style="border-color: #7EC544;" value="{{ $caso->nro_registro }}" readonly>
            </div>

            <div class="mb-3">
                <label for="nro_sesion" class="form-label" style="color: #037E8C;">Número de sesión</label>
                <input type="number" name="nro_sesion" id="nro_sesion" class="form-control" style="border-color: #7EC544;"
                    value="{{ old('nro_sesion', $ficha->nro_sesion) }}">
            </div>

            <div class="mb-3">
                <label for="estrategia" class="form-label" style="color: #037E8C;">Estrategia</label>
                <select name="estrategia" id="estrategia" class="form-control" style="border-color: #7EC544;">
                    <option value="">-- Seleccionar --</option>
                    <option value="Individual"
                        {{ old('estrategia', $ficha->estrategia) == 'Individual' ? 'selected' : '' }}>Individual</option>
                    <option value="Pareja" {{ old('estrategia', $ficha->estrategia) == 'Pareja' ? 'selected' : '' }}>Pareja
                    </option>
                    <option value="Familia" {{ old('estrategia', $ficha->estrategia) == 'Familia' ? 'selected' : '' }}>
                        Familia</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="nombre_apellidos" class="form-label" style="color: #037E8C;">Nombre y Apellidos</label>
                <input type="text" name="nombre_apellidos" id="nombre_apellidos" class="form-control"
                    style="border-color: #7EC544;" value="{{ $caso->paciente_nombres }} {{ $caso->paciente_apellidos }}"
                    readonly>
            </div>

            <div class="mb-3">
                <label for="antecedentes" class="form-label" style="color: #037E8C;">Antecedentes</label>
                <textarea name="antecedentes" id="antecedentes" class="form-control" style="border-color: #7EC544;">{{ old('antecedentes', $ficha->antecedentes) }}</textarea>
            </div>

            <div class="mb-3">
                <label for="conducta_observable" class="form-label" style="color: #037E8C;">Conducta observable</label>
                <textarea name="conducta_observable" id="conducta_observable" class="form-control" style="border-color: #7EC544;">{{ old('conducta_observable', $ficha->conducta_observable) }}</textarea>
            </div>

            <div class="mb-3">
                <label for="conclusiones_valorativas" class="form-label" style="color: #037E8C;">Conclusiones
                    valorativas</label>
                <textarea name="conclusiones_valorativas" id="conclusiones_valorativas" class="form-control"
                    style="border-color: #7EC544;">{{ old('conclusiones_valorativas', $ficha->conclusiones_valorativas) }}</textarea>
            </div>

            <div class="mb-3">
                <label for="estrategias_intervencion" class="form-label" style="color: #037E8C;">Estrategias de
                    intervención</label>
                <textarea name="estrategias_intervencion" id="estrategias_intervencion" class="form-control"
                    style="border-color: #7EC544;">{{ old('estrategias_intervencion', $ficha->estrategias_intervencion) }}</textarea>
            </div>

            <div class="mb-3">
                <label for="fecha_proxima_atencion" class="form-label" style="color: #037E8C;">Fecha próxima
                    atención</label>
                <input type="date" name="fecha_proxima_atencion" id="fecha_proxima_atencion" class="form-control"
                    style="border-color: #7EC544;"
                    value="{{ old('fecha_proxima_atencion', $ficha->fecha_proxima_atencion) }}">
            </div>

            <div class="mb-3">
                <label for="nombre_psicologo" class="form-label" style="color: #037E8C;">Nombre del psicólogo</label>
                <input type="text" name="nombre_psicologo" id="nombre_psicologo" class="form-control"
                    style="border-color: #7EC544;" value="{{ old('nombre_psicologo', $ficha->nombre_psicologo) }}">
            </div>

            <div class="d-flex justify-content-between mt-4">
                <a href="{{ route('casos.fichaSeguimientoPsicologico.index', $caso->id) }}" class="btn"
                    style="background-color: #7EC544; color: #fff;">Cancelar</a>
                <button type="submit" class="btn" style="background-color: #13C0E5; color: #fff;">Actualizar</button>
            </div>

        </form>
    </div>
@endsection
