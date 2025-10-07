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

        <!-- --- Sección 1: Datos personales --- -->
        <div class="card mb-3">
            <div class="card-header">Datos Personales y Más Datos</div>
            <div class="card-body">
                <div class="row g-2">
                    <div class="col-md-6">
                        <label class="form-label">Nombres</label>
                        <input type="text" name="nombres" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Apellidos</label>
                        <input type="text" name="apellidos" class="form-control" required>
                    </div>
                    <div class="col-md-4 mt-2">
                        <label class="form-label d-block">Sexo</label>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="sexo" value="M" required>
                            <label class="form-check-label">Varón</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="sexo" value="F" required>
                            <label class="form-check-label">Mujer</label>
                        </div>
                    </div>
                    <div class="col-md-8 mt-2">
                        <label>Edad (rango)</label>
                        <div class="d-flex flex-wrap gap-2">
                            @foreach (['menor15' => 'Menor de 15 años', '16a20' => '16 a 20 años', '21a25' => '21 a 25 años', '26a30' => '26 a 30 años', '31a35' => '31 a 35 años', '36a50' => '36 a 50 años', 'mayor50' => 'Más de 50 años'] as $value => $label)
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="edad_rango"
                                        value="{{ $value }}" required>
                                    <label class="form-check-label">{{ $label }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-md-4 mt-2">
                        <label>CI</label>
                        <input type="text" name="ci" class="form-control">
                    </div>
                    <div class="col-md-8 mt-2">
                        <label>Distrito</label><br>
                        @for ($i = 1; $i <= 14; $i++)
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="id_distrito"
                                    value="{{ $i }}" required>
                                <label class="form-check-label">Distrito {{ $i }}</label>
                            </div>
                        @endfor
                        <div class="mt-2">
                            <input type="text" name="otros" class="form-control" placeholder="Otros">
                        </div>
                        <div class="mt-2">
                            <input type="text" name="zona" class="form-control" placeholder="Zona / Barrio">
                        </div>
                        <div class="mt-2">
                            <input type="text" name="calle" class="form-control" placeholder="Calle / Avenida">
                        </div>
                        <div class="mt-2">
                            <input type="text" name="numero" class="form-control" placeholder="Número">
                        </div>
                        <div class="mt-2">
                            <input type="text" name="telefono" class="form-control" placeholder="Teléfono">
                        </div>
                    </div>
                    <div class="col-md-4 mt-2">
                        <label class="form-label d-block">Lugar de Nacimiento</label>
                        <input type="text" name="lugar_nacimiento" class="form-control"
                            placeholder="Lugar de Nacimiento">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="lugar_nacimiento_op" value="dentro"
                                required>
                            <label class="form-check-label">Dentro de municipio</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="lugar_nacimiento_op" value="fuera"
                                required>
                            <label class="form-check-label">Fuera de municipio</label>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="estadoCivil" class="form-label">Estado Civil</label>
                    <select class="form-select" id="estadoCivil" required>
                        <option value="">Seleccione...</option>
                        <option value="soltero">Soltero</option>
                        <option value="conviviente">Conviviente</option>
                        <option value="viudo">Viudo</option>
                        <option value="casado">Casado</option>
                        <option value="separado">Separado</option>
                        <option value="divorciado">Divorciado</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="nivelInstruccion" class="form-label">Nivel de Instrucción</label>
                    <select class="form-select" id="nivelInstruccion" required>
                        <option value="">Seleccione...</option>
                        <option value="ninguno">Ninguno</option>
                        <option value="primaria">Primaria</option>
                        <option value="secundaria">Secundaria</option>
                        <option value="tecnico">Técnico</option>
                        <option value="tecnicoSuperior">Técnico Superior</option>
                        <option value="licenciatura">Licenciatura</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="ocupacion" class="form-label">Ocupación Principal</label>
                    <select class="form-select" id="ocupacion" required>
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
                <div class="mb-3">
                    <label for="situacionOcupacional" class="form-label">Situación Ocupacional</label>
                    <select class="form-select" id="situacionOcupacional" required>
                        <option value="">Seleccione...</option>
                        <option value="permanente">Permanente</option>
                        <option value="temporal">Temporal</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- --- Sección 2: Datos de la pareja --- -->
        <div class="card mb-3">
            <div class="card-header">2. Datos de la pareja</div>
            <div class="card-body">
                <div class="row g-2">
                    <div class="col-md-6">
                        <label>Nombres</label>
                        <input type="text" name="pareja_nombres" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label>Apellidos</label>
                        <input type="text" name="pareja_apellidos" class="form-control" required>
                    </div>
                    <div class="col-md-4 mt-2">
                        <label>Sexo</label>
                        <div>
                            <input type="radio" name="pareja_sexo" value="M" class="form-check-input"> Varón
                            <input type="radio" name="pareja_sexo" value="F" class="form-check-input ms-3"> Mujer
                        </div>
                    </div>
                    <div class="col-md-8 mt-2">
                        <label>Edad (rango)</label>
                        <div class="d-flex gap-2 flex-wrap">
                            @foreach (['menor_15' => 'Menor de 15 años', '16_a_20' => '16 a 20', '21_25' => '21 a 25', '26_a_30' => '26 a 30', '31_a_35' => '31 a 35', '36_a_40' => '36 a 40', '41_a_45' => '41 a 45', '46_a_50' => '46 a 50'] as $value => $label)
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="pareja_edad_rango"
                                        value="{{ $value }}" id="edad_{{ $value }}">
                                    <label class="form-check-label"
                                        for="edad_{{ $value }}">{{ $label }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>


                    <div class="col-md-8 mt-2">
                        <label>Distrito</label><br>
                        @for ($i = 1; $i <= 14; $i++)
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="id_distrito"
                                    value="{{ $i }}" required>
                                <label class="form-check-label">Distrito {{ $i }}</label>
                            </div>
                        @endfor
                        <div class="mt-2">
                            <input type="text" name="otros" class="form-control" placeholder="Otros">
                        </div>
                        <div class="mt-2">
                            <input type="text" name="zona" class="form-control" placeholder="Zona / Barrio">
                        </div>
                        <div class="mt-2">
                            <input type="text" name="calle" class="form-control" placeholder="Calle / Avenida">
                        </div>
                        <div class="mt-2">
                            <input type="text" name="numero" class="form-control" placeholder="Número">
                        </div>
                        <div class="mt-2">
                            <input type="text" name="telefono" class="form-control" placeholder="Teléfono">
                        </div>
                    </div>

                    <div class="col-md-4 mt-2">
                        <label class="form-label d-block">Lugar de Nacimiento</label>
                        <input type="text" name="lugar_nacimiento" class="form-control"
                            placeholder="Lugar de Nacimiento">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="lugar_nacimiento_op" value="dentro"
                                required>
                            <label class="form-check-label">Dentro de municipio</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="lugar_nacimiento_op" value="fuera"
                                required>
                            <label class="form-check-label">Fuera de municipio</label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">3.7 Residencia Habitual</label>
                        <select class="form-select" id="residencia" required>
                            <option value="">Seleccione</option>
                            <option value="dentro">Dentro de municipio</option>
                            <option value="fuera">Fuera de municipio</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="tiempo_residencia" class="form-label">3.8 Tiempo de Residencia</label>
                        <select class="form-select" id="tiempo_residencia" required>
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

                    <div class="mb-3">
                        <label for="estado_civil" class="form-label">3.9 Estado Civil</label>
                        <select class="form-select" id="estado_civil" required>
                            <option value="">Seleccione</option>
                            <option value="soltero">Soltero</option>
                            <option value="conviviente">Conviviente</option>
                            <option value="separado">Separado</option>
                            <option value="viudo">Viudo</option>
                            <option value="divorciado">Divorciado</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="instruccion" class="form-label">3.10 Nivel de Instrucción</label>
                        <select class="form-select" id="instruccion" required>
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

                    <div class="mb-3">
                        <label for="idioma" class="form-label">3.11 Idioma Más Hablado</label>
                        <select class="form-select" id="idioma" required>
                            <option value="">Seleccione</option>
                            <option value="castellano">Castellano</option>
                            <option value="mara">Mara</option>
                            <option value="quechua">Quechua</option>
                            <option value="guarani">Guaraní</option>
                            <option value="otro">Otro</option>
                        </select>
                        <input type="text" class="form-control mt-2" id="especificar_idioma"
                            placeholder="Especifique si seleccionó 'Otro'">
                    </div>

                    <div class="mb-3">
                        <label for="ocupacion" class="form-label">Ocupación Principal</label>
                        <select class="form-select" id="ocupacion" required>
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

                    <div class="mb-3">
                        <label for="situacion_ocupacional" class="form-label">3.13 Situación Ocupacional</label>
                        <select class="form-select" id="situacion_ocupacional" required>
                            <option value="">Seleccione</option>
                            <option value="permanente">Permanente</option>
                            <option value="temporal">Temporal</option>
                        </select>
                    </div>

                    <!-- Situación Familiar -->
                    <legend>4. Situación Familiar</legend>

                    <div class="mb-3">
                        <label for="parentesco" class="form-label">4.1 Relación de Parentesco</label>
                        <select class="form-select" id="parentesco" required>
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

                    <div class="mb-3">
                        <label for="anos_convivencia" class="form-label">4.2 Años de Matrimonio o Convivencia</label>
                        <select class="form-select" id="anos_convivencia" required>
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

        <!-- --- Sección 3: Hijos --- -->
        <div class="card mb-3">
            <div class="card-header">3. Hijos</div>
            <div class="card-body">
                <div class="mb-3">
                    <label>Número de hijos en gestación</label>
                    <select name="num_hijos_gestacion" class="form-select">
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
                    <label>Edad y sexo de los hijos</label>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Edad</th>
                                <th>Masculino</th>
                                <th>Femenino</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach (['<4', '5-10', '11-15', '16-20', '21+'] as $edad)
                                <tr>
                                    <td>{{ $edad }}</td>
                                    <td><input type="checkbox" name="hijos[{{ $edad }}][]" value="M"></td>
                                    <td><input type="checkbox" name="hijos[{{ $edad }}][]" value="F"></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mb-3">
                    <label>Dependencia económica de los hijos</label>
                    <select name="hijos_dependencia" class="form-select">
                        <option value="">--Seleccione--</option>
                        <option value="dependiente_menor_18">Dependiente menor de 18 años</option>
                        <option value="dependiente_mayor_18">Dependiente mayor de 18 años</option>
                        <option value="no_dependiente_menor_18">No dependiente menor de 18 años</option>
                        <option value="no_dependiente_mayor_18">No dependiente mayor de 18 años</option>
                        <option value="no_tiene_hijos">No tiene hijos</option>
                    </select>
                </div>

                {{-- --- Sección Final: Formulario de Identificación de la Agresión --- --}}
                <div class="card mb-3">
                    <div class="card-header">5. Formulario de Identificación de la Agresión</div>
                    <div class="card-body">

                        {{-- 5.1 Violencia Física --}}
                        <h5 class="mt-3">5.1 Violencia Física</h5>
                        <div class="mb-3">
                            <label class="form-label">Seleccione tipos de violencia física:</label>
                            <div>
                                <div class="form-check"><input class="form-check-input" type="checkbox"
                                        name="violencia_fisica[]" value="pellizcos_patadas"> Pellizcos, patadas, empujones
                                </div>
                                <div class="form-check"><input class="form-check-input" type="checkbox"
                                        name="violencia_fisica[]" value="aranazos_golpes"> Arañazos o golpes</div>
                                <div class="form-check"><input class="form-check-input" type="checkbox"
                                        name="violencia_fisica[]" value="mordiscos"> Mordiscos</div>
                                <div class="form-check"><input class="form-check-input" type="checkbox"
                                        name="violencia_fisica[]" value="puñetes_tirones"> Puñetes, tirones de cabello
                                </div>
                                <div class="form-check"><input class="form-check-input" type="checkbox"
                                        name="violencia_fisica[]" value="fracturas_quemaduras"> Torceduras de brazos,
                                    fracturas, quemaduras</div>
                                <div class="form-check"><input class="form-check-input" type="checkbox"
                                        name="violencia_fisica[]" value="objetos_contundentes"> Golpes con objetos
                                    contundentes</div>
                                <div class="form-check"><input class="form-check-input" type="checkbox"
                                        name="violencia_fisica[]" value="arma_blanca_fuego"> Agresiones con arma blanca o
                                    de fuego</div>
                                <div class="form-check"><input class="form-check-input" type="checkbox"
                                        name="violencia_fisica[]" value="cortadura_cabello"> Cortadura de cabello</div>
                                <div class="form-check"><input class="form-check-input" type="checkbox"
                                        name="violencia_fisica[]" value="lesiones_asfixia"> Lesiones por asfixia</div>
                            </div>
                        </div>

                        {{-- 5.2 Violencia Psicológica --}}
                        <h5 class="mt-3">5.2 Violencia Psicológica</h5>
                        <div class="mb-3">
                            <label class="form-label">Seleccione tipos de violencia psicológica:</label>
                            <div>
                                <div class="form-check"><input class="form-check-input" type="checkbox"
                                        name="violencia_psicologica[]" value="insultos_humillaciones"> Insultos,
                                    humillaciones, descalificaciones</div>
                                <div class="form-check"><input class="form-check-input" type="checkbox"
                                        name="violencia_psicologica[]" value="comparaciones"> Comparaciones de bajo</div>
                                <div class="form-check"><input class="form-check-input" type="checkbox"
                                        name="violencia_psicologica[]" value="amenazas"> Amenazas</div>
                                <div class="form-check"><input class="form-check-input" type="checkbox"
                                        name="violencia_psicologica[]" value="difamaciones"> Difamaciones y calumnias
                                </div>
                                <div class="form-check"><input class="form-check-input" type="checkbox"
                                        name="violencia_psicologica[]" value="control"> Situaciones de control</div>
                                <div class="form-check"><input class="form-check-input" type="checkbox"
                                        name="violencia_psicologica[]" value="infidelidad"> Infidelidad, celos</div>
                                <div class="form-check"><input class="form-check-input" type="checkbox"
                                        name="violencia_psicologica[]" value="persecuciones"> Persecuciones</div>
                            </div>
                        </div>

                        {{-- 5.3 Violencia Sexual --}}
                        <h5 class="mt-3">5.3 Violencia Sexual</h5>
                        <div class="mb-3">
                            <label class="form-label">Seleccione tipos de violencia sexual:</label>
                            <div>
                                <div class="form-check"><input class="form-check-input" type="checkbox"
                                        name="violencia_sexual[]" value="intento_violacion"> Intento de violación</div>
                                <div class="form-check"><input class="form-check-input" type="checkbox"
                                        name="violencia_sexual[]" value="acoso_sexual"> Acoso sexual</div>
                                <div class="form-check"><input class="form-check-input" type="checkbox"
                                        name="violencia_sexual[]" value="toques_impudicos"> Toques impúdicos</div>
                                <div class="form-check"><input class="form-check-input" type="checkbox"
                                        name="violencia_sexual[]" value="introduccion_objetos"> Introducción de objetos en
                                    genitales</div>
                                <div class="form-check"><input class="form-check-input" type="checkbox"
                                        name="violencia_sexual[]" value="violacion_economica"> Violación económica</div>
                                <div class="form-check"><input class="form-check-input" type="checkbox"
                                        name="violencia_sexual[]" value="destruccion_patrimonio"> Destrucción de
                                    patrimonio</div>
                            </div>
                        </div>

                        {{-- 5.4 Tipo de Violencia --}}
                        <h5 class="mt-3">5.4 Tipo de Violencia</h5>
                        <select class="form-select" name="tipo_violencia" required>
                            <option value="">Seleccione tipo de violencia</option>
                            <option value="intrafamiliar">Violencia Intrafamiliar</option>
                            <option value="domestica">Violencia Doméstica</option>
                        </select>

                        {{-- 5.5 Forma de Violencia --}}
                        <h5 class="mt-3">5.5 Forma de Violencia</h5>
                        <select class="form-select" name="forma_violencia" required>
                            <option value="">Seleccione forma de violencia</option>
                            <option value="fisica">Física</option>
                            <option value="psicologica">Psicológica</option>
                            <option value="sexual">Sexual</option>
                        </select>

                        {{-- 5.6 Frecuencia --}}
                        <h5 class="mt-3">5.6 Frecuencia de Agresión</h5>
                        <select class="form-select" name="frecuencia_agresion" required>
                            <option value="">Seleccione frecuencia</option>
                            <option value="primera_vez">Primera vez</option>
                            <option value="alguna_vez">Alguna vez</option>
                            <option value="ocasionalmente">Ocasionalmente</option>
                            <option value="con_frecuencia">Con frecuencia</option>
                            <option value="siempre">Siempre</option>
                        </select>

                        {{-- 5.7 Denuncia --}}
                        <h5 class="mt-3">5.7 Denunció la Agresión</h5>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="denuncia" value="si"> Sí
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="denuncia" value="no"> No
                        </div>

                        {{-- 5.8 Razones --}}
                        <h5 class="mt-3">5.8 Razones por las que no se hizo la denuncia</h5>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="razones_no_denuncia[]"
                                value="amenaza"> Amenaza
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="razones_no_denuncia[]" value="temor">
                            Temor
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="razones_no_denuncia[]"
                                value="verguenza"> Vergüenza
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="razones_no_denuncia[]"
                                value="desconocimiento"> Desconocimiento
                        </div>
                        <div class="form-check">
                            Otros: <input type="text" name="razones_no_denuncia_otro" class="form-control mt-1">
                        </div>

                        {{-- 5.9 Motivo --}}
                        <h5 class="mt-3">5.9 Motivo de la Agresión</h5>
                        <select class="form-select" name="motivo_agresion">
                            <option value="">Seleccione motivo</option>
                            <option value="ebriedad">Ebriedad</option>
                            <option value="economico">Económico</option>
                            <option value="cultural">Cultural</option>
                            <option value="intromision">Intromisión Familiar</option>
                            <option value="infidelidad">Infidelidad</option>
                            <option value="celos">Celos</option>
                            <option value="adiccion">Adicción</option>
                            <option value="otros">Otros</option>
                        </select>
                        <input type="text" name="motivo_otro" class="form-control mt-2"
                            placeholder="Especifique si seleccionó 'Otros'">

                        {{-- 5.10 Descripción --}}
                        <h5 class="mt-3">5.10 Descripción de denuncias o procesos realizados</h5>
                        <textarea name="descripcion_denuncia" class="form-control" rows="3"></textarea>

                        {{-- 5.11 Atención demandada --}}
                        <h5 class="mt-3">5.11 Atención que Demanda</h5>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="atencion_demandada[]"
                                value="victimas"> Apoyo a víctimas
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="atencion_demandada[]" value="pareja">
                            Apoyo a pareja
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="atencion_demandada[]" value="agresor">
                            Apoyo a agresor
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="atencion_demandada[]" value="hijos">
                            Apoyo a hijos
                        </div>

                        <label class="form-label mt-3">Medidas a tomar:</label>
                        <textarea name="medidas_tomar" class="form-control" rows="3"></textarea>

                        {{-- Datos y firma --}}
                        <h5 class="mt-3">Datos Personales</h5>
                        <input type="text" name="nombre_responsable" class="form-control mb-2" placeholder="Nombre">
                        <input type="text" name="firma_responsable" class="form-control" placeholder="Firma">

                    </div>
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
