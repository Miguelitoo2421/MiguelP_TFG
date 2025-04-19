<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800">User Management</h2>
  </x-slot>

  <div class="py-6">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white shadow sm:rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Roles</th>
              <th class="px-6 py-3"></th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            @foreach($users as $user)
              <tr>
                <td class="px-6 py-4 whitespace-nowrap">{{ $user->name }}</td>
                <td class="px-6 py-4 whitespace-nowrap">{{ $user->email }}</td>
                <td class="px-6 py-4 whitespace-nowrap">
                  {{ $user->roles->pluck('name')->join(', ') }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                  <!-- Botón para editar roles -->
                  <button
                    @click="$dispatch('open-modal', { userId: {{ $user->id }} })"
                    class="text-indigo-600 hover:text-indigo-900"
                  >
                    Editar
                  </button>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>

        <div class="p-4">
          {{ $users->links() }}
        </div>
      </div>
    </div>
  </div>

  {{-- Aquí podrías tener tu modal Alpine.js para cambiar roles --}}
  {{-- Disparado con el evento "open-roles-modal" --}}
</x-app-layout>
