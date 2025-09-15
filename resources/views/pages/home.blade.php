@extends('layouts.app2')

@section('title', 'Laravel 12')

@section('content')
<main>
  <div id="myCarousel" class="carousel slide mb-6" data-bs-ride="carousel">
    <div class="carousel-indicators">
      <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="0" aria-label="Slide 1"></button>
      <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="1" class="active" aria-current="true" aria-label="Slide 2"></button>
      <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
    </div>
    <div class="carousel-inner">
      <div class="carousel-item">
        <img src="/img/banner1.png" class="d-block w-100" alt="Banner 1">
      </div>
      <div class="carousel-item active">
        <img src="/img/banner2.jpeg" class="d-block w-100" alt="Banner 2">
      </div>
      <div class="carousel-item">
        <img src="/img/banner3.jpeg" class="d-block w-100" alt="Banner 3">
      </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#myCarousel" data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#myCarousel" data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Next</span>
    </button>
  </div>
</main>

{{-- CARDS --}}
<div class="container mt-4">
  <div class="row justify-content-center gap-4">
    <div class="col-md-3">
      <div class="card" style="background-color: #F4F4F2;">
        <img src="/img/foto1.jpg" class="card-img-top" alt="Eventos">
        <div class="card-body">
          <h5 class="card-title" style="color: #7EC544;">EVENTOS</h5>
          <p class="card-text">Contenido representativo para la tarjeta de eventos.</p>
          {{-- <a href="/evento/store" class="btn" style="background-color: #13C0E5; color: white;">Añadir eventos</a> --}}
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card" style="background-color: #F4F4F2;">
        <img src="/img/foto2.jpg" class="card-img-top" alt="Beneficiarios">
        <div class="card-body">
          <h5 class="card-title" style="color: #7EC544;">BENEFICIARIOS</h5>
          <p class="card-text">Contenido representativo para la tarjeta de beneficiarios.</p>
          {{-- <a href="/beneficiario/storeBeneficiario" class="btn" style="background-color: #13C0E5; color: white;">Añadir beneficiarios</a> --}}
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card" style="background-color: #F4F4F2;">
        <img src="/img/foto3.jpg" class="card-img-top" alt="Grupos">
        <div class="card-body">
          <h5 class="card-title" style="color: #7EC544;">GRUPOS</h5>
          <p class="card-text">Contenido representativo para la tarjeta de grupos.</p>
          {{-- <a href="/grupo/storeGrupo" class="btn" style="background-color: #13C0E5; color: white;">Añadir grupos</a> --}}
        </div>
      </div>
    </div>
  </div>
</div>

<div class="container py-5">
  <div class="row">
    <div class="col-md-6">
      <h2 class="mb-4" style="color: #037E8C;">Dirección Ejecutiva</h2>
      <p><i class="bi bi-geo-alt-fill"></i> <strong>Dirección:</strong> Av. Guadalquivir, Zona Nuevos Horizontes II</p>
      <p><i class="bi bi-envelope-fill"></i> <strong>Correo:</strong> gerencia@levantatemujer.org</p>
      <p><i class="bi bi-telephone-fill"></i> <strong>Teléfono:</strong> +591 2 2784513</p>
      <p><i class="bi bi-phone-fill"></i> <strong>Móvil:</strong> +591 690 02358</p>
    </div>
    <div class="col-md-6">
      <h2 class="mb-4" style="color: #037E8C;">Ubicación</h2>
      <img src="{{ asset('img/lugar.png') }}" alt="Ubicación" class="img-fluid rounded">
    </div>
  </div>
</div>

<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <h2 class="text-center mb-4" style="color: #037E8C;">Contáctanos</h2>
      <form>
        <div class="mb-3">
          <label for="name" class="form-label">Nombre</label>
          <input type="text" class="form-control" id="name" placeholder="Tu nombre" required>
        </div>
        <div class="mb-3">
          <label for="email" class="form-label">Correo Electrónico</label>
          <input type="email" class="form-control" id="email" placeholder="correo@ejemplo.com" required>
        </div>
        <div class="mb-3">
          <label for="message" class="form-label">Mensaje</label>
          <textarea class="form-control" id="message" rows="4" placeholder="Escribe tu mensaje" required></textarea>
        </div>
        <button type="submit" class="btn" style="background-color: #13C0E5; color: white; width: 100%;">Enviar Mensaje</button>
      </form>
    </div>
  </div>
</div>
@endsection
