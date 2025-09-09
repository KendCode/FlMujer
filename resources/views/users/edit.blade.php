<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">Editar Usuario</h2>
    </x-slot>

    <div class="p-6">
        <form action="{{ route('users.update', $user) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label>CI</label>
                <input type="text" name="ci" value="{{ old('ci', $user->ci) }}" class="border rounded w-full p-2"
                    required>
                @error('ci')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-3">
                <label>Nombre</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}"
                    class="border rounded w-full p-2" required>
                @error('name')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-3">
                <label>Apellido</label>
                <input type="text" name="apellido" value="{{ old('apellido', $user->apellido) }}"
                    class="border rounded w-full p-2" required>
                @error('apellido')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}"
                    class="border rounded w-full p-2" required>
                @error('email')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-3">
                <label>Teléfono</label>
                <input type="text" name="telefono" value="{{ old('telefono', $user->telefono) }}"
                    class="border rounded w-full p-2">
            </div>

            <div class="mb-3">
                <label>Dirección</label>
                <input type="text" name="direccion" value="{{ old('direccion', $user->direccion) }}"
                    class="border rounded w-full p-2">
            </div>

            <div class="mb-3">
                <label>Fecha Nacimiento</label>
                <input type="date" name="fecha_nacimiento"
                    value="{{ old('fecha_nacimiento', $user->fecha_nacimiento ? \Carbon\Carbon::parse($user->fecha_nacimiento)->format('Y-m-d') : '') }}"
                    class="border rounded w-full p-2">
            </div>

            <div class="mb-3">
                <label>Fecha Ingreso</label>
                <input type="date" name="fecha_ingreso"
                    value="{{ old('fecha_ingreso', $user->fecha_ingreso ? \Carbon\Carbon::parse($user->fecha_ingreso)->format('Y-m-d') : '') }}"
                    class="border rounded w-full p-2">
            </div>

            <div class="mb-3">
                <label>Rol</label>
                <select name="rol" class="border rounded w-full p-2" required>
                    <option value="administrador" {{ $user->rol == 'administrador' ? 'selected' : '' }}>Administrador
                    </option>
                    <option value="trabajadora_social" {{ $user->rol == 'trabajadora_social' ? 'selected' : '' }}>
                        Trabajadora Social</option>
                    <option value="abogado" {{ $user->rol == 'abogado' ? 'selected' : '' }}>Abogado</option>
                    <option value="psicologo" {{ $user->rol == 'psicologo' ? 'selected' : '' }}>Psicólogo</option>
                </select>
            </div>

            <div class="mb-3">
                <label>Estado</label>
                <select name="estado" class="border rounded w-full p-2" required>
                    <option value="activo" {{ $user->estado == 'activo' ? 'selected' : '' }}>Activo</option>
                    <option value="inactivo" {{ $user->estado == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                </select>
            </div>

            <div class="mb-3">
                <label>Nueva Contraseña (opcional)</label>
                <input type="password" name="password" class="border rounded w-full p-2">
                <p class="text-gray-500 text-sm">Si no deseas cambiarla, deja este campo vacío</p>
            </div>

            <div class="flex space-x-3 mt-4">
                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Actualizar</button>
                <a href="{{ route('users.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded">Cancelar</a>
            </div>
        </form>
    </div>
</x-app-layout>
