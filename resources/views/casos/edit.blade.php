@extends('layouts.sidebar')

@section('content')
    <style>
        body {
            background-color: #F4F4F2;
            color: #333;
        }

        .card {
            border: 1px solid #13C0E5;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .card-header {
            background-color: #13C0E5;
            color: white;
            font-weight: bold;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }

        .form-label {
            font-weight: bold;
        }

        .form-control,
        .form-select {
            border-radius: 5px;
            border: 1px solid #7EC544;
        }

        .form-check-input:checked {
            background-color: #037E8C;
            border-color: #037E8C;
        }

        button {
            background-color: #037E8C;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 10px 15px;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #13C0E5;
        }
    </style>

    <h2>Editar Caso de Violencia</h2>
    @if (session('success'))
        <div class="alert alert-success mt-3">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger mt-3">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('casos.update', $caso->id) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- =====================
                                                 SECCIÓN 0: DATOS DE LA REGIONAL
                                            ===================== -->
        <div class="card mb-3">
            <div class="card-header">Regional</div>
            <div class="card-body">
                <div class="row g-2">
                    <div class="col-md-6">
                        <label class="form-label">Regional que recibe el caso:</label>
                        <input type="text" name="regional_recibe_caso" class="form-control"
                            value="{{ old('regional_recibe_caso', $caso->regional_recibe_caso) }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Fecha</label>
                        @php
                            // Determinar qué campo de fecha usar
                            $fechaValue = null;
                            if (old('regional_fecha')) {
                                $fechaValue = old('regional_fecha');
                            } elseif (isset($caso->regional_fecha) && $caso->regional_fecha) {
                                $fechaValue = $caso->regional_fecha;
                            } elseif (isset($caso->fecha) && $caso->fecha) {
                                $fechaValue = $caso->fecha;
                            }

                            // Si es un objeto Carbon, convertir a string Y-m-d
                            if ($fechaValue instanceof \Carbon\Carbon) {
                                $fechaValue = $fechaValue->format('Y-m-d');
                            }
                        @endphp
                        <input type="date" name="regional_fecha" class="form-control" value="{{ $fechaValue }}">

                        {{-- DEBUG: Descomenta temporalmente para ver qué fecha tiene guardada --}}
                        {{-- <small class="text-muted">Debug: {{ $caso->regional_fecha }} | {{ $caso->fecha ?? 'null' }}</small> --}}
                    </div>


                    <!-- Número de Registro (Solo lectura en edición) -->
                    <div class="col-md-6 mt-3">
                        <label class="form-label">Número de Registro</label>
                        <input type="text" class="form-control bg-light" value="{{ $caso->nro_registro }}" readonly>
                        <small class="form-text text-muted">
                            El número de registro no se puede modificar
                        </small>
                    </div>

                    <div class="col-md-6 mt-3">
                        <label class="form-label">Institución que deriva</label>
                        <input type="text" name="regional_institucion_derivante" class="form-control"
                            value="{{ old('regional_institucion_derivante', $caso->regional_institucion_derivante) }}">
                    </div>
                </div>
            </div>
        </div>

        <!-- =====================
                                                 SECCIÓN 1: DATOS PERSONALES PACIENTE
                                            ===================== -->
        <div class="card mb-3">
            <div class="card-header">Datos Personales y Más Datos</div>
            <div class="card-body">
                <div class="row g-2">
                    <div class="col-md-6">
                        <label class="form-label">Nombres</label>
                        <input type="text" name="paciente_nombres" class="form-control" required
                            value="{{ old('paciente_nombres', $caso->paciente_nombres) }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Apellido Paterno</label>
                        <input type="text" name="paciente_ap_paterno" class="form-control" required
                            value="{{ old('paciente_ap_paterno', $caso->paciente_ap_paterno) }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Apellido Materno</label>
                        <input type="text" name="paciente_ap_materno" class="form-control" required
                            value="{{ old('paciente_ap_materno', $caso->paciente_ap_materno) }}">
                    </div>
                    <div class="col-md-4 mt-2">
                        <label class="form-label d-block">Edad</label>
                        <input type="text" name="paciente_edad" class="form-control"
                            value="{{ old('paciente_edad', $caso->paciente_edad) }}">
                    </div>
                    <div class="col-md-4 mt-2">
                        <label class="form-label">CI</label>
                        <input type="text" name="paciente_ci" class="form-control"
                            value="{{ old('paciente_ci', $caso->paciente_ci) }}">
                    </div>
                    <div class="col-md-4 mt-2">
                        <label class="form-label d-block">Sexo</label>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="paciente_sexo" value="M" required
                                {{ old('paciente_sexo', $caso->paciente_sexo) == 'M' ? 'checked' : '' }}>
                            <label class="form-check-label">Varón</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="paciente_sexo" value="F" required
                                {{ old('paciente_sexo', $caso->paciente_sexo) == 'F' ? 'checked' : '' }}>
                            <label class="form-check-label">Mujer</label>
                        </div>
                    </div>
                    <div class="col-md-8 mt-2">
                        <label class="form-label">Edad (rango)</label>
                        <div class="d-flex flex-wrap gap-2">
                            @php
                                $edadRangos = [
                                    'menor15' => 'Menor de 15 años',
                                    '16a20' => '16 a 20 años',
                                    '21a25' => '21 a 25 años',
                                    '26a30' => '26 a 30 años',
                                    '31a35' => '31 a 35 años',
                                    '36a50' => '36 a 50 años',
                                    'mayor50' => 'Más de 50 años',
                                ];
                            @endphp
                            @foreach ($edadRangos as $value => $label)
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="paciente_edad_rango"
                                        value="{{ $value }}" required
                                        {{ old('paciente_edad_rango', $caso->paciente_edad_rango) == $value ? 'checked' : '' }}>
                                    <label class="form-check-label">{{ $label }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="col-md-8 mt-2">
                        <label class="form-label">Distrito</label><br>
                        <div class="d-flex flex-wrap gap-2">
                            @for ($i = 1; $i <= 14; $i++)
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="paciente_id_distrito"
                                        value="{{ $i }}" required
                                        {{ old('paciente_id_distrito', $caso->paciente_id_distrito) == $i ? 'checked' : '' }}>
                                    <label class="form-check-label">Distrito {{ $i }}</label>
                                </div>
                            @endfor
                        </div>
                        <div class="mt-2">
                            <input type="text" name="paciente_otros" class="form-control" placeholder="Otros"
                                value="{{ old('paciente_otros', $caso->paciente_otros) }}">
                        </div>
                        <div class="mt-2">
                            <input type="text" name="paciente_zona" class="form-control" placeholder="Zona / Barrio"
                                value="{{ old('paciente_zona', $caso->paciente_zona) }}">
                        </div>
                        <div class="mt-2">
                            <input type="text" name="paciente_calle" class="form-control"
                                placeholder="Calle / Avenida" value="{{ old('paciente_calle', $caso->paciente_calle) }}">
                        </div>
                        <div class="mt-2">
                            <input type="text" name="paciente_numero" class="form-control" placeholder="Número"
                                value="{{ old('paciente_numero', $caso->paciente_numero) }}">
                        </div>
                        <div class="mt-2">
                            <input type="text" name="paciente_telefono" class="form-control" placeholder="Teléfono"
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
                                value="dentro" required
                                {{ old('paciente_lugar_nacimiento_op', $caso->paciente_lugar_nacimiento_op) == 'dentro' ? 'checked' : '' }}>
                            <label class="form-check-label">Dentro de municipio</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="paciente_lugar_nacimiento_op"
                                value="fuera" required
                                {{ old('paciente_lugar_nacimiento_op', $caso->paciente_lugar_nacimiento_op) == 'fuera' ? 'checked' : '' }}>
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
                            $tiempoResidencia = [
                                'menosDeUnAno' => 'Menos de 1 año',
                                'de2a5Anos' => 'De 2 a 5 años',
                                'de6a10Anos' => 'De 6 a 10 años',
                                'masDe10Anos' => 'De 11 y más años',
                                'no_sabe_no_responde' => 'No sabe / no responde',
                            ];
                        @endphp
                        @foreach ($tiempoResidencia as $value => $label)
                            <div class="form-check form-check-inline mt-2">
                                <input class="form-check-input" type="radio" name="paciente_tiempo_residencia_op"
                                    value="{{ $value }}"
                                    {{ old('paciente_tiempo_residencia_op', $caso->paciente_tiempo_residencia_op) == $value ? 'checked' : '' }}>
                                <label class="form-check-label">{{ $label }}</label>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="row g-2 mt-3">
                    <div class="col-md-6">
                        <label for="paciente_estado_civil" class="form-label">Estado Civil</label>
                        <select class="form-select" id="paciente_estado_civil" name="paciente_estado_civil" required>
                            <option value="">Seleccione...</option>
                            @php
                                $estadosCiviles = [
                                    'soltero' => 'Soltero',
                                    'conviviente' => 'Conviviente',
                                    'viudo' => 'Viudo',
                                    'casado' => 'Casado',
                                    'separado' => 'Separado',
                                    'divorciado' => 'Divorciado',
                                ];
                            @endphp
                            @foreach ($estadosCiviles as $value => $label)
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
                            @php
                                $nivelesInstruccion = [
                                    'ninguno' => 'Ninguno',
                                    'primaria' => 'Primaria',
                                    'secundaria' => 'Secundaria',
                                    'tecnico' => 'Técnico',
                                    'tecnicoSuperior' => 'Técnico Superior',
                                    'licenciatura' => 'Licenciatura',
                                ];
                            @endphp
                            @foreach ($nivelesInstruccion as $value => $label)
                                <option value="{{ $value }}"
                                    {{ old('paciente_nivel_instruccion', $caso->paciente_nivel_instruccion) == $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="paciente_idioma_mas_hablado" class="form-label">Idioma más hablado</label>
                        <select class="form-select" id="paciente_idioma_mas_hablado" name="paciente_idioma_mas_hablado">
                            <option value="">Seleccione...</option>
                            @php
                                $idiomas = [
                                    'castellano' => 'Castellano',
                                    'aymara' => 'Aymara',
                                    'quechua' => 'Quechua',
                                    'guarani' => 'Guaraní',
                                    'otroNativo' => 'Otro nativo',
                                    'extranjero' => 'Extranjero',
                                ];
                            @endphp
                            @foreach ($idiomas as $value => $label)
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
                            placeholder="Especificar si seleccionó 'Otro'"
                            value="{{ old('paciente_idioma_especificar', $caso->paciente_idioma_especificar) }}">
                    </div>
                    <div class="col-md-6 mt-2">
                        <label for="paciente_ocupacion" class="form-label">Ocupación Principal</label>
                        <select class="form-select" id="paciente_ocupacion" name="paciente_ocupacion" required>
                            <option value="">Seleccione...</option>
                            @php
                                $ocupaciones = [
                                    'obrero' => 'Obrero',
                                    'empleada' => 'Empleada',
                                    'trabajadorCuentaPropia' => 'Trabajador por Cuenta Propia',
                                    'patrona' => 'Patrona',
                                    'socioemprendedor' => 'Socioemprendedor',
                                    'cooperativista' => 'Cooperativista',
                                    'aprendizSinRemuneracion' => 'Aprendiz sin Remuneración',
                                    'aprendizConRemuneracion' => 'Aprendiz con Remuneración',
                                    'laboresCasa' => 'Labores de Casa',
                                    'sinTrabajo' => 'No tienen Trabajo',
                                    'otros' => 'Otros',
                                ];
                            @endphp
                            @foreach ($ocupaciones as $value => $label)
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
                                Permanente
                            </option>
                            <option value="temporal"
                                {{ old('paciente_situacion_ocupacional', $caso->paciente_situacion_ocupacional) == 'temporal' ? 'selected' : '' }}>
                                Temporal
                            </option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- =====================
                                                 SECCIÓN 2: DATOS PAREJA
                                            ===================== -->
        <div class="card mb-3">
            <div class="card-header">2. Datos de la pareja</div>
            <div class="card-body">
                <div class="row g-2">
                    <div class="col-md-6">
                        <label class="form-label">Nombres</label>
                        <input type="text" name="pareja_nombres" class="form-control" required
                            value="{{ old('pareja_nombres', $caso->pareja_nombres) }}">
                    </div>
                    
                    <div class="col-md-6">
                        <label class="form-label">Apellido Paterno</label>
                        <input type="text" name="pareja_ap_paterno" class="form-control"
                            value="{{ old('pareja_ap_paterno', $caso->pareja_ap_paterno) }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Apellido Materno</label>
                        <input type="text" name="pareja_ap_materno" class="form-control"
                            value="{{ old('pareja_ap_materno', $caso->pareja_ap_materno) }}">
                    </div>
                    <div class="col-md-4 mt-2">
                        <label class="form-label d-block">Sexo</label>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="pareja_sexo" value="M" required
                                {{ old('pareja_sexo', $caso->pareja_sexo) == 'M' ? 'checked' : '' }}>
                            <label class="form-check-label">Varón</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="pareja_sexo" value="F" required
                                {{ old('pareja_sexo', $caso->pareja_sexo) == 'F' ? 'checked' : '' }}>
                            <label class="form-check-label">Mujer</label>
                        </div>
                    </div>
                    <div class="col-md-4 mt-2">
                        <label class="form-label d-block">Edad</label>
                        <input type="text" name="pareja_edad" class="form-control"
                            value="{{ old('pareja_edad', $caso->pareja_edad) }}">
                    </div>
                    <div class="col-md-4 mt-2">
                        <label class="form-label">CI</label>
                        <input type="text" name="pareja_ci" class="form-control"
                            value="{{ old('pareja_ci', $caso->pareja_ci) }}">
                    </div>
                    <div class="col-md-8 mt-2">
                        <label class="form-label">Edad (rango)</label>
                        <div class="d-flex gap-2 flex-wrap">
                            @php
                                $edadRangosPareja = [
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
                            @foreach ($edadRangosPareja as $value => $label)
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="pareja_edad_rango"
                                        value="{{ $value }}" id="pareja_edad_{{ $value }}" required
                                        {{ old('pareja_edad_rango', $caso->pareja_edad_rango) == $value ? 'checked' : '' }}>
                                    <label class="form-check-label"
                                        for="pareja_edad_{{ $value }}">{{ $label }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="col-md-8 mt-2">
                        <label class="form-label">Distrito</label><br>
                        <div class="d-flex flex-wrap gap-2">
                            @for ($i = 1; $i <= 14; $i++)
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="pareja_id_distrito"
                                        value="{{ $i }}" required
                                        {{ old('pareja_id_distrito', $caso->pareja_id_distrito) == $i ? 'checked' : '' }}>
                                    <label class="form-check-label">Distrito {{ $i }}</label>
                                </div>
                            @endfor
                        </div>
                        <div class="mt-2">
                            <input type="text" name="pareja_otros" class="form-control" placeholder="Otros"
                                value="{{ old('pareja_otros', $caso->pareja_otros) }}">
                        </div>
                        <div class="mt-2">
                            <input type="text" name="pareja_zona" class="form-control" placeholder="Zona / Barrio"
                                value="{{ old('pareja_zona', $caso->pareja_zona) }}">
                        </div>
                        <div class="mt-2">
                            <input type="text" name="pareja_calle" class="form-control" placeholder="Calle / Avenida"
                                value="{{ old('pareja_calle', $caso->pareja_calle) }}">
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
                                value="dentro" required
                                {{ old('pareja_lugar_nacimiento_op', $caso->pareja_lugar_nacimiento_op) == 'dentro' ? 'checked' : '' }}>
                            <label class="form-check-label">Dentro de municipio</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="pareja_lugar_nacimiento_op"
                                value="fuera" required
                                {{ old('pareja_lugar_nacimiento_op', $caso->pareja_lugar_nacimiento_op) == 'fuera' ? 'checked' : '' }}>
                            <label class="form-check-label">Fuera de municipio</label>
                        </div>
                    </div>
                </div>

                <div class="row g-2 mt-3">
                    <div class="col-md-4 mt-2">
                        <label class="form-label d-block">Residencia Habitual</label>
                        <div class="form-check form-check-inline mt-2">
                            <input class="form-check-input" type="radio" name="pareja_lugar_residencia_op"
                                value="dentro"
                                {{ old('pareja_lugar_residencia_op', $caso->pareja_lugar_residencia_op) == 'dentro' ? 'checked' : '' }}>
                            <label class="form-check-label">Dentro del municipio</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="pareja_lugar_residencia_op"
                                value="fuera"
                                {{ old('pareja_lugar_residencia_op', $caso->pareja_lugar_residencia_op) == 'fuera' ? 'checked' : '' }}>
                            <label class="form-check-label">Fuera de municipio</label>
                        </div>
                    </div>
                    <div class="col-md-4 mt-2">
                        <label class="form-label d-block">Tiempo de residencia en este municipio</label>
                        @foreach ($tiempoResidencia as $value => $label)
                            <div class="form-check form-check-inline mt-2">
                                <input class="form-check-input" type="radio" name="pareja_tiempo_residencia_op"
                                    value="{{ $value }}"
                                    {{ old('pareja_tiempo_residencia_op', $caso->pareja_tiempo_residencia_op) == $value ? 'checked' : '' }}>
                                <label class="form-check-label">{{ $label }}</label>
                            </div>
                        @endforeach
                    </div>

                    <div class="col-md-6 mt-2">
                        <label for="pareja_estado_civil" class="form-label">3.9 Estado Civil</label>
                        <select class="form-select" id="pareja_estado_civil" name="pareja_estado_civil" required>
                            <option value="">Seleccione</option>
                            @php
                                $estadosCivilesPareja = [
                                    'soltero' => 'Soltero',
                                    'conviviente' => 'Conviviente',
                                    'separado' => 'Separado',
                                    'viudo' => 'Viudo',
                                    'divorciado' => 'Divorciado',
                                ];
                            @endphp
                            @foreach ($estadosCivilesPareja as $value => $label)
                                <option value="{{ $value }}"
                                    {{ old('pareja_estado_civil', $caso->pareja_estado_civil) == $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mt-2">
                        <label for="pareja_nivel_instruccion" class="form-label">3.10 Nivel de Instrucción</label>
                        <select class="form-select" id="pareja_nivel_instruccion" name="pareja_nivel_instruccion"
                            required>
                            <option value="">Seleccione</option>
                            @php
                                $nivelesInstruccionPareja = [
                                    'ninguno' => 'Ninguno',
                                    'primaria' => 'Primaria',
                                    'tecnico' => 'Técnico',
                                    'tecnico_superior' => 'Técnico Superior',
                                    'lee_y_escribe' => 'Lee y Escribe',
                                    'secundaria' => 'Secundaria',
                                    'tecnico_medio' => 'Técnico Medio',
                                    'licenciatura' => 'Licenciatura',
                                ];
                            @endphp
                            @foreach ($nivelesInstruccionPareja as $value => $label)
                                <option value="{{ $value }}"
                                    {{ old('pareja_nivel_instruccion', $caso->pareja_nivel_instruccion) == $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mt-2">
                        <label for="pareja_idioma" class="form-label">3.11 Idioma Más Hablado</label>
                        <select class="form-select" id="pareja_idioma" name="pareja_idioma" required>
                            <option value="">Seleccione</option>
                            @php
                                $idiomasPareja = [
                                    'castellano' => 'Castellano',
                                    'aymara' => 'Aymara',
                                    'quechua' => 'Quechua',
                                    'guarani' => 'Guaraní',
                                    'extranjero' => 'Extranjero',
                                    'otro' => 'Otro',
                                ];
                            @endphp
                            @foreach ($idiomasPareja as $value => $label)
                                <option value="{{ $value }}"
                                    {{ old('pareja_idioma', $caso->pareja_idioma) == $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mt-2">
                        <label for="pareja_especificar_idioma" class="form-label">Especificar Otro Idioma</label>
                        <input type="text" class="form-control" id="pareja_especificar_idioma"
                            name="pareja_especificar_idioma" placeholder="Especifique si seleccionó 'Otro'"
                            value="{{ old('pareja_especificar_idioma', $caso->pareja_especificar_idioma) }}">
                    </div>

                    <div class="col-md-6 mt-2">
                        <label for="pareja_ocupacion_principal" class="form-label">3.12 Ocupación Principal</label>
                        <select class="form-select" id="pareja_ocupacion_principal" name="pareja_ocupacion_principal"
                            required>
                            <option value="">Seleccione</option>
                            @php
                                $ocupacionesPareja = [
                                    'obrero' => 'Obrero',
                                    'empleado' => 'Empleado',
                                    'trabajador_autonomo' => 'Trabajador por cuenta propia',
                                    'patrona' => 'Patrona',
                                    'socio_empleador' => 'Socio de empleador',
                                    'cooperativista' => 'Cooperativista de producción familiar',
                                    'aprendiz_sin_remuneracion' => 'Aprendiz sin remuneración',
                                    'aprendiz_con_remuneracion' => 'Aprendiz con remuneración',
                                    'labores_casa' => 'Labores de casa',
                                    'trabajadora_hogar' => 'Trabajadora del hogar',
                                    'no_trabajo' => 'No tiene trabajo',
                                    'otros' => 'Otros',
                                ];
                            @endphp
                            @foreach ($ocupacionesPareja as $value => $label)
                                <option value="{{ $value }}"
                                    {{ old('pareja_ocupacion_principal', $caso->pareja_ocupacion_principal) == $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mt-2">
                        <label for="pareja_situacion_ocupacional" class="form-label">3.13 Situación Ocupacional</label>
                        <select class="form-select" id="pareja_situacion_ocupacional" name="pareja_situacion_ocupacional"
                            required>
                            <option value="">Seleccione</option>
                            <option value="permanente"
                                {{ old('pareja_situacion_ocupacional', $caso->pareja_situacion_ocupacional) == 'permanente' ? 'selected' : '' }}>
                                Permanente
                            </option>
                            <option value="temporal"
                                {{ old('pareja_situacion_ocupacional', $caso->pareja_situacion_ocupacional) == 'temporal' ? 'selected' : '' }}>
                                Temporal
                            </option>
                        </select>
                    </div>
                </div>

                <div class="row g-2 mt-4">
                    <div class="col-12">
                        <legend class="h5">4. Situación Familiar</legend>
                    </div>

                    <div class="col-md-6">
                        <label for="pareja_parentesco" class="form-label">4.1 Relación de Parentesco</label>
                        <select class="form-select" id="pareja_parentesco" name="pareja_parentesco" required>
                            <option value="">Seleccione</option>
                            @php
                                $parentescos = [
                                    'conyuge' => 'Cónyuge',
                                    'conviviente' => 'Conviviente',
                                    'ex_conyuge' => 'Ex cónyuge',
                                    'ex_conviviente' => 'Ex conviviente',
                                    'enamorado' => 'Enamorado',
                                    'ex_enamorado' => 'Ex enamorado',
                                    'otros' => 'Otros familiares',
                                ];
                            @endphp
                            @foreach ($parentescos as $value => $label)
                                <option value="{{ $value }}"
                                    {{ old('pareja_parentesco', $caso->pareja_parentesco) == $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="pareja_anos_convivencia" class="form-label">4.2 Años de Matrimonio o
                            Convivencia</label>
                        <select class="form-select" id="pareja_anos_convivencia" name="pareja_anos_convivencia" required>
                            <option value="">Seleccione</option>
                            @php
                                $anosConvivencia = [
                                    'menos_de_un_ano' => 'Menos de un año',
                                    '1_a_5_anios' => 'De 1 a 5 años',
                                    '6_a_10_anios' => 'De 6 a 10 años',
                                    '11_a_15_anios' => 'De 11 a 15 años',
                                    '16_a_20_anios' => 'De 16 a 20 años',
                                    '21_a_25_anios' => 'De 21 a 25 años',
                                    '26_a_30_anios' => 'De 26 a 30 años',
                                    '31_a_mas' => 'De 31 años o más',
                                    'no_conviviera' => 'No conviviera',
                                ];
                            @endphp
                            @foreach ($anosConvivencia as $value => $label)
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
            <div class="card-header">3. Hijos</div>
            <div class="card-body">
                <!-- Número de hijos en gestación -->
                <div class="mb-3">
                    <label for="hijos_num_gestacion" class="form-label">Número de hijos en gestación</label>
                    <select name="hijos_num_gestacion" id="hijos_num_gestacion" class="form-select">
                        <option value="">--Seleccione--</option>
                        <option value="en_gestacion"
                            {{ old('hijos_num_gestacion', $caso->hijos_num_gestacion) == 'en_gestacion' ? 'selected' : '' }}>
                            En gestación</option>
                        <option value="solo_uno"
                            {{ old('hijos_num_gestacion', $caso->hijos_num_gestacion) == 'solo_uno' ? 'selected' : '' }}>
                            Solo uno</option>
                        <option value="2_a_3"
                            {{ old('hijos_num_gestacion', $caso->hijos_num_gestacion) == '2_a_3' ? 'selected' : '' }}>2 a 3
                        </option>
                        <option value="4_a_5"
                            {{ old('hijos_num_gestacion', $caso->hijos_num_gestacion) == '4_a_5' ? 'selected' : '' }}>4 a 5
                        </option>
                        <option value="6_a_7"
                            {{ old('hijos_num_gestacion', $caso->hijos_num_gestacion) == '6_a_7' ? 'selected' : '' }}>6 a 7
                        </option>
                        <option value="8_mas"
                            {{ old('hijos_num_gestacion', $caso->hijos_num_gestacion) == '8_mas' ? 'selected' : '' }}>8 a
                            más</option>
                        <option value="no_tiene_hijos"
                            {{ old('hijos_num_gestacion', $caso->hijos_num_gestacion) == 'no_tiene_hijos' ? 'selected' : '' }}>
                            No tiene hijos</option>
                    </select>
                </div>

                <!-- Edad y sexo de los hijos -->
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
                            @php
                                $edades = [
                                    ['label' => 'Menor de 4 años', 'm' => 'hijos_menor4_m', 'f' => 'hijos_menor4_f'],
                                    ['label' => 'De 5 a 10 años', 'm' => 'hijos_5a10_m', 'f' => 'hijos_5a10_f'],
                                    ['label' => 'De 11 a 15 años', 'm' => 'hijos_11a15_m', 'f' => 'hijos_11a15_f'],
                                    ['label' => 'De 16 a 20 años', 'm' => 'hijos_16a20_m', 'f' => 'hijos_16a20_f'],
                                    ['label' => 'De 21 a más años', 'm' => 'hijos_21mas_m', 'f' => 'hijos_21mas_f'],
                                ];
                            @endphp

                            @foreach ($edades as $edad)
                                <tr>
                                    <td>{{ $edad['label'] }}</td>
                                    <td class="text-center">
                                        @for ($i = 0; $i < 5; $i++)
                                            <input type="checkbox" name="{{ $edad['m'] }}[]" value="1"
                                                {{ $i < $caso->{$edad['m']} ? 'checked' : '' }}>
                                        @endfor
                                    </td>
                                    <td class="text-center">
                                        @for ($i = 0; $i < 5; $i++)
                                            <input type="checkbox" name="{{ $edad['f'] }}[]" value="1"
                                                {{ $i < $caso->{$edad['f']} ? 'checked' : '' }}>
                                        @endfor
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>


                <!-- Dependencia económica de los hijos -->
                <div class="mb-3">
                    <label for="hijos_dependencia" class="form-label">Dependencia económica de los hijos</label>
                    <select name="hijos_dependencia" id="hijos_dependencia" class="form-select">
                        <option value="">--Seleccione--</option>
                        <option value="dependiente_menor_18"
                            {{ old('hijos_dependencia', $caso->hijos_dependencia) == 'dependiente_menor_18' ? 'selected' : '' }}>
                            Dependiente menor de 18 años</option>
                        <option value="dependiente_mayor_18"
                            {{ old('hijos_dependencia', $caso->hijos_dependencia) == 'dependiente_mayor_18' ? 'selected' : '' }}>
                            Dependiente mayor de 18 años</option>
                        <option value="no_dependiente_menor_18"
                            {{ old('hijos_dependencia', $caso->hijos_dependencia) == 'no_dependiente_menor_18' ? 'selected' : '' }}>
                            No dependiente menor de 18 años</option>
                        <option value="no_dependiente_mayor_18"
                            {{ old('hijos_dependencia', $caso->hijos_dependencia) == 'no_dependiente_mayor_18' ? 'selected' : '' }}>
                            No dependiente mayor de 18 años</option>
                        <option value="no_tiene_hijos"
                            {{ old('hijos_dependencia', $caso->hijos_dependencia) == 'no_tiene_hijos' ? 'selected' : '' }}>
                            No tiene hijos</option>
                    </select>
                </div>
            </div>
        </div>


        <!-- =====================
                                                 SECCIÓN 4: TIPOS DE VIOLENCIA
                                            ===================== -->
        <div class="card mb-3">
            <div class="card-header">4. Tipos de Violencia</div>
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
                    <label for="violencia_frecuencia" class="form-label">Tipo de Violencia</label>
                    <select name="violencia_tipo" id="violencia_frecuencia" class="form-select" required>
                        <option value="">--Seleccione--</option>
                        <option value="violencia_intrafamiliar"
                            {{ old('violencia_tipo', $caso->violencia_tipo) == 'violencia_intrafamiliar' ? 'selected' : '' }}>
                            Violencia Intrafamiliar
                        </option>
                        <option value="violencia_domestica"
                            {{ old('violencia_tipo', $caso->violencia_tipo) == 'violencia_domestica' ? 'selected' : '' }}>
                            Violencia Domestica
                        </option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="violencia_tiempo_ocurrencia" class="form-label">Frecuencia de agresión</label>
                    <select name="violencia_frecuancia_agresion" id="violencia_tiempo_ocurrencia" class="form-select"
                        required>
                        <option value="">--Seleccione--</option>
                        @php
                            $frecuencias = [
                                'primera_vez' => 'Primera Vez',
                                'alguna_vez' => 'Alguna Vez',
                                'ocacionalmente' => 'Ocacionalmente',
                                'con_frecuencia' => 'Con Frecuencia',
                                'siempre' => 'Siempre',
                            ];
                        @endphp
                        @foreach ($frecuencias as $value => $label)
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
                        <input class="form-check-input" type="radio" name="violencia_denuncia_previa"
                            id="violencia_denuncia_previa_si" value="si" required
                            {{ old('violencia_denuncia_previa', $caso->violencia_denuncia_previa) == 'si' ? 'checked' : '' }}>
                        <label class="form-check-label" for="violencia_denuncia_previa_si">
                            Sí
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="violencia_denuncia_previa"
                            id="violencia_denuncia_previa_no" value="no" required
                            {{ old('violencia_denuncia_previa', $caso->violencia_denuncia_previa) == 'no' ? 'checked' : '' }}>
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
                        <input class="form-check-input" type="checkbox" name="violencia_no_denuncia_por_desconocimiento"
                            id="no_denuncia_desconocimiento" value="1"
                            {{ old('violencia_no_denuncia_por_desconocimiento', $caso->violencia_no_denuncia_por_desconocimiento) ? 'checked' : '' }}>
                        <label class="form-check-label" for="no_denuncia_desconocimiento">
                            Por Desconocimiento
                        </label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="violencia_no_denuncia_no_sabe_no_responde"
                            id="no_denuncia_no_sabe" value="1"
                            {{ old('violencia_no_denuncia_no_sabe_no_responde', $caso->violencia_no_denuncia_no_sabe_no_responde) ? 'checked' : '' }}>
                        <label class="form-check-label" for="no_denuncia_no_sabe">
                            No sabe / no responde
                        </label>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="violencia_lugar_hechos" class="form-label">Motivo de la Agresión</label>
                    <select name="violencia_motivo_agresion" id="violencia_lugar_hechos" class="form-select" required>
                        <option value="">--Seleccione--</option>
                        @php
                            $motivos = [
                                'ebriedad' => 'Ebriedad',
                                'infidelidad' => 'Infidelidad',
                                'economico' => 'Económico',
                                'celos' => 'Celos',
                                'cultural' => 'Cultural',
                                'adiccion' => 'Adicción',
                                'intromision_familiar' => 'Intromisión Familiar',
                                'otro' => 'Otro',
                            ];
                        @endphp
                        @foreach ($motivos as $value => $label)
                            <option value="{{ $value }}"
                                {{ old('violencia_motivo_agresion', $caso->violencia_motivo_agresion) == $value ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="md-6 mt-2">
                    <label for="pareja_especificar_idioma" class="form-label">Otros:</label>
                    <input type="text" class="form-control" id="pareja_especificar_idioma"
                        name="violencia_motivo_otros" placeholder="Especifique si seleccionó 'Otro'"
                        value="{{ old('violencia_motivo_otros', $caso->violencia_motivo_otros) }}">
                </div>

                <div class="mb-3 mt-3">
                    <label for="violencia_descripcion_hechos" class="form-label">Denuncias o proceso realizados
                        (Problemática)</label>
                    <textarea name="violencia_descripcion_hechos" id="violencia_descripcion_hechos" class="form-control" rows="4"
                        placeholder="Describa problemática.">{{ old('violencia_descripcion_hechos', $caso->violencia_descripcion_hechos) }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Atención que demanda <span class="text-danger">*</span></label>

                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="tipo_atencion" id="atencion_victima"
                            value="victima" required
                            {{ old('tipo_atencion', $caso->tipo_atencion) == 'victima' ? 'checked' : '' }}>
                        <label class="form-check-label" for="atencion_victima">
                            🧍‍♀️ Apoyo a Víctima
                        </label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="tipo_atencion" id="atencion_pareja"
                            value="pareja" {{ old('tipo_atencion', $caso->tipo_atencion) == 'pareja' ? 'checked' : '' }}>
                        <label class="form-check-label" for="atencion_pareja">
                            💑 Apoyo a Pareja</label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="tipo_atencion" id="atencion_agresor"
                            value="agresor"
                            {{ old('tipo_atencion', $caso->tipo_atencion) == 'agresor' ? 'checked' : '' }}>
                        <label class="form-check-label" for="atencion_agresor">
                            ⚠️ Apoyo a Agresor
                        </label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="tipo_atencion" id="atencion_hijos"
                            value="hijos" {{ old('tipo_atencion', $caso->tipo_atencion) == 'hijos' ? 'checked' : '' }}>
                        <label class="form-check-label" for="atencion_hijos">
                            👶 Apoyo a Hijos
                        </label>
                    </div>

                    @error('tipo_atencion')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="violencia_medidas_tomas" class="form-label">Medidas a tomar:</label>
                    <input type="text" name="violencia_medidas_tomar" id="violencia_medidas_tomas"
                        class="form-control" placeholder="Medidas a tomar"
                        value="{{ old('violencia_medidas_tomar', $caso->violencia_medidas_tomar ?? '') }}">
                </div>


                <div class="mb-3">
                    <label for="violencia_institucion_denuncia" class="form-label">Nombre de la persona que llenó el
                        formulario</label>
                    <input type="text" name="formulario_responsable_nombre" id="violencia_institucion_denuncia"
                        class="form-control" placeholder="nombre completo"
                        value="{{ old('formulario_responsable_nombre', $caso->formulario_responsable_nombre) }}">
                </div>
            </div>
        </div>

        <!-- Botones de acción -->
        <div class="d-flex gap-3 mb-4">
            <button type="submit"
                style="background-color: #037E8C; color: white; border: none; border-radius: 5px; padding: 10px 15px;">
                <i class="fas fa-save me-1"></i> Actualizar caso
            </button>
            <a href="{{ route('casos.index', $caso->id) }}"
                style="background-color: #6c757d; color: white; border: none; border-radius: 5px; padding: 10px 15px; text-decoration: none; display: inline-block;">
                <i class="fas fa-times me-1"></i> Cancelar
            </a>
        </div>
    </form>
@endsection
