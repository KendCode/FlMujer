@extends('layouts.sidebar')

@section('content')
    <div class="container py-4">
        <h3 class="mb-3 text-center">Ficha de Evaluación Preliminar - Hombres Generadores de Violencia</h3>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="" method="POST">
            @csrf

            <div class="row g-3 mb-3">
                <div class="col-md-4">
                    <label class="form-label">Nro. Caso</label>
                    <input type="text" name="nro_registro" class="form-control" value="{{ old('nro_registro') }}">
                </div>
                <div class="col-md-8">
                    <label class="form-label">Nombres y apellidos</label>
                    <input type="text" name="nombre_completo" class="form-control" value="{{ old('nombre_completo') }}"
                        required>
                </div>
            </div>

            <div class="row g-3 mb-3">
                <div class="col-md-5">
                    <label class="form-label">En caso de emergencia comunicarse con:</label>
                    <input type="text" name="contacto_emergencia" class="form-control"
                        value="{{ old('contacto_emergencia') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Telf.</label>
                    <input type="text" name="telf_emergencia" class="form-control" value="{{ old('telf_emergencia') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Parentesco</label>
                    <input type="text" name="relacion_emergencia" class="form-control"
                        value="{{ old('relacion_emergencia') }}">
                </div>
            </div>

            <!-- Grupo familiar dinámico -->
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

            <!-- Evaluación por fases -->
            <h5 class="mt-4">I. Evaluación por fases al momento del ingreso</h5>
            <div class="mb-3">
                <label class="form-label">Primera fase - Descripción</label>
                <textarea name="fase[primera]" class="form-control" rows="2">{{ old('fase.primera') }}</textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Segunda fase - Descripción</label>
                <textarea name="fase[segunda]" class="form-control" rows="2">{{ old('fase.segunda') }}</textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Tercera fase - Descripción</label>
                <textarea name="fase[tercera]" class="form-control" rows="2">{{ old('fase.tercera') }}</textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Cuarta fase - Descripción</label>
                <textarea name="fase[cuarta]" class="form-control" rows="2">{{ old('fase.cuarta') }}</textarea>
            </div>
            <!-- Observaciones generales -->
            <div class="mb-3">
                <label class="form-label">Observaciones</label>
                <textarea name="observaciones" class="form-control" rows="3">{{ old('observaciones') }}</textarea>
            </div>
            <!-- Indicadores -->
            <h5 class="mt-4">Indicadores de violencia</h5>

            <div class="card mb-3">
                <div class="card-body">
                    <strong>a) En relación a su persona</strong>
                    <div class="row">
                        @php
                            $a = [
                                'Es muy irritable se enoja con facilidad',
                                'Justifica la violencia',
                                'Dependencia emocional',
                                'Inestabilidad emocional familiar',
                                'No expresa sus sentimientos se reprime',
                                'No tiene proyecto de vida',
                                'Intentos de suicidio',
                                'Maltrato infantil en la infancia',
                                'Carencia afectiva paterna/materna',
                                'Conducta dominante - autoritaria',
                                'No reconoce la violencia, la naturaliza',
                                'Niega la violencia',
                                'Dependencia económica',
                                'Consume alcohol/drogas',
                                'Muestra inseguridad e indecisión',
                                'Desvalorización, baja autoestima',
                                'Descuido de la salud personal',
                            ];
                        @endphp
                        @foreach ($a as $idx => $item)
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="indicadores[]"
                                        value="a_{{ $idx }}" id="a_{{ $idx }}">
                                    <label class="form-check-label"
                                        for="a_{{ $idx }}">{{ $item }}</label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="card mb-3">
                <div class="card-body">
                    <strong>b) En relación con su pareja e hijos y familiares</strong>
                    @php
                        $b = [
                            'Ejerce violencia contra los hijos',
                            'Ejerce violencia con familiares (de la pareja, de él)',
                            'Ejerce violencia extrema',
                            'Desvalorización de la mujer (como un objeto)',
                            'Indolente al dolor de la mujer',
                            'Daño a animales',
                            'Irresponsabilidad paterna',
                            'Pensamiento y estructura machista',
                            'Sexualidad no responsable',
                            'Control excesivo a su pareja',
                            'Celos enfermizos',
                            'No existe vínculo afectivo con los hijos',
                            'Ejerce violencia contra su pareja (física/psicológica/sexual/económica/patrimonial)',
                        ];
                    @endphp
                    <div class="row">
                        @foreach ($b as $idx => $item)
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="indicadores[]"
                                        value="b_{{ $idx }}" id="b_{{ $idx }}">
                                    <label class="form-check-label"
                                        for="b_{{ $idx }}">{{ $item }}</label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="card mb-3">
                <div class="card-body">
                    <strong>c) En relación a las normas legales</strong>
                    @php
                        $c = [
                            'Desconoce la ley 348',
                            'Fue denunciado por instancias legales/judiciales',
                            'No respeta la autoridad (normas y reglas)',
                            'No cumple acuerdos transaccionales',
                            'Inicia proceso / denuncia por represalia',
                            'Desconocimiento sobre género/violencia intrafamiliar/masculinidades',
                        ];
                    @endphp
                    <div class="row">
                        @foreach ($c as $idx => $item)
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="indicadores[]"
                                        value="c_{{ $idx }}" id="c_{{ $idx }}">
                                    <label class="form-check-label"
                                        for="c_{{ $idx }}">{{ $item }}</label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>


            <!-- Observaciones generales -->
            <div class="mb-3">
                <label class="form-label">Medidas a tomar:</label>
                <textarea name="medidasTomar" class="form-control" rows="3">{{ old('medidasTomar') }}</textarea>
            </div>

            <!-- Firma / fecha -->
            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label">Fecha</label>
                    <input type="date" class="form-control" name="fecha" value="{{ date('Y-m-d') }}">
                </div>
                <div class="col-md-8 d-flex align-items-end">
                    <div>
                        <label class="form-label">Nombre y firma de la persona que recepcionó el caso</label>
                        <input class="form-control" name="recepcionador" />
                    </div>
                </div>
            </div>

            <button class="btn btn-success" type="submit">Guardar caso</button>
        </form>
    </div>

    <!-- Scripts: añadir/remover filas dinámicas -->

    <script>
        document.getElementById('addRow').addEventListener('click', () => {
            const table = document.getElementById('grupoFamiliar');
            const index = table.rows.length;
            const row = table.insertRow();
            for (let i = 0; i < 9; i++) {
                const cell = row.insertCell(i);
                const names = ['nombre', 'parentesco', 'edad', 'sexo', 'grado', 'estado_civil', 'ocupacion',
                    'lugar', 'observacion'
                ];
                cell.innerHTML =
                    `<input type="text" name="grupo_familiar[${index}][${names[i]}]" class="form-control">`;
            }
        });
    </script>
@endsection
