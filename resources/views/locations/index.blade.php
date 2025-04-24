{{-- resources/views/locations/index.blade.php --}}
<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Locations') }}
    </h2>
  </x-slot>

  <x-wrapper-views x-data>
    <table class="min-w-full divide-y divide-gray-200">
      <thead class="bg-gray-50">
        <tr>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
          <th class="px-6 py-3"></th>
        </tr>
      </thead>
      <tbody class="bg-white divide-y divide-gray-200">
        @foreach($locations as $location)
          <tr>
            <td class="px-6 py-4 whitespace-nowrap">{{ $location->id }}</td>
            <td class="px-6 py-4 whitespace-nowrap">{{ $location->name }}</td>
            <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
              <x-secondary-button @click="$dispatch('open-modal','edit-location-{{ $location->id }}')" style="link">{{ __('Edit') }}</x-secondary-button>
              <x-danger-button class="ml-2" @click.prevent="$dispatch('open-modal','confirm-delete-{{ $location->id }}')">{{ __('Delete') }}</x-danger-button>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>

    <div class="p-4">{{ $locations->links() }}</div>
    <div class="flex justify-center mb-4">
      <x-primary-button @click="$dispatch('open-modal','create-location')">{{ __('New Location') }}</x-primary-button>
    </div>
    @foreach($locations as $location)
      <x-modal name="edit-location-{{ $location->id }}" maxWidth="md" focusable>
      </x-modal>
      <x-modal name="confirm-delete-{{ $location->id }}" focusable>
      </x-modal>
    @endforeach
    <x-modal name="create-location" maxWidth="md" focusable>
    </x-modal>
  </x-wrapper-views>
</x-app-layout>