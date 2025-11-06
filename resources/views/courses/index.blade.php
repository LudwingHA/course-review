<x-app-layout>
    <h1 class="text-2xl font-bold mb-4">Mis Cursos</h1>

    <a href="{{ route('courses.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded">Nuevo Curso</a>

    <ul class="mt-4 space-y-2">
        @foreach($courses as $course)
            <li class="p-3 bg-gray-100 rounded flex justify-between">
                <span>{{ $course->title }}</span>
                <div>
                    <a href="{{ route('courses.edit', $course) }}" class="text-blue-500">Editar</a> |
                    <form action="{{ route('courses.destroy', $course) }}" method="POST" class="inline">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-red-500">Eliminar</button>
                    </form>
                </div>
            </li>
        @endforeach
    </ul>

    {{ $courses->links() }}
</x-app-layout>
