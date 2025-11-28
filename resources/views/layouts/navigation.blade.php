<nav x-data="{ open: false }"
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
                        Inicio
                    </x-nav-link>

                    @if(Auth::check() && Auth::user()->isInstructor())
                        <x-nav-link :href="route('courses.index')" :active="request()->routeIs('courses.*')">
                            Mis Cursos
                        </x-nav-link>
                    @endif

                    @if(Auth::check() && Auth::user()->isStudent())
                        <x-nav-link :href="route('profile.edit')" :active="request()->routeIs('profile.edit')">
                            Mi Perfil
                        </x-nav-link>
                    @endif

                    @auth
                        @if(Auth::user()->isAdmin())
                            <x-nav-link :href="route('admin.users.index')" 
                                class="text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-200 font-semibold">
                                Panel Admin
                            </x-nav-link>
                        @endif
                    @endauth
                </div>
            </div>

            <div class="flex items-center space-x-4">
                {{-- Botón dark mode --}}
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

                {{-- Perfil --}}
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
                            x-transition class="absolute right-0 mt-2 w-56 bg-white dark:bg-gray-800 rounded-xl shadow-2xl border border-gray-100 dark:border-gray-700 py-1 z-50 origin-top-right">
                            
                            <div class="px-4 py-2 text-xs text-gray-400 dark:text-gray-500 border-b border-gray-100 dark:border-gray-700">
                                {{ Auth::user()->email }}
                            </div>

                            <x-dropdown-link :href="route('profile.public', Auth::user())">
                                Ver perfil público
                            </x-dropdown-link>
                            <x-dropdown-link :href="route('profile.edit')">
                                Editar perfil
                            </x-dropdown-link>

                            @if(Auth::user()->isAdmin())
                                <x-dropdown-link :href="route('admin.users.index')" class="text-red-600 dark:text-red-400">
                                    Panel Admin
                                </x-dropdown-link>
                            @endif

                            <div class="border-t border-gray-200 dark:border-gray-600 my-1"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();"
                                    class="text-red-600 dark:text-red-400">
                                    Cerrar sesión
                                </x-dropdown-link>
                            </form>
                        </div>
                    </div>
                @endauth

                @guest
                    <div class="flex items-center space-x-3">
                        <a href="{{ route('login') }}" class="text-gray-600 dark:text-gray-400 hover:text-orange-600 dark:hover:text-orange-400 font-medium">
                            Iniciar sesión
                        </a>
                        <a href="{{ route('register') }}"
                            class="bg-orange-600 hover:bg-orange-700 text-white px-4 py-2 rounded-xl font-semibold transition-all shadow-md">
                            Registrarse
                        </a>
                    </div>
                @endguest
            </div>
        </div>
    </div>
</nav>
