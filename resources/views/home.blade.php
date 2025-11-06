{{-- resources/views/home.blade.php --}}
<x-app-layout>
    <div class="max-w-5xl mx-auto py-8">
        <h1 class="text-3xl font-bold mb-6 text-center">Cursos Disponibles</h1>

        @if($courses->isEmpty())
            <p class="text-center text-gray-500">Aún no hay cursos disponibles.</p>
        @else
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($courses as $course)
                    <div class="bg-white shadow rounded p-4 hover:shadow-lg transition">
                        <h2 class="text-xl font-semibold">
                            <a href="{{ route('courses.show', $course) }}" class="text-blue-600 hover:underline">
                                {{ $course->title }}
                            </a>
                        </h2>
                        <p class="text-sm text-gray-500 mb-2">
                            Instructor: {{ $course->instructor->name }}
                        </p>
                        <p class="text-gray-700 line-clamp-3">
                            {{ Str::limit($course->description, 100) }}
                        </p>
                        <div class="mt-3 flex justify-between items-center text-sm text-gray-500">
                            ❤️ {{ $course->likes_count }}
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-6">
                {{ $courses->links() }}
            </div>
        @endif
    </div>
</x-app-layout>
