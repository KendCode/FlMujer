<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fundación Levántate Mujer - Iniciar Sesión</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #7ac943;
            /* Verde de tu ejemplo */
        }

        .login-container {
            max-width: 400px;
            margin: 80px auto;
            background: #fff;
            border-radius: 15px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            padding: 30px;
            text-align: center;
        }

        .login-container img {
            max-width: 100px;
            margin-bottom: 15px;
        }

        .login-container h4 {
            color: #007b8f;
            font-weight: bold;
        }

        .btn-login {
            background: #00aaff;
            color: #fff;
            font-weight: bold;
        }

        .btn-login:hover {
            background: #008ecc;
        }

        .error-msg {
            color: red;
            font-size: 0.9em;
            margin-top: 10px;
        }
    </style>
</head>

<body>

    <div class="login-container">
        <!-- Logo -->
        <img src="{{ asset('img/flm_color.png') }}" alt="Logo Fundación">

        <!-- Título -->
        <h4>Inicia sesión en tu cuenta</h4>

        <!-- Formulario -->
        <form method="POST" action="{{ route('login') }}">
            @csrf

            {{-- Mostrar errores generales --}}
            @if ($errors->any())
                <div class="alert alert-danger text-start">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <!-- Usuario -->
            <div class="mb-3 text-start">
                <label for="email" class="form-label">Correo electrónico</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}"
                    required autofocus>
               
            </div>

            <!-- Contraseña -->
            <div class="mb-3 text-start">
                <label for="password" class="form-label">Contraseña</label>
                <input type="password" class="form-control" id="password" name="password" required>
                @error('password')
                    <div class="error-msg">{{ $message }}</div>
                @enderror
            </div>

            <!-- Recordarme -->
            <div class="mb-3 form-check text-start">
                <input type="checkbox" class="form-check-input" id="remember" name="remember">
                <label class="form-check-label" for="remember">Recordarme</label>
            </div>

            <!-- Botón -->
            <button type="submit" class="btn btn-login w-100">Iniciar sesión</button>

            <!-- Enlace para olvidar contraseña -->
            <div class="mt-3">
                <a href="{{ route('password.request') }}" class="text-decoration-none">Olvidaste tu contraseña?</a>
            </div>

            <!-- Mensaje de error general -->
            @if (session('error'))
                <div class="error-msg">
                    {{ session('error') }}
                </div>
            @endif
        </form>
    </div>

</body>

</html>
