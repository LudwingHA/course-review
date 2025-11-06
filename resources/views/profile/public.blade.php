<x-app-layout>
    <div class="max-w-4xl mx-auto py-10">
        {{-- Avatar e información principal --}}
        <div class="flex flex-col md:flex-row items-center md:items-start gap-6 mb-8">
            <img src="{{ $user->avatar ? asset('storage/'.$user->avatar) : 'https://via.placeholder.com/120' }}"
                 class="w-32 h-32 rounded-full object-cover border shadow">

            <div>
                <h1 class="text-3xl font-bold">{{ $user->name }}</h1>
                <p class="text-sm text-gray-500 capitalize">{{ $user->role }}</p>
                @if($user->description)
                    <p class="mt-3 text-gray-700 max-w-lg">{{ $user->description }}</p>
                @else
                    <p class="mt-3 text-gray-400 italic">Sin descripción</p>
                @endif
            </div>
        </div>

        {{-- Contenido dinámico --}}
        @if($user->isInstructor())
            <h2 class="text-2xl font-semibold mb-4">Cursos de {{ $user->name }}</h2>
            @forelse($user->courses as $course)
                <div class="p-4 bg-white rounded shadow mb-4">
                    <h3 class="text-xl font-bold">
                        <a href="{{ route('courses.show', $course) }}" class="text-blue-600 hover:underline">
                            {{ $course->title }}
                        </a>
                    </h3>
                    <p class="text-gray-600 mt-2">{{ Str::limit($course->description, 200) }}</p>
                    <p class="text-sm text-gray-500 mt-1">
                        {{ $course->reviews->count() }} reseñas • {{ $course->likes()->count() }} likes
                    </p>
                </div>
            @empty
                <p class="text-gray-500">Aún no tiene cursos publicados.</p>
            @endforelse

        @elseif($user->isStudent())
            <h2 class="text-2xl font-semibold mb-4">Reseñas de {{ $user->name }}</h2>
            @forelse($user->reviews as $review)
                <div class="p-4 bg-gray-50 rounded shadow mb-3">
                    <p class="text-yellow-500">⭐ {{ $review->rating }}/5</p>
                    <p class="text-gray-800">{{ $review->comment }}</p>
                    <p class="text-sm text-gray-500 mt-2">
                        En el curso:
                        <a href="{{ route('courses.show', $review->course) }}" class="text-blue-600 hover:underline">
                            {{ $review->course->title }}
                        </a>
                    </p>
                </div>
            @empty
                <p class="text-gray-500">Aún no ha dejado reseñas.</p>
            @endforelse
        @endif
    </div>
</x-app-layout>
