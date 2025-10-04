@extends('layouts.sidebar')

@section('content')
<h2>{{ isset($testimonio) ? 'Editar' : 'Agregar' }} Testimonio</h2>
<form action="{{ isset($testimonio) ? route('admin.testimonios.update', $testimonio->id) : route('admin.testimonios.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @if(isset($testimonio)) @method('PUT') @endif
    <div class="mb-3">
        <label>Nombre</label>
        <input type="text" name="nombre" class="form-control" value="{{ $testimonio->nombre ?? '' }}" required>
    </div>
    <div class="mb-3">
        <label>Rol</label>
        <input type="text" name="rol" class="form-control" value="{{ $testimonio->rol ?? '' }}">
    </div>
    <div class="mb-3">
        <label>Mensaje</label>
        <textarea name="mensaje" class="form-control" required>{{ $testimonio->mensaje ?? '' }}</textarea>
    </div>
    <div class="mb-3">
        <label>Imagen</label>
        <input type="file" name="imagen" class="form-control">
        @if(isset($testimonio) && $testimonio->imagen)
            <img src="{{ asset('storage/'.$testimonio->imagen) }}" width="100" class="mt-2">
        @endif
    </div>
    <button class="btn btn-success">{{ isset($testimonio) ? 'Actualizar' : 'Guardar' }}</button>
</form>
@endsection
