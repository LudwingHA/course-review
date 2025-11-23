<x-app-layout>
    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <div class="mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white">Mis Cursos</h1>
                    <p class="mt-2 text-gray-600 dark:text-gray-400">Gestiona y organiza tus cursos publicados</p>
                </div>
                <a href="{{ route('courses.create') }}" 
                   class="mt-4 sm:mt-0 inline-flex items-center bg-gradient-to-r from-orange-600 to-red-600 hover:from-orange-700 hover:to-red-700 text-white px-6 py-3 rounded-xl font-semibold shadow-lg transition-all duration-300 transform hover:scale-[1.02] focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Nuevo Curso
                </a>
            </div>
        </div>

        @if($courses->isEmpty())
            <div class="text-center py-20 bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700">
                <svg class="w-24 h-24 mx-auto text-orange-400 dark:text-orange-500 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Aún no tienes cursos</h3>
                <p class="text-gray-500 dark:text-gray-400 mb-8 max-w-md mx-auto">Comienza compartiendo tu conocimiento creando tu primer curso.</p>
                <a href="{{ route('courses.create') }}" 
                   class="inline-flex items-center bg-gradient-to-r from-orange-600 to-red-600 hover:from-orange-700 hover:to-red-700 text-white px-6 py-3 rounded-xl font-semibold shadow-lg transition-all duration-300">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Crear mi primer curso
                </a>
            </div>
        @else
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex items-center justify-between">
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white">
                            {{ $courses->total() }} curso{{ $courses->total() > 1 ? 's' : '' }} publicado{{ $courses->total() > 1 ? 's' : '' }}
                        </h2>
                        <span class="text-sm text-gray-500 dark:text-gray-400">
                            Página {{ $courses->currentPage() }} de {{ $courses->lastPage() }}
                        </span>
                    </div>
                </div>

                <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($courses as $course)
                        <li class="p-6 hover:bg-orange-50 dark:hover:bg-gray-700/50 transition-colors">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-4">
                                    
                                    @if($course->image)
                                        <img src="{{ asset('storage/' . $course->image) }}" 
                                             alt="{{ $course->title }}"
                                             class="w-16 h-16 object-cover rounded-lg shadow-md">
                                    @else
                                        <div class="w-16 h-16 bg-gradient-to-br from-orange-100 to-red-100 dark:from-orange-900/50 dark:to-red-900/50 rounded-lg flex items-center justify-center shadow-md">
                                            <svg class="w-8 h-8 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                            </svg>
                                        </div>
                                    @endif
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-1">
                                            {{ $course->title }}
                                        </h3>
                                        <div class="flex items-center space-x-4 text-sm text-gray-500 dark:text-gray-400">
                                            <span class="flex items-center">
                                                <svg class="w-4 h-4 mr-1 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/>
                                                </svg>
                                                {{ $course->likes_count ?? 0 }} likes
                                            </span>
                                            <span class="flex items-center">
                                                <svg class="w-4 h-4 mr-1 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                </svg>
                                                {{ $course->reviews_count ?? 0 }} reseñas
                                            </span>
                                            @if($course->published_at)
                                                <span class="flex items-center">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                    </svg>
                                                    {{ $course->published_at->format('d M Y') }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="flex items-center space-x-3">
                                    <a href="{{ route('courses.edit', $course) }}" 
                                       class="inline-flex items-center px-4 py-2 bg-orange-50 dark:bg-orange-900/20 text-orange-700 dark:text-orange-300 rounded-lg hover:bg-orange-100 dark:hover:bg-orange-900/30 transition-colors font-medium text-sm shadow-sm">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                        Editar
                                    </a>
                                    <form action="{{ route('courses.destroy', $course) }}" method="POST" class="inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" 
                                                onclick="return confirm('¿Estás seguro de que quieres eliminar este curso?')"
                                                class="inline-flex items-center px-4 py-2 bg-red-50 dark:bg-red-900/20 text-red-700 dark:text-red-300 rounded-lg hover:bg-red-100 dark:hover:bg-red-900/30 transition-colors font-medium text-sm shadow-sm">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                            Eliminar
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>

                <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                    {{ $courses->links('vendor.pagination.tailwind') }}
                </div>
            </div>
        @endif
    </div>
</x-app-layout>