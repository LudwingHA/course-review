{{-- resources/views/home.blade.php --}}
<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

        <!-- Encabezado -->
        <div class="text-center mb-10">
            <h1 class="text-4xl font-extrabold text-gray-900 dark:text-gray-100">Explora Nuestros Cursos</h1>
            <p class="mt-2 text-gray-600 dark:text-gray-400">Aprende, mejora y comparte conocimiento con instructores
                expertos.</p>
        </div>
        <!-- Buscador -->
        <form method="GET" action="{{ route('home') }}"
            class="mb-10 flex flex-col sm:flex-row items-center justify-center gap-3">
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Buscar curso o instructor..."
                class="w-full sm:w-1/2 rounded-lg border-gray-300 dark:bg-gray-800 dark:text-gray-200 focus:ring-indigo-500 focus:border-indigo-500">

            <select name="category"
                class="w-full sm:w-1/4 rounded-lg border-gray-300 dark:bg-gray-800 dark:text-gray-200 focus:ring-indigo-500 focus:border-indigo-500">
                <option value="">Todas las categorías</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->slug }}" {{ request('category') == $cat->slug ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                @endforeach
            </select>

            <button type="submit" class="px-5 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                Buscar 🔍
            </button>
        </form>

        @if($courses->isEmpty())
            <div class="text-center py-12">
                <p class="text-gray-500 dark:text-gray-400 text-lg">Aún no hay cursos disponibles.</p>
            </div>
        @else
            <!-- Grid de cursos -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($courses as $course)
                    <div
                        class="bg-white dark:bg-gray-900 shadow-sm rounded-2xl overflow-hidden hover:shadow-lg transition transform hover:-translate-y-1 duration-200">
                        <!-- Imagen del curso -->
                        <a href="{{ route('courses.show', $course) }}">
                            <img src="{{ $course->image ? asset('storage/' . $course->image) : asset('default-course.jpg') }}"
                                alt="Imagen del curso {{ $course->title }}" class="h-48 w-full object-cover">
                        </a>

                        <div class="p-5">
                            <!-- Categoría -->
                            @if($course->category)
                                <span
                                    class="inline-block px-3 py-1 text-xs font-semibold text-indigo-600 bg-indigo-100 dark:bg-indigo-800 dark:text-indigo-200 rounded-full mb-2">
                                    {{ $course->category }}
                                </span>
                            @endif

                            <!-- Título -->
                            <h2 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-1 line-clamp-1">
                                <a href="{{ route('courses.show', $course) }}" class="hover:text-indigo-600 transition">
                                    {{ $course->title }}
                                </a>
                            </h2>

                            <!-- Instructor -->
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">
                                👨‍🏫 {{ $course->instructor->name }}
                            </p>

                            <!-- Descripción -->
                            <p class="text-gray-700 dark:text-gray-300 text-sm mb-3 line-clamp-3">
                                {{ Str::limit($course->description, 120) }}
                            </p>

                            <!-- Etiquetas -->
                            @if($course->tags)
                                <div class="flex flex-wrap gap-1 mb-3">
                                    @foreach(explode(',', $course->tags) as $tag)
                                        <span
                                            class="text-xs px-2 py-1 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-md">#{{ trim($tag) }}</span>
                                    @endforeach
                                </div>
                            @endif

                            <!-- Información adicional -->
                            <div class="flex justify-between items-center text-sm text-gray-500 dark:text-gray-400">
                                <div class="flex items-center gap-1">
                                    ❤️ {{ $course->likes_count ?? 0 }}
                                </div>
                                @if($course->published_at)
                                    <span>📅 {{ \Carbon\Carbon::parse($course->published_at)->format('M Y') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Paginación -->
            <div class="mt-10">
                {{ $courses->links('vendor.pagination.tailwind') }}
            </div>
        @endif
    </div>
</x-app-layout>