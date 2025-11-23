<x-app-layout>
    <div class="max-w-6xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 p-8 mb-8">
            <div class="flex flex-col lg:flex-row gap-8">
                @if ($course->image)
                    <div class="lg:w-1/3">
                        <img src="{{ asset('storage/' . $course->image) }}" alt="Imagen del curso {{ $course->title }}" 
                            class="w-full h-64 lg:h-80 object-cover rounded-xl shadow-2xl">
                    </div>
                @endif

                <div class="flex-1">
                    <div class="mb-6">
                        <h1 class="text-3xl lg:text-4xl font-extrabold text-gray-900 dark:text-white mb-4">{{ $course->title }}</h1>
                        <div class="flex items-center text-gray-600 dark:text-gray-400">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            Impartido por: 
                            <a href="{{ route('profile.public', $course->instructor->id) }}" 
                               class="ml-1 font-semibold text-orange-600 dark:text-orange-400 hover:text-orange-800 dark:hover:text-orange-300 transition-colors">
                                {{ $course->instructor->name }}
                            </a>
                        </div>
                    </div>

                    <div class="flex flex-wrap gap-3 mb-6">
                        @if ($course->category)
                            <span class="inline-flex items-center px-4 py-1.5 rounded-full text-sm font-semibold bg-orange-100 dark:bg-orange-900/30 text-orange-800 dark:text-orange-200 shadow-sm">
                                {{ $course->category }}
                            </span>
                        @endif
                        @if ($course->tags)
                            @foreach (explode(',', $course->tags) as $tag)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 shadow-sm">
                                    #{{ trim($tag) }}
                                </span>
                            @endforeach
                        @endif
                    </div>

                    <p class="text-gray-700 dark:text-gray-300 text-lg leading-relaxed mb-6">
                        {{ $course->description }}
                    </p>

                    @auth
                        <form action="{{ route('like.toggle', ['type' => 'course', 'id' => $course->id]) }}" method="POST" class="inline-block">
                            @csrf
                            <button type="submit" 
                                class="inline-flex items-center px-5 py-2 border border-red-300 dark:border-red-700 rounded-xl transition-all font-semibold 
                                       @if($userLiked) 
                                            bg-red-500 hover:bg-red-600 text-white shadow-lg 
                                       @else 
                                            bg-red-50 dark:bg-red-900/20 text-red-700 dark:text-red-300 hover:bg-red-100 dark:hover:bg-red-900/30
                                       @endif">
                                @if($userLiked)
                                    <svg class="w-5 h-5 mr-2 fill-current" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/>
                                    </svg>
                                    Te gusta
                                @else
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                    </svg>
                                    Me gusta
                                @endif
                                <span class="ml-2 text-sm">({{ $course->likes->count() }})</span>
                            </button>
                        </form>
                    @else
                        <div class="inline-flex items-center px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-500 dark:text-gray-400 rounded-xl font-medium shadow-sm">
                            <svg class="w-5 h-5 mr-2 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                            </svg>
                            {{ $course->likes->count() }} likes
                            <span class="ml-2 text-sm text-gray-400 dark:text-gray-500">• Inicia sesión para dar like</span>
                        </div>
                    @endauth
                </div>
            </div>
        </div>

        @if ($course->content_table || $course->youtube_urls)
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                @if ($course->content_table)
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 p-6">
                        <div class="flex items-center mb-4 border-b border-gray-100 dark:border-gray-700 pb-3">
                            <svg class="w-6 h-6 text-orange-600 dark:text-orange-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                            <h2 class="text-xl font-extrabold text-gray-900 dark:text-white">Tabla de contenido</h2>
                        </div>
                        <div class="prose dark:prose-invert max-w-none">
                            <p class="text-gray-700 dark:text-gray-300 whitespace-pre-line leading-relaxed">
                                {{ $course->content_table }}
                            </p>
                        </div>
                    </div>
                @endif

                @if ($course->youtube_urls)
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 p-6">
                        <div class="flex items-center mb-4 border-b border-gray-100 dark:border-gray-700 pb-3">
                            <svg class="w-6 h-6 text-red-600 dark:text-red-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                            </svg>
                            <h2 class="text-xl font-extrabold text-gray-900 dark:text-white">Videos del curso</h2>
                        </div>
                        <div class="space-y-4">
                            @foreach (explode(',', $course->youtube_urls) as $url)
                                @php
                                    $videoId = null;
                                    if (preg_match('/v=([^&]+)/', $url, $matches)) {
                                        $videoId = $matches[1];
                                    } elseif (preg_match('/youtu\.be\/([^&]+)/', $url, $matches)) {
                                        $videoId = $matches[1];
                                    }
                                @endphp
                                @if ($videoId)
                                    <div class="aspect-w-16 aspect-h-9 bg-black rounded-lg overflow-hidden shadow-md">
                                        <iframe class="w-full h-48" 
                                            src="https://www.youtube.com/embed/{{ $videoId }}" 
                                            title="Video de YouTube" 
                                            frameborder="0" 
                                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                            allowfullscreen>
                                        </iframe>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        @endif

        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 p-8">
            <div class="flex items-center justify-between mb-6 border-b border-gray-100 dark:border-gray-700 pb-3">
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-yellow-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                    <h2 class="text-2xl font-extrabold text-gray-900 dark:text-white">Reseñas</h2>
                </div>
                <span class="text-sm text-gray-500 dark:text-gray-400">
                    {{ $course->reviews->count() }} reseña{{ $course->reviews->count() !== 1 ? 's' : '' }}
                </span>
            </div>

            <div class="space-y-6">
                @forelse($course->reviews as $review)
                    <div class="border-b border-gray-200 dark:border-gray-700 pb-6 last:border-b-0 last:pb-0">
                        <div class="flex items-start justify-between mb-3">
                            <div class="flex items-center space-x-3">
                                <a href="{{ route('profile.public', $review->user) }}" 
                                   class="flex items-center space-x-2 group">
                                    <div class="w-10 h-10 bg-gradient-to-r from-orange-500 to-red-600 rounded-full flex items-center justify-center text-white font-medium text-sm shadow-md">
                                        {{ substr($review->user->name, 0, 1) }}
                                    </div>
                                    <span class="font-semibold text-gray-900 dark:text-white group-hover:text-orange-600 dark:group-hover:text-orange-400 transition-colors">
                                        {{ $review->user->name }}
                                    </span>
                                </a>
                            </div>
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
                        </div>
                        <p class="text-gray-700 dark:text-gray-300 mb-4 leading-relaxed">{{ $review->comment }}</p>
                        
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-500 dark:text-gray-400">
                                {{ $review->created_at->diffForHumans() }}
                            </span>
                            @auth
                                <form action="{{ route('like.toggle', ['type' => 'review', 'id' => $review->id]) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="inline-flex items-center text-red-600 dark:text-red-400 hover:text-red-700 dark:hover:text-red-300 transition-colors text-sm">
                                        @if($review->likes->contains('user_id', auth()->id()))
                                            <svg class="w-4 h-4 mr-1 fill-current" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/>
                                            </svg>
                                        @else
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                            </svg>
                                        @endif
                                        {{ $review->likes->count() }}
                                    </button>
                                </form>
                            @else
                                <span class="inline-flex items-center text-gray-400 dark:text-gray-500 text-sm">
                                    <svg class="w-4 h-4 mr-1 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                    </svg>
                                    {{ $review->likes->count() }}
                                </span>
                            @endauth
                        </div>
                    </div>
                @empty
                    <div class="text-center py-12">
                        <svg class="w-16 h-16 mx-auto text-orange-400 dark:text-orange-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                        </svg>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Aún no hay reseñas</h3>
                        <p class="text-gray-500 dark:text-gray-400">Sé el primero en compartir tu experiencia con este curso.</p>
                    </div>
                @endforelse
            </div>

            @auth
                @if(auth()->user()->isStudent())
                    <div class="mt-8 pt-8 border-t border-gray-200 dark:border-gray-700">
                        <h3 class="text-xl font-extrabold text-gray-900 dark:text-white mb-4">Deja tu reseña</h3>
                        <form action="{{ route('reviews.store', $course) }}" method="POST" class="space-y-4">
                            @csrf
                            <div>
                                <x-input-label for="rating" :value="__('Calificación')" />
                                <div class="flex items-center space-x-3 mt-2">
                                    @for($i = 1; $i <= 5; $i++)
                                        <label class="cursor-pointer">
                                            <input type="radio" name="rating" value="{{ $i }}" class="hidden peer" {{ $i == 5 ? 'checked' : '' }}>
                                            <svg class="w-8 h-8 peer-checked:text-yellow-400 text-gray-300 dark:text-gray-600 hover:text-yellow-300 transition-colors" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                            </svg>
                                        </label>
                                    @endfor
                                </div>
                                <x-input-error :messages="$errors->get('rating')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="comment" :value="__('Comentario')" />
                                <textarea id="comment" name="comment" rows="4" placeholder="Comparte tu experiencia con este curso..."
                                    class="block w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 dark:focus:ring-orange-400 transition-colors placeholder-gray-400 dark:placeholder-gray-500 text-gray-900 dark:text-white resize-none"
                                    required>{{ old('comment') }}</textarea>
                                <x-input-error :messages="$errors->get('comment')" class="mt-2" />
                            </div>

                            <x-primary-button class="bg-gradient-to-r from-orange-600 to-red-600 hover:from-orange-700 hover:to-red-700 rounded-xl px-6 py-3 font-semibold shadow-md hover:shadow-lg focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                </svg>
                                {{ __('Enviar Reseña') }}
                            </x-primary-button>
                        </form>
                    </div>
                @endif
            @else
                <div class="mt-8 p-6 bg-orange-50 dark:bg-gray-700/50 rounded-xl text-center border border-orange-200 dark:border-gray-700 shadow-inner">
                    <p class="text-gray-700 dark:text-gray-300 font-medium mb-2">¡Queremos escuchar tu opinión!</p>
                    <p class="text-gray-600 dark:text-gray-400 mb-3">Inicia sesión para dejar una reseña y calificar este curso.</p>
                    <a href="{{ route('login') }}" class="inline-flex items-center text-orange-600 dark:text-orange-400 hover:text-orange-800 dark:hover:text-orange-300 font-semibold transition-colors">
                        Iniciar sesión
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            @endauth
        </div>
    </div>
</x-app-layout>