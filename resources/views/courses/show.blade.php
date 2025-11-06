{{-- resources/views/courses/show.blade.php --}}
<x-app-layout>
    <div class="max-w-4xl mx-auto">
        <h1 class="text-3xl font-bold mb-2">{{ $course->title }}</h1>
        <p class="text-gray-600 mb-4">Impartido por: <a href="{{ route('profile.public', $course->instructor->id) }}" class="font-semibold text-blue-600 hover:underline">
                    {{ $course->instructor->name }}
                </a></p>

        <p class="mb-4 text-gray-800">{{ $course->description }}</p>

        {{-- Like del curso --}}
        @auth
            <form action="{{ route('likes.toggle', ['type' => 'course', 'id' => $course->id]) }}" method="POST">
                @csrf
                <button type="submit" class="text-red-600">
                    {{ $userLiked ? '❤️ Ya te gusta' : '🤍 Me gusta' }}
                </button>
            </form>
        @else
            <p class="text-sm text-gray-500">Inicia sesión para dar like o comentar.</p>
        @endauth

        <hr class="my-6">

        <h2 class="text-2xl font-semibold mb-4">Reseñas</h2>

        {{-- Listado de reseñas --}}
        @forelse($course->reviews as $review)
            <div class="border rounded p-3 mb-3 bg-gray-50">
                <a href="{{ route('profile.public', $review->user) }}" class="font-semibold text-blue-600 hover:underline">
                    {{ $review->user->name }}
                </a>
                <p class="text-yellow-500">⭐ {{ $review->rating }}/5</p>
                <p>{{ $review->comment }}</p>

                {{-- Like de reseña --}}
                @auth
                    <form action="{{ route('likes.toggle', ['type' => 'review', 'id' => $review->id]) }}" method="POST"
                        class="inline">
                        @csrf
                        <button type="submit" class="text-red-600 text-sm">
                            ❤️ {{ $review->likes->count() }}
                        </button>
                    </form>
                @else
                    <span class="text-gray-400 text-sm">❤️ {{ $review->likes->count() }}</span>
                @endauth
            </div>
        @empty
            <p>No hay reseñas todavía.</p>
        @endforelse

        {{-- Formulario para nueva reseña --}}
        @auth
            @if(auth()->user()->isStudent())
                <form action="{{ route('reviews.store', $course) }}" method="POST" class="mt-6 space-y-3">
                    @csrf
                    <label>Calificación (1-5)</label>
                    <input type="number" name="rating" min="1" max="5" required class="border rounded p-2 w-20">

                    <label>Comentario</label>
                    <textarea name="comment" class="border rounded p-2 w-full" required></textarea>

                    <button class="bg-blue-600 text-white px-4 py-2 rounded">Enviar Reseña</button>
                </form>
            @endif
        @endauth
    </div>
</x-app-layout>