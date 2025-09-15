<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-200">
            Crear Usuario
        </h2>
    </x-slot>

    <div class="p-6 max-w-3xl mx-auto">
        <div class="bg-white dark:bg-gray-800 shadow-lg rounded-2xl p-8">
            <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                @csrf

                <!-- CI -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">CI</label>
                    <input type="text" name="ci" class="mt-1 w-full border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500" required>
                </div>

                <!-- Nombre -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nombre</label>
                    <input type="text" name="name" class="mt-1 w-full border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500" required>
                </div>

                <!-- Apellido -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Apellido</label>
                    <input type="text" name="apellido" class="mt-1 w-full border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500" required>
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
                    <input type="email" name="email" class="mt-1 w-full border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500" required>
                </div>

                <!-- Teléfono -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Teléfono</label>
                    <input type="text" name="telefono" class="mt-1 w-full border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500">
                </div>

                <!-- Dirección -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Dirección</label>
                    <input type="text" name="direccion" class="mt-1 w-full border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500">
                </div>

                <!-- Fechas -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Fecha Nacimiento</label>
                        <input type="date" name="fecha_nacimiento" class="mt-1 w-full border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Fecha Ingreso</label>
                        <input type="date" name="fecha_ingreso" class="mt-1 w-full border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500">
                    </div>
                </div>

                <!-- Contraseña -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Contraseña</label>
                        <input type="password" name="password" class="mt-1 w-full border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Confirmar Contraseña</label>
                        <input type="password" name="password_confirmation" class="mt-1 w-full border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500" required>
                    </div>
                </div>

                <!-- Rol -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Rol</label>
                    <select name="rol" class="mt-1 w-full border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500" required>
                        <option value="administrador">Administrador</option>
                        <option value="trabajadora_social">Trabajadora Social</option>
                        <option value="abogado">Abogado</option>
                        <option value="psicologo">Psicólogo</option>
                    </select>
                </div>

                <!-- Estado -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Estado</label>
                    <select name="estado" class="mt-1 w-full border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500">
                        <option value="activo">Activo</option>
                        <option value="inactivo">Inactivo</option>
                    </select>
                </div>

                <!-- Foto -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Foto de Perfil</label>
                    <input type="file" name="foto" class="mt-1 w-full border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500">
                </div>

                <!-- Botón -->
                <div class="pt-4">
                    <button class="w-full md:w-auto bg-green-600 hover:bg-green-700 text-white font-semibold px-6 py-3 rounded-lg shadow-md transition duration-300 ease-in-out">
                        Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
