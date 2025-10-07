@extends('layouts.sidebar')

@section('content')
<h2>Registrar caso de violencia</h2>

<form action="{{ route('casos.store') }}" method="POST">
  @csrf

  <!-- --- Sección 1: Datos personales --- -->
  <div class="card mb-3">
    <div class="card-header">1. Datos personales</div>
    <div class="card-body">
      <div class="row g-2">
        <div class="col-md-6">
          <label class="form-label">Nombres</label>
          <input type="text" name="nombres" value="{{ old('nombres') }}" class="form-control" required>
          @error('nombres') <div class="text-danger">{{ $message }}</div> @enderror
        </div>
        <div class="col-md-6">
          <label class="form-label">Apellidos</label>
          <input type="text" name="apellidos" value="{{ old('apellidos') }}" class="form-control" required>
          @error('apellidos') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="col-md-4 mt-2">
          <label class="form-label d-block">Sexo</label>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="sexo" id="sexM" value="M" {{ old('sexo')=='M' ? 'checked' : '' }}>
            <label class="form-check-label" for="sexM">Varón</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="sexo" id="sexF" value="F" {{ old('sexo')=='F' ? 'checked' : '' }}>
            <label class="form-check-label" for="sexF">Mujer</label>
          </div>
        </div>

        <div class="col-md-8 mt-2">
          <label class="form-label">Edad (rango)</label>
          <div class="d-flex flex-wrap gap-2">
            @foreach($rangos as $key => $label)
              <div class="form-check">
                <input class="form-check-input" type="radio" name="edad_rango" id="edad_{{ $key }}" value="{{ $key }}" {{ old('edad_rango')==$key ? 'checked' : '' }}>
                <label class="form-check-label" for="edad_{{ $key }}">{{ $label }}</label>
              </div>
            @endforeach
          </div>
        </div>

        <div class="col-md-4 mt-2">
          <label class="form-label">CI</label>
          <input type="text" name="ci" value="{{ old('ci') }}" class="form-control">
        </div>

        <div class="col-md-8 mt-2">
          <label class="form-label">Distrito</label><br>
          @for($i=1;$i<=14;$i++)
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="id_distrito" id="dist{{ $i }}" value="{{ $i }}" {{ old('id_distrito')==$i ? 'checked' : '' }}>
              <label class="form-check-label" for="dist{{ $i }}">Distrito {{ $i }}</label>
            </div>
          @endfor
          <div class="mt-2">
            <input type="text" name="zona" class="form-control" placeholder="Zona / Barrio (otros)">
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- --- Sección 2: Datos de la pareja (simplificado) --- -->
  <div class="card mb-3">
    <div class="card-header">2. Datos de la pareja</div>
    <div class="card-body">
      <div class="row g-2">
        <div class="col-md-6">
          <label>Nombres</label>
          <input type="text" name="pareja_nombres" value="{{ old('pareja_nombres') }}" class="form-control">
        </div>
        <div class="col-md-6">
          <label>Apellidos</label>
          <input type="text" name="pareja_apellidos" value="{{ old('pareja_apellidos') }}" class="form-control">
        </div>
        <div class="col-md-4 mt-2">
          <label>Sexo</label>
          <div>
            <input type="radio" name="pareja_sexo" value="M"> Varón
            <input type="radio" name="pareja_sexo" value="F"> Mujer
          </div>
        </div>
        <div class="col-md-8 mt-2">
          <label>Edad (rango)</label>
          <div class="d-flex gap-2 flex-wrap">
            @foreach($rangos as $key=>$label)
              <div class="form-check">
                <input class="form-check-input" type="radio" name="pareja_edad_rango" value="{{ $key }}" {{ old('pareja_edad_rango')==$key ? 'checked':'' }}>
                <label class="form-check-label">{{ $label }}</label>
              </div>
            @endforeach
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- --- Sección 3: Características de la agresión --- -->
  <div class="card mb-3">
    <div class="card-header">3. Características de la agresión</div>
    <div class="card-body">
      <div class="mb-3">
        <label class="form-label">Formas de violencia (marque todas las que apliquen)</label>
        <div class="d-flex gap-2 flex-wrap">
          @foreach($formas as $forma)
            <div class="form-check">
              <input type="checkbox" name="formas_violencia[]" value="{{ $forma->id }}" class="form-check-input" id="forma{{ $forma->id }}" {{ (is_array(old('formas_violencia')) && in_array($forma->id, old('formas_violencia')))?'checked':'' }}>
              <label class="form-check-label" for="forma{{ $forma->id }}">{{ $forma->nombre }}</label>
            </div>
          @endforeach
        </div>
      </div>

      <div class="mb-3">
        <label>Frecuencia</label>
        <select name="frecuencia_agresion" class="form-select">
          <option value="">--Seleccione--</option>
          <option value="primera" {{ old('frecuencia_agresion')=='primera'?'selected':'' }}>Primera vez</option>
          <option value="ocasional" {{ old('frecuencia_agresion')=='ocasional'?'selected':'' }}>Ocasionalmente</option>
          <option value="con_frecuencia" {{ old('frecuencia_agresion')=='con_frecuencia'?'selected':'' }}>Con frecuencia</option>
          <option value="siempre" {{ old('frecuencia_agresion')=='siempre'?'selected':'' }}>Siempre</option>
        </select>
      </div>

      <div class="mb-3">
        <label>Denunció</label>
        <div>
          <label class="me-3"><input type="radio" name="denuncio" value="1" {{ old('denuncio')=='1' ? 'checked':'' }}> Sí</label>
          <label><input type="radio" name="denuncio" value="0" {{ old('denuncio')=='0' ? 'checked':'' }}> No</label>
        </div>
      </div>

      <div class="mb-3">
        <label>Motivo (si otro, especifique)</label>
        <input type="text" name="motivo_agresion_otro" class="form-control" value="{{ old('motivo_agresion_otro') }}">
      </div>

      <div class="mb-3">
        <label>Medidas a tomar (texto)</label>
        <textarea name="medidas_tomar_text" class="form-control" rows="3">{{ old('medidas_tomar_text') }}</textarea>
      </div>
    </div>
  </div>

  <button class="btn btn-primary" type="submit">Registrar caso</button>
</form>
@endsection
