@extends('layouts.app2')

@section('title', 'Testimonios - Fundación Levántate Mujer')

@section('content')
<div class="container py-5">
  <h2 class="text-center mb-4" style="color: #037E8C;">Testimonios</h2>
  <div class="row g-4">
    <div class="col-md-4">
      <div class="card shadow-sm h-100">
        <div class="card-body">
          <p class="card-text">“Gracias a la fundación recuperé la confianza en mí misma y encontré apoyo psicológico.”</p>
          <h6 class="mt-3" style="color:#7EC544;">- María, beneficiaria</h6>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card shadow-sm h-100">
        <div class="card-body">
          <p class="card-text">“Hoy puedo decir que mi vida cambió para mejor gracias a la ayuda recibida aquí.”</p>
          <h6 class="mt-3" style="color:#7EC544;">- Ana, joven atendida</h6>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card shadow-sm h-100">
        <div class="card-body">
          <p class="card-text">“Un lugar donde encontré seguridad, comprensión y esperanza para mi familia.”</p>
          <h6 class="mt-3" style="color:#7EC544;">- Carmen, madre beneficiaria</h6>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
