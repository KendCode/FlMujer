<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>

    <title>@yield('title')</title>
    <style>
        body {
            background-color: #F4F4F2;
        }

        .navbar {
            background-color: #037E8C;
        }

        .nav-link {
            color: white !important;
        }

        .nav-link:hover {
            background-color: #13C0E5;
            border-radius: 5px;
        }

        .navbar-brand {
            color: white !important;
        }

        .navbar-toggler {
            border: none !important;
            box-shadow: none !important;
            background: transparent !important;
            outline: none !important;
        }

        .toggler-custom {
            display: block;
            width: 30px;
            height: 3px;
            background: white;
            position: relative;
        }

        .toggler-custom::before,
        .toggler-custom::after {
            content: '';
            position: absolute;
            width: 30px;
            height: 3px;
            background: white;
            left: 0;
        }

        .toggler-custom::before {
            top: -8px;
        }

        .toggler-custom::after {
            top: 8px;
        }

        .footer {
            background-color: #037E8C;
        }

        .card-title {
            color: #7EC544;
        }
    </style>
</head>

<body class="d-flex flex-column min-vh-100">
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark">
            <div class="container-fluid">
                <a class="navbar-brand d-flex align-items-center" href="/">
                    <img src="{{ asset('img/flm_blanco.png') }}" alt="Logo" class="me-2" width="80">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="toggler-custom"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="/">Principal</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('contacto') }}" class="nav-link">Contacto</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('testimonios') }}" class="nav-link">Testimonio</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('actividades') }}" class="nav-link">Actividades</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('login') }}" class="nav-link">Iniciar Sesión</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('register') }}" class="nav-link">Registrarse</a>
                        </li>
                    </ul>

                    <!-- 🔹 Ícono de usuario solo para funcionarios -->
                    {{-- <ul class="navbar-nav ms-auto">
                        @auth
                            <!-- Si ya está logueado -->
                            <li class="nav-item">
                                <a href="{{ route('dashboard') }}" class="nav-link">
                                    <i class="fa-solid fa-user-circle"></i>
                                </a>
                            </li>
                        @endauth

                        @guest
                            @php
                                // Buscar si hay un funcionario con el último correo usado
                                $funcionario = \App\Models\User::where('email', session('last_email'))->first();
                            @endphp
                            @if($funcionario)
                                <li class="nav-item">
                                    <a href="{{ route('login') }}" class="nav-link">
                                        <i class="fa-solid fa-user"></i>
                                    </a>
                                </li>
                            @endif
                        @endguest
                    </ul> --}}
                </div>
            </div>
        </nav>
    </header>

    @yield('content')

    <footer class="py-4 footer">
        <div class="container text-center">
            <h5 class="mb-3 fw-bold" style="color: #7EC544;">Fundación Levántate Mujer</h5>
            <div class="mb-3">
                <a href="#" class="text-decoration-none me-3" style="color: #F4F4F2;">Inicio</a>
                <a href="#" class="text-decoration-none me-3" style="color: #F4F4F2;">Servicios</a>
                <a href="#" class="text-decoration-none" style="color: #F4F4F2;">Contacto</a>
            </div>

            <div class="d-flex justify-content-center gap-3 mb-3 mt-3">
                <a href="https://facebook.com" target="_blank" class="btn btn-light rounded-circle"
                    style="background-color: #13C0E5; color: white;">
                    <i class="fab fa-facebook-f"></i>
                </a>
                <a href="https://twitter.com" target="_blank" class="btn btn-light rounded-circle"
                    style="background-color: #7EC544; color: white;">
                    <i class="fab fa-twitter"></i>
                </a>
                <a href="https://instagram.com" target="_blank" class="btn btn-light rounded-circle"
                    style="background-color: #F4F4F2; color: #037E8C;">
                    <i class="fab fa-instagram"></i>
                </a>
                <a href="https://linkedin.com" target="_blank" class="btn btn-light rounded-circle"
                    style="background-color: #13C0E5; color: white;">
                    <i class="fab fa-linkedin-in"></i>
                </a>
                <a href="https://youtube.com" target="_blank" class="btn btn-light rounded-circle"
                    style="background-color: #7EC544; color: white;">
                    <i class="fab fa-youtube"></i>
                </a>
            </div>

            <small style="color: #F4F4F2;">© 2025 FLM Todos los derechos reservados.</small><br>
            <small style="color: #13C0E5;">Bryan Kender Mendoza Canaviri</small>
        </div>
    </footer>

</body>
</html>
