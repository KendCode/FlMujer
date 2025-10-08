@extends('layouts.sidebar')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">Listado de Casos</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('casos.create') }}" class="btn btn-primary mb-3">Registrar Nuevo Caso</a>

    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Paciente</th>
                    <th>Sexo</th>
                    <th>Edad</th>
                    <th>Teléfono</th>
                    <th>Distrito</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($casos as $caso)
                    <tr>
                        <td>{{ $caso->id }}</td>
                        <td>{{ $caso->paciente_nombres }} {{ $caso->paciente_apellidos }}</td>
                        <td>{{ $caso->paciente_sexo == 'M' ? 'Varón' : 'Mujer' }}</td>
                        <td>{{ $caso->paciente_edad_rango }}</td>
                        <td>{{ $caso->paciente_telefono ?? '-' }}</td>
                        <td>{{ $caso->paciente_id_distrito }}</td>
                        <td>
                            {{-- <a href="{{ route('casos.show', $caso->id) }}" class="btn btn-info btn-sm">Ver</a> --}}
                            <a href="{{ route('casos.edit', $caso->id) }}" class="btn btn-warning btn-sm">Editar</a>
                            {{-- <form action="{{ route('casos.destroy', $caso->id) }}" method="POST" class="d-inline"
                                onsubmit="return confirm('¿Seguro que deseas eliminar este caso?');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm">Eliminar</button>
                            </form> --}}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">No hay casos registrados.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-3">
        {{ $casos->links() }}
    </div>
</div>
@endsection
