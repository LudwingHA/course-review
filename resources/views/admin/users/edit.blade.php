<x-app-layout>
    <div class="max-w-xl mx-auto py-10 px-4 sm:px-6 lg:px-8">

        <div class="bg-white dark:bg-gray-900 p-8 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700">
            <h2 class="text-2xl font-black text-gray-900 dark:text-white mb-6">Editar Usuario</h2>

            <form method="POST" action="{{ route('admin.users.update', $user) }}">
                @csrf
                @method('PUT')

                <div class="mb-5">
                    <label class="block text-gray-700 dark:text-gray-300 font-semibold mb-2">Nombre</label>
                    <input type="text" name="name" 
                        class="w-full border border-gray-300 dark:border-gray-600 rounded-xl p-3 
                               bg-white dark:bg-gray-800 text-gray-900 dark:text-white 
                               focus:ring focus:ring-orange-500 transition"
                        value="{{ old('name', $user->name) }}">
                </div>

                <div class="mb-5">
                    <label class="block text-gray-700 dark:text-gray-300 font-semibold mb-2">Rol</label>
                    <select name="role" 
                        class="w-full border border-gray-300 dark:border-gray-600 rounded-xl p-3 
                               bg-white dark:bg-gray-800 text-gray-900 dark:text-white 
                               focus:ring focus:ring-orange-500 transition">
                        <option value="student" @selected($user->role=='student')>Student</option>
                        <option value="instructor" @selected($user->role=='instructor')>Instructor</option>
                        <option value="admin" @selected($user->role=='admin')>Admin</option>
                    </select>
                </div>

                <div class="mb-5">
                    <label class="block text-gray-700 dark:text-gray-300 font-semibold mb-2">Descripción</label>
                    <textarea name="description" rows="4" 
                        class="w-full border border-gray-300 dark:border-gray-600 rounded-xl p-3 
                               bg-white dark:bg-gray-800 text-gray-900 dark:text-white 
                               placeholder-gray-500 dark:placeholder-gray-400 focus:ring focus:ring-orange-500 transition">{{ old('description', $user->description) }}</textarea>
                </div>

                <button type="submit" 
                    class="bg-orange-500 hover:bg-orange-600 dark:bg-orange-400 dark:hover:bg-orange-500 
                           text-white font-bold px-6 py-3 rounded-xl transition transform hover:scale-105">
                    Guardar Cambios
                </button>
            </form>
        </div>

    </div>
</x-app-layout>
