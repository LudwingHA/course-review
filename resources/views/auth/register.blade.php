<x-guest-layout>
    <div class="max-w-md mx-auto bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-8 mt-10 border border-gray-200 dark:border-gray-700">
        <h1 class="text-3xl font-extrabold text-center mb-6 text-gray-900 dark:text-white">Crear cuenta</h1>

        <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data" class="space-y-4">
            @csrf

            <div>
                <x-input-label for="name" :value="__('Nombre completo')" />
                <x-text-input id="name" class="block mt-1 w-full focus:ring-orange-500 focus:border-orange-500 dark:focus:ring-orange-400"
                              type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="email" :value="__('Correo electrónico')" />
                <x-text-input id="email" class="block mt-1 w-full focus:ring-orange-500 focus:border-orange-500 dark:focus:ring-orange-400"
                              type="email" name="email" :value="old('email')" required autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="password" :value="__('Contraseña')" />
                <x-text-input id="password" class="block mt-1 w-full focus:ring-orange-500 focus:border-orange-500 dark:focus:ring-orange-400"
                              type="password" name="password" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="password_confirmation" :value="__('Confirmar contraseña')" />
                <x-text-input id="password_confirmation" class="block mt-1 w-full focus:ring-orange-500 focus:border-orange-500 dark:focus:ring-orange-400"
                              type="password" name="password_confirmation" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <div class="pt-2">
                <x-input-label for="role" :value="__('Tipo de cuenta')" />
                <select id="role" name="role"
                        class="block w-full mt-1 px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 dark:focus:ring-orange-400 transition-colors text-gray-900 dark:text-white">
                    <option value="student" {{ old('role') == 'student' ? 'selected' : '' }}>Estudiante</option>
                    <option value="instructor" {{ old('role') == 'instructor' ? 'selected' : '' }}>Instructor</option>
                </select>
                <x-input-error :messages="$errors->get('role')" class="mt-2" />
            </div>

            <div class="pt-2">
                <x-input-label for="avatar" :value="__('Avatar (opcional)')" />
                <input id="avatar" type="file" name="avatar" accept="image/*"
                       class="block mt-1 w-full text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-medium 
                       file:bg-orange-100 dark:file:bg-orange-900/30 file:text-orange-700 dark:file:text-orange-300 
                       hover:file:bg-orange-200 dark:hover:file:bg-orange-900/50 transition-colors cursor-pointer">
                <x-input-error :messages="$errors->get('avatar')" class="mt-2" />
            </div>

            <div class="pt-2">
                <x-input-label for="description" :value="__('Descripción (opcional)')" />
                <textarea id="description" name="description"
                          class="block mt-1 w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 dark:focus:ring-orange-400 transition-colors placeholder-gray-400 dark:placeholder-gray-500 text-gray-900 dark:text-white resize-none"
                          rows="3" placeholder="Cuéntanos algo sobre ti...">{{ old('description') }}</textarea>
                <x-input-error :messages="$errors->get('description')" class="mt-2" />
            </div>

            <div class="flex items-center justify-between pt-6 border-t border-gray-200 dark:border-gray-700">
                <a href="{{ route('login') }}" class="text-sm font-medium text-gray-600 dark:text-gray-400 hover:text-orange-600 dark:hover:text-orange-400 hover:underline transition-colors">
                    ¿Ya tienes una cuenta?
                </a>

                <x-primary-button class="bg-gradient-to-r from-orange-600 to-red-600 hover:from-orange-700 hover:to-red-700 rounded-xl px-6 py-3 font-semibold shadow-md focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                    {{ __('Registrarme') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</x-guest-layout>