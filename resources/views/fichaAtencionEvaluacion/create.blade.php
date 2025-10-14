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

    <h2>FICHA DE ATENCIÓN Y EVALUACIÓN PSICOLÓGICA</h2>
    <form action="{{ route('casos.store') }}" method="POST">
        @csrf
        <div class="card mb-3">
            <div class="card-header">FORMULARIO</div>
            <div class="card-body">
                <div class="row g-2">
                    
                    <div class="col-md-6">
                        <label class="form-label">Fecha</label>
                        <input type="date" name="regional_fecha" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Nro. registro</label>
                        <input type="number" name="regional_fecha" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Institución que deriva</label>
                        <input type="text" name="regional_fecha" class="form-control" required>
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
                            <input class="form-check-input" type="radio" name="paciente_lugar_nacimiento_op"
                                value="dentro">
                            <label class="form-check-label">Dentro del municipio</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="paciente_lugar_nacimiento_op"
                                value="fuera">
                            <label class="form-check-label">Fuera de municipio</label>
                        </div>
                    </div>
                    <div class="col-md-4 mt-2">
                        <label class="form-label d-block">Tiempo de residencia en este municipio</label>
                        <div class="form-check form-check-inline mt-2">
                            <input class="form-check-input" type="radio" name="paciente_lugar_nacimiento_op"
                                value="menosDeUnAno">
                            <label class="form-check-label">Menos de 1 año</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="paciente_lugar_nacimiento_op"
                                value="de2a5Anos">
                            <label class="form-check-label">De 2 a 5 años</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="paciente_lugar_nacimiento_op"
                                value="de6a10Anos">
                            <label class="form-check-label">De 6 a 10 años</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="paciente_lugar_nacimiento_op"
                                value="masDe10Anos">
                            <label class="form-check-label">De y más años</label>
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
                        <label for="paciente_nivel_instruccion" class="form-label">Idioma más hablado</label>
                        <select class="form-select" id="paciente_nivel_instruccion" name="paciente_nivel_instruccion"
                            required>
                            <option value="">Seleccione...</option>
                            <option value="castellano">Castellano</option>
                            <option value="aymara">Aymara</option>
                            <option value="quechua">Quechua</option>
                            <option value="guarani">Guaraní</option>
                            <option value="otroNativo">Otro nativo</option>
                            <option value="extranjero">Extranjero</option>
                        </select>
                    </div>
                    <input type="text" name="paciente_idoma_mas_hablado" class="form-control"
                        placeholder="Especificar idioma más hablado">
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
