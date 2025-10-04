@extends('layouts.sidebar')

@section('content')
<div class="container py-5">
    <h2>Carousel</h2>
    <a href="{{ route('admin.carousels.create') }}" class="btn btn-success mb-3">Nuevo Slide</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
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
                <td>{{ $slide->orden }}</td>
                <td>{{ $slide->titulo }}</td>
                <td>
                    <img src="{{ asset('storage/'.$slide->imagen) }}" width="80">
                </td>
                <td>
                    <a href="{{ route('admin.carousels.edit', $slide) }}" class="btn btn-primary btn-sm">Editar</a>
                    <form action="{{ route('admin.carousels.destroy', $slide) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm" onclick="return confirm('¿Seguro que quieres eliminar este slide?')">Eliminar</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
