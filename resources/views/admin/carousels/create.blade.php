@extends('layouts.sidebar')

@section('content')
<div class="container py-5">
    <h2>Crear Nuevo Slide</h2>

    <form action="{{ route('admin.carousels.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label>Título</label>
            <input type="text" name="titulo" class="form-control" value="{{ old('titulo') }}" placeholder="Ingrese el título del slide">
        </div>

        <div class="mb-3">
            <label>Descripción</label>
            <textarea name="descripcion" class="form-control" placeholder="Ingrese la descripción del slide">{{ old('descripcion') }}</textarea>
        </div>

        <div class="mb-3">
            <label>Imagen</label>
            <input type="file" name="imagen" class="form-control">
        </div>

        <div class="mb-3">
            <label>Orden</label>
            <input type="number" name="orden" class="form-control" value="{{ old('orden') }}" placeholder="Ejemplo: 1, 2, 3...">
        </div>

        <button type="submit" class="btn btn-success">Guardar</button>
        <a href="{{ route('admin.carousels.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
