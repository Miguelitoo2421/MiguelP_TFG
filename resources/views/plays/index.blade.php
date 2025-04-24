{{-- resources/views/plays/index.blade.php --}}
<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Plays') }}
    </h2>
  </x-slot>

  <x-wrapper-views x-data>
    <table class="min-w-full divide-y divide-gray-200">
      <thead class="bg-gray-50">
        <tr>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Title</th>
          <th class="px-6 py-3"></th>
        </tr>
      </thead>
      <tbody class="bg-white divide-y divide-gray-200">
        @foreach($plays as $play)
          <tr>
            <td class="px-6 py-4 whitespace-nowrap">{{ $play->id }}</td>
            <td class="px-6 py-4 whitespace-nowrap">{{ $play->name }}</td>
            <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
              <x-secondary-button @click="$dispatch('open-modal','edit-play-{{ $play->id }}')" style="link">{{ __('Edit') }}</x-secondary-button>
              <x-danger-button class="ml-2" @click.prevent="$dispatch('open-modal','confirm-delete-{{ $play->id }}')">{{ __('Delete') }}</x-danger-button>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>

    <div class="p-4">{{ $plays->links() }}</div>
    <div class="flex justify-center mb-4">
      <x-primary-button @click="$dispatch('open-modal','create-play')">{{ __('New Play') }}</x-primary-button>
    </div>
    @foreach($plays as $play)
      <x-modal name="edit-play-{{ $play->id }}" maxWidth="md" focusable>
      </x-modal>
      <x-modal name="confirm-delete-{{ $play->id }}" focusable>
      </x-modal>
    @endforeach
    <x-modal name="create-play" maxWidth="md" focusable>
    </x-modal>
  </x-wrapper-views>
</x-app-layout>