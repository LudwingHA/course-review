<x-guest-layout>
    <div class="max-w-md mx-auto bg-white dark:bg-gray-800 rounded-lg shadow-md p-8 mt-10">
        <h1 class="text-2xl font-bold text-center mb-6 text-gray-800 dark:text-gray-100">Crear cuenta en CourseReview</h1>

        <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
            @csrf

            <!-- Nombre -->
            <div>
                <x-input-label for="name" :value="__('Nombre completo')" />
                <x-text-input id="name" class="block mt-1 w-full"
                              type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Email -->
            <div class="mt-4">
                <x-input-label for="email" :value="__('Correo electrónico')" />
                <x-text-input id="email" class="block mt-1 w-full"
                              type="email" name="email" :value="old('email')" required autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Contraseña -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('Contraseña')" />
                <x-text-input id="password" class="block mt-1 w-full"
                              type="password" name="password" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirmación -->
            <div class="mt-4">
                <x-input-label for="password_confirmation" :value="__('Confirmar contraseña')" />
                <x-text-input id="password_confirmation" class="block mt-1 w-full"
                              type="password" name="password_confirmation" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <!-- Rol -->
            <div class="mt-4">
                <x-input-label for="role" :value="__('Tipo de cuenta')" />
                <select id="role" name="role"
                        class="block w-full rounded-md border-gray-300 dark:bg-gray-900 dark:text-gray-200 focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="student" {{ old('role') == 'student' ? 'selected' : '' }}>Estudiante</option>
                    <option value="instructor" {{ old('role') == 'instructor' ? 'selected' : '' }}>Instructor</option>
                </select>
                <x-input-error :messages="$errors->get('role')" class="mt-2" />
            </div>

            <!-- Avatar -->
            <div class="mt-4">
                <x-input-label for="avatar" :value="__('Avatar (opcional)')" />
                <input id="avatar" type="file" name="avatar" accept="image/*"
                       class="block mt-1 w-full text-sm text-gray-700 dark:text-gray-300 border border-gray-300 rounded-md cursor-pointer focus:ring-indigo-500 focus:border-indigo-500">
                <x-input-error :messages="$errors->get('avatar')" class="mt-2" />
            </div>

            <!-- Descripción -->
            <div class="mt-4">
                <x-input-label for="description" :value="__('Descripción (opcional)')" />
                <textarea id="description" name="description"
                          class="block mt-1 w-full rounded-md border-gray-300 dark:bg-gray-900 dark:text-gray-200 focus:ring-indigo-500 focus:border-indigo-500"
                          rows="3" placeholder="Cuéntanos algo sobre ti...">{{ old('description') }}</textarea>
                <x-input-error :messages="$errors->get('description')" class="mt-2" />
            </div>

            <!-- Acciones -->
            <div class="flex items-center justify-between mt-6">
                <a href="{{ route('login') }}" class="text-sm text-blue-600 hover:underline">
                    ¿Ya tienes una cuenta?
                </a>

                <x-primary-button>
                    {{ __('Registrarme') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</x-guest-layout>
