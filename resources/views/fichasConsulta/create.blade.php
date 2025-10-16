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

        .form-control {
            border: 1px solid #7EC544;
        }

        .form-control:focus {
            border-color: #13C0E5;
            box-shadow: 0 0 0 0.2rem rgba(19, 192, 229, 0.25);
        }

        .btn-primary {
            background-color: #13C0E5;
            border-color: #13C0E5;
        }

        .btn-primary:hover {
            background-color: #0F9BC3;
            border-color: #0F9BC3;
        }

        .btn-cancel {
            background-color: #FF6B6B;
            border-color: #FF6B6B;
            color: white;
        }

        .btn-cancel:hover {
            background-color: #FF4C4C;
            border-color: #FF4C4C;
        }

        .form-check-input:checked {
            background-color: #7EC544;
            border-color: #7EC544;
        }

        .form-check-label {
            color: #037E8C;
        }

        h5 {
            color: #037E8C;
        }

        .row {
            display: flex;
            flex-wrap: wrap;
        }

        .col {
            flex: 1;
            min-width: 250px;
            margin-right: 20px;
        }

        .col:last-child {
            margin-right: 0;
        }

        .button-group {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }
    </style>
@endsection

@section('content')
    <div class="container mt-4">
        <div class="card mx-auto" style="max-width: 800rem;">
            <h3 class="mb-4 text-center">Crear Ficha de Consulta</h3>

            <form action="{{ route('fichasConsulta.store') }}" method="POST">
                @csrf

                <h5>Datos del Paciente</h5>
                <div class="row">
                    <div class="col mb-3">
                        <label for="ci" class="form-label">CI</label>
                        <input type="text" class="form-control" id="ci" name="ci" maxlength="9" required>
                    </div>
                    <div class="col mb-3">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" maxlength="100" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col mb-3">
                        <label for="apPaterno" class="form-label">Apellido Paterno</label>
                        <input type="text" class="form-control" id="apPaterno" name="apPaterno" maxlength="100" required>
                    </div>
                    <div class="col mb-3">
                        <label for="apMaterno" class="form-label">Apellido Materno</label>
                        <input type="text" class="form-control" id="apMaterno" name="apMaterno" maxlength="100">
                    </div>
                </div>
                <div class="row">
                    <div class="col mb-3">
                        <label for="numCelular" class="form-label">Número de Celular</label>
                        <input type="text" class="form-control" id="numCelular" name="numCelular" maxlength="8">
                    </div>
                </div>

                <h5 class="mt-4">Datos de la Consulta</h5>
                <div class="row">
                    <div class="col mb-3">
                        <label for="fecha" class="form-label">Fecha</label>
                        <input type="date" class="form-control" id="fecha" name="fecha" required>
                    </div>
                    <div class="col mb-3">
                        <label for="instDeriva" class="form-label">Institución que deriva</label>
                        <input type="text" class="form-control" id="instDeriva" name="instDeriva" maxlength="150">
                    </div>
                </div>
                <div class="mb-3">
                    <label for="testimonio" class="form-label">Testimonio</label>
                    <textarea class="form-control" id="testimonio" name="testimonio" rows="3"></textarea>
                </div>

                <h5 class="mt-4">Problemática</h5>
                <div class="form-group">
                    <label>Problemas Penales</label><br>
                    <input type="checkbox" name="Penal[]" value="Violacion"> Violación <br>
                    <input type="checkbox" name="Penal[]" value="Estupro"> Estupro <br>
                    <input type="checkbox" name="Penal[]" value="Abuso Deshonesto"> Abuso Deshonesto <br>
                    <input type="checkbox" name="Penal[]" value="Lesiones"> Lesiones <br>
                    <input type="checkbox" name="Penal[]" value="Abandono Familiar"> Abandono Familiar <br>
                    <input type="checkbox" name="Penal[]" value="Violencia Fisica"> Violencia Física <br>
                    <input type="checkbox" name="Penal[]" value="Otro"> Otro <br>
                </div>

                <div class="form-group">
                    <label>Problemas Familiares</label><br>
                    <input type="checkbox" name="Familiar[]" value="Divorcio"> Divorcio <br>
                    <input type="checkbox" name="Familiar[]" value="Asistencia Familiar"> Asistencia Familiar <br>
                    <input type="checkbox" name="Familiar[]" value="Reconocimiento Paternidad"> Reconocimiento de Paternidad <br>
                    <input type="checkbox" name="Familiar[]" value="Tenencia de Hijos"> Tenencia de Hijos <br>
                    <input type="checkbox" name="Familiar[]" value="Otro"> Otro <br>
                </div>

                <div class="form-group">
                    <label>Otros Problemas</label>
                    <textarea name="OtrosProblemas" class="form-control"></textarea>
                </div>

                <h5 class="mt-4">Orientación Interna</h5>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="legal" name="legal">
                    <label class="form-check-label" for="legal">Legal</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="social" name="social">
                    <label class="form-check-label" for="social">Social</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="psicologico" name="psicologico">
                    <label class="form-check-label" for="psicologico">Psicológico</label>
                </div>
                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" id="espiritual" name="espiritual">
                    <label class="form-check-label" for="espiritual">Espiritual</label>
                </div>

                <div class="button-group">
                    <button type="submit" class="btn btn-primary">Guardar Ficha</button>
                    <a href="{{ route('fichasConsulta.index') }}" class="btn btn-cancel">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
@endsection