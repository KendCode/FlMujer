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
        }

        .form-control:focus {
            border-color: #037E8C;
            box-shadow: 0 0 0 0.2rem rgba(3, 126, 140, 0.25);
        }

        label {
            font-weight: 600;
            color: #037E8C;
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

        .btn-cancel {
            background-color: #9ca3af;
            border-color: #9ca3af;
        }

        .btn-cancel:hover {
            background-color: #6b7280;
            border-color: #6b7280;
        }

        .header-title {
            color: #037E8C;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .foto-preview {
            border-radius: 0.5rem;
            border: 2px solid #13C0E5;
            padding: 2px;
        }
    </style>
@endsection

@section('content')
    <div class="container py-5">
        <div class="card shadow-lg p-4 mx-auto" style="max-width: 700px;">
            <h2 class="text-center header-title">Editar Usuario</h2>

            <form action="{{ route('users.update', $user) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label>CI</label>
                    <input type="text" name="ci" value="{{ old('ci', $user->ci) }}" class="form-control" required>
                    @error('ci')
                        <p class="text-danger small">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-3">
                    <label>Nombre</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-control"
                        required>
                    @error('name')
                        <p class="text-danger small">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-3">
                    <label>Apellido</label>
                    <input type="text" name="apellido" value="{{ old('apellido', $user->apellido) }}"
                        class="form-control" required>
                    @error('apellido')
                        <p class="text-danger small">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-3">
                    <label>Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-control"
                        required>
                    @error('email')
                        <p class="text-danger small">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-3">
                    <label>Teléfono</label>
                    <input type="text" name="telefono" value="{{ old('telefono', $user->telefono) }}"
                        class="form-control">
                </div>

                <div class="mb-3">
                    <label>Dirección</label>
                    <input type="text" name="direccion" value="{{ old('direccion', $user->direccion) }}"
                        class="form-control">
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label>Fecha Nacimiento</label>
                        <input type="date" name="fecha_nacimiento"
                            value="{{ old('fecha_nacimiento', $user->fecha_nacimiento ? \Carbon\Carbon::parse($user->fecha_nacimiento)->format('Y-m-d') : '') }}"
                            class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label>Fecha Ingreso</label>
                        <input type="date" name="fecha_ingreso"
                            value="{{ old('fecha_ingreso', $user->fecha_ingreso ? \Carbon\Carbon::parse($user->fecha_ingreso)->format('Y-m-d') : '') }}"
                            class="form-control">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label>Rol</label>
                        <select name="rol" class="form-select" required>
                            <option value="administrador" {{ $user->rol == 'administrador' ? 'selected' : '' }}>
                                Administrador</option>
                            <option value="trabajadora_social" {{ $user->rol == 'trabajadora_social' ? 'selected' : '' }}>
                                Trabajadora Social</option>
                            <option value="abogado" {{ $user->rol == 'abogado' ? 'selected' : '' }}>Abogado</option>
                            <option value="psicologo" {{ $user->rol == 'psicologo' ? 'selected' : '' }}>Psicólogo</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label>Estado</label>
                        <select name="estado" class="form-select" required>
                            <option value="activo" {{ $user->estado == 'activo' ? 'selected' : '' }}>Activo</option>
                            <option value="inactivo" {{ $user->estado == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">
                            <i class="fas fa-lock me-1"></i>Nueva Contraseña (opcional)
                        </label>
                        <div class="input-group">
                            <input type="password" name="password" id="password" class="form-control password-input"
                                placeholder="Mínimo 8 caracteres">
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
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                class="form-control password-input" placeholder="Repita la contraseña">
                            <button type="button" class="password-toggle"
                                onclick="togglePassword('password_confirmation', this)">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label>Foto actual</label><br>
                    @if ($user->foto)
                        <img src="{{ asset('storage/' . $user->foto) }}" alt="Foto de perfil" width="120"
                            class="foto-preview">
                    @else
                        <p>No tiene foto</p>
                    @endif
                </div>

                <div class="mb-4">
                    <label>Nueva foto (opcional)</label>
                    <input type="file" name="foto" class="form-control">
                </div>

                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn btn-primary btn-lg">Actualizar</button>
                    <a href="{{ route('users.index') }}" class="btn btn-cancel btn-lg">Cancelar</a>
                </div>
            </form>
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
