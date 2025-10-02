@extends('layouts.sidebar')

@section('styles')
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
@endsection

@section('content')

    <div class="content-fluid mt-4">
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
                <a href="{{ route('users.index') }}" 
                   class="btn btn-lg text-white font-weight-bold"
                   style="background-color:#7EC544; border-radius:8px;">
                    Gestionar Usuarios
                </a>
            </div>
        @endif
    </div>
@endsection

@section('scripts')
<script>
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });
</script>
@endsection
