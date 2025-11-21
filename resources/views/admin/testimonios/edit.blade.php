@extends('layouts.sidebar')

@section('styles')
<style>
    body {
        background-color: #F4F4F2;
    }

    .form-card {
        background-color: white;
        padding: 30px;
        border-radius: 14px;
        box-shadow: 0 4px 14px rgba(0,0,0,0.08);
        max-width: 700px;
        margin: auto;
    }

    h2 {
        color: #037E8C;
        font-weight: bold;
        text-align: center;
        margin-bottom: 25px;
    }

    label {
        font-weight: 600;
        color: #037E8C;
    }

    .btn-success {
        background-color: #7EC544 !important;
        border-color: #7EC544 !important;
        font-weight: bold;
        color: #fff !important;
    }

    .btn-success:hover {
        background-color: #6db83c !important;
    }

    .btn-secondary {
        background-color: #13C0E5 !important;
        border-color: #13C0E5 !important;
        color: #fff !important;
    }

    .btn-secondary:hover {
        background-color: #0fa8c8 !important;
    }

    img.img-preview {
        max-width: 150px;
        border-radius: 8px;
        margin-top: 10px;
    }
</style>
@endsection

@section('content')
<div class="container py-5">
    <div class="form-card">
        <h2>{{ isset($testimonio) ? 'Editar' : 'Agregar' }} Testimonio</h2>

        <form action="{{ isset($testimonio) ? route('admin.testimonios.update', $testimonio->id) : route('admin.testimonios.store') }}" 
              method="POST" 
              enctype="multipart/form-data">
            @csrf
            @if(isset($testimonio)) @method('PUT') @endif

            <div class="mb-3">
                <label for="nombre">Nombre <span class="text-danger">*</span></label>
                <input type="text" 
                       name="nombre" 
                       id="nombre"
                       class="form-control" 
                       value="{{ $testimonio->nombre ?? '' }}" 
                       required>
            </div>

            <div class="mb-3">
                <label for="rol">Rol</label>
                <input type="text" 
                       name="rol" 
                       id="rol"
                       class="form-control" 
                       value="{{ $testimonio->rol ?? '' }}">
            </div>

            <div class="mb-3">
                <label for="mensaje">Mensaje <span class="text-danger">*</span></label>
                <textarea name="mensaje" 
                          id="mensaje" 
                          class="form-control" 
                          rows="5" 
                          required>{{ $testimonio->mensaje ?? '' }}</textarea>
            </div>

            <div class="mb-3">
                <label for="imagen">Imagen</label>
                <input type="file" 
                       name="imagen" 
                       id="imagen"
                       class="form-control"
                       accept="image/*">

                @if(isset($testimonio) && $testimonio->imagen)
                    <div>
                        <img src="{{ asset('storage/'.$testimonio->imagen) }}" 
                             alt="Imagen actual" 
                             class="img-preview">
                    </div>
                @endif
            </div>

            <div class="d-flex justify-content-between mt-4">
                <a href="{{ route('admin.testimonios.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Volver
                </a>

                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save"></i> {{ isset($testimonio) ? 'Actualizar' : 'Guardar' }}
                </button>
            </div>

        </form>
    </div>
</div>
@endsection
