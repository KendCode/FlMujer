<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fundación Levántate Mujer - Panel</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Inyecta estilos de la vista -->
    @yield('styles')
    @stack('styles')
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #F4F4F2;
        }

        #wrapper {
            display: flex;
            width: 100%;
        }

        /* Sidebar */
        #sidebar-wrapper {
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            width: 250px;
            background-color: #7EC544;
            transition: all 0.3s ease;
            overflow-x: hidden;
            z-index: 1000;
        }

        #wrapper.toggled #sidebar-wrapper {
            width: 80px; /* Sidebar reducido */
        }

        /* Perfil */
        #sidebar-wrapper .profile {
            text-align: center;
            padding: 20px;
            background-color: #037E8C;
            color: #fff;
        }

        #sidebar-wrapper .profile-img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            margin-bottom: 10px;
            border: 2px solid #fff;
            object-fit: cover;
            transition: all 0.3s ease;
        }

        #wrapper.toggled .profile-img {
            width: 50px;
            height: 50px;
            margin-bottom: 0;
        }

        #sidebar-wrapper .profile h5,
        #sidebar-wrapper .profile p {
            transition: opacity 0.3s ease;
        }

        #wrapper.toggled .profile h5,
        #wrapper.toggled .profile p {
            opacity: 0;
        }

        /* Items */
        #sidebar-wrapper .list-group-item {
            background-color: #7EC544;
            color: #F4F4F2;
            border: none;
            display: flex;
            align-items: center;
            padding: 12px 15px;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        #sidebar-wrapper .list-group-item:hover {
            background-color: #037E8C;
            color: #fff;
        }

        #sidebar-wrapper .list-group-item i {
            min-width: 30px;
            text-align: center;
            font-size: 20px;
        }

        #wrapper.toggled .list-group-item span {
            display: none;
        }

        /* Contenido */
        #page-content-wrapper {
            flex: 1;
            margin-left: 250px; /* Empuja el contenido a la derecha */
            transition: all 0.3s ease;
            width: 100%;
        }

        #wrapper.toggled #page-content-wrapper {
            margin-left: 80px; /* Ajuste cuando sidebar se reduce */
        }

        .logo {
            width: 80px;
            height: auto;
        }

        /* Responsive */
        @media (max-width: 768px) {
            #sidebar-wrapper {
                left: -250px; /* Oculto por defecto */
            }

            #wrapper.toggled #sidebar-wrapper {
                left: 0; /* Se muestra sobre el contenido */
                width: 250px;
            }

            #page-content-wrapper {
                margin-left: 0 !important; /* En móviles no empuja contenido */
            }
        }
    </style>
</head>

<body>
    <div id="wrapper">
        <!-- Sidebar -->
        <div id="sidebar-wrapper">
            <div class="profile">
                <img src="{{ Auth::user()->foto_url }}" alt="Foto de {{ Auth::user()->name }}" class="profile-img">
                <h5>{{ Auth::user()->name }} {{ Auth::user()->apellido }}</h5>
                <p class="mb-0">Rol: <span class="font-weight-bold text-warning">{{ ucfirst(Auth::user()->rol) }}</span></p>
            </div>
            <div class="list-group list-group-flush">
                <a href="{{ route('dashboard') }}" class="list-group-item"><i class="fas fa-home"></i><span>Inicio</span></a>
                <a href="{{ route('users.index') }}" class="list-group-item"><i class="fas fa-users"></i><span>Usuarios</span></a>
                <a href="#" class="list-group-item"><i class="fas fa-user-md"></i><span>Pacientes</span></a>
                <a href="#" class="list-group-item"><i class="fas fa-comments"></i><span>Consultas</span></a>
                <a href="#" class="list-group-item"><i class="fas fa-calendar-alt"></i><span>Eventos</span></a>
                <a href="{{ route('profile.edit') }}" class="list-group-item"><i class="fas fa-cog"></i><span>Configuración Perfil</span></a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a href="{{ route('logout') }}" class="list-group-item" onclick="event.preventDefault(); this.closest('form').submit();">
                        <i class="fas fa-sign-out-alt"></i><span>Cerrar Sesión</span>
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
                @yield('content')
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
