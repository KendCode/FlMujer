@extends('layouts.sidebar')

@section('styles')
<style>
    body {
        background-color: #F4F4F2;
    }

    h2 {
        color: #037E8C;
        font-weight: bold;
    }

    .btn-new {
        background-color: #7EC544;
        color: white;
        border: none;
    }
    .btn-new:hover {
        background-color: #6ab33b;
        color: white;
    }

    .btn-edit {
        background-color: #13C0E5;
        border: none;
        color: white;
    }
    .btn-edit:hover {
        background-color: #0fabc8;
        color: white;
    }

    .btn-delete {
        background-color: #dc3545;
        border: none;
    }
    .btn-delete:hover {
        background-color: #c82333;
    }

    .card-custom {
        background: white;
        border-radius: 12px;
        padding: 30px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        border-left: 6px solid #037E8C;
    }

    table thead {
        background-color: #037E8C;
        color: white;
    }

    table tbody tr:hover {
        background-color: #e8f7fb;
    }
</style>
@endsection

@section('content')
<div class="container py-5">

    <div class="card-custom">

        <h2>Carousel</h2>

        <a href="{{ route('admin.carousels.create') }}" class="btn btn-new mb-3 px-3">Nuevo Slide</a>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead>
                    <tr>
                        <th>Orden</th>
                        <th>Título</th>
                        <th>Imagen</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($carousels as $slide)
                    <tr>
                        <td class="fw-bold">{{ $slide->orden }}</td>
                        <td>{{ $slide->titulo }}</td>
                        <td>
                            <img src="{{ asset('storage/'.$slide->imagen) }}" width="80" class="rounded shadow-sm">
                        </td>
                        <td>
                            <a href="{{ route('admin.carousels.edit', $slide) }}" class="btn btn-edit btn-sm px-3">Editar</a>

                            <form action="{{ route('admin.carousels.destroy', $slide) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-delete btn-sm px-3"
                                        onclick="return confirm('¿Seguro que quieres eliminar este slide?')">
                                    Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>

</div>
@endsection
