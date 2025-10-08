@extends('layouts.sidebar')

@section('content')
<div class="container">
    <h2 class="mb-4">Editar Caso</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('casos.update', $caso->id) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- =====================
             SECCIÓN 1: DATOS PACIENTE
             ===================== -->
        <div class="card mb-3">
            <div class="card-header">Datos Personales del Paciente</div>
            <div class="card-body">
                <div class="row g-2">
                    <div class="col-md-6">
                        <label class="form-label">Nombres</label>
                        <input type="text" name="paciente_nombres" class="form-control" value="{{ old('paciente_nombres', $caso->paciente_nombres) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Apellidos</label>
                        <input type="text" name="paciente_apellidos" class="form-control" value="{{ old('paciente_apellidos', $caso->paciente_apellidos) }}" required>
                    </div>

                    <div class="col-md-4 mt-2">
                        <label class="form-label d-block">Sexo</label>
                        @foreach(['M'=>'Varón','F'=>'Mujer'] as $key => $label)
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="paciente_sexo" value="{{ $key }}" {{ $caso->paciente_sexo == $key ? 'checked' : '' }} required>
                                <label class="form-check-label">{{ $label }}</label>
                            </div>
                        @endforeach
                    </div>

                    <div class="col-md-8 mt-2">
                        <label class="form-label">Edad (rango)</label>
                        <div class="d-flex flex-wrap gap-2">
                            @foreach([
                                'menor15'=>'Menor de 15 años',
                                '16a20'=>'16 a 20 años',
                                '21a25'=>'21 a 25 años',
                                '26a30'=>'26 a 30 años',
                                '31a35'=>'31 a 35 años',
                                '36a50'=>'36 a 50 años',
                                'mayor50'=>'Más de 50 años'
                            ] as $key => $label)
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="paciente_edad_rango" value="{{ $key }}" {{ $caso->paciente_edad_rango == $key ? 'checked' : '' }} required>
                                    <label class="form-check-label">{{ $label }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="col-md-4 mt-2">
                        <label class="form-label">CI</label>
                        <input type="text" name="paciente_ci" class="form-control" value="{{ old('paciente_ci', $caso->paciente_ci) }}">
                    </div>

                    <div class="col-md-8 mt-2">
                        <label class="form-label">Distrito</label><br>
                        <div class="d-flex flex-wrap gap-2">
                            @for($i=1; $i<=14; $i++)
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="paciente_id_distrito" value="{{ $i }}" {{ $caso->paciente_id_distrito == $i ? 'checked' : '' }} required>
                                    <label class="form-check-label">Distrito {{ $i }}</label>
                                </div>
                            @endfor
                        </div>
                        <div class="mt-2">
                            <input type="text" name="paciente_otros" class="form-control" placeholder="Otros" value="{{ old('paciente_otros', $caso->paciente_otros) }}">
                        </div>
                        <div class="mt-2">
                            <input type="text" name="paciente_zona" class="form-control" placeholder="Zona / Barrio" value="{{ old('paciente_zona', $caso->paciente_zona) }}">
                        </div>
                        <div class="mt-2">
                            <input type="text" name="paciente_calle" class="form-control" placeholder="Calle / Avenida" value="{{ old('paciente_calle', $caso->paciente_calle) }}">
                        </div>
                        <div class="mt-2">
                            <input type="text" name="paciente_numero" class="form-control" placeholder="Número" value="{{ old('paciente_numero', $caso->paciente_numero) }}">
                        </div>
                        <div class="mt-2">
                            <input type="text" name="paciente_telefono" class="form-control" placeholder="Teléfono" value="{{ old('paciente_telefono', $caso->paciente_telefono) }}">
                        </div>
                    </div>

                    <div class="col-md-4 mt-2">
                        <label class="form-label">Lugar de Nacimiento</label>
                        <input type="text" name="paciente_lugar_nacimiento" class="form-control" placeholder="Lugar de Nacimiento" value="{{ old('paciente_lugar_nacimiento', $caso->paciente_lugar_nacimiento) }}">
                        <div class="form-check form-check-inline mt-2">
                            <input class="form-check-input" type="radio" name="paciente_lugar_nacimiento_op" value="dentro" {{ $caso->paciente_lugar_nacimiento_op == 'dentro' ? 'checked' : '' }} required>
                            <label class="form-check-label">Dentro de municipio</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="paciente_lugar_nacimiento_op" value="fuera" {{ $caso->paciente_lugar_nacimiento_op == 'fuera' ? 'checked' : '' }} required>
                            <label class="form-check-label">Fuera de municipio</label>
                        </div>
                    </div>

                    <div class="col-md-6 mt-2">
                        <label>Estado Civil</label>
                        <select name="paciente_estado_civil" class="form-select" required>
                            <option value="">Seleccione...</option>
                            @foreach(['soltero','conviviente','viudo','casado','separado','divorciado'] as $estado)
                                <option value="{{ $estado }}" {{ $caso->paciente_estado_civil == $estado ? 'selected' : '' }}>{{ ucfirst($estado) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mt-2">
                        <label>Nivel de Instrucción</label>
                        <select name="paciente_nivel_instruccion" class="form-select" required>
                            <option value="">Seleccione...</option>
                            @foreach(['ninguno','primaria','secundaria','tecnico','tecnicoSuperior','licenciatura'] as $nivel)
                                <option value="{{ $nivel }}" {{ $caso->paciente_nivel_instruccion == $nivel ? 'selected' : '' }}>{{ ucfirst($nivel) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mt-2">
                        <label>Ocupación Principal</label>
                        <select name="paciente_ocupacion" class="form-select" required>
                            <option value="">Seleccione...</option>
                            @foreach([
                                'obrero'=>'Obrero',
                                'empleada'=>'Empleada',
                                'trabajadorCuentaPropia'=>'Trabajador por Cuenta Propia',
                                'patrona'=>'Patrona',
                                'socioemprendedor'=>'Socioemprendedor',
                                'cooperativista'=>'Cooperativista',
                                'aprendizSinRemuneracion'=>'Aprendiz sin Remuneración',
                                'aprendizConRemuneracion'=>'Aprendiz con Remuneración',
                                'laboresCasa'=>'Labores de Casa',
                                'sinTrabajo'=>'No tienen Trabajo',
                                'otros'=>'Otros'
                            ] as $key=>$label)
                                <option value="{{ $key }}" {{ $caso->paciente_ocupacion == $key ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mt-2">
                        <label>Situación Ocupacional</label>
                        <select name="paciente_situacion_ocupacional" class="form-select" required>
                            <option value="">Seleccione...</option>
                            @foreach(['permanente','temporal'] as $sit)
                                <option value="{{ $sit }}" {{ $caso->paciente_situacion_ocupacional == $sit ? 'selected' : '' }}>{{ ucfirst($sit) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- =====================
             SECCIÓN 2: DATOS PAREJA
             ===================== -->
        <div class="card mb-3">
            <div class="card-header">Datos de la Pareja</div>
            <div class="card-body">
                <div class="row g-2">
                    <div class="col-md-6">
                        <label>Nombres</label>
                        <input type="text" name="pareja_nombres" class="form-control" value="{{ old('pareja_nombres', $caso->pareja_nombres) }}">
                    </div>
                    <div class="col-md-6">
                        <label>Apellidos</label>
                        <input type="text" name="pareja_apellidos" class="form-control" value="{{ old('pareja_apellidos', $caso->pareja_apellidos) }}">
                    </div>
                    <div class="col-md-4 mt-2">
                        <label>Sexo</label><br>
                        @foreach(['M'=>'Varón','F'=>'Mujer'] as $key => $label)
                            <div class="form-check form-check-inline">
                                <input type="radio" name="pareja_sexo" value="{{ $key }}" {{ $caso->pareja_sexo == $key ? 'checked' : '' }}>
                                <label class="form-check-label">{{ $label }}</label>
                            </div>
                        @endforeach
                    </div>
                    <div class="col-md-8 mt-2">
                        <label>Edad (rango)</label><br>
                        @foreach([
                            'menor15'=>'Menor de 15 años',
                            '16a20'=>'16 a 20 años',
                            '21a25'=>'21 a 25 años',
                            '26a30'=>'26 a 30 años',
                            '31a35'=>'31 a 35 años',
                            '36a50'=>'36 a 50 años',
                            'mayor50'=>'Más de 50 años'
                        ] as $key=>$label)
                            <div class="form-check form-check-inline">
                                <input type="radio" name="pareja_edad_rango" value="{{ $key }}" {{ $caso->pareja_edad_rango == $key ? 'checked' : '' }}>
                                <label>{{ $label }}</label>
                            </div>
                        @endforeach
                    </div>

                    <div class="col-md-4 mt-2">
                        <label>CI</label>
                        <input type="text" name="pareja_ci" class="form-control" value="{{ old('pareja_ci', $caso->pareja_ci) }}">
                    </div>

                    <div class="col-md-4 mt-2">
                        <label>Ocupación Principal</label>
                        <select name="pareja_ocupacion_principal" class="form-select">
                            <option value="">Seleccione...</option>
                            @foreach([
                                'obrero'=>'Obrero',
                                'empleada'=>'Empleada',
                                'trabajadorCuentaPropia'=>'Trabajador por Cuenta Propia',
                                'patrona'=>'Patrona',
                                'socioemprendedor'=>'Socioemprendedor',
                                'cooperativista'=>'Cooperativista',
                                'aprendizSinRemuneracion'=>'Aprendiz sin Remuneración',
                                'aprendizConRemuneracion'=>'Aprendiz con Remuneración',
                                'laboresCasa'=>'Labores de Casa',
                                'sinTrabajo'=>'No tienen Trabajo',
                                'otros'=>'Otros'
                            ] as $key=>$label)
                                <option value="{{ $key }}" {{ $caso->pareja_ocupacion_principal == $key ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4 mt-2">
                        <label>Situación Ocupacional</label>
                        <select name="pareja_situacion_ocupacional" class="form-select">
                            <option value="">Seleccione...</option>
                            @foreach(['permanente','temporal'] as $sit)
                                <option value="{{ $sit }}" {{ $caso->pareja_situacion_ocupacional == $sit ? 'selected' : '' }}>{{ ucfirst($sit) }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4 mt-2">
                        <label>Parentesco</label>
                        <input type="text" name="pareja_parentesco" class="form-control" value="{{ old('pareja_parentesco', $caso->pareja_parentesco) }}">
                    </div>

                    <div class="col-md-4 mt-2">
                        <label>Residencia</label>
                        <input type="text" name="pareja_residencia" class="form-control" value="{{ old('pareja_residencia', $caso->pareja_residencia) }}">
                    </div>

                    <div class="col-md-4 mt-2">
                        <label>Años de convivencia</label>
                        <input type="number" name="pareja_anos_convivencia" class="form-control" value="{{ old('pareja_anos_convivencia', $caso->pareja_anos_convivencia) }}">
                    </div>

                    <div class="col-md-4 mt-2">
                        <label>Tiempo de residencia</label>
                        <input type="text" name="pareja_tiempo_residencia" class="form-control" value="{{ old('pareja_tiempo_residencia', $caso->pareja_tiempo_residencia) }}">
                    </div>

                    <div class="col-md-4 mt-2">
                        <label>Idioma</label>
                        <select name="pareja_idioma" class="form-select">
                            <option value="">Seleccione...</option>
                            @foreach(['Español','Quechua','Aymara','Otro'] as $idioma)
                                <option value="{{ $idioma }}" {{ $caso->pareja_idioma == $idioma ? 'selected' : '' }}>{{ $idioma }}</option>
                            @endforeach
                        </select>
                        <input type="text" name="pareja_especificar_idioma" class="form-control mt-1" placeholder="Especificar idioma" value="{{ old('pareja_especificar_idioma', $caso->pareja_especificar_idioma) }}">
                    </div>

                    <div class="col-md-12 mt-2">
                        <label>Otros</label>
                        <textarea name="pareja_otros" class="form-control">{{ old('pareja_otros', $caso->pareja_otros) }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <!-- =====================
             SECCIÓN 3: HIJOS
             ===================== -->
        <div class="card mb-3">
            <div class="card-header">Datos de los Hijos</div>
            <div class="card-body">
                <div class="row g-2">
                    <div class="col-md-4 mt-2">
                        <label>Número de Gestación</label>
                        <input type="number" name="hijos_num_gestacion" class="form-control" value="{{ old('hijos_num_gestacion', $caso->hijos_num_gestacion) }}">
                    </div>
                    <div class="col-md-4 mt-2">
                        <label>Dependencia económica</label>
                        <input type="text" name="hijos_dependencia" class="form-control" value="{{ old('hijos_dependencia', $caso->hijos_dependencia) }}">
                    </div>

                    <div class="col-md-6 mt-2">
                        <label>Hijos por edad y sexo</label>
                        <div class="row">
                            <div class="col-6">
                                <label>Menor 4 años - Femenino</label>
                                <input type="number" name="hijos_edad_menor4_femenino" class="form-control" value="{{ old('hijos_edad_menor4_femenino', $caso->hijos_edad_menor4_femenino) }}">
                            </div>
                            <div class="col-6">
                                <label>Menor 4 años - Masculino</label>
                                <input type="number" name="hijos_edad_menor4_masculino" class="form-control" value="{{ old('hijos_edad_menor4_masculino', $caso->hijos_edad_menor4_masculino) }}">
                            </div>
                            <div class="col-6 mt-2">
                                <label>5-10 años - Femenino</label>
                                <input type="number" name="hijos_edad_5_10_femenino" class="form-control" value="{{ old('hijos_edad_5_10_femenino', $caso->hijos_edad_5_10_femenino) }}">
                            </div>
                            <div class="col-6 mt-2">
                                <label>5-10 años - Masculino</label>
                                <input type="number" name="hijos_edad_5_10_masculino" class="form-control" value="{{ old('hijos_edad_5_10_masculino', $caso->hijos_edad_5_10_masculino) }}">
                            </div>
                            <div class="col-6 mt-2">
                                <label>11-15 años - Femenino</label>
                                <input type="number" name="hijos_edad_11_15_femenino" class="form-control" value="{{ old('hijos_edad_11_15_femenino', $caso->hijos_edad_11_15_femenino) }}">
                            </div>
                            <div class="col-6 mt-2">
                                <label>11-15 años - Masculino</label>
                                <input type="number" name="hijos_edad_11_15_masculino" class="form-control" value="{{ old('hijos_edad_11_15_masculino', $caso->hijos_edad_11_15_masculino) }}">
                            </div>
                            <div class="col-6 mt-2">
                                <label>16-20 años - Femenino</label>
                                <input type="number" name="hijos_edad_16_20_femenino" class="form-control" value="{{ old('hijos_edad_16_20_femenino', $caso->hijos_edad_16_20_femenino) }}">
                            </div>
                            <div class="col-6 mt-2">
                                <label>16-20 años - Masculino</label>
                                <input type="number" name="hijos_edad_16_20_masculino" class="form-control" value="{{ old('hijos_edad_16_20_masculino', $caso->hijos_edad_16_20_masculino) }}">
                            </div>
                            <div class="col-6 mt-2">
                                <label>21+ años - Femenino</label>
                                <input type="number" name="hijos_edad_21_mas_femenino" class="form-control" value="{{ old('hijos_edad_21_mas_femenino', $caso->hijos_edad_21_mas_femenino) }}">
                            </div>
                            <div class="col-6 mt-2">
                                <label>21+ años - Masculino</label>
                                <input type="number" name="hijos_edad_21_mas_masculino" class="form-control" value="{{ old('hijos_edad_21_mas_masculino', $caso->hijos_edad_21_mas_masculino) }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- =====================
             SECCIÓN 4: VIOLENCIA
             ===================== -->
        <div class="card mb-3">
            <div class="card-header">Datos de Violencia</div>
            <div class="card-body">
                <div class="row g-2">
                    <div class="col-md-6 mt-2">
                        <label>Tipo de Violencia</label><br>
                        @foreach([
                            'violencia_tipo_fisica'=>'Física',
                            'violencia_tipo_psicologica'=>'Psicológica',
                            'violencia_tipo_sexual'=>'Sexual',
                            'violencia_tipo_patrimonial'=>'Patrimonial',
                            'violencia_tipo_economica'=>'Económica'
                        ] as $key => $label)
                            <div class="form-check form-check-inline">
                                <input type="checkbox" name="{{ $key }}" value="1" class="form-check-input" {{ $caso->$key ? 'checked' : '' }}>
                                <label class="form-check-label">{{ $label }}</label>
                            </div>
                        @endforeach
                    </div>

                    <div class="col-md-6 mt-2">
                        <label>Frecuencia</label>
                        <select name="violencia_frecuencia" class="form-select">
                            <option value="">Seleccione...</option>
                            @foreach(['ocasional','frecuente','diaria'] as $freq)
                                <option value="{{ $freq }}" {{ $caso->violencia_frecuencia == $freq ? 'selected' : '' }}>{{ ucfirst($freq) }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mt-2">
                        <label>Lugar de los hechos</label>
                        <input type="text" name="violencia_lugar_hechos" class="form-control" value="{{ old('violencia_lugar_hechos', $caso->violencia_lugar_hechos) }}">
                    </div>

                    <div class="col-md-6 mt-2">
                        <label>Tiempo de ocurrencia</label>
                        <input type="text" name="violencia_tiempo_ocurrencia" class="form-control" value="{{ old('violencia_tiempo_ocurrencia', $caso->violencia_tiempo_ocurrencia) }}">
                    </div>

                    <div class="col-12 mt-2">
                        <label>Descripción de los hechos</label>
                        <textarea name="violencia_descripcion_hechos" class="form-control">{{ old('violencia_descripcion_hechos', $caso->violencia_descripcion_hechos) }}</textarea>
                    </div>

                    <div class="col-md-6 mt-2">
                        <label>Denuncia previa</label><br>
                        <div class="form-check form-check-inline">
                            <input type="radio" name="violencia_denuncia_previa" value="1" class="form-check-input" {{ $caso->violencia_denuncia_previa ? 'checked' : '' }}>
                            <label class="form-check-label">Sí</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="radio" name="violencia_denuncia_previa" value="0" class="form-check-input" {{ $caso->violencia_denuncia_previa === 0 ? 'checked' : '' }}>
                            <label class="form-check-label">No</label>
                        </div>
                    </div>

                    <div class="col-md-6 mt-2">
                        <label>Institución de denuncia</label>
                        <input type="text" name="violencia_institucion_denuncia" class="form-control" value="{{ old('violencia_institucion_denuncia', $caso->violencia_institucion_denuncia) }}">
                    </div>
                </div>
            </div>
        </div>

        <!-- =====================
             BOTÓN GUARDAR
             ===================== -->
        <div class="mb-3">
            <button type="submit" class="btn btn-primary">Actualizar Caso</button>
            <a href="{{ route('casos.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>
@endsection
