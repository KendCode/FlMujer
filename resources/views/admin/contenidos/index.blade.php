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

    .btn-add {
        background-color: #7EC544;
        color: white;
        border: none;
    }
    .btn-add:hover {
        background-color: #6ab33b;
        color: white;
    }

    .btn-edit {
        background-color: #13C0E5;
        border: none;
        color: white;
    }
    .btn-edit:hover {
        background-color: #0fa8cb;
        color: white;
    }

    .btn-delete {
        background-color: #dc3545;
        border: none;
        color: white;
    }
    .btn-delete:hover {
        background-color: #bb2333;
        color: white;
    }

    table thead {
        background-color: #037E8C !important;
        color: white;
    }

    table tbody tr:hover {
        background-color: #e9f9fd !important;
    }

    .table-custom {
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        border-radius: 10px;
        overflow: hidden;
        background: white;
    }

    img {
        border-radius: 10px;
        box-shadow: 0 3px 8px rgba(0,0,0,0.12);
    }
</style>
@endsection

@section('content')

<h2>Contenidos</h2>

<a href="{{ route('admin.contenidos.create') }}" class="btn btn-add mb-3 px-3">Agregar Contenido</a>

<div class="table-responsive table-custom">
    <table class="table table-bordered m-0">
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

                    <a href="{{ route('admin.contenidos.edit', $c->id) }}" class="btn btn-sm btn-edit px-3">
                        Editar
                    </a>

                    <form action="{{ route('admin.contenidos.destroy', $c->id) }}"
                          method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-delete px-3"
                                onclick="return confirm('¿Eliminar contenido?')">
                            Eliminar
                        </button>
                    </form>

                </td>
            </tr>
            @endforeach
        </tbody>

    </table>
</div>

@endsection
