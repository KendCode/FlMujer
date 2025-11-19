<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Fundación Levántate Mujer - Panel</title>

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">


    <!-- Estilos propios -->
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
            width: 80px;
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
            margin-left: 250px;
            transition: all 0.3s ease;
            width: 100%;
            z-index: 1;
            position: relative;
        }

        #wrapper.toggled #page-content-wrapper {
            margin-left: 80px;
        }

        .logo {
            width: 80px;
            height: auto;
        }

        .custom-select {
            background-color: #7EC544;
            color: #fff;
            border: none;
            padding: 12px 15px;
        }

        .custom-select:focus {
            background-color: #037E8C;
            color: #fff;
            outline: none;
        }

        /* 🔥 Asegurar que los dropdowns estén arriba */
        .dropdown-menu {
            z-index: 2000 !important;
        }

        /* Responsive */
        @media (max-width: 768px) {
            #sidebar-wrapper {
                left: -250px;
            }

            #wrapper.toggled #sidebar-wrapper {
                left: 0;
                width: 250px;
            }

            #page-content-wrapper {
                margin-left: 0 !important;
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
                <p class="mb-0">Rol: <span
                        class="font-weight-bold text-warning">{{ ucfirst(Auth::user()->rol) }}</span></p>
            </div>
            <div class="list-group list-group-flush">
                <a href="{{ route('dashboard') }}" class="list-group-item"><i
                        class="fas fa-home"></i><span>Inicio</span></a>
                <a href="{{ route('users.index') }}" class="list-group-item"><i class="fas fa-users"></i><span>Lista de
                        Usuarios</span></a>
                <a href="{{ route('fichasConsulta.index') }}" class="list-group-item"><i
                        class="fas fa-comments"></i><span>Formulario de Consultas</span></a>
                <!-- En layouts/sidebar.blade.php -->
                <!-- Dropdown navegación estilo sidebar (solo para ADMINISTRADOR) -->
                @auth
                    @if (Auth::user()->rol === 'administrador')
                        <div class="dropdown w-100">
                            <button class="list-group-item list-group-item-action dropdown-toggle text-start w-100"
                                type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-cogs"></i> Página Web
                            </button>
                            <ul class="dropdown-menu w-100" aria-labelledby="dropdownMenuButton">
                                <li>
                                    <a class="list-group-item-action dropdown-item"
                                        href="{{ route('admin.carousels.index') }}">
                                        <i class="fas fa-images"></i> Carrusel de imágenes
                                    </a>
                                </li>
                                <li>
                                    <a class="list-group-item-action dropdown-item"
                                        href="{{ route('admin.contenidos.index') }}">
                                        <i class="fas fa-file-alt"></i> Gestión de contenidos
                                    </a>
                                </li>
                                <li>
                                    <a class="list-group-item-action dropdown-item"
                                        href="{{ route('admin.actividades.index') }}">
                                        <i class="fas fa-tasks"></i> Actividades
                                    </a>
                                </li>
                                <li>
                                    <a class="list-group-item-action dropdown-item"
                                        href="{{ route('admin.testimonios.index') }}">
                                        <i class="fas fa-comments"></i> Testimonios
                                    </a>
                                </li>
                            </ul>
                        </div>
                    @endif
                @endauth


                <a href="{{ route('casos.index') }}" class="list-group-item">
                    <i class="fas fa-calendar-alt"></i><span>Situación de Violencia intrafamiliar</span></a>
                <!-- 🔔 Gestión de Citas -->
                @auth
                    @if (Auth::user()->rol === 'administrador')
                        <a href="{{ route('citas.index') }}" class="list-group-item">
                            <i class="fas fa-calendar-check"></i>
                            <span>Control de Citas</span>
                        </a>
                    @elseif (Auth::user()->rol === 'psicologo')
                        <a href="{{ route('citas.index') }}" class="list-group-item">
                            <i class="fas fa-calendar-alt"></i>
                            <span>Mis Citas</span>
                        </a>
                    @endif
                @endauth

                <a href="{{ route('reportes.index') }}" class="list-group-item">
                    <i class="fas fa-chart-bar"></i> Reportes
                </a>
                <a href="{{ route('profile.edit') }}" class="list-group-item"><i
                        class="fas fa-cog"></i><span>Configuración Perfil</span></a>

                <!-- Botón de cerrar sesión -->
                <form method="POST" action="{{ route('logout') }}" id="logout-form">
                    @csrf
                    <a href="#" class="list-group-item" data-bs-toggle="modal"
                        data-bs-target="#confirmLogoutModal">
                        <i class="fas fa-sign-out-alt"></i> <span>Cerrar Sesión</span>
                    </a>
                </form>
            </div>
        </div>

        <!-- Contenido -->
        <div id="page-content-wrapper">
            <nav class="navbar navbar-expand-lg border-bottom">
                <button class="btn btn-outline-success" id="menu-toggle">☰</button>
                <div class="ms-auto">
                    <img src="{{ asset('img/flm_color.png') }}" alt="Logo" class="logo">
                </div>
            </nav>

            <div class="container-fluid mt-4">
                @yield('content')
            </div>
        </div>
    </div>
    <!-- Modal de confirmación -->
    <div class="modal fade" id="confirmLogoutModal" tabindex="-1" aria-labelledby="confirmLogoutModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-3">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="confirmLogoutModalLabel">Confirmar cierre de sesión</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    ¿Está seguro de que desea cerrar sesión?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-danger" id="confirmLogoutBtn">Cerrar sesión</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.getElementById("menu-toggle").addEventListener("click", function(e) {
            e.preventDefault();
            document.getElementById("wrapper").classList.toggle("toggled");
        });

        // Manejar el cierre de sesión con confirmación
        document.getElementById('confirmLogoutBtn').addEventListener('click', function() {
            document.getElementById('logout-form').submit();
        });
    </script>
</body>

</html>
