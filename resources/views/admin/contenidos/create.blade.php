@extends('layouts.sidebar')

@section('content')
<h2>{{ isset($contenido) ? 'Editar' : 'Agregar' }} Contenido</h2>
<form action="{{ isset($contenido) ? route('admin.contenidos.update', $contenido->id) : route('admin.contenidos.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @if(isset($contenido)) @method('PUT') @endif
    <div class="mb-3">
        <label>Sección</label>
        <input type="text" name="seccion" class="form-control" value="{{ $contenido->seccion ?? '' }}" required>
    </div>
    <div class="mb-3">
        <label>Título</label>
        <input type="text" name="titulo" class="form-control" value="{{ $contenido->titulo ?? '' }}">
    </div>
    <div class="mb-3">
        <label>Descripción</label>
        <textarea name="descripcion" class="form-control">{{ $contenido->descripcion ?? '' }}</textarea>
    </div>
    <div class="mb-3">
        <label>Imagen</label>
        <input type="file" name="imagen" class="form-control">
        @if(isset($contenido) && $contenido->imagen)
            <img src="{{ asset('storage/'.$contenido->imagen) }}" width="100" class="mt-2">
        @endif
    </div>
    <button class="btn btn-success">{{ isset($contenido) ? 'Actualizar' : 'Guardar' }}</button>
</form>
@endsection
