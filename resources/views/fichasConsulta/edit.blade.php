@extends('layouts.sidebar')

@section('styles')
    <style>
        body {
            background-color: #F4F4F2;
            font-family: Arial, sans-serif;
        }

        .card {
            border-radius: 1.5rem;
            border: none;
            background-color: #fff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 2rem;
        }

        .btn-primary {
            background-color: #037E8C;
            border-color: #037E8C;
        }

        .btn-primary:hover {
            background-color: #025F66;
            border-color: #025F66;
        }
    </style>
@endsection

@section('content')
    <div class="container mt-5">
        <div class="card">
            <h3 class="mb-4">Editar Ficha de Consulta</h3>

            <form action="{{ route('fichasConsulta.update', $ficha->idFicha) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="ci" class="form-label">CI</label>
                        <input type="text" name="ci" id="ci" class="form-control"
                            value="{{ old('ci', $ficha->ci) }}" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" name="nombre" id="nombre" class="form-control"
                            value="{{ old('nombre', $ficha->nombre) }}" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="apPaterno" class="form-label">Apellido Paterno</label>
                        <input type="text" name="apPaterno" id="apPaterno" class="form-control"
                            value="{{ old('apPaterno', $ficha->apPaterno) }}" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="apMaterno" class="form-label">Apellido Materno</label>
                        <input type="text" name="apMaterno" id="apMaterno" class="form-control"
                            value="{{ old('apMaterno', $ficha->apMaterno) }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="numCelular" class="form-label">Número de Celular</label>
                        <input type="text" name="numCelular" id="numCelular" class="form-control"
                            value="{{ old('numCelular', $ficha->numCelular) }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="fecha" class="form-label">Fecha</label>
                        <input type="date" name="fecha" id="fecha" class="form-control"
                            value="{{ old('fecha', $ficha->fecha->format('Y-m-d')) }}" required>

                    </div>

                    <div class="col-md-12 mb-3">
                        <label for="instDeriva" class="form-label">Institución que Deriva</label>
                        <input type="text" name="instDeriva" id="instDeriva" class="form-control"
                            value="{{ old('instDeriva', $ficha->instDeriva) }}">
                    </div>

                    <div class="col-md-12 mb-3">
                        <label for="testimonio" class="form-label">Testimonio</label>
                        <textarea name="testimonio" id="testimonio" class="form-control">{{ old('testimonio', $ficha->testimonio) }}</textarea>
                    </div>
                </div>

                <!-- Problemática Penal -->
                <div class="mb-3">
                    <label class="form-label">Problemática Penal</label><br>
                    @php
                        $penales = [
                            'Violación',
                            'Estupro',
                            'Abuso Deshonesto',
                            'Lesiones',
                            'Abandono Familiar',
                            'Violencia Física',
                            'Otro',
                        ];
                        $selectedPenal = $ficha->Penal ?? [];
                    @endphp
                    @foreach ($penales as $p)
                        <div class="form-check form-check-inline">
                            <input type="checkbox" name="Penal[]" value="{{ $p }}" class="form-check-input"
                                {{ in_array($p, $selectedPenal) ? 'checked' : '' }}>
                            <label class="form-check-label">{{ $p }}</label>
                        </div>
                    @endforeach
                </div>

                <!-- Problemática Familiar -->
                <div class="mb-3">
                    <label class="form-label">Problemática Familiar</label><br>
                    @php
                        $familiares = [
                            'Divorcio',
                            'Asistencia Familiar',
                            'Reconocimiento Paternidad',
                            'Tenencia de Hijos',
                            'Otro',
                        ];
                        $selectedFamiliar = $ficha->Familiar ?? [];
                    @endphp
                    @foreach ($familiares as $f)
                        <div class="form-check form-check-inline">
                            <input type="checkbox" name="Familiar[]" value="{{ $f }}" class="form-check-input"
                                {{ in_array($f, $selectedFamiliar) ? 'checked' : '' }}>
                            <label class="form-check-label">{{ $f }}</label>
                        </div>
                    @endforeach
                </div>

                <!-- Otros Problemas -->
                <div class="mb-3">
                    <label for="OtrosProblemas" class="form-label">Otros Problemas</label>
                    <textarea name="OtrosProblemas" id="OtrosProblemas" class="form-control">{{ old('OtrosProblemas', $ficha->OtrosProblemas) }}</textarea>
                </div>

                <!-- Orientación interna -->
                <div class="mb-3">
                    <label class="form-label">Orientación Interna</label><br>
                    <div class="form-check form-check-inline">
                        <input type="checkbox" name="legal" value="1" class="form-check-input"
                            {{ $ficha->legal ? 'checked' : '' }}>
                        <label class="form-check-label">Legal</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input type="checkbox" name="social" value="1" class="form-check-input"
                            {{ $ficha->social ? 'checked' : '' }}>
                        <label class="form-check-label">Social</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input type="checkbox" name="psicologico" value="1" class="form-check-input"
                            {{ $ficha->psicologico ? 'checked' : '' }}>
                        <label class="form-check-label">Psicológico</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input type="checkbox" name="espiritual" value="1" class="form-check-input"
                            {{ $ficha->espiritual ? 'checked' : '' }}>
                        <label class="form-check-label">Espiritual</label>
                    </div>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('fichasConsulta.index') }}" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-primary">Actualizar</button>
                </div>
            </form>
        </div>
    </div>
@endsection
