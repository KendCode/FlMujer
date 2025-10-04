@extends('layouts.sidebar')

@section('content')
<div class="container py-5">
    <h2>Editar Slide</h2>

    <form action="{{ route('admin.carousels.update', $carousel) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label>Título</label>
            <input type="text" name="titulo" class="form-control" value="{{ old('titulo', $carousel->titulo) }}">
        </div>
        <div class="mb-3">
            <label>Descripción</label>
            <textarea name="descripcion" class="form-control">{{ old('descripcion', $carousel->descripcion) }}</textarea>
        </div>
        <div class="mb-3">
            <label>Imagen</label>
            <input type="file" name="imagen" class="form-control">
            @if($carousel->imagen)
                <img src="{{ asset('storage/'.$carousel->imagen) }}" width="120" class="mt-2">
            @endif
        </div>
        <div class="mb-3">
            <label>Orden</label>
            <input type="number" name="orden" class="form-control" value="{{ old('orden', $carousel->orden) }}">
        </div>
        <button type="submit" class="btn btn-primary">Actualizar</button>
    </form>
</div>
@endsection
