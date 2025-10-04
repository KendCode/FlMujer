@extends('layouts.sidebar')

@section('content')
<div class="container py-5">
    <h2>Actividades</h2>
    <a href="{{ route('admin.actividades.create') }}" class="btn btn-success mb-3">Nueva Actividad</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Título</th>
                <th>Imagen</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($actividades as $actividad)
            <tr>
                <td>{{ $actividad->titulo }}</td>
                <td>
                    @if($actividad->imagen)
                        <img src="{{ asset('storage/'.$actividad->imagen) }}" width="80">
                    @endif
                </td>
                <td>
                    <a href="{{ route('admin.actividades.edit', $actividad) }}" class="btn btn-primary btn-sm">Editar</a>
                    <form action="{{ route('admin.actividades.destroy', $actividad) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar actividad?')">Eliminar</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
