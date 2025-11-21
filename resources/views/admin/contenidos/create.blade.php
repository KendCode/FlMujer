@extends('layouts.sidebar')

@section('styles')
<style>
    body {
        background-color: #F4F4F2;
    }

    h2 {
        color: #037E8C;
        font-weight: bold;
        margin-bottom: 20px;
    }

    label {
        font-weight: 600;
        color: #037E8C;
    }

    .card-custom {
        background: white;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        border-left: 6px solid #037E8C;
    }

    .btn-save {
        background-color: #13C0E5;
        border: none;
        color: white;
        padding: 8px 25px;
    }
    .btn-save:hover {
        background-color: #0fa8cb;
        color: white;
    }

    .btn-cancel {
        background-color: #7EC544;
        border: none;
        color: white;
        padding: 8px 25px;
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

<div class="container py-4">

    <div class="card-custom">

        <h2>{{ isset($contenido) ? 'Editar Contenido' : 'Agregar Contenido' }}</h2>

        <form action="{{ isset($contenido) 
                        ? route('admin.contenidos.update', $contenido->id) 
                        : route('admin.contenidos.store') }}" 
              method="POST" 
              enctype="multipart/form-data">
            
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
                    <img src="{{ asset('storage/'.$contenido->imagen) }}" width="120" class="mt-3 preview-img">
                @endif
            </div>

            <button class="btn btn-save">
                {{ isset($contenido) ? 'Actualizar' : 'Guardar' }}
            </button>

            <a href="{{ route('admin.contenidos.index') }}" class="btn btn-cancel ms-2">Cancelar</a>

        </form>

    </div>

</div>

@endsection
