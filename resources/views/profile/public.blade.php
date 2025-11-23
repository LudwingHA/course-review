<x-app-layout>
    <div class="max-w-4xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 p-8 mb-8">
            <div class="flex flex-col md:flex-row items-center md:items-start gap-8">
                <div class="relative shrink-0">
                    <img src="{{ $user->avatar ? asset('storage/'.$user->avatar) : 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80' }}"
                         class="w-32 h-32 rounded-full object-cover border-4 border-orange-200 dark:border-orange-900/50 shadow-lg">
                    <div class="absolute -bottom-2 -right-2 bg-gradient-to-r from-orange-500 to-red-600 rounded-full p-2 shadow-xl border-2 border-white dark:border-gray-800">
                        @if($user->isInstructor())
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l9 5m-9-5v10"/>
                            </svg>
                        @else
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        @endif
                    </div>
                </div>

                <div class="flex-1 text-center md:text-left">
                    <h1 class="text-4xl font-extrabold text-gray-900 dark:text-white mb-2">{{ $user->name }}</h1>
                    <div class="inline-flex items-center px-4 py-1 rounded-full text-sm font-semibold bg-orange-100 dark:bg-orange-900/30 text-orange-800 dark:text-orange-200 mb-4 shadow-sm">
                        {{ $user->isInstructor() ? 'Instructor' : 'Estudiante' }}
                    </div>
                    
                    @if($user->description)
                        <p class="text-gray-700 dark:text-gray-300 text-lg leading-relaxed max-w-2xl">{{ $user->description }}</p>
                    @else
                        <p class="text-gray-400 dark:text-gray-500 italic text-lg">Este usuario aún no ha escrito una descripción.</p>
                    @endif
                </div>
            </div>
        </div>

        @if($user->isInstructor())
            <div class="mb-8">
                <div class="flex items-center justify-between mb-6 border-b border-gray-200 dark:border-gray-700 pb-3">
                    <h2 class="text-2xl font-extrabold text-gray-900 dark:text-white">Cursos de {{ $user->name }}</h2>
                    <span class="bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 px-3 py-1 rounded-full text-sm font-medium">
                        {{ $user->courses->count() }} cursos
                    </span>
                </div>

                <div class="grid gap-6">
                    @forelse($user->courses as $course)
                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md border border-gray-200 dark:border-gray-700 p-6 hover:shadow-lg transition-shadow duration-200">
                            <div class="flex justify-between items-start mb-3">
                                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                    <a href="{{ route('courses.show', $course) }}" class="hover:text-orange-600 dark:hover:text-orange-400 transition-colors">
                                        {{ $course->title }}
                                    </a>
                                </h3>
                                <div class="flex items-center space-x-4 text-sm text-gray-500 dark:text-gray-400">
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 mr-1 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                        {{ $course->reviews->count() }} reseñas
                                    </span>
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 mr-1 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/>
                                        </svg>
                                        {{ $course->likes()->count() }} likes
                                    </span>
                                </div>
                            </div>
                            <p class="text-gray-600 dark:text-gray-300 mb-4 leading-relaxed">{{ Str::limit($course->description, 200) }}</p>
                            <a href="{{ route('courses.show', $course) }}" class="inline-flex items-center text-orange-600 dark:text-orange-400 hover:text-orange-800 dark:hover:text-orange-300 font-semibold transition-colors">
                                Ver curso
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
                        </div>
                    @empty
                        <div class="text-center py-12 bg-gray-50 dark:bg-gray-700/50 rounded-xl border border-gray-200 dark:border-gray-700 shadow-inner">
                            <svg class="w-16 h-16 mx-auto text-orange-400 dark:text-orange-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                            <p class="text-gray-500 dark:text-gray-400 text-lg">Este instructor aún no tiene cursos publicados</p>
                        </div>
                    @endforelse
                </div>
            </div>

        @elseif($user->isStudent())
            <div class="mb-8">
                <div class="flex items-center justify-between mb-6 border-b border-gray-200 dark:border-gray-700 pb-3">
                    <h2 class="text-2xl font-extrabold text-gray-900 dark:text-white">Reseñas de {{ $user->name }}</h2>
                    <span class="bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 px-3 py-1 rounded-full text-sm font-medium">
                        {{ $user->reviews->count() }} reseñas
                    </span>
                </div>

                <div class="grid gap-6">
                    @forelse($user->reviews as $review)
                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md border border-gray-200 dark:border-gray-700 p-6">
                            <div class="flex items-start justify-between mb-3">
                                <div class="flex items-center space-x-2">
                                    <div class="flex text-yellow-400">
                                        @for($i = 1; $i <= 5; $i++)
                                            <svg class="w-5 h-5 {{ $i <= $review->rating ? 'fill-current' : 'fill-gray-300 dark:fill-gray-600' }}" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                            </svg>
                                        @endfor
                                    </div>
                                    <span class="text-lg font-semibold text-yellow-600 dark:text-yellow-400">{{ $review->rating }}/5</span>
                                </div>
                                <span class="text-sm text-gray-500 dark:text-gray-400">{{ $review->created_at->diffForHumans() }}</span>
                            </div>
                            <p class="text-gray-700 dark:text-gray-300 mb-4 leading-relaxed">{{ $review->comment }}</p>
                            <div class="flex items-center text-sm text-gray-500 dark:text-gray-400">
                                <svg class="w-4 h-4 mr-2 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                </svg>
                                En el curso: 
                                <a href="{{ route('courses.show', $review->course) }}" class="ml-1 text-orange-600 dark:text-orange-400 hover:text-orange-800 dark:hover:text-orange-300 font-semibold transition-colors">
                                    {{ $review->course->title }}
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-12 bg-gray-50 dark:bg-gray-700/50 rounded-xl border border-gray-200 dark:border-gray-700 shadow-inner">
                            <svg class="w-16 h-16 mx-auto text-orange-400 dark:text-orange-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                            </svg>
                            <p class="text-gray-500 dark:text-gray-400 text-lg">Aún no ha dejado reseñas en ningún curso.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        @endif
    </div>
</x-app-layout>