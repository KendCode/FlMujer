@extends('layouts.app2')

@section('title', 'Actividades - Fundación Levántate Mujer')

@section('content')
<div class="container py-5">
  <h2 class="text-center mb-4" style="color:#037E8C;">Actividades de la Fundación</h2>
  <div class="row g-4">
    <div class="col-md-4">
      <div class="card h-100 shadow-sm">
        <img src="{{ asset('img/actividad1.jpg') }}" class="card-img-top" alt="Taller de apoyo">
        <div class="card-body">
          <h5 style="color:#7EC544;">Talleres de apoyo</h5>
          <p>Sesiones de crecimiento personal y fortalecimiento emocional para mujeres y jóvenes.</p>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card h-100 shadow-sm">
        <img src="{{ asset('img/actividad2.jpg') }}" class="card-img-top" alt="Charlas educativas">
        <div class="card-body">
          <h5 style="color:#7EC544;">Charlas educativas</h5>
          <p>Charlas en colegios y comunidades sobre prevención de la violencia y derechos humanos.</p>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card h-100 shadow-sm">
        <img src="{{ asset('img/actividad3.jpg') }}" class="card-img-top" alt="Eventos comunitarios">
        <div class="card-body">
          <h5 style="color:#7EC544;">Eventos comunitarios</h5>
          <p>Actividades culturales y ferias para sensibilizar y acercar la misión de la fundación a la población.</p>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
