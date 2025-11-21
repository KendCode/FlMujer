@extends('layouts.sidebar')

@section('styles')
<style>
    body {
        background-color: #F4F4F2;
    }

    .card-header {
        background-color: #13C0E5 !important;
        color: white;
        font-weight: bold;
    }

    h5.text-primary {
        color: #037E8C !important;
        font-weight: 600;
    }

    .form-check-label {
        color: #037E8C;
    }

    .btn-primary {
        background-color: #037E8C !important;
        border-color: #037E8C !important;
        font-weight: bold;
        color: #fff;
    }

    .btn-primary:hover {
        background-color: #026873 !important;
        border-color: #026873 !important;
    }

    .btn-outline-primary {
        color: #13C0E5;
        border-color: #13C0E5;
        font-weight: bold;
    }

    .btn-outline-primary:hover {
        background-color: #13C0E5;
        color: #fff;
        border-color: #13C0E5;
    }

    table.table-bordered th {
        background-color: #7EC544;
        color: white;
        text-align: center;
        vertical-align: middle;
    }

    table.table-bordered td {
        vertical-align: middle;
    }

    .form-control:focus {
        border-color: #037E8C;
        box-shadow: 0 0 0 0.2rem rgba(3, 126, 140, 0.25);
    }
</style>
@endsection

@section('content')
<div class="container mt-4">
    <div class="card shadow-lg rounded-3 border-0">
        <div class="card-header text-center">
            <h4>Ficha de Evaluación Preliminar</h4>
            <p class="mb-0">Parejas que viven en situación de violencia intrafamiliar</p>
        </div>

        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form method="POST" action="{{ route('casos.fichaPreliminarPareja.store', $caso->id) }}">
                @csrf
                <!-- Datos iniciales y observaciones -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label>N° de Caso</label>
                        <input type="text" name="nro_caso" class="form-control" value="{{ $caso->nro_registro }}" readonly>
                    </div>
                    <div class="col-md-6">
                        <label>Nombres y Apellidos</label>
                        <input type="text" name="nombres_apellidos" class="form-control" value="{{ $caso->paciente_nombres }} {{ $caso->paciente_ap_paterno }} {{ $caso->paciente_ap_materno }}" readonly>
                    </div>
                </div>

                <div class="mb-3">
                    <label>Observaciones</label>
                    <textarea name="observaciones" class="form-control" rows="2">{{ old('observaciones', $ficha->observaciones ?? '') }}</textarea>
                </div>

                <!-- Grupo Familiar -->
                <h5 class="text-primary mt-4">Grupo Familiar</h5>
                <table class="table table-bordered table-sm text-center align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Nombre y Apellidos</th>
                            <th>Parentesco</th>
                            <th>Edad</th>
                            <th>Sexo</th>
                            <th>Grado de Instrucción</th>
                            <th>Estado Civil</th>
                            <th>Ocupación</th>
                            <th>Lugar de trabajo o estudio</th>
                            <th>Observaciones</th>
                        </tr>
                    </thead>
                    <tbody id="grupoFamiliar">
                        @php
                            $grupo = old(
                                'grupo_familiar',
                                $ficha->grupo_familiar ?? [[
                                    'nombre'=>null,'parentesco'=>null,'edad'=>null,'sexo'=>null,
                                    'grado'=>null,'estado_civil'=>null,'ocupacion'=>null,'lugar'=>null,'observacion'=>null
                                ]]
                            );
                        @endphp

                        @foreach ($grupo as $index => $miembro)
                            <tr>
                                <td><input type="text" name="grupo_familiar[{{ $index }}][nombre]" class="form-control" value="{{ $miembro['nombre'] ?? '' }}"></td>
                                <td><input type="text" name="grupo_familiar[{{ $index }}][parentesco]" class="form-control" value="{{ $miembro['parentesco'] ?? '' }}"></td>
                                <td><input type="number" name="grupo_familiar[{{ $index }}][edad]" class="form-control" value="{{ $miembro['edad'] ?? '' }}"></td>
                                <td><input type="text" name="grupo_familiar[{{ $index }}][sexo]" class="form-control" value="{{ $miembro['sexo'] ?? '' }}"></td>
                                <td><input type="text" name="grupo_familiar[{{ $index }}][grado]" class="form-control" value="{{ $miembro['grado'] ?? '' }}"></td>
                                <td><input type="text" name="grupo_familiar[{{ $index }}][estado_civil]" class="form-control" value="{{ $miembro['estado_civil'] ?? '' }}"></td>
                                <td><input type="text" name="grupo_familiar[{{ $index }}][ocupacion]" class="form-control" value="{{ $miembro['ocupacion'] ?? '' }}"></td>
                                <td><input type="text" name="grupo_familiar[{{ $index }}][lugar]" class="form-control" value="{{ $miembro['lugar'] ?? '' }}"></td>
                                <td><input type="text" name="grupo_familiar[{{ $index }}][observacion]" class="form-control" value="{{ $miembro['observacion'] ?? '' }}"></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <button type="button" class="btn btn-outline-primary btn-sm" id="addRow">+ Agregar miembro</button>

                <!-- Indicadores -->
                <h5 class="text-primary mt-4">Indicadores de Violencia - A nivel de pareja</h5>
                @php
                    $indicadoresPareja = [
                        'Inadecuada comunicación (silencios, gritos, golpes, órdenes, comunicación de una sola vía)',
                        'Inequidad de roles','Crianza de los hijos no compartida en pareja',
                        'Tareas del hogar no compartido en pareja','Desvalorización del trabajo del hogar',
                        'Desvalorización de la pareja','Falta de expresión de sentimientos y emociones',
                        'Permisividad a la intromisión familiar','Falta de independencia económica en relación a las familias de origen',
                        'Relacionamiento violento en pareja','Falta de confianza','Inestabilidad emocional en la pareja',
                        'Falta de un proyecto de vida en común','Control excesivo hacia la pareja',
                        'Infidelidad y pérdida de respeto a la pareja','Falta de independencia en la toma de decisiones',
                        'No realizan actividades recreativas en familia',
                    ];
                    $seleccionadosPareja = old('indicadores_pareja', $ficha->indicadores_pareja ?? []);
                @endphp
                @foreach ($indicadoresPareja as $indicador)
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="indicadores_pareja[]" value="{{ $indicador }}" {{ in_array($indicador, $seleccionadosPareja) ? 'checked' : '' }}>
                        <label class="form-check-label">{{ $indicador }}</label>
                    </div>
                @endforeach

                <h5 class="text-primary mt-4">En relación a las hijas e hijos</h5>
                @php
                    $indicadoresHijos = [
                        'Maltrato infantil (físico, psicológico, sexual, omisión)',
                        'Pérdida de autoridad sobre los hijos','Alienación parental',
                        'Discuten y ejercen violencia delante de los hijos',
                        'Irresponsabilidad paterna (en lo económico, educación y protección de la familia)',
                        'Irresponsabilidad materna (descuido de los hijos, reproducción de la violencia)',
                        'Desigualdad en la crianza de los hijos (preferencias de un hijo u otro)',
                    ];
                    $seleccionadosHijos = old('indicadores_hijos', $ficha->indicadores_hijos ?? []);
                @endphp
                @foreach ($indicadoresHijos as $indicador)
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="indicadores_hijos[]" value="{{ $indicador }}" {{ in_array($indicador, $seleccionadosHijos) ? 'checked' : '' }}>
                        <label class="form-check-label">{{ $indicador }}</label>
                    </div>
                @endforeach

                <!-- Evaluación por fases -->
                <h5 class="mt-4">I. Evaluación por fases al momento del ingreso</h5>
                <div class="mb-3">
                    <label class="form-label">Primera fase - Descripción</label>
                    <textarea name="fase[primera]" class="form-control" rows="2">{{ old('fase.primera', $ficha->fase_primera ?? '') }}</textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Segunda fase - Descripción</label>
                    <textarea name="fase[segunda]" class="form-control" rows="2">{{ old('fase.segunda', $ficha->fase_segunda ?? '') }}</textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Tercera fase - Descripción</label>
                    <textarea name="fase[tercera]" class="form-control" rows="2">{{ old('fase.tercera', $ficha->fase_tercera ?? '') }}</textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Cuarta fase - Descripción</label>
                    <textarea name="fase[cuarta]" class="form-control" rows="2">{{ old('fase.cuarta', $ficha->fase_cuarta ?? '') }}</textarea>
                </div>
                <div class="mb-3">
                    <label>Observaviones</label>
                    <textarea name="observacion_fase" class="form-control" rows="2">{{ old('observacion_fase', $ficha->observacion_fase ?? '') }}</textarea>
                </div>
                <div class="mb-3">
                    <label>Medidas a tomar</label>
                    <textarea name="medidas" class="form-control" rows="2">{{ old('medidas', $ficha->medidas ?? '') }}</textarea>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label>Fecha</label>
                        <input type="date" name="fecha" class="form-control" value="{{ old('fecha', $ficha->fecha ?? '') }}">
                    </div>
                    <div class="col-md-6">
                        <label>Nombre y firma del responsable</label>
                        <input type="text" name="responsable" class="form-control" value="{{ old('responsable', $ficha->responsable ?? '') }}">
                    </div>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-primary">Guardar Ficha</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.getElementById('addRow').addEventListener('click', () => {
        const table = document.getElementById('grupoFamiliar');
        const index = table.rows.length;
        const row = table.insertRow();
        const names = ['nombre','parentesco','edad','sexo','grado','estado_civil','ocupacion','lugar','observacion'];
        for (let i=0; i<9; i++) {
            const cell = row.insertCell(i);
            cell.innerHTML = `<input type="text" name="grupo_familiar[${index}][${names[i]}]" class="form-control">`;
        }
    });
</script>
@endsection
