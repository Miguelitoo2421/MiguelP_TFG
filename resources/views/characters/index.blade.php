{{-- resources/views/characters/index.blade.php --}}
<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('Characters') }}
    </h2>
  </x-slot>

  <x-wrapper-views x-data>
    {{-- Action: New Character --}}
    <x-slot name="actions">
      <x-primary-button @click="$dispatch('open-modal','create-character')">
        {{ __('New Character') }}
      </x-primary-button>
    </x-slot>

    {{-- Characters table --}}
    <div class="overflow-x-auto">
      <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
          <tr>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">{{ __('Image') }}</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">{{ __('Name') }}</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">{{ __('Play') }}</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">{{ __('Notes') }}</th>
            <th class="px-6 py-3"></th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
          @foreach($characters as $character)
            <tr>
              <td class="px-6 py-4 whitespace-nowrap">
                @if($character->image)
                  <div class="inline-block transform transition duration-150 ease-in-out hover:scale-125">
                    <div class="h-16 w-16 overflow-hidden rounded">
                      <img
                        src="{{ Storage::url($character->image) }}"
                        alt="{{ $character->name }}"
                        class="h-full w-full object-cover"
                      />
                    </div>
                  </div>
                @else
                  &mdash;
                @endif
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-base text-gray-900">
                {{ $character->name }}
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-base text-gray-900">
                {{ $character->play?->name }}
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-base text-gray-900">
                <span
                  class="cursor-pointer"
                  title="{{ $character->notes ?: '...' }}"
                >📝</span>
              </td>              
              <td class="px-6 py-4 whitespace-nowrap text-base text-right">
                <x-secondary-button style="link"
                  @click="$dispatch('open-modal','edit-character-{{ $character->id }}')">
                  {{ __('✏️') }}
                </x-secondary-button>
                <x-danger-button class="ml-2"
                  @click.prevent="$dispatch('open-modal','confirm-delete-character-{{ $character->id }}')">
                  {{ __('⛌') }}
                </x-danger-button>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>

    {{-- Pagination --}}
    <div class="mt-4">{{ $characters->links() }}</div>

    {{-- Modal: Create Character --}}
    <x-modal-form
      modal-name="create-character"
      max-width="md"
      action="{{ route('characters.store') }}"
      method="POST"
      enctype="multipart/form-data"
      title="{{ __('New Character') }}"
      submit-text="{{ __('Create') }}"
    >
      <x-input-label for="name" :value="__('Name')" />
      <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" required />
      <x-input-error :messages="$errors->get('name')" class="mt-2" />

      <x-input-label for="play_id" :value="__('Play')" />
      <select id="play_id" name="play_id" class="mt-1 block w-full border-gray-300 rounded">
        <option value="">{{ __('— None —') }}</option>
        @foreach($plays as $id => $title)
          <option value="{{ $id }}">{{ $title }}</option>
        @endforeach
      </select>
      <x-input-error :messages="$errors->get('play_id')" class="mt-2" />

      <x-input-label for="notes" :value="__('Notes')" />
      <textarea id="notes" name="notes" class="mt-1 block w-full border-gray-300 rounded"></textarea>
      <x-input-error :messages="$errors->get('notes')" class="mt-2" />

      <x-input-label for="image" :value="__('Image')" />
      <input id="image" name="image" type="file" class="mt-1 block w-full" />
      <x-input-error :messages="$errors->get('image')" class="mt-2" />
    </x-modal-form>

    {{-- Modals: Edit Character --}}
    @foreach($characters as $character)
      <x-modal-form
        modal-name="edit-character-{{ $character->id }}"
        max-width="md"
        action="{{ route('characters.update', $character) }}"
        method="PATCH"
        enctype="multipart/form-data"
        title="{{ __('Edit Character') }}"
        submit-text="{{ __('Save') }}"
      >
        <x-input-label for="name-{{ $character->id }}" :value="__('Name')" />
        <x-text-input
          id="name-{{ $character->id }}"
          name="name"
          type="text"
          class="mt-1 block w-full"
          :value="old('name', $character->name)"
          required
        />
        <x-input-error :messages="$errors->get('name')" class="mt-2" />

        <x-input-label for="play_id-{{ $character->id }}" :value="__('Play')" />
        <select id="play_id-{{ $character->id }}" name="play_id" class="mt-1 block w-full border-gray-300 rounded">
          <option value="">{{ __('— None —') }}</option>
          @foreach($plays as $id => $title)
            <option value="{{ $id }}" {{ old('play_id', $character->play_id) == $id ? 'selected' : '' }}>
              {{ $title }}
            </option>
          @endforeach
        </select>
        <x-input-error :messages="$errors->get('play_id')" class="mt-2" />

        <x-input-label for="notes-{{ $character->id }}" :value="__('Notes')" />
        <textarea
          id="notes-{{ $character->id }}"
          name="notes"
          class="mt-1 block w-full border-gray-300 rounded"
        >{{ old('notes', $character->notes) }}</textarea>
        <x-input-error :messages="$errors->get('notes')" class="mt-2" />

        <x-input-label for="image-{{ $character->id }}" :value="__('Photo')" />
        <input id="image-{{ $character->id }}" name="image" type="file" class="mt-1 block w-full" />
        @if($character->image)
          <div class="mt-2 inline-block transform transition duration-150 ease-in-out hover:scale-125">
            <div class="h-20 w-20 overflow-hidden rounded">
              <img
                src="{{ Storage::url($character->image) }}"
                alt="{{ $character->name }}"
                class="h-full w-full object-cover"
              />
            </div>
          </div>
        @endif
        <x-input-error :messages="$errors->get('image')" class="mt-2" />
      </x-modal-form>
    @endforeach

    {{-- Modals: Confirm Delete --}}
    @foreach($characters as $character)
      <x-modal name="confirm-delete-character-{{ $character->id }}" focusable>
        <form action="{{ route('characters.destroy', $character) }}" method="POST" class="p-6">
          @csrf @method('DELETE')
          <h2 class="text-lg font-medium text-gray-900">
            {{ __('Are you sure you want to delete ":name"?', ['name' => $character->name]) }}
          </h2>
          <div class="mt-4 flex justify-end space-x-2">
            <x-secondary-button @click="$dispatch('close-modal','confirm-delete-character-{{ $character->id }}')">
              {{ __('Cancel') }}
            </x-secondary-button>
            <x-danger-button type="submit">{{ __('Delete') }}</x-danger-button>
          </div>
        </form>
      </x-modal>
    @endforeach

  </x-wrapper-views>
</x-app-layout>
