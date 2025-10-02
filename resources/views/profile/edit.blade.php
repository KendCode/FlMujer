<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #F4F4F2;
            /* Blanco */
        }

        .navbar {
            background-color: #037E8C;
        }

        .navbar .nav-link,
        .navbar-brand {
            color: #F4F4F2 !important;
        }

        .navbar .nav-link:hover {
            color: #7EC544 !important;
        }

        .btn-custom {
            background-color: #13C0E5;
            color: #fff;
        }

        .btn-custom:hover {
            background-color: #037E8C;
            color: #fff;
        }

        .header {
            color: #037E8C;
            /* Verde botella */
        }

        .card-header {
            background-color: #7EC544;
            /* Verde */
            color: #fff;
            font-weight: bold;
            text-align: center;
        }

        .card {
            background-color: #fff;
            border-radius: 0.75rem;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
            transition: transform 0.2s ease-in-out;
        }

        .card:hover {
            transform: translateY(-4px);
        }

        .btn-custom {
            background-color: #13C0E5;
            /* Celeste */
            color: #fff;
            border: none;
            font-weight: 500;
        }

        .btn-custom:hover {
            background-color: #037E8C;
            /* Verde botella */
            color: #fff;
        }

        .img-custom {
            width: 80px;
            /* Foto más pequeña */
            height: 80px;
            object-fit: cover;
            border-radius: 50%;
            border: 3px solid #7EC544;
            /* Borde verde */
            margin-bottom: 15px;
        }
    </style>
</head>

<body>

    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="{{ route('dashboard') }}">Mi Fundación</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon" style="filter: invert(100%);"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('dashboard') ? 'fw-bold' : '' }}"
                            href="{{ route('dashboard') }}">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('profile.edit') }}">Perfil</a>
                    </li>
                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <a href="{{ route('logout') }}" class="nav-link"
                                onclick="event.preventDefault(); this.closest('form').submit();">Cerrar Sesión</a>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container py-5">

        <h2 class="text-center fw-bold header mb-4">Perfil de Usuario</h2>

        <div class="row justify-content-center g-4">
            <!-- 📸 Formulario para actualizar foto -->
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Actualizar Foto</div>
                    <div class="card-body text-center">
                        <img src="{{ Auth::user()->foto_url ?? asset('storage/fotos/default.jpg') }}"
                            alt="Foto de perfil" class="img-custom">

                        <form method="POST" action="{{ route('profile.update.photo') }}" enctype="multipart/form-data"
                            class="mt-3">
                            @csrf
                            @method('PATCH')
                            <input type="file" name="foto" id="foto" accept="image/*"
                                class="form-control mb-3">

                            @error('foto')
                                <p class="text-danger small">{{ $message }}</p>
                            @enderror

                            <button type="submit" class="btn btn-custom w-100">Actualizar Foto</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- 📝 Información de perfil -->
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header text-center">Información de Perfil</div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('profile.update') }}">
                            @csrf
                            @method('PATCH')

                            <!-- Nombre -->
                            <div class="mb-3">
                                <label for="name" class="form-label fw-semibold">Nombre</label>
                                <input type="text" id="name" name="name" class="form-control"
                                    value="{{ old('name', $user->name) }}" required autofocus>
                                @error('name')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="mb-3">
                                <label for="email" class="form-label fw-semibold">Correo electrónico</label>
                                <input type="email" id="email" name="email" class="form-control"
                                    value="{{ old('email', $user->email) }}" required>
                                @error('email')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror

                                <!-- Verificación de correo -->
                                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                                    <div class="mt-2">
                                        <p class="small text-muted">
                                            Tu correo aún no está verificado.
                                            <button type="submit" form="send-verification"
                                                class="btn btn-link p-0 small text-decoration-underline"
                                                style="color:#13C0E5;">
                                                Reenviar enlace de verificación
                                            </button>
                                        </p>

                                        @if (session('status') === 'verification-link-sent')
                                            <p class="small text-success fw-semibold">
                                                Se ha enviado un nuevo enlace a tu correo.
                                            </p>
                                        @endif
                                    </div>
                                @endif
                            </div>

                            <!-- Botón guardar -->
                            <div class="d-grid">
                                <button type="submit" class="btn btn-custom">
                                    <i class="bi bi-save me-1"></i> Guardar cambios
                                </button>
                            </div>

                            <!-- Mensaje de éxito -->
                            @if (session('status') === 'profile-updated')
                                <p class="text-success text-center mt-2 small">✅ Cambios guardados correctamente</p>
                            @endif
                        </form>
                    </div>
                </div>
            </div>


            <!-- 🔑 Cambiar contraseña -->
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header text-center">Cambiar Contraseña</div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('password.update') }}">
                            @csrf
                            @method('PUT')

                            <!-- Contraseña actual -->
                            <div class="mb-3">
                                <label for="current_password" class="form-label fw-semibold">Contraseña actual</label>
                                <input type="password" id="current_password" name="current_password"
                                    class="form-control" required autocomplete="current-password">
                                @error('current_password')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Nueva contraseña -->
                            <div class="mb-3">
                                <label for="password" class="form-label fw-semibold">Nueva contraseña</label>
                                <input type="password" id="password" name="password" class="form-control" required
                                    autocomplete="new-password">
                                @error('password')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Confirmar nueva contraseña -->
                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label fw-semibold">Confirmar nueva
                                    contraseña</label>
                                <input type="password" id="password_confirmation" name="password_confirmation"
                                    class="form-control" required autocomplete="new-password">
                                @error('password_confirmation')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Botón guardar -->
                            <div class="d-grid">
                                <button type="submit" class="btn btn-custom">
                                    <i class="bi bi-lock-fill me-1"></i> Actualizar Contraseña
                                </button>
                            </div>

                            <!-- Mensaje de éxito -->
                            @if (session('status') === 'password-updated')
                                <p class="text-success text-center mt-2 small">✅ Contraseña actualizada correctamente
                                </p>
                            @endif
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
