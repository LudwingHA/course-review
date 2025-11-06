{{-- resources/views/home.blade.php --}}
<x-app-layout>
    <h1 class="text-3xl font-bold mb-6 text-center">Cursos Disponibles</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @foreach($courses as $course)
            <div class="bg-white shadow rounded p-4 hover:shadow-lg transition">
                <h2 class="text-xl font-semibold">
                    <a href="{{ route('courses.show', $course) }}">
                        {{ $course->title }}
                    </a>
                </h2>
                <p class="text-sm text-gray-500 mb-2">
                    Instructor: {{ $course->instructor->name }}
                </p>
                <p class="text-gray-700 line-clamp-3">{{ $course->description }}</p>

                <div class="mt-3 flex justify-between items-center text-sm">
                    <span class="text-gray-500">{{ $course->likes_count }} ❤️</span>
                    <a href="{{ route('courses.show', $course) }}" class="text-blue-600">Ver detalles</a>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-6">
        {{ $courses->links() }}
    </div>
</x-app-layout>
