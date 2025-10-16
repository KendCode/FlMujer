@extends('layouts.sidebar')

@section('content')
    <div class="container-fluid py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Editar Caso - {{ $caso->nro_registro }}</h2>
            {{-- <a href="{{ route('casos.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Volver al listado
        </a> --}}
        </div>

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>¡Error!</strong> Por favor corrija los siguientes problemas:
                <ul class="mb-0 mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <form action="{{ route('casos.update', $caso->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- =====================
                                 SECCIÓN 0: DATOS DE LA REGIONAL
                            ===================== -->
            <div class="card mb-3">
                <div class="card-header bg-primary text-white">
                    <i class="bi bi-building"></i> Regional
                </div>
                <div class="card-body">
                    <div class="row g-2">
                        <div class="col-md-6">
                            <label class="form-label">Regional que recibe el caso:</label>
                            <input type="text" name="regional_recibe_caso" class="form-control"
                                value="{{ old('regional_recibe_caso', $caso->regional_recibe_caso) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Fecha</label>
                            <input type="date" name="regional_fecha" class="form-control"
                                value="{{ old('regional_fecha', \Carbon\Carbon::parse($caso->regional_fecha)->format('Y-m-d')) }}"
                                required>
                        </div>


                        <div class="col-md-6 mt-3">
                            <label class="form-label">Número de Registro</label>
                            <input type="text" class="form-control" value="{{ $caso->nro_registro }}" readonly disabled>
                            <small class="text-muted">El número de registro no se puede modificar</small>
                        </div>

                        <div class="col-md-6 mt-3">
                            <label class="form-label">Institución que deriva</label>
                            <input type="text" name="regional_institucion_derivante" class="form-control"
                                value="{{ old('regional_institucion_derivante', $caso->regional_institucion_derivante) }}"
                                required>
                        </div>
                    </div>
                </div>
            </div>

            <!-- =====================
                                 SECCIÓN 1: DATOS PERSONALES PACIENTE
                            ===================== -->
            <div class="card mb-3">
                <div class="card-header bg-info text-white">
                    <i class="bi bi-person"></i> Datos Personales del Paciente
                </div>
                <div class="card-body">
                    <div class="row g-2">
                        <div class="col-md-6">
                            <label class="form-label">Nombres</label>
                            <input type="text" name="paciente_nombres" class="form-control"
                                value="{{ old('paciente_nombres', $caso->paciente_nombres) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Apellidos</label>
                            <input type="text" name="paciente_apellidos" class="form-control"
                                value="{{ old('paciente_apellidos', $caso->paciente_apellidos) }}" required>
                        </div>
                        <div class="col-md-4 mt-2">
                            <label class="form-label d-block">Sexo</label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="paciente_sexo" value="M"
                                    {{ old('paciente_sexo', $caso->paciente_sexo) == 'M' ? 'checked' : '' }} required>
                                <label class="form-check-label">Varón</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="paciente_sexo" value="F"
                                    {{ old('paciente_sexo', $caso->paciente_sexo) == 'F' ? 'checked' : '' }} required>
                                <label class="form-check-label">Mujer</label>
                            </div>
                        </div>
                        <div class="col-md-8 mt-2">
                            <label class="form-label">Edad (rango)</label>
                            <div class="d-flex flex-wrap gap-2">
                                @php
                                    $edades = [
                                        'menor15' => 'Menor de 15 años',
                                        '16a20' => '16 a 20 años',
                                        '21a25' => '21 a 25 años',
                                        '26a30' => '26 a 30 años',
                                        '31a35' => '31 a 35 años',
                                        '36a50' => '36 a 50 años',
                                        'mayor50' => 'Más de 50 años',
                                    ];
                                @endphp
                                @foreach ($edades as $value => $label)
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="paciente_edad_rango"
                                            value="{{ $value }}" id="edad_{{ $value }}"
                                            {{ old('paciente_edad_rango', $caso->paciente_edad_rango) == $value ? 'checked' : '' }}
                                            required>
                                        <label class="form-check-label"
                                            for="edad_{{ $value }}">{{ $label }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="col-md-4 mt-2">
                            <label class="form-label">CI</label>
                            <input type="text" name="paciente_ci" class="form-control"
                                value="{{ old('paciente_ci', $caso->paciente_ci) }}">
                        </div>
                        <div class="col-md-8 mt-2">
                            <label class="form-label">Distrito</label><br>
                            <div class="d-flex flex-wrap gap-2">
                                @for ($i = 1; $i <= 14; $i++)
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="paciente_id_distrito"
                                            value="{{ $i }}" id="distrito_{{ $i }}"
                                            {{ old('paciente_id_distrito', $caso->paciente_id_distrito) == $i ? 'checked' : '' }}
                                            required>
                                        <label class="form-check-label" for="distrito_{{ $i }}">Distrito
                                            {{ $i }}</label>
                                    </div>
                                @endfor
                            </div>
                            <div class="mt-2">
                                <input type="text" name="paciente_otros" class="form-control" placeholder="Otros"
                                    value="{{ old('paciente_otros', $caso->paciente_otros) }}">
                            </div>
                            <div class="mt-2">
                                <input type="text" name="paciente_zona" class="form-control"
                                    placeholder="Zona / Barrio" value="{{ old('paciente_zona', $caso->paciente_zona) }}">
                            </div>
                            <div class="mt-2">
                                <input type="text" name="paciente_calle" class="form-control"
                                    placeholder="Calle / Avenida"
                                    value="{{ old('paciente_calle', $caso->paciente_calle) }}">
                            </div>
                            <div class="mt-2">
                                <input type="text" name="paciente_numero" class="form-control" placeholder="Número"
                                    value="{{ old('paciente_numero', $caso->paciente_numero) }}">
                            </div>
                            <div class="mt-2">
                                <input type="text" name="paciente_telefono" class="form-control"
                                    placeholder="Teléfono"
                                    value="{{ old('paciente_telefono', $caso->paciente_telefono) }}">
                            </div>
                        </div>
                        <div class="col-md-4 mt-2">
                            <label class="form-label d-block">Lugar de Nacimiento</label>
                            <input type="text" name="paciente_lugar_nacimiento" class="form-control"
                                placeholder="Lugar de Nacimiento"
                                value="{{ old('paciente_lugar_nacimiento', $caso->paciente_lugar_nacimiento) }}">
                            <div class="form-check form-check-inline mt-2">
                                <input class="form-check-input" type="radio" name="paciente_lugar_nacimiento_op"
                                    value="dentro"
                                    {{ old('paciente_lugar_nacimiento_op', $caso->paciente_lugar_nacimiento_op) == 'dentro' ? 'checked' : '' }}
                                    required>
                                <label class="form-check-label">Dentro de municipio</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="paciente_lugar_nacimiento_op"
                                    value="fuera"
                                    {{ old('paciente_lugar_nacimiento_op', $caso->paciente_lugar_nacimiento_op) == 'fuera' ? 'checked' : '' }}
                                    required>
                                <label class="form-check-label">Fuera de municipio</label>
                            </div>
                        </div>
                        <div class="col-md-4 mt-2">
                            <label class="form-label d-block">Residencia Habitual</label>
                            <div class="form-check form-check-inline mt-2">
                                <input class="form-check-input" type="radio" name="paciente_lugar_residencia_op"
                                    value="dentro"
                                    {{ old('paciente_lugar_residencia_op', $caso->paciente_lugar_residencia_op) == 'dentro' ? 'checked' : '' }}>
                                <label class="form-check-label">Dentro del municipio</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="paciente_lugar_residencia_op"
                                    value="fuera"
                                    {{ old('paciente_lugar_residencia_op', $caso->paciente_lugar_residencia_op) == 'fuera' ? 'checked' : '' }}>
                                <label class="form-check-label">Fuera de municipio</label>
                            </div>
                        </div>
                        <div class="col-md-4 mt-2">
                            <label class="form-label d-block">Tiempo de residencia en este municipio</label>
                            @php
                                $tiempos = [
                                    'menosDeUnAno' => 'Menos de 1 año',
                                    'de2a5Anos' => 'De 2 a 5 años',
                                    'de6a10Anos' => 'De 6 a 10 años',
                                    'masDe10Anos' => 'De 11 y más años',
                                ];
                            @endphp
                            @foreach ($tiempos as $value => $label)
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="paciente_tiempo_residencia_op"
                                        value="{{ $value }}" id="tiempo_{{ $value }}"
                                        {{ old('paciente_tiempo_residencia_op', $caso->paciente_tiempo_residencia_op) == $value ? 'checked' : '' }}>
                                    <label class="form-check-label"
                                        for="tiempo_{{ $value }}">{{ $label }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="row g-2 mt-3">
                        <div class="col-md-6">
                            <label for="paciente_estado_civil" class="form-label">Estado Civil</label>
                            <select class="form-select" id="paciente_estado_civil" name="paciente_estado_civil" required>
                                <option value="">Seleccione...</option>
                                @foreach (['soltero' => 'Soltero', 'conviviente' => 'Conviviente', 'viudo' => 'Viudo', 'casado' => 'Casado', 'separado' => 'Separado', 'divorciado' => 'Divorciado'] as $value => $label)
                                    <option value="{{ $value }}"
                                        {{ old('paciente_estado_civil', $caso->paciente_estado_civil) == $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="paciente_nivel_instruccion" class="form-label">Nivel de Instrucción</label>
                            <select class="form-select" id="paciente_nivel_instruccion" name="paciente_nivel_instruccion"
                                required>
                                <option value="">Seleccione...</option>
                                @foreach (['ninguno' => 'Ninguno', 'primaria' => 'Primaria', 'secundaria' => 'Secundaria', 'tecnico' => 'Técnico', 'tecnicoSuperior' => 'Técnico Superior', 'licenciatura' => 'Licenciatura'] as $value => $label)
                                    <option value="{{ $value }}"
                                        {{ old('paciente_nivel_instruccion', $caso->paciente_nivel_instruccion) == $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="paciente_idioma_mas_hablado" class="form-label">Idioma más hablado</label>
                            <select class="form-select" id="paciente_idioma_mas_hablado"
                                name="paciente_idioma_mas_hablado">
                                <option value="">Seleccione...</option>
                                @foreach (['castellano' => 'Castellano', 'aymara' => 'Aymara', 'quechua' => 'Quechua', 'guarani' => 'Guaraní', 'otroNativo' => 'Otro nativo', 'extranjero' => 'Extranjero'] as $value => $label)
                                    <option value="{{ $value }}"
                                        {{ old('paciente_idioma_mas_hablado', $caso->paciente_idioma_mas_hablado) == $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mt-2">
                            <label for="paciente_idioma_especificar" class="form-label">Especificar Otro Idioma</label>
                            <input type="text" name="paciente_idioma_especificar" class="form-control"
                                value="{{ old('paciente_idioma_especificar', $caso->paciente_idioma_especificar) }}"
                                placeholder="Especificar si seleccionó 'Otro'">
                        </div>
                        <div class="col-md-6 mt-2">
                            <label for="paciente_ocupacion" class="form-label">Ocupación Principal</label>
                            <select class="form-select" id="paciente_ocupacion" name="paciente_ocupacion" required>
                                <option value="">Seleccione...</option>
                                @foreach (['obrero' => 'Obrero', 'empleada' => 'Empleada', 'trabajadorCuentaPropia' => 'Trabajador por Cuenta Propia', 'patrona' => 'Patrona', 'socioemprendedor' => 'Socioemprendedor', 'cooperativista' => 'Cooperativista', 'aprendizSinRemuneracion' => 'Aprendiz sin Remuneración', 'aprendizConRemuneracion' => 'Aprendiz con Remuneración', 'laboresCasa' => 'Labores de Casa', 'sinTrabajo' => 'No tienen Trabajo', 'otros' => 'Otros'] as $value => $label)
                                    <option value="{{ $value }}"
                                        {{ old('paciente_ocupacion', $caso->paciente_ocupacion) == $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mt-2">
                            <label for="paciente_situacion_ocupacional" class="form-label">Situación Ocupacional</label>
                            <select class="form-select" id="paciente_situacion_ocupacional"
                                name="paciente_situacion_ocupacional" required>
                                <option value="">Seleccione...</option>
                                <option value="permanente"
                                    {{ old('paciente_situacion_ocupacional', $caso->paciente_situacion_ocupacional) == 'permanente' ? 'selected' : '' }}>
                                    Permanente</option>
                                <option value="temporal"
                                    {{ old('paciente_situacion_ocupacional', $caso->paciente_situacion_ocupacional) == 'temporal' ? 'selected' : '' }}>
                                    Temporal</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- =====================
                                 SECCIÓN 2: DATOS PAREJA
                            ===================== -->
            <div class="card mb-3">
                <div class="card-header bg-warning">
                    <i class="bi bi-people"></i> Datos de la Pareja
                </div>
                <div class="card-body">
                    <div class="row g-2">
                        <div class="col-md-6">
                            <label class="form-label">Nombres</label>
                            <input type="text" name="pareja_nombres" class="form-control"
                                value="{{ old('pareja_nombres', $caso->pareja_nombres) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Apellidos</label>
                            <input type="text" name="pareja_apellidos" class="form-control"
                                value="{{ old('pareja_apellidos', $caso->pareja_apellidos) }}" required>
                        </div>
                        <div class="col-md-4 mt-2">
                            <label class="form-label d-block">Sexo</label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="pareja_sexo" value="M"
                                    {{ old('pareja_sexo', $caso->pareja_sexo) == 'M' ? 'checked' : '' }} required>
                                <label class="form-check-label">Varón</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="pareja_sexo" value="F"
                                    {{ old('pareja_sexo', $caso->pareja_sexo) == 'F' ? 'checked' : '' }} required>
                                <label class="form-check-label">Mujer</label>
                            </div>
                        </div>
                        <div class="col-md-8 mt-2">
                            <label class="form-label">Edad (rango)</label>
                            <div class="d-flex gap-2 flex-wrap">
                                @php
                                    $edadesPareja = [
                                        'menor_15' => 'Menor de 15 años',
                                        '16_a_20' => '16 a 20',
                                        '21_25' => '21 a 25',
                                        '26_a_30' => '26 a 30',
                                        '31_a_35' => '31 a 35',
                                        '36_a_40' => '36 a 40',
                                        '41_a_45' => '41 a 45',
                                        '46_a_50' => '46 a 50',
                                    ];
                                @endphp
                                @foreach ($edadesPareja as $value => $label)
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="pareja_edad_rango"
                                            value="{{ $value }}" id="pareja_edad_{{ $value }}"
                                            {{ old('pareja_edad_rango', $caso->pareja_edad_rango) == $value ? 'checked' : '' }}
                                            required>
                                        <label class="form-check-label"
                                            for="pareja_edad_{{ $value }}">{{ $label }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="col-md-4 mt-2">
                            <label class="form-label">CI</label>
                            <input type="text" name="pareja_ci" class="form-control"
                                value="{{ old('pareja_ci', $caso->pareja_ci) }}">
                        </div>

                        <div class="col-md-8 mt-2">
                            <label class="form-label">Distrito</label><br>
                            <div class="d-flex flex-wrap gap-2">
                                @for ($i = 1; $i <= 14; $i++)
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="pareja_id_distrito"
                                            value="{{ $i }}" id="pareja_distrito_{{ $i }}"
                                            {{ old('pareja_id_distrito', $caso->pareja_id_distrito) == $i ? 'checked' : '' }}
                                            required>
                                        <label class="form-check-label"
                                            for="pareja_distrito_{{ $i }}">Distrito
                                            {{ $i }}</label>
                                    </div>
                                @endfor
                            </div>
                            <div class="mt-2">
                                <input type="text" name="pareja_otros" class="form-control" placeholder="Otros"
                                    value="{{ old('pareja_otros', $caso->pareja_otros) }}">
                            </div>
                            <div class="mt-2">
                                <input type="text" name="pareja_zona" class="form-control"
                                    placeholder="Zona / Barrio" value="{{ old('pareja_zona', $caso->pareja_zona) }}">
                            </div>
                            <div class="mt-2">
                                <input type="text" name="pareja_calle" class="form-control"
                                    placeholder="Calle / Avenida" value="{{ old('pareja_calle', $caso->pareja_calle) }}">
                            </div>
                            <div class="mt-2">
                                <input type="text" name="pareja_numero" class="form-control" placeholder="Número"
                                    value="{{ old('pareja_numero', $caso->pareja_numero) }}">
                            </div>
                            <div class="mt-2">
                                <input type="text" name="pareja_telefono" class="form-control" placeholder="Teléfono"
                                    value="{{ old('pareja_telefono', $caso->pareja_telefono) }}">
                            </div>
                        </div>

                        <div class="col-md-4 mt-2">
                            <label class="form-label d-block">Lugar de Nacimiento</label>
                            <input type="text" name="pareja_lugar_nacimiento" class="form-control"
                                placeholder="Lugar de Nacimiento"
                                value="{{ old('pareja_lugar_nacimiento', $caso->pareja_lugar_nacimiento) }}">
                            <div class="form-check form-check-inline mt-2">
                                <input class="form-check-input" type="radio" name="pareja_lugar_nacimiento_op"
                                    value="dentro"
                                    {{ old('pareja_lugar_nacimiento_op', $caso->pareja_lugar_nacimiento_op) == 'dentro' ? 'checked' : '' }}
                                    required>
                                <label class="form-check-label">Dentro de municipio</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="pareja_lugar_nacimiento_op"
                                    value="fuera"
                                    {{ old('pareja_lugar_nacimiento_op', $caso->pareja_lugar_nacimiento_op) == 'fuera' ? 'checked' : '' }}
                                    required>
                                <label class="form-check-label">Fuera de municipio</label>
                            </div>
                        </div>
                    </div>

                    <div class="row g-2 mt-3">
                        <div class="col-md-6">
                            <label for="pareja_residencia" class="form-label">Residencia Habitual</label>
                            <select class="form-select" id="pareja_residencia" name="pareja_residencia" required>
                                <option value="">Seleccione</option>
                                <option value="dentro"
                                    {{ old('pareja_residencia', $caso->pareja_residencia) == 'dentro' ? 'selected' : '' }}>
                                    Dentro de municipio</option>
                                <option value="fuera"
                                    {{ old('pareja_residencia', $caso->pareja_residencia) == 'fuera' ? 'selected' : '' }}>
                                    Fuera de municipio</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="pareja_tiempo_residencia" class="form-label">Tiempo de Residencia</label>
                            <select class="form-select" id="pareja_tiempo_residencia" name="pareja_tiempo_residencia"
                                required>
                                <option value="">Seleccione</option>
                                @foreach (['menos_de_un_ano' => 'Menos de un año', '2_a_5_anios' => '2 a 5 años', '6_a_10_anios' => '6 a 10 años', '11_y_mas' => '11 y más años', 'otro' => 'Otro', 'no_saben' => 'No saben', 'no_responde' => 'No responde'] as $value => $label)
                                    <option value="{{ $value }}"
                                        {{ old('pareja_tiempo_residencia', $caso->pareja_tiempo_residencia) == $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 mt-2">
                            <label for="pareja_estado_civil" class="form-label">Estado Civil</label>
                            <select class="form-select" id="pareja_estado_civil" name="pareja_estado_civil" required>
                                <option value="">Seleccione</option>
                                @foreach (['soltero' => 'Soltero', 'conviviente' => 'Conviviente', 'separado' => 'Separado', 'viudo' => 'Viudo', 'divorciado' => 'Divorciado'] as $value => $label)
                                    <option value="{{ $value }}"
                                        {{ old('pareja_estado_civil', $caso->pareja_estado_civil) == $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 mt-2">
                            <label for="pareja_nivel_instruccion" class="form-label">Nivel de Instrucción</label>
                            <select class="form-select" id="pareja_nivel_instruccion" name="pareja_nivel_instruccion"
                                required>
                                <option value="">Seleccione</option>
                                @foreach (['ninguno' => 'Ninguno', 'primaria' => 'Primaria', 'tecnico' => 'Técnico', 'tecnico_superior' => 'Técnico Superior', 'lee_y_escribe' => 'Lee y Escribe', 'secundaria' => 'Secundaria', 'tecnico_medio' => 'Técnico Medio', 'licenciatura' => 'Licenciatura'] as $value => $label)
                                    <option value="{{ $value }}"
                                        {{ old('pareja_nivel_instruccion', $caso->pareja_nivel_instruccion) == $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 mt-2">
                            <label for="pareja_idioma" class="form-label">Idioma Más Hablado</label>
                            <select class="form-select" id="pareja_idioma" name="pareja_idioma" required>
                                <option value="">Seleccione</option>
                                @foreach (['castellano' => 'Castellano', 'aymara' => 'Aymara', 'quechua' => 'Quechua', 'guarani' => 'Guaraní', 'extranjero' => 'Extranjero', 'otro' => 'Otro'] as $value => $label)
                                    <option value="{{ $value }}"
                                        {{ old('pareja_idioma', $caso->pareja_idioma) == $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mt-2">
                            <label for="pareja_idioma_especificar" class="form-label">Especificar Otro Idioma</label>
                            <input type="text" name="pareja_idioma_especificar" class="form-control"
                                value="{{ old('pareja_idioma_especificar', $caso->pareja_idioma_especificar) }}"
                                placeholder="Especificar si seleccionó 'Otro'">
                        </div>

                        <div class="col-md-6 mt-2">
                            <label for="pareja_ocupacion_principal" class="form-label">Ocupación Principal</label>
                            <select class="form-select" id="pareja_ocupacion_principal" name="pareja_ocupacion_principal"
                                required>
                                <option value="">Seleccione</option>
                                @foreach (['obrero' => 'Obrero', 'empleado' => 'Empleado', 'trabajador_autonomo' => 'Trabajador por cuenta propia', 'patrona' => 'Patrona', 'socio_empleador' => 'Socio de empleador', 'cooperativista' => 'Cooperativista de producción familiar', 'aprendiz_sin_remuneracion' => 'Aprendiz sin remuneración', 'aprendiz_con_remuneracion' => 'Aprendiz con remuneración', 'labores_casa' => 'Labores de casa', 'trabajadora_hogar' => 'Trabajadora del hogar', 'no_trabajo' => 'No tiene trabajo', 'otros' => 'Otros'] as $value => $label)
                                    <option value="{{ $value }}"
                                        {{ old('pareja_ocupacion_principal', $caso->pareja_ocupacion_principal) == $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 mt-2">
                            <label for="pareja_situacion_ocupacional" class="form-label">Situación Ocupacional</label>
                            <select class="form-select" id="pareja_situacion_ocupacional"
                                name="pareja_situacion_ocupacional" required>
                                <option value="">Seleccione</option>
                                <option value="permanente"
                                    {{ old('pareja_situacion_ocupacional', $caso->pareja_situacion_ocupacional) == 'permanente' ? 'selected' : '' }}>
                                    Permanente</option>
                                <option value="temporal"
                                    {{ old('pareja_situacion_ocupacional', $caso->pareja_situacion_ocupacional) == 'temporal' ? 'selected' : '' }}>
                                    Temporal</option>
                            </select>
                        </div>
                    </div>

                    <div class="row g-2 mt-4">
                        <div class="col-12">
                            <legend class="h5">Situación Familiar</legend>
                        </div>

                        <div class="col-md-6">
                            <label for="pareja_parentesco" class="form-label">Relación de Parentesco</label>
                            <select class="form-select" id="pareja_parentesco" name="pareja_parentesco" required>
                                <option value="">Seleccione</option>
                                @foreach (['conyuge' => 'Cónyuge', 'conviviente' => 'Conviviente', 'ex_conyuge' => 'Ex cónyuge', 'ex_conviviente' => 'Ex conviviente', 'enamorado' => 'Enamorado', 'ex_enamorado' => 'Ex enamorado', 'otros' => 'Otros familiares'] as $value => $label)
                                    <option value="{{ $value }}"
                                        {{ old('pareja_parentesco', $caso->pareja_parentesco) == $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="pareja_anos_convivencia" class="form-label">Años de Matrimonio o
                                Convivencia</label>
                            <select class="form-select" id="pareja_anos_convivencia" name="pareja_anos_convivencia"
                                required>
                                <option value="">Seleccione</option>
                                @foreach (['menos_de_un_ano' => 'Menos de un año', '1_a_5_anios' => 'De 1 a 5 años', '6_a_10_anios' => 'De 6 a 10 años', '11_a_15_anios' => 'De 11 a 15 años', '16_a_20_anios' => 'De 16 a 20 años', '21_a_25_anios' => 'De 21 a 25 años', '26_a_30_anios' => 'De 26 a 30 años', '31_a_mas' => 'De 31 años o más', 'no_conviviera' => 'No conviviera'] as $value => $label)
                                    <option value="{{ $value }}"
                                        {{ old('pareja_anos_convivencia', $caso->pareja_anos_convivencia) == $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- =====================
                                 SECCIÓN 3: DATOS HIJOS
                            ===================== -->
            <div class="card mb-3">
                <div class="card-header bg-success text-white">
                    <i class="bi bi-person-hearts"></i> Hijos
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="hijos_num_gestacion" class="form-label">Número de hijos en gestación</label>
                        <select name="hijos_num_gestacion" id="hijos_num_gestacion" class="form-select">
                            <option value="">--Seleccione--</option>
                            @foreach (['en_gestacion' => 'En gestación', 'solo_uno' => 'Solo uno', '2_a_3' => '2 a 3', '4_a_5' => '4 a 5', '6_a_7' => '6 a 7', '8_mas' => '8 a más', 'no_tiene_hijos' => 'No tiene hijos'] as $value => $label)
                                <option value="{{ $value }}"
                                    {{ old('hijos_num_gestacion', $caso->hijos_num_gestacion) == $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Edad y sexo de los hijos</label>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Edad</th>
                                    <th>Masculino</th>
                                    <th>Femenino</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Menor de 4 años</td>
                                    <td>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox"
                                                name="hijos_edad_menor4_masculino" id="hijos_edad_menor4_masculino"
                                                value="M"
                                                {{ old('hijos_edad_menor4_masculino', $caso->hijos_edad_menor4_masculino) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="hijos_edad_menor4_masculino"></label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox"
                                                name="hijos_edad_menor4_femenino" id="hijos_edad_menor4_femenino"
                                                value="F"
                                                {{ old('hijos_edad_menor4_femenino', $caso->hijos_edad_menor4_femenino) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="hijos_edad_menor4_femenino"></label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>De 5 a 10 años</td>
                                    <td>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox"
                                                name="hijos_edad_5_10_masculino" id="hijos_edad_5_10_masculino"
                                                value="M"
                                                {{ old('hijos_edad_5_10_masculino', $caso->hijos_edad_5_10_masculino) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="hijos_edad_5_10_masculino"></label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox"
                                                name="hijos_edad_5_10_femenino" id="hijos_edad_5_10_femenino"
                                                value="F"
                                                {{ old('hijos_edad_5_10_femenino', $caso->hijos_edad_5_10_femenino) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="hijos_edad_5_10_femenino"></label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>De 11 a 15 años</td>
                                    <td>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox"
                                                name="hijos_edad_11_15_masculino" id="hijos_edad_11_15_masculino"
                                                value="M"
                                                {{ old('hijos_edad_11_15_masculino', $caso->hijos_edad_11_15_masculino) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="hijos_edad_11_15_masculino"></label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox"
                                                name="hijos_edad_11_15_femenino" id="hijos_edad_11_15_femenino"
                                                value="F"
                                                {{ old('hijos_edad_11_15_femenino', $caso->hijos_edad_11_15_femenino) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="hijos_edad_11_15_femenino"></label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>De 16 a 20 años</td>
                                    <td>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox"
                                                name="hijos_edad_16_20_masculino" id="hijos_edad_16_20_masculino"
                                                value="M"
                                                {{ old('hijos_edad_16_20_masculino', $caso->hijos_edad_16_20_masculino) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="hijos_edad_16_20_masculino"></label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox"
                                                name="hijos_edad_16_20_femenino" id="hijos_edad_16_20_femenino"
                                                value="F"
                                                {{ old('hijos_edad_16_20_femenino', $caso->hijos_edad_16_20_femenino) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="hijos_edad_16_20_femenino"></label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>De 21 a más años </td>
                                    <td>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox"
                                                name="hijos_edad_21_mas_masculino" id="hijos_edad_21_mas_masculino"
                                                value="M"
                                                {{ old('hijos_edad_21_mas_masculino', $caso->hijos_edad_21_mas_masculino) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="hijos_edad_21_mas_masculino"></label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox"
                                                name="hijos_edad_21_mas_femenino" id="hijos_edad_21_mas_femenino"
                                                value="F"
                                                {{ old('hijos_edad_21_mas_femenino', $caso->hijos_edad_21_mas_femenino) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="hijos_edad_21_mas_femenino"></label>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="mb-3">
                        <label for="hijos_dependencia" class="form-label">Dependencia económica de los hijos</label>
                        <select name="hijos_dependencia" id="hijos_dependencia" class="form-select">
                            <option value="">--Seleccione--</option>
                            @foreach (['dependiente_menor_18' => 'Dependiente menor de 18 años', 'dependiente_mayor_18' => 'Dependiente mayor de 18 años', 'no_dependiente_menor_18' => 'No dependiente menor de 18 años', 'no_dependiente_mayor_18' => 'No dependiente mayor de 18 años', 'no_tiene_hijos' => 'No tiene hijos'] as $value => $label)
                                <option value="{{ $value }}"
                                    {{ old('hijos_dependencia', $caso->hijos_dependencia) == $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <!-- =====================
                                 SECCIÓN 4: TIPOS DE VIOLENCIA
                            ===================== -->
            <div class="card mb-3">
                <div class="card-header bg-danger text-white">
                    <i class="bi bi-exclamation-triangle"></i> Tipos de Violencia
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Seleccione los tipos de violencia (puede marcar varios):</label>

                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="violencia_tipo_fisica"
                                id="violencia_tipo_fisica" value="1"
                                {{ old('violencia_tipo_fisica', $caso->violencia_tipo_fisica) ? 'checked' : '' }}>
                            <label class="form-check-label" for="violencia_tipo_fisica">
                                Violencia Física
                            </label>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="violencia_tipo_psicologica"
                                id="violencia_tipo_psicologica" value="1"
                                {{ old('violencia_tipo_psicologica', $caso->violencia_tipo_psicologica) ? 'checked' : '' }}>
                            <label class="form-check-label" for="violencia_tipo_psicologica">
                                Violencia Psicológica
                            </label>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="violencia_tipo_sexual"
                                id="violencia_tipo_sexual" value="1"
                                {{ old('violencia_tipo_sexual', $caso->violencia_tipo_sexual) ? 'checked' : '' }}>
                            <label class="form-check-label" for="violencia_tipo_sexual">
                                Violencia Sexual
                            </label>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="violencia_tipo_economica"
                                id="violencia_tipo_economica" value="1"
                                {{ old('violencia_tipo_economica', $caso->violencia_tipo_economica) ? 'checked' : '' }}>
                            <label class="form-check-label" for="violencia_tipo_economica">
                                Violencia Económica
                            </label>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="violencia_tipo_patrimonial"
                                id="violencia_tipo_patrimonial" value="1"
                                {{ old('violencia_tipo_patrimonial', $caso->violencia_tipo_patrimonial) ? 'checked' : '' }}>
                            <label class="form-check-label" for="violencia_tipo_patrimonial">
                                Violencia Patrimonial
                            </label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="violencia_tipo" class="form-label">Tipo de Violencia</label>
                        <select name="violencia_tipo" id="violencia_tipo" class="form-select" required>
                            <option value="">--Seleccione--</option>
                            <option value="violencia_intrafamiliar"
                                {{ old('violencia_tipo', $caso->violencia_tipo) == 'violencia_intrafamiliar' ? 'selected' : '' }}>
                                Violencia Intrafamiliar</option>
                            <option value="violencia_domestica"
                                {{ old('violencia_tipo', $caso->violencia_tipo) == 'violencia_domestica' ? 'selected' : '' }}>
                                Violencia Doméstica</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="violencia_frecuancia_agresion" class="form-label">Frecuencia de agresión</label>
                        <select name="violencia_frecuancia_agresion" id="violencia_frecuancia_agresion"
                            class="form-select" required>
                            <option value="">--Seleccione--</option>
                            @foreach (['primera_vez' => 'Primera Vez', 'alguna_vez' => 'Alguna Vez', 'ocacionalmente' => 'Ocasionalmente', 'con_frecuencia' => 'Con Frecuencia', 'siempre' => 'Siempre'] as $value => $label)
                                <option value="{{ $value }}"
                                    {{ old('violencia_frecuancia_agresion', $caso->violencia_frecuancia_agresion) == $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">¿Ha denunciado anteriormente?</label>
                        <div class="form-check">
                            <input type="radio" name="violencia_denuncia_previa" value="1"
                                {{ (old('violencia_denuncia_previa') ?? $caso->violencia_denuncia_previa) == 'si' ? 'checked' : '' }}>
                            <label class="form-check-label" for="violencia_denuncia_previa_si">
                                Sí
                            </label>
                        </div>
                        <div class="form-check">
                            <input type="radio" name="violencia_denuncia_previa" value="0"
                                {{ (old('violencia_denuncia_previa') ?? $caso->violencia_denuncia_previa) == 'no' ? 'checked' : '' }}>
                            <label class="form-check-label" for="violencia_denuncia_previa_no">
                                No
                            </label>
                        </div>
                    </div>


                    <div class="mb-3">
                        <label class="form-label">Razones por las que no hizo la denuncia</label>

                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="violencia_no_denuncia_por_amenaza"
                                id="no_denuncia_amenaza" value="1"
                                {{ old('violencia_no_denuncia_por_amenaza', $caso->violencia_no_denuncia_por_amenaza) ? 'checked' : '' }}>
                            <label class="form-check-label" for="no_denuncia_amenaza">
                                Por Amenaza
                            </label>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="violencia_no_denuncia_por_temor"
                                id="no_denuncia_temor" value="1"
                                {{ old('violencia_no_denuncia_por_temor', $caso->violencia_no_denuncia_por_temor) ? 'checked' : '' }}>
                            <label class="form-check-label" for="no_denuncia_temor">
                                Por Temor
                            </label>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="violencia_no_denuncia_por_verguenza"
                                id="no_denuncia_verguenza" value="1"
                                {{ old('violencia_no_denuncia_por_verguenza', $caso->violencia_no_denuncia_por_verguenza) ? 'checked' : '' }}>
                            <label class="form-check-label" for="no_denuncia_verguenza">
                                Por Vergüenza
                            </label>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="checkbox"
                                name="violencia_no_denuncia_por_desconocimiento" id="no_denuncia_desconocimiento"
                                value="1"
                                {{ old('violencia_no_denuncia_por_desconocimiento', $caso->violencia_no_denuncia_por_desconocimiento) ? 'checked' : '' }}>
                            <label class="form-check-label" for="no_denuncia_desconocimiento">
                                Por Desconocimiento
                            </label>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="checkbox"
                                name="violencia_no_denuncia_no_sabe_no_responde" id="no_denuncia_no_sabe" value="1"
                                {{ old('violencia_no_denuncia_no_sabe_no_responde', $caso->violencia_no_denuncia_no_sabe_no_responde) ? 'checked' : '' }}>
                            <label class="form-check-label" for="no_denuncia_no_sabe">
                                No sabe / no responde
                            </label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="violencia_motivo_agresion" class="form-label">Motivo de la Agresión</label>
                        <select name="violencia_motivo_agresion" id="violencia_motivo_agresion" class="form-select"
                            required>
                            <option value="">--Seleccione--</option>
                            @foreach (['ebriedad' => 'Ebriedad', 'infidelidad' => 'Infidelidad', 'economico' => 'Económico', 'celos' => 'Celos', 'cultural' => 'Cultural', 'adiccion' => 'Adicción', 'intromision_familiar' => 'Intromisión Familiar', 'otro' => 'Otro'] as $value => $label)
                                <option value="{{ $value }}"
                                    {{ old('violencia_motivo_agresion', $caso->violencia_motivo_agresion) == $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="violencia_motivo_otros" class="form-label">Otros:</label>
                        <input type="text" class="form-control" id="violencia_motivo_otros"
                            name="violencia_motivo_otros" placeholder="Especifique si seleccionó 'Otro'"
                            value="{{ old('violencia_motivo_otros', $caso->violencia_motivo_otros) }}">
                    </div>

                    <div class="mb-3">
                        <label for="violencia_descripcion_hechos" class="form-label">Denuncias o proceso realizados
                            (Problemática)</label>
                        <textarea name="violencia_descripcion_hechos" id="violencia_descripcion_hechos" class="form-control" rows="4"
                            placeholder="Describa problemática.">{{ old('violencia_descripcion_hechos', $caso->violencia_descripcion_hechos) }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Atención que demanda</label>

                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="violencia_atencion_apoyo_victima"
                                id="atencion_victima" value="1"
                                {{ old('violencia_atencion_apoyo_victima', $caso->violencia_atencion_apoyo_victima) == 1 ? 'checked' : '' }}>
                            <label class="form-check-label" for="atencion_victima">
                                Apoyo a Víctima
                            </label>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="violencia_atencion_apoyo_pareja"
                                id="atencion_pareja" value="1"
                                {{ old('violencia_atencion_apoyo_pareja', $caso->violencia_atencion_apoyo_pareja) == 1 ? 'checked' : '' }}>
                            <label class="form-check-label" for="atencion_pareja">
                                Apoyo a Pareja
                            </label>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="violencia_atencion_apoyo_agresor"
                                id="atencion_agresor" value="1"
                                {{ old('violencia_atencion_apoyo_agresor', $caso->violencia_atencion_apoyo_agresor) == 1 ? 'checked' : '' }}>
                            <label class="form-check-label" for="atencion_agresor">
                                Apoyo a agresor
                            </label>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="violencia_atencion_apoyo_hijos"
                                id="atencion_hijos" value="1"
                                {{ old('violencia_atencion_apoyo_hijos', $caso->violencia_atencion_apoyo_hijos) == 1 ? 'checked' : '' }}>
                            <label class="form-check-label" for="atencion_hijos">
                                Apoyo hijos
                            </label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="violencia_institucion_denuncia" class="form-label">Medidas a tomar:</label>
                        <input type="text" name="violencia_institucion_denuncia" id="violencia_institucion_denuncia"
                            class="form-control" placeholder="medidas a tomar"
                            value="{{ old('violencia_institucion_denuncia', $caso->violencia_institucion_denuncia) }}">
                    </div>

                    <div class="mb-3">
                        <label for="formulario_responsable_nombre" class="form-label">Nombre de la persona que llenó el
                            formulario</label>
                        <input type="text" name="formulario_responsable_nombre" id="formulario_responsable_nombre"
                            class="form-control" placeholder="nombre completo"
                            value="{{ old('formulario_responsable_nombre', $caso->formulario_responsable_nombre) }}">
                    </div>
                </div>
            </div>

            <div class="d-flex gap-2 mb-4">
                <button class="btn btn-primary" type="submit">
                    <i class="bi bi-save"></i> Actualizar caso
                </button>
                <a href="{{ route('casos.index') }}" class="btn btn-secondary">
                    <i class="bi bi-x-circle"></i> Cancelar
                </a>
                {{-- <a href="{{ route('casos.show', $caso->id) }}" class="btn btn-info">
                <i class="bi bi-eye"></i> Ver detalles
            </a> --}}
            </div>
        </form>
    </div>
@endsection
