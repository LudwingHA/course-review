<x-app-layout>
    <div class="max-w-4xl mx-auto py-8 px-4 sm:px-6 lg:px-8">

        <div class="mb-8">
            <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white mb-2">
                Crear Nuevo Curso
            </h1>
            <p class="text-gray-600 dark:text-gray-400">
                Comparte tu conocimiento con la comunidad educativa
            </p>
        </div>

        @if (session('success'))
            <div class="mb-6 p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-xl flex items-center shadow-sm">
                <span class="text-green-800 dark:text-green-200 font-medium">
                    {{ session('success') }}
                </span>
            </div>
        @endif

        <form method="POST" action="{{ route('courses.store') }}" enctype="multipart/form-data"
            class="space-y-6 bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 p-8">

            @csrf

            <!-- TÍTULO -->
            <div>
                <x-input-label for="title" :value="__('Título del curso')" />
                <x-text-input id="title" name="title" type="text" class="block w-full"
                    value="{{ old('title') }}" required />
            </div>

            <!-- DESCRIPCIÓN -->
            <div>
                <x-input-label for="description" :value="__('Descripción')" />
                <textarea id="description" name="description" rows="4"
                    class="block w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white"
                    required>{{ old('description') }}</textarea>
            </div>

            <!-- IMAGEN -->
            <div>
                <x-input-label for="image" :value="__('Imagen del curso')" />

                <div class="mt-2 flex items-center space-x-6">
                    <img id="image-preview"
                        class="h-32 w-32 object-cover rounded-xl border-2 border-dashed border-gray-300 dark:border-gray-600"
                        src="https://via.placeholder.com/400"
                        alt="Preview">

                    <input id="image" type="file" name="image" accept="image/*"
                        onchange="previewImage(this)"
                        class="text-sm text-gray-500 file:bg-orange-100 file:text-orange-700 file:px-4 file:py-2 file:rounded-lg">
                </div>
            </div>

            <!-- CATEGORÍA -->
            <div>
                <x-input-label for="category_id" :value="__('Categoría')" />
                <select id="category_id" name="category_id"
                    class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700">
                    <option value="">Selecciona...</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- ETIQUETAS DINÁMICAS -->
            <div>
                <x-input-label :value="__('Etiquetas')" />

                <div
                    class="mt-1 border border-gray-300 dark:border-gray-600 rounded-lg p-3 bg-gray-50 dark:bg-gray-700 focus-within:ring-2 focus-within:ring-orange-500">

                    <div id="tags-container" class="flex flex-wrap gap-2 mb-2"></div>

                    <input id="tag-input" type="text"
                        placeholder="Escribe una etiqueta y presiona coma..."
                        class="bg-transparent outline-none w-full text-gray-900 dark:text-white">

                    <input type="hidden" name="tags" id="tags-hidden">
                </div>
            </div>

            <!-- TABLA DE CONTENIDO -->
            <div>
                <x-input-label :value="__('Tabla de contenido')" />

                <div class="space-y-3 mt-2">
                    <div class="flex gap-2">
                        <input id="topic-input" type="text"
                            placeholder="Ej: Introducción a Laravel"
                            class="flex-1 px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white">

                        <button type="button" onclick="addTopic()"
                            class="px-4 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition">
                            Agregar
                        </button>
                    </div>

                    <ul id="topics-list" class="space-y-2"></ul>
                    <textarea id="content_table" name="content_table" hidden></textarea>
                </div>
            </div>

            <!-- URLS YOUTUBE -->
            <div>
                <x-input-label for="youtube_urls" :value="__('Videos de YouTube')" />
                <x-text-input id="youtube_urls" name="youtube_urls" type="text" class="block w-full"
                    placeholder="https://youtube.com/..." />
            </div>

            <!-- FECHA -->
            <div>
                <x-input-label for="published_at" :value="__('Fecha de publicación')" />
                <x-text-input id="published_at" name="published_at" type="date" class="block w-full" />
            </div>

            <!-- BOTÓN -->
            <div class="flex justify-end">
                <x-primary-button
                    class="bg-gradient-to-r from-orange-600 to-red-600 hover:from-orange-700 hover:to-red-700 px-6 py-3 rounded-xl text-white shadow-lg">
                    Crear Curso
                </x-primary-button>
            </div>

        </form>
    </div>

    <!-- ===================== SCRIPTS ===================== -->

    <script>
        function previewImage(input) {
            const preview = document.getElementById('image-preview');
            const file = input.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = e => preview.src = e.target.result;
                reader.readAsDataURL(file);
            }
        }
    </script>

    <!-- TAGS INTERACTIVOS -->
    <script>
        let tags = [];
        const tagInput = document.getElementById('tag-input');
        const tagsContainer = document.getElementById('tags-container');
        const hiddenInput = document.getElementById('tags-hidden');

        tagInput.addEventListener('keydown', function (e) {
            if (e.key === ',' || e.key === 'Enter') {
                e.preventDefault();
                const value = tagInput.value.replace(',', '').trim();
                if (value !== '') {
                    addTag(value);
                }
                tagInput.value = '';
            }
        });

        function addTag(text) {
            if (tags.includes(text)) return;
            tags.push(text);
            renderTags();
        }

        function removeTag(index) {
            tags.splice(index, 1);
            renderTags();
        }

        function renderTags() {
            tagsContainer.innerHTML = '';
            tags.forEach((tag, index) => {
                const el = document.createElement('div');

                el.className = "flex items-center bg-orange-100 dark:bg-orange-900/40 text-orange-700 dark:text-orange-300 px-3 py-1 rounded-full text-sm";

                el.innerHTML = `<span>${tag}</span>
                                <button onclick="removeTag(${index})"
                                        class="ml-2 text-orange-500 hover:text-red-600">&times;</button>`;

                tagsContainer.appendChild(el);
            });

            hiddenInput.value = tags.join(',');
        }
    </script>

    <!-- TABLA DE CONTENIDO -->
    <script>
        let topics = [];

        function addTopic() {
            const input = document.getElementById('topic-input');
            const text = input.value.trim();

            if (text === '') return;

            // Permite varias líneas pegadas
            const lines = text.split("\n");

            lines.forEach(line => {
                if (line.trim() !== '') {
                    topics.push(line.trim());
                }
            });

            input.value = '';
            renderTopics();
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

                li.className = "flex items-center justify-between bg-gray-100 dark:bg-gray-700 px-4 py-2 rounded-lg";

                li.innerHTML = `
                    <span>${index + 1}. ${topic}</span>
                    <button onclick="removeTopic(${index})" class="text-red-500 hover:text-red-700">Eliminar</button>
                `;

                list.appendChild(li);
            });

            textarea.value = topics.join("\n");
        }
    </script>

</x-app-layout>
