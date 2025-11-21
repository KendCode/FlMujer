@extends('layouts.sidebar')

@section('styles')
<style>
    body {
        background-color: #F4F4F2;
    }

    .form-card {
        background: white;
        padding: 30px;
        border-radius: 14px;
        box-shadow: 0 4px 14px rgba(0,0,0,0.08);
        border: none;
        max-width: 700px;
        margin: auto;
    }

    h2 {
        color: #037E8C;
        font-weight: bold;
        margin-bottom: 25px;
        text-align: center;
    }

    label {
        font-weight: 600;
        color: #037E8C;
    }

    .btn-success {
        background-color: #7EC544 !important;
        border-color: #7EC544 !important;
        font-weight: bold;
    }

    .btn-success:hover {
        background-color: #6db83c !important;
    }

    .btn-secondary {
        background-color: #13C0E5 !important;
        border-color: #13C0E5 !important;
    }

    .btn-secondary:hover {
        background-color: #0fa8c8 !important;
    }
</style>
@endsection

@section('content')
<div class="container py-5">

    <div class="form-card">
        <h2>Editar Actividad</h2>

        <form action="{{ route('admin.actividades.update', $actividad) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="titulo">Título</label>
                <input type="text" 
                       name="titulo" 
                       id="titulo"
                       class="form-control" 
                       value="{{ $actividad->titulo }}">
            </div>

            <div class="mb-3">
                <label for="descripcion">Descripción</label>
                <textarea name="descripcion" 
                          id="descripcion"
                          class="form-control" 
                          rows="5">{{ $actividad->descripcion }}</textarea>
            </div>

            <div class="mb-3">
                <label for="imagen">Imagen</label>
                <input type="file" 
                       name="imagen" 
                       id="imagen"
                       class="form-control"
                       accept="image/*">

                @if($actividad->imagen)
                    <div class="mt-3">
                        <label class="form-label">Imagen actual:</label>
                        <br>
                        <img src="{{ asset('storage/'.$actividad->imagen) }}" 
                             class="img-thumbnail" 
                             style="max-width: 150px;">
                    </div>
                @endif
            </div>

            <div class="d-flex justify-content-between mt-4">
                <a href="{{ route('admin.actividades.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Volver
                </a>

                <button class="btn btn-success">
                    <i class="fas fa-save"></i> Actualizar
                </button>
            </div>

        </form>

    </div>

</div>
@endsection
