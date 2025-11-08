{{-- resources/views/courses/show.blade.php --}}
<x-app-layout>
    <div class="max-w-5xl mx-auto py-10 px-4">
        <!-- Encabezado del curso -->
        <div class="bg-white dark:bg-gray-900 rounded-lg shadow p-6 mb-8">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100 mb-2">{{ $course->title }}</h1>

            <p class="text-gray-600 dark:text-gray-400 mb-4">
                Impartido por: 
                <a href="{{ route('profile.public', $course->instructor->id) }}" 
                   class="font-semibold text-indigo-600 hover:underline">
                    {{ $course->instructor->name }}
                </a>
            </p>

            @if ($course->image)
                <img src="{{ asset('storage/' . $course->image) }}" alt="Imagen del curso" 
                     class="w-full h-64 object-cover rounded-md mb-4">
            @endif

            <div class="flex flex-wrap gap-4 mb-4">
                @if ($course->category)
                    <span class="px-3 py-1 bg-indigo-100 text-indigo-700 rounded-full text-sm font-semibold">
                        {{ $course->category }}
                    </span>
                @endif
                @if ($course->tags)
                    @foreach (explode(',', $course->tags) as $tag)
                        <span class="px-3 py-1 bg-gray-200 dark:bg-gray-800 text-gray-700 dark:text-gray-300 rounded-full text-xs">
                            #{{ trim($tag) }}
                        </span>
                    @endforeach
                @endif
            </div>

            <p class="text-gray-800 dark:text-gray-200 mb-6 leading-relaxed">
                {{ $course->description }}
            </p>

            <!-- Like del curso -->
            @auth
                <form action="{{ route('like.toggle', ['type' => 'course', 'id' => $course->id]) }}" method="POST">
                    @csrf
                    <button type="submit" 
                        class="flex items-center gap-1 text-red-600 hover:text-red-700 transition">
                        {!! $userLiked ? '❤️ <span>Te gusta</span>' : '🤍 <span>Me gusta</span>' !!}
                        <span class="text-sm text-gray-500 ml-1">({{ $course->likes->count() }})</span>
                    </button>
                </form>
            @else
                <p class="text-sm text-gray-500">Inicia sesión para dar like o comentar.</p>
            @endauth
        </div>

        <!-- Contenido adicional -->
        @if ($course->content_table || $course->youtube_urls)
            <div class="bg-white dark:bg-gray-900 rounded-lg shadow p-6 mb-8">
                @if ($course->content_table)
                    <h2 class="text-xl font-semibold mb-3 text-gray-900 dark:text-gray-100">📘 Tabla de contenido</h2>
                    <p class="text-gray-700 dark:text-gray-300 whitespace-pre-line">
                        {{ $course->content_table }}
                    </p>
                @endif

                @if ($course->youtube_urls)
                    <h2 class="text-xl font-semibold mt-6 mb-3 text-gray-900 dark:text-gray-100">🎥 Videos del curso</h2>
                    @foreach (explode(',', $course->youtube_urls) as $url)
                        @php
                            $videoId = null;
                            if (preg_match('/v=([^&]+)/', $url, $matches)) {
                                $videoId = $matches[1];
                            }
                        @endphp
                        @if ($videoId)
                            <div class="mb-4 aspect-w-16 aspect-h-9">
                                <iframe class="w-full h-64 rounded-lg" 
                                    src="https://www.youtube.com/embed/{{ $videoId }}" 
                                    title="Video de YouTube" frameborder="0" allowfullscreen></iframe>
                            </div>
                        @endif
                    @endforeach
                @endif
            </div>
        @endif

        <!-- Reseñas -->
        <div class="bg-white dark:bg-gray-900 rounded-lg shadow p-6">
            <h2 class="text-2xl font-semibold mb-4 text-gray-900 dark:text-gray-100">💬 Reseñas</h2>

            @forelse($course->reviews as $review)
                <div class="border-b border-gray-200 dark:border-gray-700 pb-3 mb-3">
                    <div class="flex justify-between items-center">
                        <a href="{{ route('profile.public', $review->user) }}" 
                           class="font-semibold text-indigo-600 hover:underline">
                            {{ $review->user->name }}
                        </a>
                        <span class="text-yellow-500">⭐ {{ $review->rating }}/5</span>
                    </div>
                    <p class="mt-2 text-gray-800 dark:text-gray-200">{{ $review->comment }}</p>

                    @auth
                        <form action="{{ route('like.toggle', ['type' => 'review', 'id' => $review->id]) }}" method="POST"
                            class="inline">
                            @csrf
                            <button type="submit" class="text-red-600 text-sm mt-2 hover:text-red-700">
                                ❤️ {{ $review->likes->count() }}
                            </button>
                        </form>
                    @else
                        <span class="text-gray-400 text-sm mt-2 inline-block">❤️ {{ $review->likes->count() }}</span>
                    @endauth
                </div>
            @empty
                <p class="text-gray-500 dark:text-gray-400">No hay reseñas todavía.</p>
            @endforelse

            <!-- Formulario de nueva reseña -->
            @auth
                @if(auth()->user()->isStudent())
                    <form action="{{ route('reviews.store', $course) }}" method="POST" class="mt-6 space-y-3">
                        @csrf
                        <div>
                            <x-input-label for="rating" :value="__('Calificación (1-5)')" />
                            <x-text-input id="rating" name="rating" type="number" min="1" max="5"
                                class="w-24 mt-1" required />
                        </div>

                        <div>
                            <x-input-label for="comment" :value="__('Comentario')" />
                            <textarea id="comment" name="comment" rows="3"
                                class="block w-full rounded-md border-gray-300 dark:bg-gray-800 dark:text-gray-200 focus:ring-indigo-500 focus:border-indigo-500"
                                required></textarea>
                        </div>

                        <x-primary-button>
                            {{ __('Enviar reseña') }}
                        </x-primary-button>
                    </form>
                @endif
            @endauth
        </div>
    </div>
</x-app-layout>
