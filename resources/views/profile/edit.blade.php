<x-app-layout>
    <div class="max-w-3xl mx-auto py-8">
        <h1 class="text-3xl font-bold mb-6">Mi Perfil</h1>

        @if(session('success'))
            <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PATCH')

            {{-- Nombre --}}
            <div>
                <label class="block font-medium">Nombre</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}"
                       class="w-full border rounded p-2">
                @error('name') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
            </div>

            {{-- Avatar --}}
            <div>
                <label class="block font-medium">Avatar</label>
                <div class="flex items-center gap-4 mt-2">
                    <img src="{{ $user->avatar ? asset('storage/'.$user->avatar) : 'https://via.placeholder.com/80' }}"
                         class="w-20 h-20 rounded-full object-cover border" alt="Avatar actual">
                    <input type="file" name="avatar" accept="image/*" class="text-sm">
                </div>
                @error('avatar') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
            </div>

            {{-- Descripción --}}
            <div>
                <label class="block font-medium">Descripción</label>
                <textarea name="description" rows="4"
                          class="w-full border rounded p-2">{{ old('description', $user->description) }}</textarea>
                @error('description') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
            </div>

            <div>
                <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Guardar Cambios
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
