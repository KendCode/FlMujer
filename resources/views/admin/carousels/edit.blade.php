@extends('layouts.sidebar')

@section('styles')
<style>
    body {
        background-color: #F4F4F2;
    }

    h2 {
        color: #037E8C;
        font-weight: bold;
    }

    label {
        color: #037E8C;
        font-weight: 600;
    }

    .card-custom {
        background: white;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        border-left: 6px solid #037E8C;
    }

    .btn-update {
        background-color: #13C0E5;
        color: white;
        border: none;
    }
    .btn-update:hover {
        background-color: #0fa8cb;
        color: white;
    }

    .btn-cancel {
        background-color: #7EC544;
        color: white;
        border: none;
    }
    .btn-cancel:hover {
        background-color: #6ab33b;
        color: white;
    }

    .preview-img {
        border-radius: 10px;
        box-shadow: 0 3px 8px rgba(0,0,0,0.12);
    }
</style>
@endsection

@section('content')
<div class="container py-5">

    <div class="card-custom">
        <h2 class="mb-4">Editar Slide</h2>

        <form action="{{ route('admin.carousels.update', $carousel) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label>Título</label>
                <input type="text" name="titulo" class="form-control"
                       value="{{ old('titulo', $carousel->titulo) }}">
            </div>

            <div class="mb-3">
                <label>Descripción</label>
                <textarea name="descripcion" class="form-control">{{ old('descripcion', $carousel->descripcion) }}</textarea>
            </div>

            <div class="mb-3">
                <label>Imagen</label>
                <input type="file" name="imagen" class="form-control">

                @if($carousel->imagen)
                    <img src="{{ asset('storage/'.$carousel->imagen) }}" width="130" class="mt-3 preview-img">
                @endif
            </div>

            <div class="mb-3">
                <label>Orden</label>
                <input type="number" name="orden" class="form-control"
                       value="{{ old('orden', $carousel->orden) }}">
            </div>

            <button type="submit" class="btn btn-update px-4">Actualizar</button>

            <a href="{{ route('admin.carousels.index') }}" class="btn btn-cancel px-4">Cancelar</a>
        </form>

    </div>

</div>
@endsection
