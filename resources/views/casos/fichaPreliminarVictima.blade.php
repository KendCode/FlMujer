@extends('layouts.sidebar')

@section('content')
<div class="container mt-4">
    <h4>Crear Ficha Preliminar - Víctima (Caso {{ $caso->id }})</h4>

    <form action="{{ route('casos.fichaPreliminarVictima.store', $caso->id) }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Nombre</label>
            <input type="text" name="nombre" class="form-control" value="{{ old('nombre') }}">
        </div>
        <div class="mb-3">
            <label>CI</label>
            <input type="text" name="ci" class="form-control" value="{{ old('ci') }}">
        </div>
        <div class="mb-3">
            <label>Fecha Nacimiento</label>
            <input type="date" name="fecha_nacimiento" class="form-control" value="{{ old('fecha_nacimiento') }}">
        </div>
        <div class="mb-3">
            <label>Género</label>
            <select name="genero" class="form-control">
                <option value="">--</option>
                <option value="M">M</option>
                <option value="F">F</option>
            </select>
        </div>
        <div class="mb-3">
            <label>Descripción de los hechos</label>
            <textarea name="descripcion_hechos" class="form-control">{{ old('descripcion_hechos') }}</textarea>
        </div>

        <button class="btn btn-primary">Guardar</button>
    </form>
</div>
@endsection
