@extends('layouts.sidebar')

@section('styles')
    <style>
        body {
            background: linear-gradient(135deg, #F4F4F2 0%, #e8e8e6 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
        }
        .content {
            padding: 2rem 1rem;
        }
        .card {
            border-radius: 1.5rem;
            border: none;
            background: #ffffff;
            box-shadow: 0 10px 40px rgba(3, 126, 140, 0.1);
        }
        .card-header {
            background: linear-gradient(135deg, #037E8C 0%, #13C0E5 100%);
            border-radius: 1.5rem 1.5rem 0 0;
            padding: 2rem;
            border: none;
        }
        .card-header h2 {
            color: #ffffff;
            font-weight: 600;
            margin: 0;
            font-size: 1.8rem;
        }
        .card-body {
            padding: 2.5rem;
        }
        .form-label {
            font-weight: 600;
            color: #037E8C;
            margin-bottom: 0.5rem;
            font-size: 0.95rem;
        }
        .form-control, .form-select {
            border: 2px solid #e0e0e0;
            border-radius: 0.75rem;
            padding: 0.75rem 1rem;
            transition: all 0.3s ease;
            font-size: 0.95rem;
        }
        .form-control:focus, .form-select:focus {
            border-color: #13C0E5;
            box-shadow: 0 0 0 0.25rem rgba(19, 192, 229, 0.15);
            background-color: #f8feff;
        }
        .form-control:hover, .form-select:hover {
            border-color: #13C0E5;
        }
        .input-group {
            position: relative;
        }
        .password-toggle {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #037E8C;
            z-index: 10;
            padding: 0.5rem;
            background: none;
            border: none;
            transition: color 0.3s ease;
        }
        .password-toggle:hover {
            color: #13C0E5;
        }
        .password-input {
            padding-right: 3rem;
        }
        .btn-primary {
            background: linear-gradient(135deg, #13C0E5 0%, #037E8C 100%);
            border: none;
            border-radius: 0.75rem;
            padding: 1rem 2rem;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(19, 192, 229, 0.3);
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, #037E8C 0%, #025a66 100%);
            box-shadow: 0 6px 20px rgba(3, 126, 140, 0.4);
            transform: translateY(-2px);
        }
        .section-divider {
            border-top: 2px solid #F4F4F2;
            margin: 2rem 0;
            position: relative;
        }
        .section-divider::after {
            content: '';
            position: absolute;
            top: -2px;
            left: 0;
            width: 60px;
            height: 2px;
            background: linear-gradient(90deg, #13C0E5, #7EC544);
        }
        .section-title {
            color: #037E8C;
            font-weight: 600;
            font-size: 1.1rem;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
        }
        .section-title::before {
            content: '';
            width: 4px;
            height: 24px;
            background: linear-gradient(180deg, #13C0E5, #7EC544);
            border-radius: 2px;
            margin-right: 0.75rem;
        }
        .mb-3 {
            margin-bottom: 1.5rem !important;
        }
        input[type="file"]::file-selector-button {
            background: linear-gradient(135deg, #7EC544 0%, #6ab038 100%);
            color: white;
            border: none;
            padding: 0.5rem 1.5rem;
            border-radius: 0.5rem;
            cursor: pointer;
            font-weight: 600;
            margin-right: 1rem;
            transition: all 0.3s ease;
        }
        input[type="file"]::file-selector-button:hover {
            background: linear-gradient(135deg, #6ab038 0%, #5a9630 100%);
            transform: translateY(-1px);
        }
        .form-select {
            cursor: pointer;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%23037E8C' d='M6 9L1 4h10z'/%3E%3C/svg%3E");
        }
    </style>
@endsection

@section('content')
    <div class="content">
        <div class="card mx-auto" style="max-width: 1100px;">
            <div class="card-header">
                <h2 class="text-center">
                    <i class="fas fa-user-plus me-2"></i>Crear Nuevo Usuario
                </h2>
            </div>
            <div class="card-body">
                <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- Información Personal -->
                    <div class="section-title">Información Personal</div>
                    
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="form-label">
                                <i class="fas fa-id-card me-1"></i>CI
                            </label>
                            <input type="text" name="ci" class="form-control" required placeholder="Ej: 1234567">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">
                                <i class="fas fa-user me-1"></i>Nombre
                            </label>
                            <input type="text" name="name" class="form-control" required placeholder="Nombre completo">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">
                                <i class="fas fa-user me-1"></i>Apellido
                            </label>
                            <input type="text" name="apellido" class="form-control" required placeholder="Apellidos">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">
                                <i class="fas fa-envelope me-1"></i>Email
                            </label>
                            <input type="email" name="email" class="form-control" required placeholder="correo@ejemplo.com">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">
                                <i class="fas fa-phone me-1"></i>Teléfono
                            </label>
                            <input type="text" name="telefono" class="form-control" placeholder="Ej: +591 12345678">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">
                            <i class="fas fa-map-marker-alt me-1"></i>Dirección
                        </label>
                        <input type="text" name="direccion" class="form-control" placeholder="Dirección completa">
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">
                                <i class="fas fa-birthday-cake me-1"></i>Fecha de Nacimiento
                            </label>
                            <input type="date" name="fecha_nacimiento" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">
                                <i class="fas fa-calendar-check me-1"></i>Fecha de Ingreso
                            </label>
                            <input type="date" name="fecha_ingreso" class="form-control">
                        </div>
                    </div>

                    <div class="section-divider"></div>

                    <!-- Seguridad -->
                    <div class="section-title">Seguridad y Acceso</div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">
                                <i class="fas fa-lock me-1"></i>Contraseña
                            </label>
                            <div class="input-group">
                                <input type="password" name="password" id="password" class="form-control password-input" required placeholder="Mínimo 8 caracteres">
                                <button type="button" class="password-toggle" onclick="togglePassword('password', this)">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">
                                <i class="fas fa-lock me-1"></i>Confirmar Contraseña
                            </label>
                            <div class="input-group">
                                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control password-input" required placeholder="Repita la contraseña">
                                <button type="button" class="password-toggle" onclick="togglePassword('password_confirmation', this)">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">
                                <i class="fas fa-user-tag me-1"></i>Rol
                            </label>
                            <select name="rol" class="form-select" required>
                                <option value="">Seleccione un rol</option>
                                <option value="administrador">Administrador</option>
                                <option value="trabajadora_social">Trabajadora Social</option>
                                <option value="abogado">Abogado</option>
                                <option value="psicologo">Psicólogo</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">
                                <i class="fas fa-toggle-on me-1"></i>Estado
                            </label>
                            <select name="estado" class="form-select">
                                <option value="activo">Activo</option>
                                <option value="inactivo">Inactivo</option>
                            </select>
                        </div>
                    </div>

                    <div class="section-divider"></div>

                    <!-- Foto de Perfil -->
                    <div class="section-title">Foto de Perfil</div>
                    
                    <div class="mb-4">
                        <label class="form-label">
                            <i class="fas fa-camera me-1"></i>Seleccionar Foto
                        </label>
                        <input type="file" name="foto" class="form-control" accept="image/*">
                        <small class="text-muted">Formatos permitidos: JPG, PNG, GIF (Máx. 2MB)</small>
                    </div>

                    <!-- Botón de Envío -->
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-save me-2"></i>Guardar Usuario
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function togglePassword(inputId, button) {
            const input = document.getElementById(inputId);
            const icon = button.querySelector('i');
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
    </script>
@endsection