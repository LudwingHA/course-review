<x-app-layout>
    <div class="max-w-4xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <div class="mb-8">
            <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white mb-2">Editar Curso</h1>
            <p class="text-gray-600 dark:text-gray-400">Actualiza la información de tu curso</p>
        </div>

        @if (session('success'))
            <div class="mb-6 p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-xl flex items-center shadow-sm">
                <svg class="w-5 h-5 text-green-600 dark:text-green-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span class="text-green-800 dark:text-green-200 font-medium">{{ session('success') }}</span>
            </div>
        @endif

        <form method="POST" action="{{ route('courses.update', $course) }}" enctype="multipart/form-data" class="space-y-6 bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 p-8">
            @csrf
            @method('PUT')

            <div>
                <x-input-label for="title" :value="__('Título del curso')" />
                <div class="relative mt-1">
                    <x-text-input id="title" name="title" type="text" class="block w-full" value="{{ old('title', $course->title) }}" required autofocus />
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                    </div>
                </div>
                <x-input-error :messages="$errors->get('title')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="description" :value="__('Descripción')" />
                <textarea id="description" name="description" rows="5"
                    class="block w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 dark:focus:ring-orange-400 transition-colors text-gray-900 dark:text-white resize-none"
                    required>{{ old('description', $course->description) }}</textarea>
                <x-input-error :messages="$errors->get('description')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="image" :value="__('Imagen del curso')" />
                <div class="mt-2 flex items-center space-x-6">
                    <div class="shrink-0">
                        <img id="image-preview" class="h-32 w-32 object-cover rounded-xl border-4 border-gray-300 dark:border-gray-600 shadow-inner" 
                            src="{{ $course->image ? asset('storage/' . $course->image) : 'https://images.unsplash.com/photo-1496128858413-b36217c2ce36?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=400&q=80' }}" 
                            alt="Preview de imagen del curso">
                    </div>
                    <div class="flex-1">
                        <input id="image" type="file" name="image" accept="image/*" 
                               class="block w-full text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-medium 
                               file:bg-orange-100 dark:file:bg-orange-900/30 file:text-orange-700 dark:file:text-orange-300 
                               hover:file:bg-orange-200 dark:hover:file:bg-orange-900/50 transition-colors cursor-pointer"
                               onchange="previewImage(this)">
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">PNG, JPG, GIF hasta 2MB</p>
                    </div>
                </div>
                <x-input-error :messages="$errors->get('image')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="category_id" :value="__('Categoría')" />
                <select id="category_id" name="category_id"
                    class="block w-full mt-1 px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 dark:focus:ring-orange-400 transition-colors text-gray-900 dark:text-white"
                    required>
                    <option value="">-- Selecciona una categoría --</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $course->category_id) == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="tags" :value="__('Etiquetas (separadas por coma)')" />
                <div class="relative mt-1">
                    <x-text-input id="tags" name="tags" type="text" class="block w-full" value="{{ old('tags', $course->tags) }}" />
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div>
                <x-input-label for="content_table" :value="__('Tabla de contenido')" />
                <textarea id="content_table" name="content_table" rows="3"
                    class="block w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 dark:focus:ring-orange-400 transition-colors text-gray-900 dark:text-white resize-none">{{ old('content_table', $course->content_table) }}</textarea>
            </div>

            <div>
                <x-input-label for="youtube_urls" :value="__('URLs de videos (separadas por coma)')" />
                <div class="relative mt-1">
                    <x-text-input id="youtube_urls" name="youtube_urls" type="text" class="block w-full" 
                                 value="{{ old('youtube_urls', $course->youtube_urls) }}" />
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div>
                <x-input-label for="published_at" :value="__('Fecha de publicación')" />
                <div class="relative mt-1">
                    <x-text-input id="published_at" name="published_at" type="date" class="block w-full" 
                                 value="{{ old('published_at', optional($course->published_at)->format('Y-m-d')) }}" />
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-between pt-6 border-t border-gray-200 dark:border-gray-700">
                <a href="{{ route('courses.index') }}" 
                   class="inline-flex items-center text-gray-600 dark:text-gray-400 hover:text-orange-600 dark:hover:text-orange-400 font-medium transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Volver a mis cursos
                </a>

                <x-primary-button class="bg-gradient-to-r from-orange-600 to-red-600 hover:from-orange-700 hover:to-red-700 rounded-xl px-6 py-3 font-semibold shadow-md hover:shadow-lg focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    {{ __('Guardar Cambios') }}
                </x-primary-button>
            </div>
        </form>
    </div>

    <script>
        function previewImage(input) {
            const preview = document.getElementById('image-preview');
            const file = input.files[0];
            
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                }
                reader.readAsDataURL(file);
            }
        }
    </script>
</x-app-layout>