@extends('layouts.app2')

@section('title', 'Contacto - Fundación Levántate Mujer')

@section('content')
<div class="container py-5">
  <h2 class="text-center mb-4" style="color: #037E8C;">Contáctanos</h2>
  <div class="row">
    <div class="col-md-6">
      <h4 style="color: #7EC544;">Oficinas Centrales</h4>
      <p><i class="bi bi-geo-alt-fill"></i> Av. Guadalquivir, Zona Nuevos Horizontes II</p>
      <p><i class="bi bi-envelope-fill"></i> gerencia@levantatemujer.org</p>
      <p><i class="bi bi-telephone-fill"></i> +591 2 2784513</p>
      <p><i class="bi bi-phone-fill"></i> +591 690 02358</p>
    </div>
    <div class="col-md-6">
      <form>
        <div class="mb-3">
          <label for="name" class="form-label">Nombre</label>
          <input type="text" class="form-control" id="name" placeholder="Tu nombre" required>
        </div>
        <div class="mb-3">
          <label for="email" class="form-label">Correo</label>
          <input type="email" class="form-control" id="email" placeholder="correo@ejemplo.com" required>
        </div>
        <div class="mb-3">
          <label for="message" class="form-label">Mensaje</label>
          <textarea class="form-control" id="message" rows="4" placeholder="Escribe tu mensaje" required></textarea>
        </div>
        <button type="submit" class="btn w-100" style="background-color:#13C0E5; color:white;">Enviar</button>
      </form>
    </div>
  </div>
</div>
@endsection
