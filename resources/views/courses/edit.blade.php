<x-app-layout>
    <div class="max-w-4xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <div class="mb-8">
            <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white mb-2">Editar Curso</h1>
            <p class="text-gray-600 dark:text-gray-400">Actualiza la información de tu curso</p>
        </div>

        @if (session('success'))
            <div class="mb-6 p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-xl flex items-center shadow-sm">
                <span class="text-green-800 dark:text-green-200 font-medium">{{ session('success') }}</span>
            </div>
        @endif

        <form method="POST" action="{{ route('courses.update', $course) }}" enctype="multipart/form-data" 
              class="space-y-6 bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 p-8">

            @csrf
            @method('PUT')

            {{-- TÍTULO --}}
            <div>
                <x-input-label for="title" :value="__('Título del curso')" />
                <x-text-input id="title" name="title" type="text" class="block w-full mt-1" 
                    value="{{ old('title', $course->title) }}" required />
            </div>

            {{-- DESCRIPCIÓN --}}
            <div>
                <x-input-label for="description" :value="__('Descripción')" />
                <textarea id="description" name="description" rows="4"
                    class="block w-full mt-1 bg-gray-50 dark:bg-gray-700 border border-gray-300 rounded-lg px-4 py-2 text-white resize-none"
                required>{{ old('description', $course->description) }}</textarea>
            </div>

            {{-- IMAGEN --}}
            <div>
                <x-input-label for="image" :value="__('Imagen del curso')" />
                <div class="flex items-center gap-6 mt-2">
                    <img id="image-preview" 
                         src="{{ $course->image ? asset('storage/'.$course->image) : '' }}" 
                         class="w-32 h-32 object-cover rounded-xl border">
                    
                    <input type="file" name="image" id="image" accept="image/*"
                        onchange="previewImage(this)"
                        class="block w-full text-sm text-gray-500 file:bg-orange-600 file:text-white file:px-4 file:py-2 file:rounded-lg cursor-pointer">
                </div>
            </div>

            {{-- CATEGORÍA --}}
            <div>
                <x-input-label for="category_id" :value="__('Categoría')" />
                <select id="category_id" name="category_id"
                        class="block w-full mt-1 bg-gray-50 dark:bg-gray-700 border border-gray-300 rounded-lg px-4 py-2 text-white">
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}"
                            {{ old('category_id', $course->category_id) == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- ✅ ETIQUETAS MODERNAS --}}
            <div>
                <x-input-label :value="__('Etiquetas')" />

                <div class="border border-gray-300 rounded-lg p-3 bg-gray-50 dark:bg-gray-700 focus-within:ring-2 focus-within:ring-orange-500">
                    <div id="tags-container" class="flex flex-wrap gap-2 mb-2"></div>

                    <input id="tag-input" type="text" 
                        placeholder="Escribe una etiqueta y presiona coma..."
                        class="bg-transparent outline-none w-full text-white">

                    <input type="hidden" name="tags" id="tags-hidden">
                </div>
            </div>

            {{-- ✅ TABLA DE CONTENIDO INTERACTIVA --}}
            <div>
                <x-input-label :value="__('Tabla de contenido')" />

                <div class="space-y-3 mt-2">
                    <div class="flex gap-2">
                        <input id="topic-input" type="text" 
                               placeholder="Ej: Introducción a Laravel"
                               class="flex-1 px-4 py-2 rounded-lg bg-gray-50 dark:bg-gray-700 border text-white">
                        <button type="button" onclick="addTopic()" 
                                class="px-4 py-2 bg-orange-600 text-white rounded-lg">
                            Agregar
                        </button>
                    </div>

                    <ul id="topics-list" class="space-y-2"></ul>

                    <textarea id="content_table" name="content_table" hidden></textarea>
                </div>
            </div>

            {{-- YOUTUBE URLs --}}
            <div>
                <x-input-label for="youtube_urls" :value="__('URLs de videos')" />
                <x-text-input id="youtube_urls" name="youtube_urls" type="text" class="block w-full"
                    value="{{ old('youtube_urls', $course->youtube_urls) }}" />
            </div>

            {{-- FECHA --}}
            <div>
                <x-input-label for="published_at" :value="__('Fecha de publicación')" />
                <x-text-input id="published_at" name="published_at"
                              type="date" 
                              value="{{ old('published_at', optional($course->published_at)->format('Y-m-d')) }}" />
            </div>

            {{-- BOTÓN --}}
            <div class="flex justify-end pt-6">
                <x-primary-button>
                    Guardar Cambios
                </x-primary-button>
            </div>

        </form>
    </div>

{{-- 🧠 JAVASCRIPT --}}
<script>
    // ----------------------
    // PREVIEW DE IMAGEN
    function previewImage(input) {
        const preview = document.getElementById('image-preview');
        const file = input.files[0];

        if (file) {
            const reader = new FileReader();
            reader.onload = e => preview.src = e.target.result;
            reader.readAsDataURL(file);
        }
    }

    // ----------------------
    // ETIQUETAS
    let tags = [];

    const rawTags = "{{ old('tags', $course->tags) }}";
    if (rawTags) tags = rawTags.split(',');

    const tagsContainer = document.getElementById('tags-container');
    const tagInput = document.getElementById('tag-input');
    const hiddenInput = document.getElementById('tags-hidden');

    function renderTags() {
        tagsContainer.innerHTML = '';
        tags.forEach((tag, index) => {
            const div = document.createElement('div');
            div.className = "bg-orange-100 text-orange-800 px-3 py-1 rounded-full flex items-center gap-2";

            div.innerHTML = `
                <span>${tag}</span>
                <button type="button" onclick="removeTag(${index})">✕</button>
            `;

            tagsContainer.appendChild(div);
        });

        hiddenInput.value = tags.join(',');
    }

    function removeTag(index) {
        tags.splice(index, 1);
        renderTags();
    }

    tagInput.addEventListener('keydown', e => {
        if (e.key === ',' || e.key === 'Enter') {
            e.preventDefault();
            const value = tagInput.value.trim();
            if (value && !tags.includes(value)) {
                tags.push(value);
                renderTags();
            }
            tagInput.value = '';
        }
    });

    renderTags();

    // ----------------------
    // TABLA DE CONTENIDO
    let topics = [];

    const rawContent = `{!! str_replace("\n", "\\n", old('content_table', $course->content_table)) !!}`;

    if (rawContent) {
        topics = rawContent.split("\\n");
    }

    function addTopic() {
        const input = document.getElementById('topic-input');
        if (input.value.trim() !== "") {
            topics.push(input.value.trim());
            input.value = '';
            renderTopics();
        }
    }

    function removeTopic(index) {
        topics.splice(index, 1);
        renderTopics();
    }

    function renderTopics() {
        const list = document.getElementById('topics-list');
        const textarea = document.getElementById('content_table');

        list.innerHTML = '';

        topics.forEach((topic, index) => {
            const li = document.createElement('li');
            li.className = "flex justify-between items-center bg-gray-100 dark:bg-gray-700 px-4 py-2 rounded-lg";

            li.innerHTML = `
                <span>${index + 1}. ${topic}</span>
                <button onclick="removeTopic(${index})" class="text-red-500">Eliminar</button>
            `;

            list.appendChild(li);
        });

        textarea.value = topics.join("\n");
    }

    renderTopics();
</script>
</x-app-layout>
