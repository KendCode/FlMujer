@extends('layouts.sidebar')

@section('styles')
<style>
    body {
        background-color: #F4F4F2 !important;
    }

    .card {
        border-radius: 12px;
        border-left: 6px solid #037E8C;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        background: #ffffff;
    }

    .card-header {
        background-color: #037E8C;
        color: white;
        border-radius: 12px 12px 0 0;
        padding: 18px 20px;
    }

    h2 {
        font-weight: bold;
        margin: 0;
    }

    label {
        font-weight: 600;
        color: #037E8C;
    }

    .btn-update {
        background-color: #13C0E5;
        border: none;
        color: white;
        padding: 8px 20px;
    }
    .btn-update:hover {
        background-color: #0fa8cb;
        color: white;
    }

    .btn-cancel {
        background-color: #7EC544;
        border: none;
        color: white;
        padding: 8px 20px;
    }
    .btn-cancel:hover {
        background-color: #6ab33b;
        color: white;
    }

    .img-thumbnail {
        border-radius: 10px;
        box-shadow: 0 3px 8px rgba(0,0,0,0.12);
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">

            <div class="card">
                <div class="card-header">
                    <h2 class="mb-0">Editar Contenido</h2>
                </div>

                <div class="card-body">

                    <form action="{{ route('admin.contenidos.update', $contenido->id) }}" 
                          method="POST" 
                          enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label for="seccion" class="form-label">Sección <span class="text-danger">*</span></label>
                            <input type="text" 
                                   name="seccion" 
                                   id="seccion"
                                   class="form-control @error('seccion') is-invalid @enderror" 
                                   value="{{ old('seccion', $contenido->seccion) }}" 
                                   required>
                            @error('seccion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="titulo" class="form-label">Título</label>
                            <input type="text" 
                                   name="titulo" 
                                   id="titulo"
                                   class="form-control @error('titulo') is-invalid @enderror" 
                                   value="{{ old('titulo', $contenido->titulo) }}">
                            @error('titulo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="descripcion" class="form-label">Descripción</label>
                            <textarea name="descripcion" 
                                      id="descripcion"
                                      class="form-control @error('descripcion') is-invalid @enderror" 
                                      rows="5">{{ old('descripcion', $contenido->descripcion) }}</textarea>
                            @error('descripcion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="imagen" class="form-label">Imagen</label>
                            <input type="file" 
                                   name="imagen" 
                                   id="imagen"
                                   class="form-control @error('imagen') is-invalid @enderror"
                                   accept="image/*">
                            @error('imagen')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            
                            @if($contenido->imagen)
                                <div class="mt-3">
                                    <label class="form-label">Imagen actual:</label>
                                    <div>
                                        <img src="{{ asset('storage/' . $contenido->imagen) }}" 
                                             alt="Imagen actual" 
                                             class="img-thumbnail" 
                                             style="max-width: 200px;">
                                    </div>
                                    <small class="text-muted">Selecciona una nueva imagen para reemplazarla</small>
                                </div>
                            @endif
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-update">
                                <i class="fas fa-save"></i> Actualizar
                            </button>

                            <a href="{{ route('admin.contenidos.index') }}" class="btn btn-cancel">
                                <i class="fas fa-arrow-left"></i> Cancelar
                            </a>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection
