<nav x-data="{ open: false, userOpen: false }"
    class="bg-white dark:bg-gray-900 border-b border-gray-200 dark:border-gray-800 shadow-sm transition-colors duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <a href="{{ route('home') }}" class="flex items-center space-x-3">
                    <x-application-logo
                        class="block h-8 w-auto text-orange-600 dark:text-orange-400 transition-colors" />
                    <span
                        class="text-xl font-extrabold text-gray-900 dark:text-white">{{ config('app.name', 'CourseReview') }}</span>
                </a>

                <div class="hidden md:flex md:items-center md:space-x-1 md:ml-10">
                    <x-nav-link :href="route('home')" :active="request()->routeIs('home')"
                        class="text-orange-600 dark:text-orange-400 hover:text-orange-800 dark:hover:text-orange-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        {{ __('Inicio') }}
                    </x-nav-link>

                    @if(Auth::check() && Auth::user()->isInstructor())
                        <x-nav-link :href="route('courses.index')" :active="request()->routeIs('courses.*')">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 14l9-5-9-5-9 5 9 5z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 14l9-5-9-5-9 5 9 5zm0 0l9 5m-9-5v10" />
                            </svg>
                            {{ __('Mis Cursos') }}
                        </x-nav-link>
                    @endif

                    @if(Auth::check() && Auth::user()->isStudent())
                        <x-nav-link :href="route('profile.edit')" :active="request()->routeIs('profile.edit')">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            {{ __('Mi Perfil') }}
                        </x-nav-link>
                    @endif
                </div>
            </div>

            <div class="flex items-center space-x-4">
                <button
                    @click="document.documentElement.classList.toggle('dark'); localStorage.theme = document.documentElement.classList.contains('dark') ? 'dark' : 'light'"
                    class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                    <svg x-show="!document.documentElement.classList.contains('dark')" class="w-5 h-5 text-gray-600"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                    </svg>
                    <svg x-show="document.documentElement.classList.contains('dark')" class="w-5 h-5 text-yellow-400"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </button>

                @auth
                    <div class="relative" x-data="{ userOpen: false }">
                        <button @click="userOpen = !userOpen"
                            class="flex items-center space-x-3 p-2 rounded-xl hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-opacity-50">
                            <div class="flex items-center space-x-2">
                                <div class="relative">
                                    @if(Auth::user()->avatar)
                                       <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="Foto de perfil"
                                            class="w-9 h-9 rounded-full object-cover border-2 border-orange-500 shadow-md hover:ring-2 hover:ring-orange-400 transition">
                                    @else
                                        <div
                                            class="w-9 h-9 rounded-full bg-gradient-to-r from-orange-500 to-red-600 flex items-center justify-center text-white font-semibold border-2 border-orange-500 shadow-md">
                                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                        </div>
                                    @endif
                                </div>

                                <span
                                    class="hidden lg:block font-medium text-gray-700 dark:text-gray-300">{{ Auth::user()->name }}</span>
                            </div>
                        </button>

                        <div x-show="userOpen" @click.outside="userOpen = false"
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                            class="absolute right-0 mt-2 w-56 bg-white dark:bg-gray-800 rounded-xl shadow-2xl border border-gray-100 dark:border-gray-700 py-1 z-50 origin-top-right">
                            <div
                                class="px-4 py-2 text-xs text-gray-400 dark:text-gray-500 border-b border-gray-100 dark:border-gray-700">
                                {{ Auth::user()->email }}
                            </div>
                            <x-dropdown-link :href="route('profile.public', Auth::user())"
                                class="flex items-center px-4 py-2 hover:bg-orange-50 dark:hover:bg-gray-700 transition-colors">
                                <svg class="w-4 h-4 mr-3 text-orange-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                {{ __('Ver perfil público') }}
                            </x-dropdown-link>
                            <x-dropdown-link :href="route('profile.edit')"
                                class="flex items-center px-4 py-2 hover:bg-orange-50 dark:hover:bg-gray-700 transition-colors">
                                <svg class="w-4 h-4 mr-3 text-orange-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                {{ __('Editar perfil') }}
                            </x-dropdown-link>
                            <div class="border-t border-gray-200 dark:border-gray-600 my-1"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();"
                                    class="flex items-center px-4 py-2 text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-gray-700 transition-colors">
                                    <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                    </svg>
                                    {{ __('Cerrar sesión') }}
                                </x-dropdown-link>
                            </form>
                        </div>
                    </div>
                @endauth

                @guest
                    <div class="flex items-center space-x-3">
                        <a href="{{ route('login') }}"
                            class="text-gray-600 dark:text-gray-400 hover:text-orange-600 dark:hover:text-orange-400 font-medium transition-colors">
                            {{ __('Iniciar sesión') }}
                        </a>
                        <a href="{{ route('register') }}"
                            class="bg-orange-600 hover:bg-orange-700 text-white px-4 py-2 rounded-xl font-semibold transition-all duration-300 shadow-md hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-opacity-50">
                            {{ __('Registrarse') }}
                        </a>
                    </div>
                @endguest
            </div>

        </div>
    </div>
</nav>

<div x-show="open" x-transition
    class="md:hidden bg-white dark:bg-gray-900 border-t border-gray-200 dark:border-gray-800">
    <div class="px-2 pt-2 pb-3 space-y-1">
    </div>

    @auth
        <div class="pt-4 pb-3 border-t border-gray-200 dark:border-gray-800">
            <div class="px-4 space-y-3">
                <div class="flex items-center space-x-3">
                    <div
                        class="w-10 h-10 bg-gradient-to-r from-orange-500 to-red-600 rounded-full flex items-center justify-center text-white font-semibold shadow-md">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                </div>
            </div>
        </div>
    @endauth

    @guest
        <div class="pt-4 pb-3 border-t border-gray-200 dark:border-gray-800 px-4 space-y-2">
            <a href="{{ route('login') }}"
                class="block text-gray-600 dark:text-gray-400 hover:text-orange-600 dark:hover:text-orange-400 font-medium py-2">
                {{ __('Iniciar sesión') }}
            </a>
            <a href="{{ route('register') }}"
                class="block bg-orange-600 hover:bg-orange-700 text-white text-center py-2 rounded-xl font-semibold transition-colors shadow-md">
                {{ __('Registrarse') }}
            </a>
        </div>
    @endguest
</div>