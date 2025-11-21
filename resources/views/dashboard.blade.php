@extends('layouts.sidebar')

@section('styles')
<style>
    body {
        font-family: 'Segoe UI', Arial, sans-serif;
        background-color: #F4F4F2;
    }

    /* SIDEBAR */
    #sidebar-wrapper {
        min-height: 100vh;
        background-color: #7EC544;
        padding-top: 20px;
        transition: all .3s ease;
        box-shadow: 3px 0 10px rgba(0,0,0,0.15);
    }

    #sidebar-wrapper .list-group-item {
        background-color: transparent;
        color: #F4F4F2;
        border: none;
        padding: 15px 20px;
        font-size: 16px;
        transition: all .2s;
    }

    #sidebar-wrapper .list-group-item:hover {
        background-color: #037E8C;
        color: #FFFFFF;
        border-radius: 6px;
    }

    .profile {
        padding: 25px;
        text-align: center;
        background: #037E8C;
        color: white;
        border-radius: 10px;
        margin: 10px 15px;
    }

    .profile-img {
        width: 90px;
        height: 90px;
        border-radius: 50%;
        border: 3px solid white;
        object-fit: cover;
        margin-bottom: 10px;
    }

    /* NAVBAR */
    .navbar {
        background-color: #F4F4F2 !important;
        border-bottom: 2px solid #e0e0e0;
    }

    /* HEADER */
    .jumbotron {
        background: linear-gradient(135deg, #7EC544, #13C0E5);
        border-radius: 12px;
        padding: 40px 20px;
        color: #FFF;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    /* CARDS */
    .card-custom {
        border: none;
        color: #FFF;
        border-radius: 12px;
        padding: 25px 15px;
        box-shadow: 0px 4px 12px rgba(0,0,0,0.12);
        transition: transform .15s ease, box-shadow .2s ease;
    }

    .card-custom:hover {
        transform: translateY(-4px);
        box-shadow: 0px 6px 18px rgba(0,0,0,0.18);
    }

    /* RESPONSIVE SIDEBAR */
    #wrapper.toggled #sidebar-wrapper {
        margin-left: -250px;
    }

    #sidebar-wrapper {
        width: 250px;
    }

    #page-content-wrapper {
        width: 100%;
    }

    /* BOTÓN ADMIN */
    .btn-admin {
        background-color: #7EC544;
        color: #FFF;
        padding: 12px 30px;
        border-radius: 10px;
        font-size: 18px;
        transition: .2s ease;
        font-weight: bold;
    }

    .btn-admin:hover {
        background-color: #037E8C;
        color: #FFF;
        transform: translateY(-2px);
    }
</style>
@endsection

@section('content')

<div class="content-fluid mt-4">

    <!-- Encabezado -->
    <div class="jumbotron text-center">
        <h1 class="display-6 fw-bold">¡Bienvenido/a, {{ Auth::user()->name }}!</h1>
        <p class="lead">Has iniciado sesión correctamente.</p>
    </div>

    <!-- Tarjetas -->
    <div class="row mt-4">

        <div class="col-md-4">
            <div class="card card-custom mb-4" style="background-color:#13C0E5;">
                <h3 class="card-title text-center">Pacientes</h3>
                <p class="text-center mt-2">Gestión y seguimiento de pacientes registrados.</p>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card card-custom mb-4" style="background-color:#037E8C;">
                <h3 class="card-title text-center">Consultas</h3>
                <p class="text-center mt-2">Revisión de consultas psicológicas y legales.</p>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card card-custom mb-4" style="background-color:#7EC544;">
                <h3 class="card-title text-center">Eventos</h3>
                <p class="text-center mt-2">Organización de talleres y actividades de apoyo.</p>
            </div>
        </div>

    </div>

    <!-- Botón solo administrador -->
    @if (Auth::user()->rol === 'administrador')
        <div class="text-center mt-3">
            <a href="{{ route('users.index') }}" class="btn-admin">
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
