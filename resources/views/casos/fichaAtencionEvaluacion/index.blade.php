@extends('layouts.sidebar')

@section('content')
    <div class="container mt-4">
        <h3 class="text-center text-primary fw-bold mb-4">
            Fichas de Atención y Evaluación Psicológica
        </h3>

        {{-- Mensaje de éxito --}}
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="mb-3 text-end">
            <a href="{{ route('casos.fichaAtencionEvaluacion.create', $caso->id) }}" class="btn btn-primary">
                + Nueva Ficha
            </a>
        </div>

        @if ($fichas->count() > 0)
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-primary text-center">
                        <tr>
                            <th>ID</th>
                            <th>Fecha</th>
                            <th>Nombres y Apellidos</th>
                            <th>Edad</th>
                            <th>Motivo de consulta</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($fichas as $ficha)
                            <tr class="text-center">
                                <td>{{ $ficha->id }}</td>
                                <td>{{ $ficha->fecha->format('d-m-Y') }}</td>
                                <td>{{ $ficha->nombres_apellidos }}</td>
                                <td>
                                    @php
                                        $edades = [
                                            1 => 'Menor de 15 años',
                                            2 => '16 a 20 años',
                                            3 => '21 a 25 años',
                                            4 => '26 a 30 años',
                                            5 => '31 a 35 años',
                                            6 => '36 a 50 años',
                                            7 => 'Más de 50 años',
                                        ];
                                    @endphp
                                    {{ $edades[$ficha->edad] ?? 'N/A' }}
                                </td>

                                <td>{{ Str::limit($ficha->motivo_consulta, 30) }}</td>
                                <td>
                                    <a href="{{ route('casos.fichaAtencionEvaluacion.edit', ['caso' => $caso->id, 'ficha' => $ficha->id]) }}"
                                        class="btn btn-sm btn-warning">
                                        Editar
                                    </a>
                                    <form
                                        action="{{ route('casos.fichaAtencionEvaluacion.destroy', ['caso' => $caso->id, 'ficha' => $ficha->id]) }}"
                                        method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"
                                            onclick="return confirm('¿Desea eliminar esta ficha?')">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="alert alert-info text-center">
                No hay fichas registradas para este caso.
            </div>
        @endif
    </div>
@endsection
