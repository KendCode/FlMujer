@extends('layouts.sidebar')

@section('content')
<h2>Editar Actividad</h2>
<form action="{{ route('admin.actividades.update', $actividad->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="mb-3">
        <label>Título</label>
        <input type="text" name="titulo" class="form-control" value="{{ $actividad->titulo }}">
    </div>
    <div class="mb-3">
        <label>Descripción</label>
        <textarea name="descripcion" class="form-control">{{ $actividad->descripcion }}</textarea>
    </div>
    <div class="mb-3">
        <label>Imagen</label>
        <input type="file" name="imagen" class="form-control">
        @if($actividad->imagen)
            <img src="{{ asset('storage/'.$actividad->imagen) }}" width="100" class="mt-2">
        @endif
    </div>
    <button class="btn btn-success">Actualizar</button>
</form>
@endsection
