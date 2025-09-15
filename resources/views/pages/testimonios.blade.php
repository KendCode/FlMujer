@extends('layouts.app2')

@section('title', 'Testimonios - Fundación Levántate Mujer')

@section('content')
<div class="container py-5">
  <h2 class="text-center mb-5 fw-bold" style="color: #037E8C;">Testimonios</h2>
  
  <div class="row g-4">
    <!-- Testimonio 1 -->
    <div class="col-md-4">
      <div class="card shadow-sm h-100 border-0 rounded-4">
        <div class="card-body text-center">
          <img src="/img/banner1.png" alt="Testimonio María" class="img-fluid rounded-circle mb-3" style="width: 100px; height: 100px; object-fit: cover;">
          <p class="card-text fst-italic">“Gracias a la fundación recuperé la confianza en mí misma y encontré apoyo psicológico.”</p>
          <h6 class="mt-3 fw-semibold" style="color:#7EC544;">— María, beneficiaria</h6>
        </div>
      </div>
    </div>

    <!-- Testimonio 2 -->
    <div class="col-md-4">
      <div class="card shadow-sm h-100 border-0 rounded-4">
        <div class="card-body text-center">
          <img src="/img/banner1.png" alt="Testimonio Ana" class="img-fluid rounded-circle mb-3" style="width: 100px; height: 100px; object-fit: cover;">
          <p class="card-text fst-italic">“Hoy puedo decir que mi vida cambió para mejor gracias a la ayuda recibida aquí.”</p>
          <h6 class="mt-3 fw-semibold" style="color:#7EC544;">— Ana, joven atendida</h6>
        </div>
      </div>
    </div>

    <!-- Testimonio 3 -->
    <div class="col-md-4">
      <div class="card shadow-sm h-100 border-0 rounded-4">
        <div class="card-body text-center">
          <img src="/img/banner1.png" alt="Testimonio Carmen" class="img-fluid rounded-circle mb-3" style="width: 100px; height: 100px; object-fit: cover;">
          <p class="card-text fst-italic">“Un lugar donde encontré seguridad, comprensión y esperanza para mi familia.”</p>
          <h6 class="mt-3 fw-semibold" style="color:#7EC544;">— Carmen, madre beneficiaria</h6>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
