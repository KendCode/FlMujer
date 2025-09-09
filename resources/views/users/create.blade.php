<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">Crear Usuario</h2>
    </x-slot>

    <div class="p-6">
        <form action="{{ route('users.store') }}" method="POST">
            @csrf
            <div>
                <label>CI</label>
                <input type="text" name="ci" class="border rounded w-full" required>
            </div>
            <div>
                <label>Nombre</label>
                <input type="text" name="name" class="border rounded w-full" required>
            </div>
            <div>
                <label>Apellido</label>
                <input type="text" name="apellido" class="border rounded w-full" required>
            </div>
            <div>
                <label>Email</label>
                <input type="email" name="email" class="border rounded w-full" required>
            </div>
            <div>
                <label>Teléfono</label>
                <input type="text" name="telefono" class="border rounded w-full">
            </div>
            <div>
                <label>Dirección</label>
                <input type="text" name="direccion" class="border rounded w-full">
            </div>
            <div>
                <label>Fecha Nacimiento</label>
                <input type="date" name="fecha_nacimiento" class="border rounded w-full">
            </div>
            <div>
                <label>Fecha Ingreso</label>
                <input type="date" name="fecha_ingreso" class="border rounded w-full">
            </div>
            <div>
                <label>Contraseña</label>
                <input type="password" name="password" class="border rounded w-full" required>
            </div>
            <div>
                <label>Confirmar Contraseña</label>
                <input type="password" name="password_confirmation" class="border rounded w-full" required>
            </div>
            <div>
                <label>Rol</label>
                <select name="rol" class="border rounded w-full" required>
                    <option value="administrador">Administrador</option>
                    <option value="trabajadora_social">Trabajadora Social</option>
                    <option value="abogado">Abogado</option>
                    <option value="psicologo">Psicólogo</option>
                </select>
            </div>
            <div>
                <label>Estado</label>
                <select name="estado" class="border rounded w-full">
                    <option value="activo">Activo</option>
                    <option value="inactivo">Inactivo</option>
                </select>
            </div>
            <button class="bg-green-500 text-white px-4 py-2 rounded mt-3">Guardar</button>
        </form>
    </div>
</x-app-layout>
