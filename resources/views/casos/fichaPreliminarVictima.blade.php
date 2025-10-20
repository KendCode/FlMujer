{{-- resources/views/casos/create.blade.php --}}
@extends('layouts.sidebar') {{-- o tu layout --}}

@section('content')
<div class="container mt-4">
    <h3 class="text-primary mb-4">Ficha de Evaluación Preliminar - Mujeres Víctimas de Violencia Intrafamiliar</h3>

    <form action="" method="POST">
        @csrf

        {{-- Número de caso --}}
        <div class="mb-3 row">
            <label for="nro_caso" class="col-sm-2 col-form-label">Nro. Caso:</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" id="nro_caso" name="nro_caso" value="{{ old('nro_caso') }}">
            </div>
        </div>

        {{-- Datos de la víctima --}}
        <div class="mb-3">
            <label for="nombres_apellidos" class="form-label">Nombres y Apellidos</label>
            <input type="text" class="form-control" id="nombres_apellidos" name="nombres_apellidos" value="{{ old('nombres_apellidos') }}">
        </div>

        <div class="mb-3 row">
            <div class="col-md-6">
                <label for="emergencia_nombre" class="form-label">En caso de emergencia comunicarse con:</label>
                <input type="text" class="form-control" id="emergencia_nombre" name="emergencia_nombre" value="{{ old('emergencia_nombre') }}">
            </div>
            <div class="col-md-3">
                <label for="emergencia_telefono" class="form-label">Telf.</label>
                <input type="text" class="form-control" id="emergencia_telefono" name="emergencia_telefono" value="{{ old('emergencia_telefono') }}">
            </div>
            <div class="col-md-3">
                <label for="emergencia_parentesco" class="form-label">Parentesco</label>
                <input type="text" class="form-control" id="emergencia_parentesco" name="emergencia_parentesco" value="{{ old('emergencia_parentesco') }}">
            </div>
        </div>

        {{-- Grupo familiar --}}
        <h5 class="mt-4">Grupo familiar</h5>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nombres y Apellidos</th>
                    <th>Parentesco</th>
                    <th>Edad</th>
                    <th>Sexo</th>
                    <th>Grado de Instrucción</th>
                    <th>Estado Civil</th>
                    <th>Ocupación</th>
                    <th>Lugar trabajo/estudio</th>
                    <th>Observaciones</th>
                </tr>
            </thead>
            <tbody>
                @for ($i = 0; $i < 5; $i++)
                <tr>
                    <td><input type="text" class="form-control" name="grupo_familiar[{{ $i }}][nombre]" value="{{ old("grupo_familiar.$i.nombre") }}"></td>
                    <td><input type="text" class="form-control" name="grupo_familiar[{{ $i }}][parentesco]" value="{{ old("grupo_familiar.$i.parentesco") }}"></td>
                    <td><input type="number" class="form-control" name="grupo_familiar[{{ $i }}][edad]" value="{{ old("grupo_familiar.$i.edad") }}"></td>
                    <td>
                        <select class="form-select" name="grupo_familiar[{{ $i }}][sexo]">
                            <option value="">Seleccione</option>
                            <option value="M" {{ old("grupo_familiar.$i.sexo") == 'M' ? 'selected' : '' }}>M</option>
                            <option value="F" {{ old("grupo_familiar.$i.sexo") == 'F' ? 'selected' : '' }}>F</option>
                        </select>
                    </td>
                    <td><input type="text" class="form-control" name="grupo_familiar[{{ $i }}][grado]" value="{{ old("grupo_familiar.$i.grado") }}"></td>
                    <td><input type="text" class="form-control" name="grupo_familiar[{{ $i }}][estado_civil]" value="{{ old("grupo_familiar.$i.estado_civil") }}"></td>
                    <td><input type="text" class="form-control" name="grupo_familiar[{{ $i }}][ocupacion]" value="{{ old("grupo_familiar.$i.ocupacion") }}"></td>
                    <td><input type="text" class="form-control" name="grupo_familiar[{{ $i }}][lugar]" value="{{ old("grupo_familiar.$i.lugar") }}"></td>
                    <td><input type="text" class="form-control" name="grupo_familiar[{{ $i }}][observaciones]" value="{{ old("grupo_familiar.$i.observaciones") }}"></td>
                </tr>
                @endfor
            </tbody>
        </table>

        {{-- Indicadores de violencia --}}
        <h5 class="mt-4">Indicadores de violencia</h5>
        <div class="mb-3">
            <h6>a) En relación a la toma de decisiones</h6>
            @php
                $indicadores_decision = [
                    'Tiene miedo a las amenazas',
                    'Dependiente emocional y económicamente',
                    'Larga historia de victimización',
                    'No decide sobre las relaciones sexuales',
                    'No expresa sus opiniones por temor',
                    'No considera alternativas, ni consecuencias',
                    'No toma decisiones',
                    'Niega su realidad justifica VIF',
                    'Idealización de su pareja',
                    'No decide sobre nro. de hijos',
                    'Muestra inseguridad',
                    'Ambivalencia en las decisiones'
                ];
            @endphp
            @foreach($indicadores_decision as $indicador)
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="indicadores_decision[]" value="{{ $indicador }}" id="decision_{{ $loop->index }}">
                <label class="form-check-label" for="decision_{{ $loop->index }}">
                    {{ $indicador }}
                </label>
            </div>
            @endforeach
        </div>

        <div class="mb-3">
            <h6>b) En relación a su persona</h6>
            @php
                $indicadores_persona = [
                    'Baja autoestima',
                    'Sentimiento de culpa',
                    'Desvalorización como mujer',
                    'Muestra depresión',
                    'No tiene proyecto de vida',
                    'Idealización del amor que todo lo da y nada recibe',
                    'Reproduce violencia en el hogar',
                    'Presenta desarreglo personal',
                    'Aislamiento',
                    'Sentimiento de miedo y desprotección',
                    'Pensamientos y/o intentos de suicidio',
                    'Miedo a enfrentar la vida sola',
                    'Problemas de salud',
                    'No expresa afecto',
                    'Espera que su agresor cambie'
                ];
            @endphp
            @foreach($indicadores_persona as $indicador)
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="indicadores_persona[]" value="{{ $indicador }}" id="persona_{{ $loop->index }}">
                <label class="form-check-label" for="persona_{{ $loop->index }}">
                    {{ $indicador }}
                </label>
            </div>
            @endforeach
        </div>

        <div class="mb-3">
            <h6>c) En relación a sus derechos</h6>
            @php
                $indicadores_derechos = [
                    'No denuncia la violencia sufrida',
                    'Conoce sus DDHH, no los defiende',
                    'Solo denuncia',
                    'Tolera la violencia',
                    'Desconoce ley 348',
                    'Falta de información sobre su DDHH',
                    'No reconoce VIF como problema social',
                    'Vuelve o continúa con su agresor',
                    'Abandona proceso o denuncia',
                    'No hace cumplir acuerdos o garantías'
                ];
            @endphp
            @foreach($indicadores_derechos as $indicador)
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="indicadores_derechos[]" value="{{ $indicador }}" id="derechos_{{ $loop->index }}">
                <label class="form-check-label" for="derechos_{{ $loop->index }}">
                    {{ $indicador }}
                </label>
            </div>
            @endforeach
        </div>

        {{-- Evaluación por fases --}}
        <h5 class="mt-4">Evaluación por fases al momento del ingreso</h5>
        @php
            $fases = ['Primera Fase', 'Segunda Fase', 'Tercera Fase', 'Cuarta Fase'];
        @endphp
        @foreach($fases as $index => $fase)
        <div class="mb-3">
            <label class="form-label">{{ $fase }}</label>
            <textarea class="form-control" name="fases[{{ $index }}]" rows="2">{{ old("fases.$index") }}</textarea>
        </div>
        @endforeach

        {{-- Observaciones y medidas a tomar --}}
        <div class="mb-3">
            <label class="form-label">Observaciones</label>
            <textarea class="form-control" name="observaciones" rows="2">{{ old('observaciones') }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Medidas a tomar</label>
            <textarea class="form-control" name="medidas" rows="2">{{ old('medidas') }}</textarea>
        </div>

        {{-- Fecha y firma --}}
        <div class="mb-3 row">
            <div class="col-md-3">
                <label class="form-label">Fecha</label>
                <input type="date" class="form-control" name="fecha" value="{{ old('fecha') }}">
            </div>
            <div class="col-md-9">
                <label class="form-label">Nombre y firma de la persona que recepcionó el caso</label>
                <input type="text" class="form-control" name="recepcion" value="{{ old('recepcion') }}">
            </div>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Guardar</button>
        <a href="{{route('casos.index')}}" class="btn btn-danger mt-3">Volver</a>
        
    </form>
</div>
@endsection
