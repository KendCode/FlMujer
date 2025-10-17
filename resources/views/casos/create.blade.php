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

    <h2>Registrar Caso de Violencia</h2>
    @if (session('success'))
        <div class="alert alert-success mt-3">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger mt-3">
            {{ $errors->first() }}
        </div>
    @endif
    <form action="{{ route('casos.store') }}" method="POST">
        @csrf
        <!-- =====================
                                                                                 SECCIÓN 0: DATOS DE LA REGIONAL
                                                                            ===================== -->
        <div class="card mb-3">
            <div class="card-header">Regional</div>
            <div class="card-body">
                <div class="row g-2">
                    <div class="col-md-6">
                        <label class="form-label">Regional que recibe el caso:</label>
                        <input type="text" name="regional_recibe_caso" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Fecha</label>
                        <input type="date" name="regional_fecha" class="form-control">
                    </div>

                    <!-- ✅ NUEVO: Opción para elegir entre automático o manual -->
                    <div class="col-md-12 mt-3">
                        <label class="form-label d-block">Número de Registro</label>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="tipo_registro" id="registro_automatico"
                                value="automatico" checked onchange="toggleRegistroManual()">
                            <label class="form-check-label" for="registro_automatico">
                                Generar Automáticamente
                            </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="tipo_registro" id="registro_manual"
                                value="manual" onchange="toggleRegistroManual()">
                            <label class="form-check-label" for="registro_manual">
                                Ingresar Manualmente
                            </label>
                        </div>
                    </div>

                    <!-- Campo para ingreso manual (oculto por defecto) -->
                    <div class="col-md-6 mt-2" id="campo_registro_manual" style="display: none;">
                        <label class="form-label">Número de Registro Manual</label>
                        <input type="text" name="nro_registro_manual_input" id="nro_registro_manual_input"
                            class="form-control" placeholder="CT-48-25-P/T"
                            pattern="^[A-Z]{2,4}-\d{2}-\d{2}(-[A-Z0-9]+(/[A-Z0-9]+)?)?$"
                            title="Ejemplos válidos: CT-48-25-P/T, CT-07-25-7, CT-06-25-T, FLM-25000001">
                        <small class="form-text text-muted">
                            Formato válido: CT-48-25-P/T, CT-07-25-7, CT-06-25-T, FLM-25000001
                        </small>

                    </div>


                    <!-- Previsualización del número automático -->
                    <div class="col-md-6 mt-2" id="preview_automatico">
                        <label class="form-label">Próximo número automático:</label>
                        <input type="text" class="form-control" id="preview_numero"
                            value="{{ App\Models\Caso::generarNumeroRegistro() }}" readonly disabled>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Institución que deriva</label>
                        <input type="text" name="regional_institucion_derivante" class="form-control">
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
                        <input type="text" name="paciente_nombres" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Apellidos</label>
                        <input type="text" name="paciente_apellidos" class="form-control" required>
                    </div>
                    <div class="col-md-4 mt-2">
                        <label class="form-label d-block">Edad</label>
                        <div class="form-check form-check-inline">
                            <input type="text" name="paciente_edad" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-4 mt-2">
                        <label class="form-label">CI</label>
                        <input type="text" name="paciente_ci" class="form-control">
                    </div>
                    <div class="col-md-4 mt-2">
                        <label class="form-label d-block">Sexo</label>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="paciente_sexo" value="M" required>
                            <label class="form-check-label">Varón</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="paciente_sexo" value="F" required>
                            <label class="form-check-label">Mujer</label>
                        </div>
                    </div>
                    <div class="col-md-8 mt-2">
                        <label class="form-label">Edad (rango)</label>
                        <div class="d-flex flex-wrap gap-2">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="paciente_edad_rango"
                                    value="menor15" required>
                                <label class="form-check-label">Menor de 15 años</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="paciente_edad_rango" value="16a20"
                                    required>
                                <label class="form-check-label">16 a 20 años</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="paciente_edad_rango" value="21a25"
                                    required>
                                <label class="form-check-label">21 a 25 años</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="paciente_edad_rango" value="26a30"
                                    required>
                                <label class="form-check-label">26 a 30 años</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="paciente_edad_rango" value="31a35"
                                    required>
                                <label class="form-check-label">31 a 35 años</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="paciente_edad_rango" value="36a50"
                                    required>
                                <label class="form-check-label">36 a 50 años</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="paciente_edad_rango"
                                    value="mayor50" required>
                                <label class="form-check-label">Más de 50 años</label>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-8 mt-2">
                        <label class="form-label">Distrito</label><br>
                        <div class="d-flex flex-wrap gap-2">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="paciente_id_distrito"
                                    value="1" required>
                                <label class="form-check-label">Distrito 1</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="paciente_id_distrito"
                                    value="2" required>
                                <label class="form-check-label">Distrito 2</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="paciente_id_distrito"
                                    value="3" required>
                                <label class="form-check-label">Distrito 3</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="paciente_id_distrito"
                                    value="4" required>
                                <label class="form-check-label">Distrito 4</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="paciente_id_distrito"
                                    value="5" required>
                                <label class="form-check-label">Distrito 5</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="paciente_id_distrito"
                                    value="6" required>
                                <label class="form-check-label">Distrito 6</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="paciente_id_distrito"
                                    value="7" required>
                                <label class="form-check-label">Distrito 7</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="paciente_id_distrito"
                                    value="8" required>
                                <label class="form-check-label">Distrito 8</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="paciente_id_distrito"
                                    value="9" required>
                                <label class="form-check-label">Distrito 9</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="paciente_id_distrito"
                                    value="10" required>
                                <label class="form-check-label">Distrito 10</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="paciente_id_distrito"
                                    value="11" required>
                                <label class="form-check-label">Distrito 11</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="paciente_id_distrito"
                                    value="12" required>
                                <label class="form-check-label">Distrito 12</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="paciente_id_distrito"
                                    value="13" required>
                                <label class="form-check-label">Distrito 13</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="paciente_id_distrito"
                                    value="14" required>
                                <label class="form-check-label">Distrito 14</label>
                            </div>
                        </div>
                        <div class="mt-2">
                            <input type="text" name="paciente_otros" class="form-control" placeholder="Otros">
                        </div>
                        <div class="mt-2">
                            <input type="text" name="paciente_zona" class="form-control" placeholder="Zona / Barrio">
                        </div>
                        <div class="mt-2">
                            <input type="text" name="paciente_calle" class="form-control"
                                placeholder="Calle / Avenida">
                        </div>
                        <div class="mt-2">
                            <input type="text" name="paciente_numero" class="form-control" placeholder="Número">
                        </div>
                        <div class="mt-2">
                            <input type="text" name="paciente_telefono" class="form-control" placeholder="Teléfono">
                        </div>
                    </div>
                    <div class="col-md-4 mt-2">
                        <label class="form-label d-block">Lugar de Nacimiento</label>
                        <input type="text" name="paciente_lugar_nacimiento" class="form-control"
                            placeholder="Lugar de Nacimiento">
                        <div class="form-check form-check-inline mt-2">
                            <input class="form-check-input" type="radio" name="paciente_lugar_nacimiento_op"
                                value="dentro" required>
                            <label class="form-check-label">Dentro de municipio</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="paciente_lugar_nacimiento_op"
                                value="fuera" required>
                            <label class="form-check-label">Fuera de municipio</label>
                        </div>
                    </div>
                    <div class="col-md-4 mt-2">
                        <label class="form-label d-block">Residencia Habitual</label>
                        <div class="form-check form-check-inline mt-2">
                            <input class="form-check-input" type="radio" name="paciente_lugar_residencia_op"
                                value="dentro">
                            <label class="form-check-label">Dentro del municipio</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="paciente_lugar_residencia_op"
                                value="fuera">
                            <label class="form-check-label">Fuera de municipio</label>
                        </div>
                    </div>
                    <div class="col-md-4 mt-2">
                        <label class="form-label d-block">Tiempo de residencia en este municipio</label>
                        <div class="form-check form-check-inline mt-2">
                            <input class="form-check-input" type="radio" name="paciente_tiempo_residencia_op"
                                value="menosDeUnAno">
                            <label class="form-check-label">Menos de 1 año</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="paciente_tiempo_residencia_op"
                                value="de2a5Anos">
                            <label class="form-check-label">De 2 a 5 años</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="paciente_tiempo_residencia_op"
                                value="de6a10Anos">
                            <label class="form-check-label">De 6 a 10 años</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="paciente_tiempo_residencia_op"
                                value="masDe10Anos">
                            <label class="form-check-label">De 11 y más años</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="paciente_tiempo_residencia_op"
                                value="no_sabe_no_responde">
                            <label class="form-check-label">No sabe / no responde</label>
                        </div>
                    </div>
                </div>

                <div class="row g-2 mt-3">
                    <div class="col-md-6">
                        <label for="paciente_estado_civil" class="form-label">Estado Civil</label>
                        <select class="form-select" id="paciente_estado_civil" name="paciente_estado_civil" required>
                            <option value="">Seleccione...</option>
                            <option value="soltero">Soltero</option>
                            <option value="conviviente">Conviviente</option>
                            <option value="viudo">Viudo</option>
                            <option value="casado">Casado</option>
                            <option value="separado">Separado</option>
                            <option value="divorciado">Divorciado</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="paciente_nivel_instruccion" class="form-label">Nivel de Instrucción</label>
                        <select class="form-select" id="paciente_nivel_instruccion" name="paciente_nivel_instruccion"
                            required>
                            <option value="">Seleccione...</option>
                            <option value="ninguno">Ninguno</option>
                            <option value="primaria">Primaria</option>
                            <option value="secundaria">Secundaria</option>
                            <option value="tecnico">Técnico</option>
                            <option value="tecnicoSuperior">Técnico Superior</option>
                            <option value="licenciatura">Licenciatura</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="paciente_idioma_mas_hablado" class="form-label">Idioma más hablado</label>
                        <select class="form-select" id="paciente_idioma_mas_hablado" name="paciente_idioma_mas_hablado">
                            <option value="">Seleccione...</option>
                            <option value="castellano">Castellano</option>
                            <option value="aymara">Aymara</option>
                            <option value="quechua">Quechua</option>
                            <option value="guarani">Guaraní</option>
                            <option value="otroNativo">Otro nativo</option>
                            <option value="extranjero">Extranjero</option>
                        </select>
                    </div>
                    <div class="col-md-6 mt-2">
                        <label for="paciente_idioma_especificar" class="form-label">Especificar Otro Idioma</label>
                        <input type="text" name="paciente_idioma_especificar" class="form-control"
                            placeholder="Especificar si seleccionó 'Otro'">
                    </div>
                    <div class="col-md-6 mt-2">
                        <label for="paciente_ocupacion" class="form-label">Ocupación Principal</label>
                        <select class="form-select" id="paciente_ocupacion" name="paciente_ocupacion" required>
                            <option value="">Seleccione...</option>
                            <option value="obrero">Obrero</option>
                            <option value="empleada">Empleada</option>
                            <option value="trabajadorCuentaPropia">Trabajador por Cuenta Propia</option>
                            <option value="patrona">Patrona</option>
                            <option value="socioemprendedor">Socioemprendedor</option>
                            <option value="cooperativista">Cooperativista</option>
                            <option value="aprendizSinRemuneracion">Aprendiz sin Remuneración</option>
                            <option value="aprendizConRemuneracion">Aprendiz con Remuneración</option>
                            <option value="laboresCasa">Labores de Casa</option>
                            <option value="sinTrabajo">No tienen Trabajo</option>
                            <option value="otros">Otros</option>
                        </select>
                    </div>
                    <div class="col-md-6 mt-2">
                        <label for="paciente_situacion_ocupacional" class="form-label">Situación Ocupacional</label>
                        <select class="form-select" id="paciente_situacion_ocupacional"
                            name="paciente_situacion_ocupacional" required>
                            <option value="">Seleccione...</option>
                            <option value="permanente">Permanente</option>
                            <option value="temporal">Temporal</option>
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
                        <input type="text" name="pareja_nombres" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Apellidos</label>
                        <input type="text" name="pareja_apellidos" class="form-control" required>
                    </div>
                    <div class="col-md-4 mt-2">
                        <label class="form-label d-block">Sexo</label>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="pareja_sexo" value="M" required>
                            <label class="form-check-label">Varón</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="pareja_sexo" value="F" required>
                            <label class="form-check-label">Mujer</label>
                        </div>
                    </div>
                    <div class="col-md-4 mt-2">
                        <label class="form-label d-block">Edad</label>
                        <div class="form-check form-check-inline">
                            <input type="text" name="pareja_edad" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-4 mt-2">
                        <label class="form-label">CI</label>
                        <input type="text" name="pareja_ci" class="form-control">
                    </div>
                    <div class="col-md-8 mt-2">
                        <label class="form-label">Edad (rango)</label>
                        <div class="d-flex gap-2 flex-wrap">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="pareja_edad_rango" value="menor_15"
                                    id="pareja_edad_menor_15" required>
                                <label class="form-check-label" for="pareja_edad_menor_15">Menor de 15 años</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="pareja_edad_rango" value="16_a_20"
                                    id="pareja_edad_16_a_20" required>
                                <label class="form-check-label" for="pareja_edad_16_a_20">16 a 20</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="pareja_edad_rango" value="21_25"
                                    id="pareja_edad_21_25" required>
                                <label class="form-check-label" for="pareja_edad_21_25">21 a 25</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="pareja_edad_rango" value="26_a_30"
                                    id="pareja_edad_26_a_30" required>
                                <label class="form-check-label" for="pareja_edad_26_a_30">26 a 30</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="pareja_edad_rango" value="31_a_35"
                                    id="pareja_edad_31_a_35" required>
                                <label class="form-check-label" for="pareja_edad_31_a_35">31 a 35</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="pareja_edad_rango" value="36_a_40"
                                    id="pareja_edad_36_a_40" required>
                                <label class="form-check-label" for="pareja_edad_36_a_40">36 a 40</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="pareja_edad_rango" value="41_a_45"
                                    id="pareja_edad_41_a_45" required>
                                <label class="form-check-label" for="pareja_edad_41_a_45">41 a 45</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="pareja_edad_rango" value="46_a_50"
                                    id="pareja_edad_46_a_50" required>
                                <label class="form-check-label" for="pareja_edad_46_a_50">46 a 50</label>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-8 mt-2">
                        <label class="form-label">Distrito</label><br>
                        <div class="d-flex flex-wrap gap-2">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="pareja_id_distrito" value="1"
                                    required>
                                <label class="form-check-label">Distrito 1</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="pareja_id_distrito" value="2"
                                    required>
                                <label class="form-check-label">Distrito 2</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="pareja_id_distrito" value="3"
                                    required>
                                <label class="form-check-label">Distrito 3</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="pareja_id_distrito" value="4"
                                    required>
                                <label class="form-check-label">Distrito 4</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="pareja_id_distrito" value="5"
                                    required>
                                <label class="form-check-label">Distrito 5</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="pareja_id_distrito" value="6"
                                    required>
                                <label class="form-check-label">Distrito 6</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="pareja_id_distrito" value="7"
                                    required>
                                <label class="form-check-label">Distrito 7</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="pareja_id_distrito" value="8"
                                    required>
                                <label class="form-check-label">Distrito 8</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="pareja_id_distrito" value="9"
                                    required>
                                <label class="form-check-label">Distrito 9</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="pareja_id_distrito" value="10"
                                    required>
                                <label class="form-check-label">Distrito 10</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="pareja_id_distrito" value="11"
                                    required>
                                <label class="form-check-label">Distrito 11</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="pareja_id_distrito" value="12"
                                    required>
                                <label class="form-check-label">Distrito 12</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="pareja_id_distrito" value="13"
                                    required>
                                <label class="form-check-label">Distrito 13</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="pareja_id_distrito" value="14"
                                    required>
                                <label class="form-check-label">Distrito 14</label>
                            </div>
                        </div>
                        <div class="mt-2">
                            <input type="text" name="pareja_otros" class="form-control" placeholder="Otros">
                        </div>
                        <div class="mt-2">
                            <input type="text" name="pareja_zona" class="form-control" placeholder="Zona / Barrio">
                        </div>
                        <div class="mt-2">
                            <input type="text" name="pareja_calle" class="form-control"
                                placeholder="Calle / Avenida">
                        </div>
                        <div class="mt-2">
                            <input type="text" name="pareja_numero" class="form-control" placeholder="Número">
                        </div>
                        <div class="mt-2">
                            <input type="text" name="pareja_telefono" class="form-control" placeholder="Teléfono">
                        </div>
                    </div>

                    <div class="col-md-4 mt-2">
                        <label class="form-label d-block">Lugar de Nacimiento</label>
                        <input type="text" name="pareja_lugar_nacimiento" class="form-control"
                            placeholder="Lugar de Nacimiento">
                        <div class="form-check form-check-inline mt-2">
                            <input class="form-check-input" type="radio" name="pareja_lugar_nacimiento_op"
                                value="dentro" required>
                            <label class="form-check-label">Dentro de municipio</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="pareja_lugar_nacimiento_op"
                                value="fuera" required>
                            <label class="form-check-label">Fuera de municipio</label>
                        </div>
                    </div>
                </div>

                <div class="row g-2 mt-3">
                    <div class="col-md-4 mt-2">
                        <label class="form-label d-block">Residencia Habitual</label>
                        <div class="form-check form-check-inline mt-2">
                            <input class="form-check-input" type="radio" name="pareja_lugar_residencia_op"
                                value="dentro">
                            <label class="form-check-label">Dentro del municipio</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="pareja_lugar_residencia_op"
                                value="fuera">
                            <label class="form-check-label">Fuera de municipio</label>
                        </div>
                    </div>
                    <div class="col-md-4 mt-2">
                        <label class="form-label d-block">Tiempo de residencia en este municipio</label>
                        <div class="form-check form-check-inline mt-2">
                            <input class="form-check-input" type="radio" name="pareja_tiempo_residencia_op"
                                value="menosDeUnAno">
                            <label class="form-check-label">Menos de 1 año</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="pareja_tiempo_residencia_op"
                                value="de2a5Anos">
                            <label class="form-check-label">De 2 a 5 años</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="pareja_tiempo_residencia_op"
                                value="de6a10Anos">
                            <label class="form-check-label">De 6 a 10 años</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="pareja_tiempo_residencia_op"
                                value="masDe10Anos">
                            <label class="form-check-label">De 11 y más años</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="pareja_tiempo_residencia_op"
                                value="no_sabe_no_responde">
                            <label class="form-check-label">No sabe / no responde</label>
                        </div>
                    </div>

                    <div class="col-md-6 mt-2">
                        <label for="pareja_estado_civil" class="form-label">3.9 Estado Civil</label>
                        <select class="form-select" id="pareja_estado_civil" name="pareja_estado_civil" required>
                            <option value="">Seleccione</option>
                            <option value="soltero">Soltero</option>
                            <option value="conviviente">Conviviente</option>
                            <option value="separado">Separado</option>
                            <option value="viudo">Viudo</option>
                            <option value="divorciado">Divorciado</option>
                        </select>
                    </div>

                    <div class="col-md-6 mt-2">
                        <label for="pareja_nivel_instruccion" class="form-label">3.10 Nivel de Instrucción</label>
                        <select class="form-select" id="pareja_nivel_instruccion" name="pareja_nivel_instruccion"
                            required>
                            <option value="">Seleccione</option>
                            <option value="ninguno">Ninguno</option>
                            <option value="primaria">Primaria</option>
                            <option value="tecnico">Técnico</option>
                            <option value="tecnico_superior">Técnico Superior</option>
                            <option value="lee_y_escribe">Lee y Escribe</option>
                            <option value="secundaria">Secundaria</option>
                            <option value="tecnico_medio">Técnico Medio</option>
                            <option value="licenciatura">Licenciatura</option>
                        </select>
                    </div>

                    <div class="col-md-6 mt-2">
                        <label for="pareja_idioma" class="form-label">3.11 Idioma Más Hablado</label>
                        <select class="form-select" id="pareja_idioma" name="pareja_idioma" required>
                            <option value="">Seleccione</option>
                            <option value="castellano">Castellano</option>
                            <option value="aymara">Aymara</option>
                            <option value="quechua">Quechua</option>
                            <option value="guarani">Guaraní</option>
                            <option value="extranjero">Extranjero</option>
                            <option value="otro">Otro</option>
                        </select>
                    </div>
                    <div class="col-md-6 mt-2">
                        <label for="pareja_especificar_idioma" class="form-label">Especificar Otro Idioma</label>
                        <input type="text" class="form-control" id="pareja_especificar_idioma"
                            name="pareja_especificar_idioma" placeholder="Especifique si seleccionó 'Otro'">
                    </div>

                    <div class="col-md-6 mt-2">
                        <label for="pareja_ocupacion_principal" class="form-label">3.12 Ocupación Principal</label>
                        <select class="form-select" id="pareja_ocupacion_principal" name="pareja_ocupacion_principal"
                            required>
                            <option value="">Seleccione</option>
                            <option value="obrero">Obrero</option>
                            <option value="empleado">Empleado</option>
                            <option value="trabajador_autonomo">Trabajador por cuenta propia</option>
                            <option value="patrona">Patrona</option>
                            <option value="socio_empleador">Socio de empleador</option>
                            <option value="cooperativista">Cooperativista de producción familiar</option>
                            <option value="aprendiz_sin_remuneracion">Aprendiz sin remuneración</option>
                            <option value="aprendiz_con_remuneracion">Aprendiz con remuneración</option>
                            <option value="labores_casa">Labores de casa</option>
                            <option value="trabajadora_hogar">Trabajadora del hogar</option>
                            <option value="no_trabajo">No tiene trabajo</option>
                            <option value="otros">Otros</option>
                        </select>
                    </div>

                    <div class="col-md-6 mt-2">
                        <label for="pareja_situacion_ocupacional" class="form-label">3.13 Situación Ocupacional</label>
                        <select class="form-select" id="pareja_situacion_ocupacional" name="pareja_situacion_ocupacional"
                            required>
                            <option value="">Seleccione</option>
                            <option value="permanente">Permanente</option>
                            <option value="temporal">Temporal</option>
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
                            <option value="conyuge">Cónyuge</option>
                            <option value="conviviente">Conviviente</option>
                            <option value="ex_conyuge">Ex cónyuge</option>
                            <option value="ex_conviviente">Ex conviviente</option>
                            <option value="enamorado">Enamorado</option>
                            <option value="ex_enamorado">Ex enamorado</option>
                            <option value="otros">Otros familiares</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="pareja_anos_convivencia" class="form-label">4.2 Años de Matrimonio o
                            Convivencia</label>
                        <select class="form-select" id="pareja_anos_convivencia" name="pareja_anos_convivencia" required>
                            <option value="">Seleccione</option>
                            <option value="menos_de_un_ano">Menos de un año</option>
                            <option value="1_a_5_anios">De 1 a 5 años</option>
                            <option value="6_a_10_anios">De 6 a 10 años</option>
                            <option value="11_a_15_anios">De 11 a 15 años</option>
                            <option value="16_a_20_anios">De 16 a 20 años</option>
                            <option value="21_a_25_anios">De 21 a 25 años</option>
                            <option value="26_a_30_anios">De 26 a 30 años</option>
                            <option value="31_a_mas">De 31 años o más</option>
                            <option value="no_conviviera">No conviviera</option>
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
                <div class="mb-3">
                    <label for="hijos_num_gestacion" class="form-label">Número de hijos en gestación</label>
                    <select name="hijos_num_gestacion" id="hijos_num_gestacion" class="form-select">
                        <option value="">--Seleccione--</option>
                        <option value="en_gestacion">En gestación</option>
                        <option value="solo_uno">Solo uno</option>
                        <option value="2_a_3">2 a 3</option>
                        <option value="4_a_5">4 a 5</option>
                        <option value="6_a_7">6 a 7</option>
                        <option value="8_mas">8 a más</option>
                        <option value="no_tiene_hijos">No tiene hijos</option>
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

                                <!-- Masculino -->
                                <td>
                                    <div class="d-flex gap-2 justify-content-center">
                                        @for ($i = 0; $i < 5; $i++)
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    name="hijos_edad_menor4_masculino"
                                                    id="hijos_edad_menor4_masculino_{{ $i }}" value="M">
                                            </div>
                                        @endfor
                                    </div>
                                </td>

                                <!-- Femenino -->
                                <td>
                                    <div class="d-flex gap-2 justify-content-center">
                                        @for ($i = 0; $i < 5; $i++)
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    name="hijos_edad_menor4_femenino"
                                                    id="hijos_edad_menor4_femenino_{{ $i }}" value="F">
                                            </div>
                                        @endfor
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td>De 5 a 10 años</td>
                                <td>
                                    <div class="d-flex gap-2 justify-content-center">
                                        @for ($i = 0; $i < 5; $i++)
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    name="hijos_edad_5_10_masculino"
                                                    id="hijos_edad_5_10_masculino_{{ $i }}" value="M">
                                            </div>
                                        @endfor
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex gap-2 justify-content-center">
                                        @for ($i = 0; $i < 5; $i++)
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    name="hijos_edad_5_10_femenino"
                                                    id="hijos_edad_5_10_femenino_{{ $i }}" value="F">
                                            </div>
                                        @endfor
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td>De 11 a 15 años</td>
                                <td>
                                    <div class="d-flex gap-2 justify-content-center">
                                        @for ($i = 0; $i < 5; $i++)
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    name="hijos_edad_11_15_masculino"
                                                    id="hijos_edad_11_15_masculino_{{ $i }}" value="M">
                                            </div>
                                        @endfor
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex gap-2 justify-content-center">
                                        @for ($i = 0; $i < 5; $i++)
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    name="hijos_edad_11_15_femenino"
                                                    id="hijos_edad_11_15_femenino_{{ $i }}" value="F">
                                            </div>
                                        @endfor
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td>De 16 a 20 años</td>
                                <td>
                                    <div class="d-flex gap-2 justify-content-center">
                                        @for ($i = 0; $i < 5; $i++)
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    name="hijos_edad_16_20_masculino"
                                                    id="hijos_edad_16_20_masculino_{{ $i }}" value="M">
                                            </div>
                                        @endfor
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex gap-2 justify-content-center">
                                        @for ($i = 0; $i < 5; $i++)
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    name="hijos_edad_16_20_femenino"
                                                    id="hijos_edad_16_20_femenino_{{ $i }}" value="F">
                                            </div>
                                        @endfor
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td>De 21 a más años</td>
                                <td>
                                    <div class="d-flex gap-2 justify-content-center">
                                        @for ($i = 0; $i < 5; $i++)
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    name="hijos_edad_21_mas_masculino"
                                                    id="hijos_edad_21_mas_masculino_{{ $i }}" value="M">
                                            </div>
                                        @endfor
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex gap-2 justify-content-center">
                                        @for ($i = 0; $i < 5; $i++)
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    name="hijos_edad_21_mas_femenino"
                                                    id="hijos_edad_21_mas_femenino_{{ $i }}" value="F">
                                            </div>
                                        @endfor
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
                        <option value="dependiente_menor_18">Dependiente menor de 18 años</option>
                        <option value="dependiente_mayor_18">Dependiente mayor de 18 años</option>
                        <option value="no_dependiente_menor_18">No dependiente menor de 18 años</option>
                        <option value="no_dependiente_mayor_18">No dependiente mayor de 18 años</option>
                        <option value="no_tiene_hijos">No tiene hijos</option>
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
                            id="violencia_tipo_fisica" value="1">
                        <label class="form-check-label" for="violencia_tipo_fisica">
                            Violencia Física
                        </label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="violencia_tipo_psicologica"
                            id="violencia_tipo_psicologica" value="1">
                        <label class="form-check-label" for="violencia_tipo_psicologica">
                            Violencia Psicológica
                        </label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="violencia_tipo_sexual"
                            id="violencia_tipo_sexual" value="1">
                        <label class="form-check-label" for="violencia_tipo_sexual">
                            Violencia Sexual
                        </label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="violencia_tipo_economica"
                            id="violencia_tipo_economica" value="1">
                        <label class="form-check-label" for="violencia_tipo_economica">
                            Violencia Económica
                        </label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="violencia_tipo_patrimonial"
                            id="violencia_tipo_patrimonial" value="1">
                        <label class="form-check-label" for="violencia_tipo_patrimonial">
                            Violencia Patrimonial
                        </label>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="violencia_frecuencia" class="form-label">Tipo de Violencia</label>
                    <select name="violencia_tipo" id="violencia_frecuencia" class="form-select" required>
                        <option value="">--Seleccione--</option>
                        <option value="violencia_intrafamiliar">Violencia Intrafamiliar</option>
                        <option value="violencia_domestica">Violencia Domestica</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="violencia_tiempo_ocurrencia" class="form-label">Frecuancia de agresión</label>
                    <select name="violencia_frecuancia_agresion" id="violencia_tiempo_ocurrencia" class="form-select"
                        required>
                        <option value="">--Seleccione--</option>
                        <option value="primera_vez">Primera Vez</option>
                        <option value="alguna_vez">Alguna Vez</option>
                        <option value="ocacionalmente">Ocacionalmente</option>
                        <option value="con_frecuencia">Con Frecuencia</option>
                        <option value="siempre">Siempre</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">¿Ha denunciado anteriormente?</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="violencia_denuncia_previa"
                            id="violencia_denuncia_previa_si" value="si" required>
                        <label class="form-check-label" for="violencia_denuncia_previa_si">
                            Sí
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="violencia_denuncia_previa"
                            id="violencia_denuncia_previa_no" value="no" required>
                        <label class="form-check-label" for="violencia_denuncia_previa_no">
                            No
                        </label>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Razones por las que no hizo la denuncia</label>

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="violencia_no_denuncia_por_amenaza"
                            id="violencia_tipo_fisica" value="1">
                        <label class="form-check-label" for="violencia_tipo_fisica">
                            Por Amenaza
                        </label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="violencia_no_denuncia_por_temor"
                            id="violencia_tipo_psicologica" value="1">
                        <label class="form-check-label" for="violencia_tipo_psicologica">
                            Por Temor
                        </label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="violencia_no_denuncia_por_verguenza"
                            id="violencia_tipo_sexual" value="1">
                        <label class="form-check-label" for="violencia_tipo_sexual">
                            Por Vergüenza
                        </label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox"
                            name="violencia_no_denuncia_por_desconocimiento" id="violencia_tipo_economica"
                            value="1">
                        <label class="form-check-label" for="violencia_tipo_economica">
                            Por Desconocimiento
                        </label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox"
                            name="violencia_no_denuncia_no_sabe_no_responde" id="violencia_tipo_patrimonial"
                            value="1">
                        <label class="form-check-label" for="violencia_tipo_patrimonial">
                            No sabe / no responde
                        </label>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="violencia_lugar_hechos" class="form-label">Motivo de la Agresión</label>
                    <select name="violencia_motivo_agresion" id="violencia_lugar_hechos" class="form-select" required>
                        <option value="">--Seleccione--</option>
                        <option value="ebriedad">Ebriedad</option>
                        <option value="infidelidad">Infidelidad</option>
                        <option value="economico">Económico</option>
                        <option value="celos">Celos</option>
                        <option value="cultural">Cultural</option>
                        <option value="adiccion">Adicción</option>
                        <option value="intromision_familiar">Intromisión Familiar</option>
                        <option value="otro">Otro</option>
                    </select>
                </div>
                <div class="md-6 mt-2">
                    <label for="pareja_especificar_idioma" class="form-label">Otros:</label>
                    <input type="text" class="form-control" id="pareja_especificar_idioma"
                        name="violencia_motivo_otros" placeholder="Especifique si seleccionó 'Otro'">
                </div>

                <div class="mb-3 mt-3">
                    <label for="violencia_descripcion_hechos" class="form-label">Denuncias o proceso realizados
                        (Problemática)</label>
                    <textarea name="violencia_descripcion_hechos" id="violencia_descripcion_hechos" class="form-control"
                        rows="4" placeholder="Describa problemática."></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Atención que demanda <span class="text-danger">*</span></label>

                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="tipo_atencion" id="atencion_victima"
                            value="victima" {{ old('tipo_atencion') == 'victima' ? 'checked' : '' }} required>
                        <label class="form-check-label" for="atencion_victima">
                            🧍‍♀️ Apoyo a Víctima
                        </label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="tipo_atencion" id="atencion_pareja"
                            value="pareja" {{ old('tipo_atencion') == 'pareja' ? 'checked' : '' }}>
                        <label class="form-check-label" for="atencion_pareja">
                            💑 Apoyo a Pareja
                        </label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="tipo_atencion" id="atencion_agresor"
                            value="agresor" {{ old('tipo_atencion') == 'agresor' ? 'checked' : '' }}>
                        <label class="form-check-label" for="atencion_agresor">
                            ⚠️ Apoyo a Agresor
                        </label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="tipo_atencion" id="atencion_hijos"
                            value="hijos" {{ old('tipo_atencion') == 'hijos' ? 'checked' : '' }}>
                        <label class="form-check-label" for="atencion_hijos">
                            👶 Apoyo a Hijos
                        </label>
                    </div>

                    @error('tipo_atencion')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>


                <div class="mb-3">
                    <label for="violencia_institucion_denuncia" class="form-label">Medidas a tomar:</label>
                    <input type="text" name="violencia_medidas_tomas" id="violencia_institucion_denuncia"
                        class="form-control" placeholder="medidas a tomar">
                </div>
                <div class="mb-3">
                    <label for="violencia_institucion_derivar" class="form-label">Institución a derivar:</label>
                    <input type="text" name="violencia_institucion_derivar" id="violencia_institucion_derivar"
                        class="form-control" placeholder="institucion a derivar">
                </div>
                <div class="mb-3">
                    <label for="violencia_institucion_denuncia" class="form-label">Nombre de la persona que lleno el
                        formulario</label>
                    <input type="text" name="formulario_responsable_nombre" id="violencia_institucion_denuncia"
                        class="form-control" placeholder="nombre completo">
                </div>
            </div>
        </div>

        <button class="btn btn-primary" type="submit">Registrar caso</button>
    </form>

    <!-- JavaScript para toggle del registro -->
    <script>
        function toggleRegistroManual() {
            const campoManual = document.getElementById('campo_registro_manual');
            const previewAutomatico = document.getElementById('preview_automatico');
            const registroManual = document.getElementById('registro_manual').checked;

            campoManual.style.display = registroManual ? 'block' : 'none';
            previewAutomatico.style.display = registroManual ? 'none' : 'block';
        }
    </script>
@endsection
