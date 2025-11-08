<x-app-layout>
    <div class="max-w-3xl mx-auto py-10">
        <h1 class="text-3xl font-bold text-gray-800 dark:text-gray-100 mb-6">Editar curso</h1>

        @if (session('success'))
            <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('courses.update', $course) }}">
            @csrf
            @method('PUT')

            <!-- Título -->
            <div class="mb-4">
                <x-input-label for="title" :value="__('Título del curso')" />
                <x-text-input id="title" name="title" type="text" class="block w-full mt-1"
                    value="{{ old('title', $course->title) }}" required autofocus />
                <x-input-error :messages="$errors->get('title')" class="mt-2" />
            </div>

            <!-- Descripción -->
            <div class="mb-4">
                <x-input-label for="description" :value="__('Descripción')" />
                <textarea id="description" name="description" rows="5"
                    class="block w-full rounded-md border-gray-300 dark:bg-gray-900 dark:text-gray-200 focus:ring-indigo-500 focus:border-indigo-500"
                    required>{{ old('description', $course->description) }}</textarea>
                <x-input-error :messages="$errors->get('description')" class="mt-2" />
            </div>
            <!-- Imagen -->
            <div class="mb-4">
                <x-input-label for="image" :value="__('Imagen del curso')" />
                <input id="image" type="file" name="image"
                    class="block mt-1 w-full text-sm text-gray-700 dark:text-gray-300">
                @if($course->image)
                    <img src="{{ asset('storage/' . $course->image) }}" class="w-40 mt-2 rounded shadow">
                @endif
            </div>

            <!-- Categoría -->
            <div class="mb-4">
                <x-input-label for="category" :value="__('Categoría')" />
                <x-text-input id="category" name="category" type="text" class="block mt-1 w-full"
                    value="{{ old('category', $course->category) }}" />
            </div>

            <!-- Etiquetas -->
            <div class="mb-4">
                <x-input-label for="tags" :value="__('Etiquetas (separadas por coma)')" />
                <x-text-input id="tags" name="tags" type="text" class="block mt-1 w-full"
                    value="{{ old('tags', $course->tags) }}" />
            </div>

            <!-- Tabla de contenido -->
            <div class="mb-4">
                <x-input-label for="content_table" :value="__('Tabla de contenido')" />
                <textarea id="content_table" name="content_table" rows="3"
                    class="block w-full rounded-md border-gray-300">{{ old('content_table', $course->content_table) }}</textarea>
            </div>

            <!-- Videos -->
            <div class="mb-4">
                <x-input-label for="youtube_urls" :value="__('URLs de videos (separadas por coma)')" />
                <x-text-input id="youtube_urls" name="youtube_urls" type="text" class="block mt-1 w-full"
                    value="{{ old('youtube_urls', $course->youtube_urls) }}" />
            </div>

            <!-- Fecha -->
            <div class="mb-4">
                <x-input-label for="published_at" :value="__('Fecha de publicación')" />
                <x-text-input id="published_at" name="published_at" type="date" class="block mt-1 w-full"
                    value="{{ old('published_at', optional($course->published_at)->format('Y-m-d')) }}" />
            </div>


            <!-- Botones -->
            <div class="flex items-center justify-between mt-6">
                <a href="{{ route('courses.index') }}"
                    class="text-gray-600 dark:text-gray-400 hover:text-indigo-600 text-sm">
                    ← Volver
                </a>

                <x-primary-button>
                    {{ __('Guardar cambios') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</x-app-layout>