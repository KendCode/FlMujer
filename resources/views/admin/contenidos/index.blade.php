@extends('layouts.sidebar')

@section('content')
<h2>Contenidos</h2>
<a href="{{ route('admin.contenidos.create') }}" class="btn btn-primary mb-3">Agregar Contenido</a>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Sección</th>
            <th>Título</th>
            <th>Descripción</th>
            <th>Imagen</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach($contenidos as $c)
        <tr>
            <td>{{ $c->id }}</td>
            <td>{{ $c->seccion }}</td>
            <td>{{ $c->titulo }}</td>
            <td>{{ $c->descripcion }}</td>
            <td>
                @if($c->imagen)
                <img src="{{ asset('storage/'.$c->imagen) }}" width="100">
                @endif
            </td>
            <td>
                <a href="{{ route('admin.contenidos.edit', $c->id) }}" class="btn btn-sm btn-warning">Editar</a>
                <form action="{{ route('admin.contenidos.destroy', $c->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar contenido?')">Eliminar</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
