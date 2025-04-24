{{-- resources/views/actors/index.blade.php --}}
<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Actors') }}
    </h2>
  </x-slot>

  <x-wrapper-views x-data>
    {{-- Tabla de actores --}}
    <table class="min-w-full divide-y divide-gray-200">
      <thead class="bg-gray-50">
        <tr>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
          <th class="px-6 py-3"></th>
        </tr>
      </thead>
      <tbody class="bg-white divide-y divide-gray-200">
        @foreach($actors as $actor)
          <tr>
            <td class="px-6 py-4 whitespace-nowrap">{{ $actor->id }}</td>
            <td class="px-6 py-4 whitespace-nowrap">{{ $actor->first_name }} {{ $actor->last_name }}</td>
            <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
              <x-secondary-button @click="$dispatch('open-modal','edit-actor-{{ $actor->id }}')" style="link">{{ __('Edit') }}</x-secondary-button>
              <x-danger-button class="ml-2" @click.prevent="$dispatch('open-modal','confirm-delete-{{ $actor->id }}')">{{ __('Delete') }}</x-danger-button>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>

    {{-- Paginación --}}
    <div class="p-4">{{ $actors->links() }}</div>

    {{-- Botón crear actor --}}
    <div class="flex justify-center mb-4">
      <x-primary-button @click="$dispatch('open-modal','create-actor')">{{ __('New Actor') }}</x-primary-button>
    </div>

    {{-- Modales de edición y creación --}}
    @foreach($actors as $actor)
      <x-modal name="edit-actor-{{ $actor->id }}" maxWidth="md" focusable>
        <!-- Formulario de edición similar al de creación -->
      </x-modal>
      <x-modal name="confirm-delete-{{ $actor->id }}" focusable>
        <!-- Confirmación borrado -->
      </x-modal>
    @endforeach
    <x-modal name="create-actor" maxWidth="md" focusable>
      <!-- Formulario de creación -->
    </x-modal>
  </x-wrapper-views>
</x-app-layout>