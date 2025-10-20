@extends('layouts.sidebar')

@section('content')
    <div class="container" style="background-color: #F4F4F2; padding: 20px; border-radius: 10px;">
        <h3 class="mb-4" style="color: #037E8C;">📋 Fichas de Seguimiento Psicológico - Caso: {{ $caso->nro_registro }}</h3>

        <div class="mb-3">
            <a href="{{ route('casos.fichaSeguimientoPsicologico.create', $caso->id) }}" class="btn"
                style="background-color: #13C0E5; color: #fff;">+ Nueva Ficha</a>
        </div>

        @if ($fichas->isEmpty())
            <p>No hay fichas registradas para este caso.</p>
        @else
            <table class="table table-bordered">
                <thead style="background-color: #037E8C; color: #fff;">
                    <tr>
                        <th>#</th>
                        <th>Fecha</th>
                        <th>Número de sesión</th>
                        <th>Nombre paciente</th>
                        <th>Estrategia</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($fichas as $ficha)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ \Carbon\Carbon::parse($ficha->fecha)->format('d/m/Y') }}</td>
                            <td>{{ $ficha->nro_sesion }}</td>
                            <td>{{ $ficha->nombre_apellidos }}</td>
                            <td>{{ $ficha->estrategia }}</td>
                            <td>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('casos.fichaSeguimientoPsicologico.edit', [$caso->id, $ficha->id]) }}"
                                        class="btn btn-sm" style="background-color: #13C0E5; color: #fff;">Editar</a>

                                    <button type="button" 
                                        class="btn btn-danger btn-sm" 
                                        onclick="confirmarEliminacion({{ $ficha->id }}, '{{ $ficha->nro_sesion }}')">
                                        Eliminar
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

        <a href="{{ route('casos.index') }}" class="btn mt-3" style="background-color: #037E8C; color: #fff;">Volver a Casos</a>

    </div>

    <!-- Modal Custom -->
    <div id="customModal" style="display: none; position: fixed; z-index: 9999; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5);">
        <div style="position: relative; top: 50%; left: 50%; transform: translate(-50%, -50%); background-color: white; padding: 0; border-radius: 8px; max-width: 500px; width: 90%; box-shadow: 0 4px 6px rgba(0,0,0,0.3);">
            
            <!-- Header -->
            <div style="background-color: #037E8C; color: white; padding: 15px 20px; border-radius: 8px 8px 0 0; display: flex; justify-content: space-between; align-items: center;">
                <h5 style="margin: 0; font-size: 1.1rem;">Confirmar eliminación</h5>
                <button onclick="cerrarModal()" style="background: none; border: none; color: white; font-size: 1.5rem; cursor: pointer; padding: 0; width: 30px; height: 30px; line-height: 1;">&times;</button>
            </div>
            
            <!-- Body -->
            <div style="padding: 20px;">
                <p style="margin-bottom: 15px; color: #333;">
                    ¿Estás seguro de que deseas eliminar la ficha de seguimiento 
                    <strong>Sesión N° <span id="modalSesionNumero"></span></strong>?
                </p>
                <p style="margin: 0; color: #666;">Esta acción no se puede deshacer.</p>
            </div>
            
            <!-- Footer -->
            <div style="padding: 15px 20px; border-top: 1px solid #dee2e6; display: flex; justify-content: flex-end; gap: 10px;">
                <button type="button" onclick="cerrarModal()" class="btn btn-secondary">Cancelar</button>
                <form id="formEliminar" method="POST" action="" style="display: inline; margin: 0;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Eliminar</button>
                </form>
            </div>
            
        </div>
    </div>

    <script>
        function confirmarEliminacion(fichaId, nroSesion) {
            // Actualizar número de sesión en el modal
            document.getElementById('modalSesionNumero').textContent = nroSesion;
            
            // Actualizar action del formulario
            document.getElementById('formEliminar').action = 
                '{{ url("casos/" . $caso->id . "/fichaSeguimientoPsicologico") }}/' + fichaId;
            
            // Mostrar modal
            document.getElementById('customModal').style.display = 'block';
            
            // Prevenir scroll del body
            document.body.style.overflow = 'hidden';
        }
        
        function cerrarModal() {
            document.getElementById('customModal').style.display = 'none';
            document.body.style.overflow = 'auto';
        }
        
        // Cerrar modal al hacer clic fuera
        document.addEventListener('click', function(event) {
            const modal = document.getElementById('customModal');
            if (event.target === modal) {
                cerrarModal();
            }
        });
        
        // Cerrar modal con ESC
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                cerrarModal();
            }
        });
    </script>

@endsection