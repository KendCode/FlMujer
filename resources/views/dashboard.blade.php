<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fundación Levántate Mujer - Panel</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #F4F4F2;
        }

        #sidebar-wrapper {
            min-height: 100vh;
            background-color: #7EC544;
        }

        #sidebar-wrapper .list-group-item {
            background-color: #7EC544;
            color: #F4F4F2;
            border: none;
        }

        #sidebar-wrapper .list-group-item:hover {
            background-color: #037E8C;
            color: #fff;
        }

        .profile {
            padding: 20px;
            text-align: center;
            background-color: #037E8C;
            color: #fff;
        }

        .profile-img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            margin-bottom: 10px;
            border: 2px solid #fff;
            object-fit: cover;
        }

        .navbar {
            background-color: #F4F4F2 !important;
        }

        .card-custom {
            color: #F4F4F2;
            border: none;
        }

        .logo {
            width: 80px;
            height: auto;
        }

        #wrapper.toggled #sidebar-wrapper {
            margin-left: -250px;
            transition: margin 0.3s;
        }

        #sidebar-wrapper {
            width: 250px;
            transition: margin 0.3s;
        }

        #page-content-wrapper {
            width: 100%;
        }
    </style>
</head>

<body>
    <div class="d-flex" id="wrapper">

        <!-- Sidebar -->
        <div id="sidebar-wrapper">
            <div class="profile">
                <img src="{{ Auth::user()->foto_url }}" alt="Foto de {{ Auth::user()->name }}" class="profile-img">
                <h5>{{ Auth::user()->name }} {{ Auth::user()->apellido }}</h5>
                <p class="mb-0">Rol: <span
                        class="font-weight-bold text-warning">{{ ucfirst(Auth::user()->rol) }}</span></p>
            </div>

            <div class="list-group list-group-flush">
                <a href="{{ route('dashboard') }}" class="list-group-item">Inicio</a>
                <a href="{{ route('users.index') }}" class="list-group-item">Usuarios</a>
                <a href="#" class="list-group-item">Pacientes</a>
                <a href="#" class="list-group-item">Consultas</a>
                <a href="#" class="list-group-item">Eventos</a>
                <a href="{{ route('profile.edit') }}" class="list-group-item">Configuración Perfil</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a href="{{ route('logout') }}" class="list-group-item list-group-item-action"
                        onclick="event.preventDefault(); this.closest('form').submit();">
                        Cerrar Sesión
                    </a>
                </form>

            </div>
        </div>

        <!-- Contenido -->
        <div id="page-content-wrapper">
            <nav class="navbar navbar-expand-lg border-bottom">
                <button class="btn btn-outline-success" id="menu-toggle">☰</button>
                <div class="ml-auto">
                    <img src="{{ asset('img/flm_color.png') }}" alt="Logo" class="logo">
                </div>
            </nav>

            <div class="container-fluid mt-4">
                <div class="jumbotron py-4 text-center" style="background-color:#7EC544; color:#F4F4F2;">
                    <h1 class="display-5">¡Bienvenido/a, {{ Auth::user()->name }}!</h1>
                    <p class="lead">Has iniciado sesión correctamente.</p>
                </div>

                <!-- Tarjetas -->
                <div class="row">
                    <div class="col-md-4">
                        <div class="card card-custom mb-4" style="background-color:#13C0E5;">
                            <div class="card-body text-center">
                                <h3 class="card-title">Pacientes</h3>
                                <p>Gestión y seguimiento de pacientes registrados.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card card-custom mb-4" style="background-color:#037E8C;">
                            <div class="card-body text-center">
                                <h3 class="card-title">Consultas</h3>
                                <p>Revisión de consultas psicológicas y legales.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card card-custom mb-4" style="background-color:#7EC544;">
                            <div class="card-body text-center">
                                <h3 class="card-title">Eventos</h3>
                                <p>Organización de talleres y actividades de apoyo.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Link solo administrador -->
                @if (Auth::user()->rol === 'administrador')
                    <div class="text-center mt-4">
                        <a href="{{ route('users.index') }}" class="btn btn-lg text-white font-weight-bold"
                            style="background-color:#7EC544; border-radius:8px;">
                            Gestionar Usuarios
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $("#menu-toggle").click(function(e) {
            e.preventDefault();
            $("#wrapper").toggleClass("toggled");
        });
    </script>
</body>

</html>
