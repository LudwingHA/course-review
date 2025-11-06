<x-guest-layout>
    <div class="max-w-md mx-auto bg-white dark:bg-gray-800 rounded-lg shadow-md p-8 mt-10">
        <h1 class="text-2xl font-bold text-center mb-6 text-gray-800 dark:text-gray-100">Iniciar sesión en CourseReview</h1>

        <!-- Estado de sesión -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email -->
            <div>
                <x-input-label for="email" :value="__('Correo electrónico')" />
                <x-text-input id="email" class="block mt-1 w-full"
                              type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('Contraseña')" />
                <x-text-input id="password" class="block mt-1 w-full"
                              type="password" name="password" required autocomplete="current-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Recordarme -->
            <div class="block mt-4">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox"
                           class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                           name="remember">
                    <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">Recordarme</span>
                </label>
            </div>

            <!-- Acciones -->
            <div class="flex items-center justify-between mt-6">
                @if (Route::has('password.request'))
                    <a class="text-sm text-blue-600 dark:text-blue-400 hover:underline"
                       href="{{ route('password.request') }}">
                        ¿Olvidaste tu contraseña?
                    </a>
                @endif

                <x-primary-button>
                    {{ __('Iniciar sesión') }}
                </x-primary-button>
            </div>

            <div class="text-center mt-6 text-sm text-gray-600 dark:text-gray-400">
                ¿Aún no tienes una cuenta?
                <a href="{{ route('register') }}" class="text-blue-600 hover:underline">
                    Regístrate aquí
                </a>
            </div>
        </form>
    </div>
</x-guest-layout>
