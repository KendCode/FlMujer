@extends('layouts.sidebar')

@section('styles')
<style>
    body {
        background-color: #F4F4F2;
        font-family: Arial, sans-serif;
    }

    h3, h5 {
        color: #037E8C;
    }

    .card {
        border-radius: 12px;
        border: none;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        background-color: #F4F4F2;
    }

    .card-header {
        background: linear-gradient(135deg, #7EC544 0%, #13C0E5 100%);
        color: white;
    }

    .form-label {
        font-weight: 500;
        color: #037E8C;
    }

    .table thead {
        background-color: #13C0E5;
        color: white;
    }

    .table tbody tr:nth-child(even) {
        background-color: #F4F4F2;
    }

    .form-control:focus {
        border-color: #7EC544;
        box-shadow: 0 0 0 0.2rem rgba(126, 197, 68, 0.25);
    }

    .btn-outline-primary {
        border-color: #037E8C;
        color: #037E8C;
    }

    .btn-outline-primary:hover {
        background-color: #037E8C;
        color: white;
    }

    .btn-success {
        background-color: #7EC544;
        border-color: #7EC544;
    }

    .btn-success:hover {
        background-color: #037E8C;
        border-color: #037E8C;
    }

    .btn-secondary {
        background-color: #13C0E5;
        border-color: #13C0E5;
        color: white;
    }

    .btn-secondary:hover {
        background-color: #037E8C;
        border-color: #037E8C;
        color: white;
    }

    .alert-success {
        background-color: #7EC544;
        color: white;
        border: none;
    }

    .form-check-label {
        color: #037E8C;
    }

    .card .form-check-input:checked {
        background-color: #7EC544;
        border-color: #037E8C;
    }
</style>
@endsection

@section('content')
<div class="container py-4">
    <div class="card shadow-lg mb-4">
        <div class="card-header text-center">
            <h4>Ficha de Evaluación Preliminar</h4>
            <p class="mb-0">Hombres Generadores de Violencia</p>
        </div>
        <div class="card-body">

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form
                action="{{ isset($ficha) && $ficha && $ficha->id
                    ? route('casos.fichaPreliminarAgresor.update', ['caso' => $caso->id, 'ficha' => $ficha->id])
                    : route('casos.guardarFichaPreliminarAgresor', $caso->id) }}"
                method="POST">
                @csrf
                @if (isset($ficha) && $ficha && $ficha->id)
                    @method('PUT')
                @endif

                <div class="row g-3 mb-3">
                    <div class="col-md-4">
                        <label class="form-label">Nro. Caso</label>
                        <input type="text" name="nro_registro" class="form-control" value="{{ $caso->nro_registro }}" readonly>
                    </div>
                    <div class="col-md-8">
                        <label class="form-label">Nombres y apellidos</label>
                        <input type="text" name="nombre_completo" class="form-control"
                            value="{{ $caso->paciente_nombres }} {{ $caso->paciente_ap_paterno }} {{ $caso->paciente_ap_materno }}"
                            readonly>
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-5">
                        <label class="form-label">En caso de emergencia comunicarse con:</label>
                        <input type="text" name="contacto_emergencia" class="form-control"
                            value="{{ old('contacto_emergencia', $ficha->contacto_emergencia ?? '') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Telf.</label>
                        <input type="text" name="telf_emergencia" class="form-control"
                            value="{{ old('telf_emergencia', $ficha->telf_emergencia ?? '') }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Parentesco</label>
                        <input type="text" name="relacion_emergencia" class="form-control"
                            value="{{ old('relacion_emergencia', $ficha->relacion_emergencia ?? '') }}">
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
                        @php
                            $grupo = isset($ficha) && $ficha && isset($ficha->grupo_familiar)
                                ? $ficha->grupo_familiar
                                : [['nombre'=>'','parentesco'=>'','edad'=>'','sexo'=>'','grado'=>'','estado_civil'=>'','ocupacion'=>'','lugar'=>'','observacion'=>'']];
                        @endphp
                        @foreach ($grupo as $i => $miembro)
                            <tr>
                                <td><input type="text" name="grupo_familiar[{{ $i }}][nombre]" class="form-control" value="{{ old("grupo_familiar.$i.nombre", $miembro['nombre'] ?? '') }}"></td>
                                <td><input type="text" name="grupo_familiar[{{ $i }}][parentesco]" class="form-control" value="{{ old("grupo_familiar.$i.parentesco", $miembro['parentesco'] ?? '') }}"></td>
                                <td><input type="number" name="grupo_familiar[{{ $i }}][edad]" class="form-control" value="{{ old("grupo_familiar.$i.edad", $miembro['edad'] ?? '') }}"></td>
                                <td><input type="text" name="grupo_familiar[{{ $i }}][sexo]" class="form-control" value="{{ old("grupo_familiar.$i.sexo", $miembro['sexo'] ?? '') }}"></td>
                                <td><input type="text" name="grupo_familiar[{{ $i }}][grado]" class="form-control" value="{{ old("grupo_familiar.$i.grado", $miembro['grado'] ?? '') }}"></td>
                                <td><input type="text" name="grupo_familiar[{{ $i }}][estado_civil]" class="form-control" value="{{ old("grupo_familiar.$i.estado_civil", $miembro['estado_civil'] ?? '') }}"></td>
                                <td><input type="text" name="grupo_familiar[{{ $i }}][ocupacion]" class="form-control" value="{{ old("grupo_familiar.$i.ocupacion", $miembro['ocupacion'] ?? '') }}"></td>
                                <td><input type="text" name="grupo_familiar[{{ $i }}][lugar]" class="form-control" value="{{ old("grupo_familiar.$i.lugar", $miembro['lugar'] ?? '') }}"></td>
                                <td><input type="text" name="grupo_familiar[{{ $i }}][observacion]" class="form-control" value="{{ old("grupo_familiar.$i.observacion", $miembro['observacion'] ?? '') }}"></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <button type="button" class="btn btn-outline-primary btn-sm mb-3" id="addRow">+ Agregar miembro</button>

                <!-- Evaluación por fases -->
                <h5 class="mt-4">I. Evaluación por fases al momento del ingreso</h5>
                @foreach(['primera','segunda','tercera','cuarta'] as $fase)
                    <div class="mb-3">
                        <label class="form-label">{{ ucfirst($fase) }} fase - Descripción</label>
                        <textarea name="fase[{{ $fase }}]" class="form-control" rows="2">{{ old("fase.$fase", $ficha->{"fase_$fase"} ?? '') }}</textarea>
                    </div>
                @endforeach

                <div class="mb-3">
                    <label class="form-label">Observaciones</label>
                    <textarea name="observaciones" class="form-control" rows="3">{{ old('observaciones', $ficha->observaciones ?? '') }}</textarea>
                </div>

                <!-- Indicadores -->
                <h5 class="mt-4">Indicadores de violencia</h5>

                @foreach(['a'=>'En relación a su persona','b'=>'En relación con su pareja e hijos y familiares','c'=>'En relación a las normas legales'] as $key=>$titulo)
                    <div class="card mb-3">
                        <div class="card-body">
                            <strong>{{ $key }}) {{ $titulo }}</strong>
                            @php
                                $items = [];
                                if($key=='a') $items = ['Es muy irritable se enoja con facilidad','Justifica la violencia','Dependencia emocional','Inestabilidad emocional familiar','No expresa sus sentimientos se reprime','No tiene proyecto de vida','Intentos de suicidio','Maltrato infantil en la infancia','Carencia afectiva paterna/materna','Conducta dominante - autoritaria','No reconoce la violencia, la naturaliza','Niega la violencia','Dependencia económica','Consume alcohol/drogas','Muestra inseguridad e indecisión','Desvalorización, baja autoestima','Descuido de la salud personal'];
                                if($key=='b') $items = ['Ejerce violencia contra los hijos','Ejerce violencia con familiares (de la pareja, de él)','Ejerce violencia extrema','Desvalorización de la mujer (como un objeto)','Indolente al dolor de la mujer','Daño a animales','Irresponsabilidad paterna','Pensamiento y estructura machista','Sexualidad no responsable','Control excesivo a su pareja','Celos enfermizos','No existe vínculo afectivo con los hijos','Ejerce violencia contra su pareja (física/psicológica/sexual/económica/patrimonial)'];
                                if($key=='c') $items = ['Desconoce la ley 348','Fue denunciado por instancias legales/judiciales','No respeta la autoridad (normas y reglas)','No cumple acuerdos transaccionales','Inicia proceso / denuncia por represalia','Desconocimiento sobre género/violencia intrafamiliar/masculinidades'];
                                $seleccionados = old('indicadores',$ficha->indicadores ?? []);
                            @endphp
                            <div class="row">
                                @foreach($items as $idx=>$item)
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="indicadores[]" value="{{ $key.'_'.$idx }}" id="{{ $key.'_'.$idx }}" {{ in_array($key.'_'.$idx,$seleccionados)?'checked':'' }}>
                                            <label class="form-check-label" for="{{ $key.'_'.$idx }}">{{ $item }}</label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach

                <!-- Medidas a tomar -->
                <div class="mb-3">
                    <label class="form-label">Medidas a tomar:</label>
                    <textarea name="medidasTomar" class="form-control" rows="3">{{ old('medidasTomar', $ficha->medidas_tomar ?? '') }}</textarea>
                </div>

                <!-- Firma / fecha -->
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label">Fecha</label>
                        <input type="date" class="form-control" name="fecha"
                            value="{{ old('fecha', isset($ficha) && $ficha ? ($ficha->fecha ? $ficha->fecha->format('Y-m-d') : date('Y-m-d')) : date('Y-m-d')) }}">
                    </div>
                    <div class="col-md-8 d-flex align-items-end">
                        <div>
                            <label class="form-label">Nombre y firma de la persona que recepcionó el caso</label>
                            <input class="form-control" name="recepcionador" value="{{ old('recepcionador', $ficha->recepcionador ?? '') }}" />
                        </div>
                    </div>
                </div>

                <!-- Botones de acción -->
                <div class="d-flex gap-2 mb-4">
                    <button class="btn btn-success" type="submit">
                        <i class="bi bi-save"></i>
                        {{ isset($ficha) && $ficha && $ficha->id ? 'Actualizar ficha' : 'Guardar ficha' }}
                    </button>
                    <a href="{{ route('casos.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i>
                        Volver
                    </a>
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
            const inputType = names[i]==='edad'?'number':'text';
            cell.innerHTML = `<input type="${inputType}" name="grupo_familiar[${index}][${names[i]}]" class="form-control">`;
        }
    });
</script>
@endsection
