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

    .btn-success {
        background-color: #7EC544 !important;
        border-color: #7EC544 !important;
        font-weight: bold;
        color: #fff !important;
    }

    .btn-success:hover {
        background-color: #6db83c !important;
    }

    .btn-warning {
        background-color: #13C0E5 !important;
        border-color: #13C0E5 !important;
        color: white !important;
        font-weight: bold;
    }

    .btn-warning:hover {
        background-color: #0fa8c8 !important;
    }

    .btn-danger {
        background-color: #d9534f !important;
        border-color: #d9534f !important;
        font-weight: bold;
    }

    table {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 14px rgba(0,0,0,0.08);
    }

    thead {
        background-color: #037E8C;
        color: white;
    }
</style>
@endsection

@section('content')
<div class="container py-4">

    <h2>Testimonios</h2>

    <a href="{{ route('admin.testimonios.create') }}" class="btn btn-success mb-3">
        + Agregar Testimonio
    </a>

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
                    <img src="{{ asset('storage/'.$t->imagen) }}" width="100" class="rounded">
                    @endif
                </td>
                <td>
                    <a href="{{ route('admin.testimonios.edit', $t->id) }}" 
                       class="btn btn-sm btn-warning mb-1">
                        Editar
                    </a>

                    <form action="{{ route('admin.testimonios.destroy', $t->id) }}" 
                          method="POST" 
                          style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger" 
                                onclick="return confirm('¿Eliminar testimonio?')">
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
