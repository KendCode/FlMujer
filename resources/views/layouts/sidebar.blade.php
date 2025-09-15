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

        /* ...existing code... */
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
    @php
        // Detectar el guard activo y obtener usuario
        if (Auth::guard('web')->check()) {
            $user = Auth::guard('web')->user();
            $guard = 'web';
        } elseif (Auth::guard('funcionario')->check()) {
            $user = Auth::guard('funcionario')->user();
            $guard = 'funcionario';
        } else {
            $user = null;
            $guard = null;
        }
    @endphp
    <!-- Sidebar -->
    <div class="border-right" id="sidebar-wrapper">
        <div class="profile">
            <img src="{{ asset('img/flm_blanco.png') }}" alt="Foto de Perfil" class="profile-img">
            <h5>{{ $user ? $user->name : 'Invitado' }}</h5>
        </div>
        <div class="list-group list-group-flush">
            <a href="{{ route('dashboard') }}" class="list-group-item">Panel principal</a>

            @if (Auth::user()->role_id == 1)
                {{-- 1 = admin --}}
                <a href="{{ route('funcionarios.index') }}" class="list-group-item">Funcionarios</a>
            @endif


            <a href="#" class="list-group-item">Consultas</a>
            <a href="#" class="list-group-item">Eventos</a>
            <a href="{{ route('profile.edit') }}" class="list-group-item">Configuración del Perfil</a>
            <a href="#" class="list-group-item"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                Cerrar Sesión
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
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
