<x-app-layout>
    <div class="max-w-6xl mx-auto py-10 px-4 sm:px-6 lg:px-8 space-y-8">

        <h1 class="text-3xl font-black text-gray-900 dark:text-white">Panel de Administradores</h1>

        @if(session('success'))
            <div class="bg-green-100 dark:bg-green-900 text-green-700 dark:text-green-300 p-4 rounded-xl border border-green-200 dark:border-green-700 shadow">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-x-auto">
            <table class="w-full min-w-[600px]">
                <thead class="bg-gray-100 dark:bg-gray-800">
                    <tr>
                        <th class="p-4 text-left text-gray-700 dark:text-gray-300">Nombre</th>
                        <th class="p-4 text-left text-gray-700 dark:text-gray-300">Email</th>
                        <th class="p-4 text-left text-gray-700 dark:text-gray-300">Rol</th>
                        <th class="p-4 text-center text-gray-700 dark:text-gray-300">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr class="border-t border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800 transition">
                            <td class="p-4 text-gray-900 dark:text-white font-semibold">{{ $user->name }}</td>
                            <td class="p-4 text-gray-700 dark:text-gray-300">{{ $user->email }}</td>
                            <td class="p-4">
                                <span class="
                                    @if($user->role == 'admin') text-red-600 dark:text-red-400
                                    @elseif($user->role == 'instructor') text-blue-600 dark:text-blue-400
                                    @else text-green-600 dark:text-green-400
                                    @endif
                                    font-semibold
                                ">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>
                            <td class="p-4 flex justify-center gap-4">
                                <a href="{{ route('admin.users.edit',$user) }}" class="text-blue-600 dark:text-blue-400 hover:underline">Editar</a>

                                <form method="POST" action="{{ route('admin.users.destroy',$user) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button onclick="return confirm('¿Eliminar usuario?')" 
                                        class="text-red-600 dark:text-red-400 hover:underline">
                                        Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $users->links() }}
        </div>

    </div>
</x-app-layout>
