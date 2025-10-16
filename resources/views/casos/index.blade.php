@extends('layouts.sidebar')

@section('content')
    <div class="container-fluid py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Lista de Casos Registrados</h2>
            <a href="{{ route('casos.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Nuevo Caso
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="card">
            <div class="card-header bg-white">
                <form method="GET" action="{{ route('casos.index') }}" class="row g-3 align-items-end">
                    <div class="col-md-3">
                        <label class="form-label">Buscar</label>
                        <input type="text" name="search" class="form-control" placeholder="Nombre, CI o registro"
                            value="{{ request('search') }}">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Distrito</label>
                        <select name="distrito" class="form-select">
                            <option value="">Todos los distritos</option>
                            @for ($i = 1; $i <= 14; $i++)
                                <option value="{{ $i }}" {{ request('distrito') == $i ? 'selected' : '' }}>
                                    Distrito {{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Tipo de violencia</label>
                        <select name="tipo_violencia" class="form-select">
                            <option value="">Todos</option>
                            <option value="violencia_intrafamiliar"
                                {{ request('tipo_violencia') == 'violencia_intrafamiliar' ? 'selected' : '' }}>Intrafamiliar
                            </option>
                            <option value="violencia_domestica"
                                {{ request('tipo_violencia') == 'violencia_domestica' ? 'selected' : '' }}>Doméstica</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Fecha</label>
                        <input type="date" name="fecha" class="form-control" value="{{ request('fecha') }}">
                    </div>
                    <div class="col-md-3 d-flex gap-2">
                        <button type="submit" class="btn btn-primary mt-2">Buscar</button>
                        <a href="{{ route('casos.index') }}" class="btn btn-secondary mt-2">Limpiar</a>
                        <a href="#" class="btn btn-success mt-2">
                            <i class="bi bi-file-earmark-excel"></i> Exportar
                        </a>
                        {{-- <a href="{{ route('casos.export') }}" class="btn btn-success mt-2">
                            <i class="bi bi-file-earmark-excel"></i> Exportar
                        </a> --}}
                    </div>
                </form>
            </div>


            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-striped align-middle" id="tablaCasos">
                        <thead class="table-light">
                            <tr>
                                <th>N° Registro</th>
                                <th>Fecha</th>
                                <th>Paciente</th>
                                <th>CI</th>
                                <th>Edad</th>
                                <th>Distrito</th>
                                <th>Tipo Violencia</th>
                                <th>Regional</th>
                                {{-- <th>Estado</th> --}}
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($casos as $caso)
                                <tr>
                                    <td>
                                        <strong class="text-primary">{{ $caso->nro_registro }}</strong>
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($caso->regional_fecha)->format('d/m/Y') }}</td>
                                    <td>
                                        <div>
                                            <strong>{{ $caso->paciente_nombres }} {{ $caso->paciente_apellidos }}</strong>
                                            <br>
                                            <small class="text-muted">
                                                <i
                                                    class="bi bi-gender-{{ $caso->paciente_sexo == 'F' ? 'female' : 'male' }}"></i>
                                                {{ $caso->paciente_sexo == 'F' ? 'Mujer' : 'Varón' }}
                                            </small>
                                        </div>
                                    </td>
                                    <td>{{ $caso->paciente_ci ?? 'N/A' }}</td>
                                    <td>
                                        <span class="badge bg-info">
                                            {{ ucfirst(str_replace('_', ' ', $caso->paciente_edad_rango)) }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary">
                                            Distrito {{ $caso->paciente_id_distrito }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column gap-1">
                                            @if ($caso->violencia_tipo_fisica)
                                                <span class="badge bg-danger">Física</span>
                                            @endif
                                            @if ($caso->violencia_tipo_psicologica)
                                                <span class="badge bg-warning text-dark">Psicológica</span>
                                            @endif
                                            @if ($caso->violencia_tipo_sexual)
                                                <span class="badge bg-dark">Sexual</span>
                                            @endif
                                            @if ($caso->violencia_tipo_economica)
                                                <span class="badge bg-success">Económica</span>
                                            @endif
                                            @if ($caso->violencia_tipo_patrimonial)
                                                <span class="badge bg-info">Patrimonial</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <small>{{ Str::limit($caso->regional_recibe_caso, 20) }}</small>
                                    </td>
                                    {{-- <td>
                                        <span class="badge bg-{{ $caso->estado == 'activo' ? 'success' : 'secondary' }}">
                                            {{ ucfirst($caso->estado ?? 'activo') }}
                                        </span>
                                    </td> --}}
                                    <td>
                                        <div class="btn-group" role="group">
                                            {{-- Botón Ver --}}
                                            <a href="#" class="btn btn-outline-primary" title="Ver detalles">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            {{-- <a href="{{ route('casos.show', $caso->id) }}" class="btn btn-outline-primary"
                                                title="Ver detalles">
                                                <i class="bi bi-eye"></i>
                                            </a> --}}

                                            {{-- Dropdown para fichas --}}
                                            <div class="btn-group" role="group">
                                                <button id="btnFichas{{ $caso->id }}" type="button"
                                                    class="btn btn-outline-success dropdown-toggle"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    Fichas Psicológicas
                                                </button>
                                                <ul class="dropdown-menu" aria-labelledby="btnFichas{{ $caso->id }}">
                                                    <li>
                                                        {{-- <a class="dropdown-item" href="#">
                                                            Ficha de Atención
                                                        </a> --}}
                                                        <a class="dropdown-item"
                                                            href="{{ route('casos.fichaAtencionEvaluacion.create', $caso->id) }}">
                                                            Ficha de Atención y Evaluación Psicológica
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="#">
                                                            Ficha de seguimiento psicológico
                                                        </a>
                                                        {{-- <a class="dropdown-item"
                                                            href="{{ route('casos.fichas_evaluacion.create', $caso->id) }}">
                                                            Ficha de Evaluación
                                                        </a> --}}
                                                    </li>
                                                </ul>
                                            </div>

                                            {{-- Editar --}}
                                            {{-- <a href="#" class="btn btn-outline-warning" title="Editar">
                                                <i class="bi bi-pencil"></i>
                                            </a> --}}
                                            <a href="{{ route('casos.edit', $caso->id) }}" class="btn btn-outline-warning"
                                                title="Editar">
                                                <i class="bi bi-pencil"></i>
                                            </a>

                                            {{-- Eliminar --}}
                                            <button type="button" class="btn btn-outline-danger" title="Eliminar"
                                                onclick="confirmarEliminacion({{ $caso->id }})">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="text-center py-4">
                                        <div class="text-muted">
                                            <i class="bi bi-inbox fs-1"></i>
                                            <p class="mt-2">No hay casos registrados</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card-footer bg-white">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <small class="text-muted">
                            Mostrando {{ $casos->firstItem() ?? 0 }} a {{ $casos->lastItem() ?? 0 }}
                            de {{ $casos->total() }} casos
                        </small>
                    </div>
                    <div>
                        {{ $casos->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function confirmarEliminacion(id) {
                if (confirm('¿Está seguro de eliminar este caso? Esta acción no se puede deshacer.')) {
                    document.getElementById('delete-form-' + id).submit();
                }
            }

            document.getElementById('btnLimpiar').addEventListener('click', function() {
                document.getElementById('searchInput').value = '';
                document.getElementById('filterDistrito').value = '';
                document.getElementById('filterTipoViolencia').value = '';
                document.getElementById('filterFecha').value = '';
                window.location.href = "{{ route('casos.index') }}";
            });

            // Búsqueda en tiempo real (opcional)
            document.getElementById('searchInput').addEventListener('keyup', function(e) {
                let searchTerm = e.target.value.toLowerCase();
                let rows = document.querySelectorAll('#tablaCasos tbody tr');

                rows.forEach(row => {
                    let text = row.textContent.toLowerCase();
                    row.style.display = text.includes(searchTerm) ? '' : 'none';
                });
            });

            // Filtrado por distrito, tipo de violencia y fecha
            document.getElementById('filterDistrito').addEventListener('change', function(e) {
                let distrito = e.target.value;
                let rows = document.querySelectorAll('#tablaCasos tbody tr');
                rows.forEach(row => {
                    let rowDistrito = row.querySelector('td:nth-child(6) .badge').textContent.replace(
                        'Distrito ', '');
                    row.style.display = distrito === '' || rowDistrito === distrito ? '' : 'none';
                });
            });
        </script>
    @endpush
@endsection
