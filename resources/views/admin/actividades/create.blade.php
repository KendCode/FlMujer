@extends('layouts.sidebar')

@section('content')
<h2>Agregar Actividad</h2>
<form action="{{ route('admin.actividades.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="mb-3">
        <label>Título</label>
        <input type="text" name="titulo" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Descripción</label>
        <textarea name="descripcion" class="form-control" required></textarea>
    </div>
    <div class="mb-3">
        <label>Imagen</label>
        <input type="file" name="imagen" class="form-control">
    </div>
    <button class="btn btn-success">Guardar</button>
</form>
@endsection
