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
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        padding: 2rem;
    }
    .form-control:focus {
        border-color: #037E8C;
        box-shadow: 0 0 0 0.2rem rgba(3,126,140,0.25);
    }
    .btn-primary {
        background-color: #037E8C;
        border-color: #037E8C;
    }
    .btn-primary:hover {
        background-color: #025F66;
        border-color: #025F66;
    }
    .form-check-input:checked {
        background-color: #037E8C;
        border-color: #037E8C;
    }
</style>
@endsection

@section('content')
<div class="container mt-5">
    <div class="card mx-auto" style="max-width: 800px;">
        <h3 class="mb-4 text-center">Crear Ficha de Consulta</h3>

        <form action="{{ route('fichasConsulta.store') }}" method="POST">
            @csrf

            <!-- Datos del paciente -->
            <h5>Datos del Paciente</h5>
            <div class="mb-3">
                <label for="ci" class="form-label">CI</label>
                <input type="text" class="form-control" id="ci" name="ci" maxlength="9" required>
            </div>
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" maxlength="100" required>
            </div>
            <div class="mb-3">
                <label for="apPaterno" class="form-label">Apellido Paterno</label>
                <input type="text" class="form-control" id="apPaterno" name="apPaterno" maxlength="100" required>
            </div>
            <div class="mb-3">
                <label for="apMaterno" class="form-label">Apellido Materno</label>
                <input type="text" class="form-control" id="apMaterno" name="apMaterno" maxlength="100">
            </div>
            <div class="mb-3">
                <label for="numCelular" class="form-label">Número de Celular</label>
                <input type="text" class="form-control" id="numCelular" name="numCelular" maxlength="8">
            </div>

            <!-- Datos de la consulta -->
            <h5 class="mt-4">Datos de la Consulta</h5>
            <div class="mb-3">
                <label for="fecha" class="form-label">Fecha</label>
                <input type="date" class="form-control" id="fecha" name="fecha" required>
            </div>
            <div class="mb-3">
                <label for="instDeriva" class="form-label">Institución que deriva</label>
                <input type="text" class="form-control" id="instDeriva" name="instDeriva" maxlength="150">
            </div>
            <div class="mb-3">
                <label for="testimonio" class="form-label">Testimonio</label>
                <textarea class="form-control" id="testimonio" name="testimonio" rows="3"></textarea>
            </div>

            <!-- Problemática -->
            <h5 class="mt-4">Problemática</h5>
            <div class="mb-3">
                <label for="tipo" class="form-label">Tipo</label>
                <input type="text" class="form-control" id="tipo" name="tipo" maxlength="100" required>
            </div>
            <div class="mb-3">
                <label for="subTipo" class="form-label">Subtipo</label>
                <input type="text" class="form-control" id="subTipo" name="subTipo" maxlength="100">
            </div>
            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción</label>
                <textarea class="form-control" id="descripcion" name="descripcion" rows="3"></textarea>
            </div>

            <!-- Orientación interna -->
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

            <button type="submit" class="btn btn-primary w-100">Guardar Ficha</button>
        </form>
    </div>
</div>
@endsection
