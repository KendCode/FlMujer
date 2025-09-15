<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Foto de perfil') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Sube o cambia tu foto de perfil. Se permiten imágenes JPG y PNG de máximo 2 MB.') }}
        </p>
    </header>

    <form method="POST" action="{{ route('profile.update.photo') }}" enctype="multipart/form-data" class="mt-6 space-y-6">
        @csrf
        @method('PATCH')

        <div class="flex items-center gap-4">
            <!-- Foto actual -->
            <div>
                @if(Auth::user()->foto)
                    <img src="{{ asset('storage/' . Auth::user()->foto) }}" 
                         alt="Foto de perfil" 
                         class="w-20 h-20 rounded-full object-cover">
                @else
                    <img src="{{ asset('storage/fotos/default.png') }}" 
                         alt="Foto por defecto" 
                         class="w-20 h-20 rounded-full object-cover">
                @endif
            </div>

            <!-- Input nueva foto -->
            <input id="foto" name="foto" type="file" 
                   class="block w-full text-sm text-gray-500" accept="image/*">
        </div>

        @error('foto')
            <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
        @enderror

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Actualizar Foto') }}</x-primary-button>
        </div>
    </form>
</section>
