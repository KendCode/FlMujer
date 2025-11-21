@extends('layouts.sidebar')

@section('styles')
<style>
    body {
        background-color: #F4F4F2;
    }

    .card-custom {
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        padding: 30px;
        border-left: 6px solid #037E8C;
    }

    h2 {
        color: #037E8C;
        font-weight: bold;
    }

    label {
        font-weight: 600;
        color: #037E8C;
    }

    .btn-primary-custom {
        background-color: #13C0E5;
        border: none;
    }

    .btn-primary-custom:hover {
        background-color: #0da7ca;
    }

    .btn-secondary-custom {
        background-color: #7EC544;
        border: none;
        color: white;
    }

    .btn-secondary-custom:hover {
        background-color: #6cb33a;
    }

</style>
@endsection

@section('content')
<div class="container py-5">
    <div class="card-custom">
        <h2 class="mb-4">Crear Nuevo Slide</h2>

        <form action="{{ route('admin.carousels.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label>Título</label>
                <input type="text" name="titulo" class="form-control"
                       value="{{ old('titulo') }}"
                       placeholder="Ingrese el título del slide">
            </div>

            <div class="mb-3">
                <label>Descripción</label>
                <textarea name="descripcion" class="form-control"
                          placeholder="Ingrese la descripción del slide">{{ old('descripcion') }}</textarea>
            </div>

            <div class="mb-3">
                <label>Imagen</label>
                <input type="file" name="imagen" class="form-control">
            </div>

            <div class="mb-3">
                <label>Orden</label>
                <input type="number" name="orden" class="form-control"
                       value="{{ old('orden') }}"
                       placeholder="Ejemplo: 1, 2, 3...">
            </div>

            <button type="submit" class="btn btn-primary-custom px-4">Guardar</button>
            <a href="{{ route('admin.carousels.index') }}" class="btn btn-secondary-custom px-4">Cancelar</a>
        </form>
    </div>
</div>
@endsection
