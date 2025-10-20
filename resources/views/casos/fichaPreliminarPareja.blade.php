@extends('layouts.sidebar')

@section('content')
<div class="container mt-4">
    <div class="card shadow-lg rounded-3 border-0">
        <div class="card-header bg-primary text-white text-center">
            <h4>Ficha de Evaluación Preliminar</h4>
            <p class="mb-0">Parejas que viven en situación de violencia intrafamiliar</p>
        </div>

        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form method="POST" action="">
                @csrf

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label>N° de Caso</label>
                        <input type="text" name="nro_caso" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label>Nombres y Apellidos</label>
                        <input type="text" name="nombres_apellidos" class="form-control" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label>Observaciones</label>
                    <textarea name="observaciones" class="form-control" rows="2"></textarea>
                </div>

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
                        <tr>
                            <td><input type="text" name="grupo_familiar[0][nombre]" class="form-control"></td>
                            <td><input type="text" name="grupo_familiar[0][parentesco]" class="form-control"></td>
                            <td><input type="number" name="grupo_familiar[0][edad]" class="form-control"></td>
                            <td><input type="text" name="grupo_familiar[0][sexo]" class="form-control"></td>
                            <td><input type="text" name="grupo_familiar[0][grado]" class="form-control"></td>
                            <td><input type="text" name="grupo_familiar[0][estado_civil]" class="form-control"></td>
                            <td><input type="text" name="grupo_familiar[0][ocupacion]" class="form-control"></td>
                            <td><input type="text" name="grupo_familiar[0][lugar]" class="form-control"></td>
                            <td><input type="text" name="grupo_familiar[0][observacion]" class="form-control"></td>
                        </tr>
                    </tbody>
                </table>
                <button type="button" class="btn btn-outline-primary btn-sm" id="addRow">+ Agregar miembro</button>

                <h5 class="text-primary mt-4">Indicadores de Violencia - A nivel de pareja</h5>
                @php
                $indicadoresPareja = [
                    'Inadecuada comunicación (silencios, gritos, golpes, órdenes, comunicación de una sola vía)',
                    'Inequidad de roles',
                    'Crianza de los hijos no compartida en pareja',
                    'Tareas del hogar no compartido en pareja',
                    'Desvalorización del trabajo del hogar',
                    'Desvalorización de la pareja',
                    'Falta de expresión de sentimientos y emociones',
                    'Permisividad a la intromisión familiar',
                    'Falta de independencia económica en relación a las familias de origen',
                    'Relacionamiento violento en pareja',
                    'Falta de confianza',
                    'Inestabilidad emocional en la pareja',
                    'Falta de un proyecto de vida en común',
                    'Control excesivo hacia la pareja',
                    'Infidelidad y pérdida de respeto a la pareja',
                    'Falta de independencia en la toma de decisiones',
                    'No realizan actividades recreativas en familia'
                ];
                @endphp

                @foreach($indicadoresPareja as $indicador)
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="indicadores_pareja[]" value="{{ $indicador }}">
                        <label class="form-check-label">{{ $indicador }}</label>
                    </div>
                @endforeach

                <h5 class="text-primary mt-4">En relación a las hijas e hijos</h5>
                @php
                $indicadoresHijos = [
                    'Maltrato infantil (físico, psicológico, sexual, omisión)',
                    'Pérdida de autoridad sobre los hijos',
                    'Alienación parental',
                    'Discuten y ejercen violencia delante de los hijos',
                    'Irresponsabilidad paterna (económica, educativa o de protección)',
                    'Irresponsabilidad materna (descuidos, reproducción de la violencia)',
                    'Desigualdad en la crianza (preferencia por un hijo u otro)'
                ];
                @endphp

                @foreach($indicadoresHijos as $indicador)
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="indicadores_hijos[]" value="{{ $indicador }}">
                        <label class="form-check-label">{{ $indicador }}</label>
                    </div>
                @endforeach

                <h5 class="text-primary mt-4">Evaluación por fases al momento del ingreso</h5>
                <div class="mb-3">
                    <select class="form-select" name="fase">
                        <option value="">Seleccione fase</option>
                        <option>Primera Fase</option>
                        <option>Segunda Fase</option>
                        <option>Tercera Fase</option>
                        <option>Cuarta Fase</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label>Descripción</label>
                    <textarea name="descripcion_fase" class="form-control" rows="2"></textarea>
                </div>

                <div class="mb-3">
                    <label>Medidas a tomar</label>
                    <textarea name="medidas" class="form-control" rows="2"></textarea>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label>Fecha</label>
                        <input type="date" name="fecha" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label>Nombre y firma del responsable</label>
                        <input type="text" name="responsable" class="form-control">
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
    for (let i = 0; i < 9; i++) {
        const cell = row.insertCell(i);
        const names = ['nombre','parentesco','edad','sexo','grado','estado_civil','ocupacion','lugar','observacion'];
        cell.innerHTML = `<input type="text" name="grupo_familiar[${index}][${names[i]}]" class="form-control">`;
    }
});
</script>
@endsection
