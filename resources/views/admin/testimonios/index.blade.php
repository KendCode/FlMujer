@extends('layouts.sidebar')

@section('content')
<h2>Testimonios</h2>
<a href="{{ route('admin.testimonios.create') }}" class="btn btn-success mb-3">Agregar Testimonio</a>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Rol</th>
            <th>Mensaje</th>
            <th>Imagen</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach($testimonios as $t)
        <tr>
            <td>{{ $t->id }}</td>
            <td>{{ $t->nombre }}</td>
            <td>{{ $t->rol }}</td>
            <td>{{ $t->mensaje }}</td>
            <td>
                @if($t->imagen)
                <img src="{{ asset('storage/'.$t->imagen) }}" width="100">
                @endif
            </td>
            <td>
                <a href="{{ route('admin.testimonios.edit', $t->id) }}" class="btn btn-sm btn-warning">Editar</a>
                <form action="{{ route('admin.testimonios.destroy', $t->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar testimonio?')">Eliminar</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
