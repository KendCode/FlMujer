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

    <form action="{{ route('casos.store') }}" method="POST">
        @csrf

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
                                <input class="form-check-input" type="radio" name="paciente_edad_rango" value="menor15"
                                    required>
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
                                <input class="form-check-input" type="radio" name="paciente_edad_rango" value="mayor50"
                                    required>
                                <label class="form-check-label">Más de 50 años</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mt-2">
                        <label class="form-label">CI</label>
                        <input type="text" name="paciente_ci" class="form-control">
                    </div>
                    <div class="col-md-8 mt-2">
                        <label class="form-label">Distrito</label><br>
                        <div class="d-flex flex-wrap gap-2">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="paciente_id_distrito" value="1"
                                    required>
                                <label class="form-check-label">Distrito 1</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="paciente_id_distrito" value="2"
                                    required>
                                <label class="form-check-label">Distrito 2</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="paciente_id_distrito" value="3"
                                    required>
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

                    <div class="col-md-4 mt-2">
                        <label class="form-label">CI</label>
                        <input type="text" name="pareja_ci" class="form-control">
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
                    <div class="col-md-6">
                        <label for="pareja_residencia" class="form-label">3.7 Residencia Habitual</label>
                        <select class="form-select" id="pareja_residencia" name="pareja_residencia" required>
                            <option value="">Seleccione</option>
                            <option value="dentro">Dentro de municipio</option>
                            <option value="fuera">Fuera de municipio</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="pareja_tiempo_residencia" class="form-label">3.8 Tiempo de Residencia</label>
                        <select class="form-select" id="pareja_tiempo_residencia" name="pareja_tiempo_residencia"
                            required>
                            <option value="">Seleccione</option>
                            <option value="menos_de_un_ano">Menos de un año</option>
                            <option value="2_a_5_anios">2 a 5 años</option>
                            <option value="6_a_10_anios">6 a 10 años</option>
                            <option value="11_y_mas">11 y más años</option>
                            <option value="otro">Otro</option>
                            <option value="no_saben">No saben</option>
                            <option value="no_responde">No responde</option>
                        </select>
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
                            <option value="mara">Mara</option>
                            <option value="quechua">Quechua</option>
                            <option value="guarani">Guaraní</option>
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
                        <option value="solo_uno">Solo uno</option>
                        <option value="2_a_3">2 a 3</option>
                        <option value="4_a_5">4 a 5</option>
                        <option value="6_a_7">6 a 7</option>
                        <option value="8_mas">8 a más</option>
                        <option value="no_tiene_hijos">No tiene hijos</option>
                        <option value="otra_opcion">Otra opción</option>
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
                                <td>&lt;4</td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox"
                                            name="hijos_edad_menor4_masculino" id="hijos_edad_menor4_masculino"
                                            value="M">
                                        <label class="form-check-label" for="hijos_edad_menor4_masculino"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="hijos_edad_menor4_femenino"
                                            id="hijos_edad_menor4_femenino" value="F">
                                        <label class="form-check-label" for="hijos_edad_menor4_femenino"></label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>5-10</td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="hijos_edad_5_10_masculino"
                                            id="hijos_edad_5_10_masculino" value="M">
                                        <label class="form-check-label" for="hijos_edad_5_10_masculino"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="hijos_edad_5_10_femenino"
                                            id="hijos_edad_5_10_femenino" value="F">
                                        <label class="form-check-label" for="hijos_edad_5_10_femenino"></label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>11-15</td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="hijos_edad_11_15_masculino"
                                            id="hijos_edad_11_15_masculino" value="M">
                                        <label class="form-check-label" for="hijos_edad_11_15_masculino"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="hijos_edad_11_15_femenino"
                                            id="hijos_edad_11_15_femenino" value="F">
                                        <label class="form-check-label" for="hijos_edad_11_15_femenino"></label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>16-20</td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="hijos_edad_16_20_masculino"
                                            id="hijos_edad_16_20_masculino" value="M">
                                        <label class="form-check-label" for="hijos_edad_16_20_masculino"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="hijos_edad_16_20_femenino"
                                            id="hijos_edad_16_20_femenino" value="F">
                                        <label class="form-check-label" for="hijos_edad_16_20_femenino"></label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>21+</td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox"
                                            name="hijos_edad_21_mas_masculino" id="hijos_edad_21_mas_masculino"
                                            value="M">
                                        <label class="form-check-label" for="hijos_edad_21_mas_masculino"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="hijos_edad_21_mas_femenino"
                                            id="hijos_edad_21_mas_femenino" value="F">
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
                    <label for="violencia_frecuencia" class="form-label">Frecuencia de la Violencia</label>
                    <select name="violencia_frecuencia" id="violencia_frecuencia" class="form-select" required>
                        <option value="">--Seleccione--</option>
                        <option value="primera_vez">Primera vez</option>
                        <option value="ocasional">Ocasional</option>
                        <option value="frecuente">Frecuente</option>
                        <option value="permanente">Permanente</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="violencia_tiempo_ocurrencia" class="form-label">Tiempo de Ocurrencia</label>
                    <select name="violencia_tiempo_ocurrencia" id="violencia_tiempo_ocurrencia" class="form-select"
                        required>
                        <option value="">--Seleccione--</option>
                        <option value="menos_1_mes">Menos de 1 mes</option>
                        <option value="1_a_3_meses">1 a 3 meses</option>
                        <option value="4_a_6_meses">4 a 6 meses</option>
                        <option value="7_a_12_meses">7 a 12 meses</option>
                        <option value="mas_1_ano">Más de 1 año</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="violencia_lugar_hechos" class="form-label">Lugar de los Hechos</label>
                    <select name="violencia_lugar_hechos" id="violencia_lugar_hechos" class="form-select" required>
                        <option value="">--Seleccione--</option>
                        <option value="domicilio">Domicilio</option>
                        <option value="via_publica">Vía pública</option>
                        <option value="trabajo">Trabajo</option>
                        <option value="centro_estudios">Centro de estudios</option>
                        <option value="otro">Otro</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="violencia_descripcion_hechos" class="form-label">Descripción de los Hechos</label>
                    <textarea name="violencia_descripcion_hechos" id="violencia_descripcion_hechos" class="form-control" rows="4"
                        placeholder="Describa brevemente lo ocurrido..."></textarea>
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
                    <label for="violencia_institucion_denuncia" class="form-label">Institución donde realizó la denuncia
                        (si corresponde)</label>
                    <input type="text" name="violencia_institucion_denuncia" id="violencia_institucion_denuncia"
                        class="form-control" placeholder="Nombre de la institución">
                </div>
            </div>
        </div>

        <button class="btn btn-primary" type="submit">Registrar caso</button>
    </form>
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
@endsection
