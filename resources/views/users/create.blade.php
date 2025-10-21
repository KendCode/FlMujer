@extends('layouts.sidebar')

@section('styles')
    <style>
        body {
            background-color: #F4F4F2;
            font-family: Arial, sans-serif;
        }
        .card {
            border-radius: 1rem;
            border: none;
        }
        .form-control:focus {
            border-color: #037E8C;
            box-shadow: 0 0 0 0.2rem rgba(3, 126, 140, 0.25);
        }
        .btn-primary {
            background-color: #13C0E5;
            border-color: #13C0E5;
        }
        .btn-primary:hover {
            background-color: #037E8C;
            border-color: #037E8C;
        }
        .btn-success {
            background-color: #7EC544;
            border-color: #7EC544;
        }
        .btn-success:hover {
            background-color: #037E8C;
            border-color: #037E8C;
        }
        label {
            font-weight: 500;
        }
    </style>
@endsection

@section('content')
    <div class="content py-5">
        <div class="card shadow-lg p-4 mx-auto" style="max-width: 1100px;">
            <h2 class="mb-4 text-center" style="color: #037E8C;">Crear Usuario</h2>
            <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- CI -->
                <div class="mb-3">
                    <label class="form-label">CI</label>
                    <input type="text" name="ci" class="form-control" required>
                </div>

                <!-- Nombre -->
                <div class="mb-3">
                    <label class="form-label">Nombre</label>
                    <input type="text" name="name" class="form-control" required>
                </div>

                <!-- Apellido -->
                <div class="mb-3">
                    <label class="form-label">Apellido</label>
                    <input type="text" name="apellido" class="form-control" required>
                </div>

                <!-- Email -->
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" required>
                </div>

                <!-- Teléfono -->
                <div class="mb-3">
                    <label class="form-label">Teléfono</label>
                    <input type="text" name="telefono" class="form-control">
                </div>

                <!-- Dirección -->
                <div class="mb-3">
                    <label class="form-label">Dirección</label>
                    <input type="text" name="direccion" class="form-control">
                </div>

                <!-- Fechas -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Fecha Nacimiento</label>
                        <input type="date" name="fecha_nacimiento" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Fecha Ingreso</label>
                        <input type="date" name="fecha_ingreso" class="form-control">
                    </div>
                </div>

                <!-- Contraseña -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Contraseña</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Confirmar Contraseña</label>
                        <input type="password" name="password_confirmation" class="form-control" required>
                    </div>
                </div>

                <!-- Rol -->
                <div class="mb-3">
                    <label class="form-label">Rol</label>
                    <select name="rol" class="form-select" required>
                        <option value="administrador">Administrador</option>
                        <option value="trabajadora_social">Trabajadora Social</option>
                        <option value="abogado">Abogado</option>
                        <option value="psicologo">Psicólogo</option>
                    </select>
                </div>

                <!-- Estado -->
                <div class="mb-3">
                    <label class="form-label">Estado</label>
                    <select name="estado" class="form-select">
                        <option value="activo">Activo</option>
                        <option value="inactivo">Inactivo</option>
                    </select>
                </div>

                <!-- Foto -->
                <div class="mb-3">
                    <label class="form-label">Foto de Perfil</label>
                    <input type="file" name="foto" class="form-control">
                </div>

                <!-- Botón -->
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary btn-lg">Guardar</button>
                </div>
            </form>
        </div>
    </div>
@endsection
