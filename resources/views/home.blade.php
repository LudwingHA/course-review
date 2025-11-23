<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="text-center mb-12">
            <h1 class="text-4xl md:text-5xl font-extrabold text-gray-900 dark:text-white mb-4 bg-gradient-to-r from-orange-600 to-red-600 bg-clip-text text-transparent">
                Explora Nuestros Cursos
            </h1>
            <p class="text-xl text-gray-600 dark:text-gray-400 max-w-2xl mx-auto leading-relaxed">
                Aprende, mejora y comparte conocimiento con instructores expertos en nuestra plataforma.
            </p>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 p-8 mb-12">
            <form method="GET" action="{{ route('home') }}" class="flex flex-col lg:flex-row gap-4 items-end">
                <div class="flex-1 w-full">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Buscar cursos</label>
                    <div class="relative">
                        <input type="text" name="q" value="{{ request('q') }}" 
                               placeholder="Buscar curso, instructor o tema..."
                               class="w-full pl-10 pr-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 dark:focus:ring-orange-400 transition-colors placeholder-gray-400 dark:placeholder-gray-500 text-gray-900 dark:text-white">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="w-full lg:w-64">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Categoría</label>
                    <select name="category" class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 dark:focus:ring-orange-400 transition-colors text-gray-900 dark:text-white">
                        <option value="">Todas las categorías</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->slug }}" {{ request('category') == $cat->slug ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="w-full lg:w-auto bg-gradient-to-r from-orange-600 to-red-600 hover:from-orange-700 hover:to-red-700 text-white px-6 py-3 rounded-xl font-semibold shadow-md transition-all duration-200 transform hover:scale-[1.02] focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 flex items-center justify-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    Buscar
                </button>
            </form>
        </div>

        @if($courses->isEmpty())
            <div class="text-center py-20 bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700">
                <div class="max-w-md mx-auto">
                    <svg class="w-24 h-24 mx-auto text-orange-400 dark:text-orange-500 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">No se encontraron cursos</h3>
                    <p class="text-gray-500 dark:text-gray-400 mb-6">Parece que no hay cursos disponibles con los criterios de búsqueda actuales.</p>
                    <a href="{{ route('home') }}" class="inline-flex items-center text-orange-600 dark:text-orange-400 hover:text-orange-800 dark:hover:text-orange-300 font-semibold transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                        Ver todos los cursos
                    </a>
                </div>
            </div>
        @else
            <div class="mb-8">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-extrabold text-gray-900 dark:text-white">
                        {{ $courses->total() }} curso{{ $courses->total() > 1 ? 's' : '' }} disponible{{ $courses->total() > 1 ? 's' : '' }}
                    </h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($courses as $course)
                        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md border border-gray-200 dark:border-gray-700 overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 group">
                            <a href="{{ route('courses.show', $course) }}" class="block relative overflow-hidden h-48">
                                @if ($course->image)
                                    <img src="{{ asset('storage/' . $course->image) }}"
                                       alt="Imagen del curso {{ $course->title }}" 
                                       class="h-full w-full object-cover group-hover:scale-105 transition-transform duration-500">
                                @else
                                    <div class="h-full w-full flex items-center justify-center bg-gradient-to-br from-orange-100 to-red-100 dark:from-orange-900/50 dark:to-red-900/50">
                                        <svg class="w-16 h-16 text-orange-600 dark:text-orange-400 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                        </svg>
                                    </div>
                                @endif
                                
                                @if($course->category)
                                    <div class="absolute top-4 left-4">
                                        <span class="inline-flex items-center px-4 py-1.5 rounded-full text-xs font-semibold bg-orange-600 text-white shadow-lg">
                                            {{ $course->category }}
                                        </span>
                                    </div>
                                @endif
                            </a>

                            <div class="p-6">
                                <h3 class="text-xl font-extrabold text-gray-900 dark:text-white mb-2 line-clamp-2 group-hover:text-orange-600 dark:group-hover:text-orange-400 transition-colors">
                                    <a href="{{ route('courses.show', $course) }}" class="hover:no-underline">
                                        {{ $course->title }}
                                    </a>
                                </h3>

                                <div class="flex items-center text-sm text-gray-600 dark:text-gray-400 mb-3">
                                    <svg class="w-4 h-4 mr-2 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                    <span class="font-medium">{{ $course->instructor->name }}</span>
                                </div>

                                <p class="text-gray-600 dark:text-gray-300 text-sm mb-4 line-clamp-3 leading-relaxed">
                                    {{ Str::limit($course->description, 120) }}
                                </p>

                                @if($course->tags)
                                    <div class="flex flex-wrap gap-2 mb-4">
                                        @foreach(explode(',', $course->tags) as $tag)
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300">
                                                #{{ trim($tag) }}
                                            </span>
                                        @endforeach
                                    </div>
                                @endif

                                <div class="flex items-center justify-between text-sm text-gray-500 dark:text-gray-400 pt-4 border-t border-gray-200 dark:border-gray-700">
                                    <div class="flex items-center space-x-4">
                                        <span class="flex items-center">
                                            <svg class="w-4 h-4 mr-1 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/>
                                            </svg>
                                            {{ $course->likes_count ?? 0 }}
                                        </span>
                                        <span class="flex items-center">
                                            <svg class="w-4 h-4 mr-1 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                            </svg>
                                            {{ $course->reviews_count ?? 0 }}
                                        </span>
                                    </div>
                                    @if($course->published_at)
                                        <span class="flex items-center text-xs">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                            {{ \Carbon\Carbon::parse($course->published_at)->format('M Y') }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="mt-12">
                {{ $courses->links('vendor.pagination.tailwind') }}
            </div>
        @endif
    </div>
</x-app-layout>