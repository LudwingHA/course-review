<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

        {{-- Encabezado --}}
        <div class="text-center mb-12">
            <h1 class="text-4xl md:text-5xl font-extrabold text-gray-900 dark:text-white mb-4 
                bg-gradient-to-r from-orange-600 to-red-600 bg-clip-text text-transparent">
                Explora Nuestros Cursos
            </h1>

            <p class="text-xl text-gray-600 dark:text-gray-400 max-w-2xl mx-auto leading-relaxed">
                Aprende, mejora y comparte conocimiento con instructores expertos.
            </p>
        </div>

        {{-- Filtros --}}
        <div
            class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 p-8 mb-12">

            <form method="GET" action="{{ route('home') }}" class="flex flex-col lg:flex-row gap-4 items-end">

                {{-- Buscador --}}
                <div class="flex-1 w-full">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Buscar cursos
                    </label>
                    <input type="text" name="q" value="{{ request('q') }}"
                        placeholder="Buscar curso, instructor o tema..."
                        class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-orange-500 text-gray-900 dark:text-white">
                </div>

                {{-- Categoría --}}
                <div class="w-full lg:w-64">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Categoría
                    </label>
                    <select name="category"
                        class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl text-gray-900 dark:text-white">
                        <option value="">Todas</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->slug }}" {{ request('category') == $cat->slug ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Botón --}}
                <button type="submit"
                    class="bg-gradient-to-r from-orange-600 to-red-600 text-white px-6 py-3 rounded-xl font-semibold shadow-md hover:scale-105 transition-all">
                    Buscar
                </button>

            </form>
        </div>

        {{-- Cursos --}}
        @if($courses->isEmpty())
            <div class="text-center text-gray-500 dark:text-gray-400 py-16">
                No hay cursos disponibles.
            </div>
        @else

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">

                @foreach($courses as $course)

                    @php
                        $likes = $course->likes_count ?? 0;
                        $totalReviews = $course->reviews_count ?? 0;
                        $avgRating = $course->reviews_avg_rating ?? 0;

                   
                        $ratingScore = ($avgRating / 5) * 100;

                        $reviewWeight = min($totalReviews / 20, 1); 

                    
                        $likeBonus = min($likes / 100, 1) * 5; 

                     
                        $ponderacionFinal = ($ratingScore * (0.6 + ($reviewWeight * 0.4))) + $likeBonus;
                    @endphp


                    <div
                        class="bg-white dark:bg-gray-800 rounded-2xl shadow-md border border-gray-200 dark:border-gray-700 overflow-hidden hover:shadow-xl transition-all">

                        {{-- Imagen --}}
                        <a href="{{ route('courses.show', $course) }}" class="block h-48 overflow-hidden">
                            @if ($course->image)
                                <img src="{{ asset('storage/' . $course->image) }}"
                                    class="h-full w-full object-cover hover:scale-105 transition-transform">
                            @else
                                <div class="h-full flex items-center justify-center bg-gray-200 dark:bg-gray-700 text-gray-500">
                                    Sin imagen
                                </div>
                            @endif
                        </a>

                        {{-- Contenido --}}
                        <div class="p-6">

                            {{-- Ponderación --}}
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-sm font-bold text-orange-600">
                                    🔥 {{ number_format($ponderacionFinal, 1) }}/100
                                </span>

                                <span class="text-xs text-gray-500 dark:text-gray-400">
                                    ⭐ {{ number_format($avgRating, 1) }} / 5
                                </span>
                            </div>

                            {{-- Título --}}
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">
                                {{ $course->title }}
                            </h3>

                            {{-- Instructor --}}
                       
                              <a href="{{ route('profile.public', $course->instructor->id) }}"
                                class="font-semibold text-orange-600 hover:underline">
                                {{ $course->instructor->name }}
                            </a>

                            {{-- Descripción --}}
                            <p class="text-sm text-gray-600 dark:text-gray-300 mb-4">
                                {{ \Illuminate\Support\Str::limit($course->description, 100) }}
                            </p>

                            {{-- Tags --}}
                            @if($course->tags)
                                <div class="flex flex-wrap gap-2 mb-4">
                                    @foreach(explode(',', $course->tags) as $tag)
                                        <span
                                            class="px-2 py-1 text-xs bg-gray-100 dark:bg-gray-700 rounded-full text-gray-700 dark:text-gray-300">
                                            #{{ trim($tag) }}
                                        </span>
                                    @endforeach
                                </div>
                            @endif

                            {{-- Likes y Reseñas --}}
                            <div
                                class="flex justify-between items-center border-t border-gray-200 dark:border-gray-700 pt-4 text-sm text-gray-500 dark:text-gray-400">

                                <span>❤️ {{ $likes }}</span>

                                <span>⭐ {{ $totalReviews }} reseñas</span>

                            </div>

                        </div>
                    </div>

                @endforeach
            </div>

            {{-- Paginación --}}
            <div class="mt-12">
                {{ $courses->links('vendor.pagination.tailwind') }}
            </div>

        @endif

    </div>
</x-app-layout>