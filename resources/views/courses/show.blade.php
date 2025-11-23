<x-app-layout> 
    <div class="max-w-6xl mx-auto py-10 px-4 sm:px-6 lg:px-8 space-y-10">

        {{-- ================== INFO DEL CURSO ================== --}}
        <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                {{-- Imagen --}}
                @if ($course->image)
                    <div class="overflow-hidden rounded-xl">
                        <img src="{{ asset('storage/' . $course->image) }}" 
                             alt="Imagen del curso {{ $course->title }}"
                             class="w-full h-72 object-cover transition-transform duration-300 hover:scale-105">
                    </div>
                @endif

                {{-- Info principal --}}
                <div class="lg:col-span-2 flex flex-col justify-between">

                    <div>
                        <h1 class="text-3xl md:text-4xl font-black text-gray-900 dark:text-white mb-4">
                            {{ $course->title }}
                        </h1>

                        {{-- Instructor --}}
                        <div class="flex items-center gap-2 text-gray-600 dark:text-gray-400 mb-4">
                            <span>👨‍🏫 Instructor:</span>
                            <a href="{{ route('profile.public', $course->instructor->id) }}"
                               class="font-semibold text-orange-600 hover:underline">
                                {{ $course->instructor->name }}
                            </a>
                        </div>

                        {{-- Categoría y Tags --}}
                        <div class="flex flex-wrap gap-2 mb-6">
                            @if($course->category)
                                <span class="px-4 py-1 rounded-full bg-orange-100 text-orange-700 text-sm font-semibold">
                                    {{ $course->category }}
                                </span>
                            @endif

                            @if($course->tags)
                                @foreach(explode(',', $course->tags) as $tag)
                                    <span
                                      class="px-3 py-1 rounded-full bg-gray-100 dark:bg-gray-800 text-sm text-gray-700 dark:text-gray-300">
                                        #{{ trim($tag) }}
                                    </span>
                                @endforeach
                            @endif
                        </div>

                        <p class="text-gray-700 dark:text-gray-300 leading-relaxed text-lg">
                            {{ $course->description }}
                        </p>
                    </div>

                    {{-- Botón Like --}}
                    <div class="mt-6">
                        @auth
                            <form action="{{ route('like.toggle', ['type' => 'course', 'id' => $course->id]) }}" method="POST">
                                @csrf

                                <button
                                    class="flex items-center gap-2 px-6 py-3 rounded-xl font-semibold transition-all
                                    {{ $userLiked 
                                        ? 'bg-red-500 text-white hover:bg-red-600' 
                                        : 'bg-gray-200 dark:bg-gray-800 text-gray-700 dark:text-white hover:bg-red-100 dark:hover:bg-red-900/40' }}">

                                    ❤️ {{ $userLiked ? 'Te gusta' : 'Me gusta' }}
                                    <span class="font-bold">({{ $course->likes->count() }})</span>
                                </button>
                            </form>
                        @else
                            <p class="text-gray-400 text-sm mt-2">
                                Inicia sesión para dar like ❤️
                            </p>
                        @endauth
                    </div>
                </div>
            </div>
        </div>

        {{-- ================== CONTENIDO DEL CURSO ================== --}}
        @if ($course->content_table || $course->youtube_urls)
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                {{-- Tabla contenido --}}
                @if ($course->content_table)
                    <div class="bg-white dark:bg-gray-900 p-6 rounded-2xl shadow border border-gray-200 dark:border-gray-700">
                        <h2 class="text-xl font-bold mb-3 text-gray-900 dark:text-white">📑 Tabla de contenido</h2>
                        <pre class="whitespace-pre-line text-gray-700 dark:text-gray-300">
{{ $course->content_table }}
                        </pre>
                    </div>
                @endif

                {{-- Videos --}}
                @if ($course->youtube_urls)
                    <div class="bg-white dark:bg-gray-900 p-6 rounded-2xl shadow border border-gray-200 dark:border-gray-700">
                        <h2 class="text-xl font-bold mb-4 text-gray-900 dark:text-white">🎬 Videos</h2>

                        <div class="space-y-4">
                            @foreach(explode(',', $course->youtube_urls) as $url)

                                @php
                                    preg_match('/(?:v=|youtu\.be\/)([^&?]+)/', $url, $match);
                                    $videoId = $match[1] ?? null;
                                @endphp

                                @if($videoId)
                                    <iframe class="w-full rounded-lg shadow aspect-video"
                                        src="https://www.youtube.com/embed/{{ $videoId }}"
                                        frameborder="0"
                                        allowfullscreen>
                                    </iframe>
                                @endif

                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        @endif

        {{-- ================== RESEÑAS ================== --}}
        <div class="bg-white dark:bg-gray-900 p-8 rounded-2xl border border-gray-200 dark:border-gray-700 shadow">

            <div class="flex justify-between items-center mb-8">
                <h2 class="text-2xl font-black text-gray-900 dark:text-white">
                    ⭐ Reseñas
                </h2>

                <span class="text-sm text-gray-500 dark:text-gray-400">
                    {{ $course->reviews->count() }} reseñas
                </span>
            </div>

            {{-- FORMULARIO --}}
            @auth
                @if(auth()->user()->isStudent())

                    @if(!$course->reviews->where('user_id', auth()->id())->count())
                        <div class="mb-8 p-6 bg-gray-100 dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700">

                            <h3 class="text-lg font-bold mb-4 text-gray-900 dark:text-white">
                                ✍️ Deja tu reseña
                            </h3>

                            <form action="{{ route('reviews.store', $course->slug) }}" method="POST">
                                @csrf

                                <div class="mb-4">
                                    <select name="rating" required 
                                        class="w-full border border-gray-300 dark:border-gray-600 rounded-lg p-2 
                                        bg-white dark:bg-gray-900 
                                        text-gray-900 dark:text-white 
                                        focus:ring focus:ring-orange-500">
                                        <option value="">Selecciona calificación</option>
                                        <option value="5">⭐⭐⭐⭐⭐</option>
                                        <option value="4">⭐⭐⭐⭐</option>
                                        <option value="3">⭐⭐⭐</option>
                                        <option value="2">⭐⭐</option>
                                        <option value="1">⭐</option>
                                    </select>
                                </div>

                                <div class="mb-4">
                                    <textarea name="comment" rows="3" required
                                        class="w-full border border-gray-300 dark:border-gray-600 rounded-lg p-3 
                                        bg-white dark:bg-gray-900 
                                        text-gray-900 dark:text-white 
                                        placeholder-gray-500 dark:placeholder-gray-400
                                        focus:ring focus:ring-orange-500"
                                        placeholder="Escribe tu opinión del curso..."></textarea>
                                </div>

                                <button 
                                    class="bg-orange-500 text-white px-6 py-2 rounded-full 
                                           hover:bg-orange-600 dark:hover:bg-orange-400 
                                           transition">
                                    Enviar reseña
                                </button>
                            </form>
                        </div>
                    @else
                        <p class="text-center text-gray-500 dark:text-gray-400 mb-6">
                            Ya dejaste una reseña en este curso.
                        </p>
                    @endif

                @else
                    <p class="text-gray-500 dark:text-gray-400 mb-6 text-center">
                        Solo los estudiantes pueden dejar reseñas.
                    </p>
                @endif
            @else
                <p class="text-gray-500 dark:text-gray-400 mb-6 text-center">
                    Inicia sesión para dejar una reseña.
                </p>
            @endauth

            {{-- LISTA DE RESEÑAS --}}
            <div class="space-y-6">

                @forelse($course->reviews as $review)
                    <div class="border-b border-gray-300 dark:border-gray-700 pb-6">

                        <div class="flex justify-between mb-2">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-orange-500 text-white rounded-full flex items-center justify-center font-bold">
                                    {{ strtoupper(substr($review->user->name, 0, 1)) }}
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-900 dark:text-white">
                                        {{ $review->user->name }}
                                    </p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">
                                        {{ $review->created_at->diffForHumans() }}
                                    </p>
                                </div>
                            </div>

                            {{-- Estrellas --}}
                            <div class="flex text-yellow-400">
                                @for($i = 1; $i <= 5; $i++)
                                    <svg class="w-5 h-5 {{ $i <= $review->rating ? 'fill-current' : 'fill-gray-500 dark:fill-gray-600' }}"
                                         viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902
                                        0l1.07 3.292a1 1 0 00.95.69h3.462
                                        c.969 0 1.371 1.24.588 1.81l-2.8 2.034
                                        a1 1 0 00-.364 1.118l1.07 3.292
                                        c.3.921-.755 1.688-1.54 1.118l-2.8
                                        -2.034a1 1 0 00-1.175 0l-2.8
                                        2.034c-.784.57-1.838-.197-1.539
                                        -1.118l1.07-3.292a1 1 0 00-.364
                                        -1.118L2.98 8.72c-.783-.57-.38-1.81
                                        .588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                @endfor
                            </div>
                        </div>

                        <p class="text-gray-700 dark:text-gray-300 mt-3">
                            {{ $review->comment }}
                        </p>
                    </div>

                @empty
                    <div class="text-center text-gray-500 dark:text-gray-400 py-10">
                        Aún no hay reseñas para este curso.
                    </div>
                @endforelse

            </div>
        </div>

    </div>
</x-app-layout>
