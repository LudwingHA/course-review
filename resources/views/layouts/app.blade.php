<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script>
        // Este script ahora solo aplica la clase 'dark' si está en localStorage o prefiere el modo oscuro
        // Esto previene un destello de contenido sin estilo (FOUC)
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
</head>
<body class="font-sans antialiased bg-white dark:bg-gray-950 text-gray-900 dark:text-gray-100 min-h-screen transition-colors duration-300">
    <div class="min-h-screen flex flex-col">
        @include('layouts.navigation')

        @isset($header)
            <header class="bg-white dark:bg-gray-800 shadow-sm border-b border-gray-100 dark:border-gray-800">
                <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <main class="flex-1">
            {{ $slot }}
        </main>
    </div>
</body>
</html>