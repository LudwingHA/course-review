<x-guest-layout>
    <div class="max-w-md mx-auto bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-8 mt-10 border border-gray-200 dark:border-gray-700">
        <h1 class="text-3xl font-extrabold text-center mb-6 text-gray-900 dark:text-white">Iniciar sesión</h1>

        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf

            <div>
                <x-input-label for="email" :value="__('Correo electrónico')" />
                <x-text-input id="email" 
                              class="block mt-1 w-full focus:ring-orange-500 focus:border-orange-500 dark:focus:ring-orange-400"
                              type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="password" :value="__('Contraseña')" />
                <x-text-input id="password" 
                              class="block mt-1 w-full focus:ring-orange-500 focus:border-orange-500 dark:focus:ring-orange-400"
                              type="password" name="password" required autocomplete="current-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="block pt-2">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox"
                           class="rounded border-gray-300 text-orange-600 shadow-sm focus:ring-orange-500 dark:bg-gray-700 dark:border-gray-600"
                           name="remember">
                    <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">Recordarme</span>
                </label>
            </div>

            <div class="flex items-center justify-between pt-4">
                @if (Route::has('password.request'))
                    <a class="text-sm text-orange-600 dark:text-orange-400 hover:text-orange-800 dark:hover:text-orange-300 hover:underline transition-colors font-medium"
                       href="{{ route('password.request') }}">
                        ¿Olvidaste tu contraseña?
                    </a>
                @endif

                <x-primary-button class="bg-gradient-to-r from-orange-600 to-red-600 hover:from-orange-700 hover:to-red-700 rounded-xl px-6 py-3 font-semibold shadow-md focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                    {{ __('Iniciar sesión') }}
                </x-primary-button>
            </div>

            <div class="text-center pt-4 border-t border-gray-200 dark:border-gray-700">
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    ¿Aún no tienes una cuenta?
                    <a href="{{ route('register') }}" class="font-semibold text-orange-600 dark:text-orange-400 hover:underline hover:text-orange-800 transition-colors">
                        Regístrate aquí
                    </a>
                </p>
            </div>
        </form>
    </div>
</x-guest-layout>