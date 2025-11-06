<x-app-layout>
    <h1 class="text-2xl font-bold mb-4">Crear Curso</h1>

    <form action="{{ route('courses.store') }}" method="POST" class="space-y-4">
        @csrf
        <div>
            <label>Título</label>
            <input type="text" name="title" class="w-full border rounded p-2" required>
        </div>
        <div>
            <label>Descripción</label>
            <textarea name="description" class="w-full border rounded p-2" required></textarea>
        </div>
        <button class="bg-blue-600 text-white px-4 py-2 rounded">Guardar</button>
    </form>
</x-app-layout>
