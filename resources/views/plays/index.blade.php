<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('Plays') }}
    </h2>
  </x-slot>

  <x-wrapper-views x-data>
    {{-- Acción: Nuevo Play --}}
    <x-slot name="actions">
      <x-primary-button @click="$dispatch('open-modal','create-play')">
        {{ __('New Play') }}
      </x-primary-button>
    </x-slot>

    {{-- Tabla --}}
    <div class="overflow-x-auto">
      <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
          <tr>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">{{ __('Image') }}</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">{{ __('Title') }}</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">{{ __('Producer') }}</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">{{ __('Active') }}</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">{{ __('Notes') }}</th>
            <th class="px-6 py-3"></th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
          @foreach($plays as $play)
            <tr>
              {{-- Imagen --}}
              <td class="px-6 py-4 whitespace-nowrap">
                @if($play->image)
                  <div class="inline-block transform transition duration-150 ease-in-out hover:scale-125">
                    <div class="h-16 w-16 overflow-hidden rounded">
                      <img src="{{ Storage::url($play->image) }}"
                           alt="{{ $play->name }}"
                           class="h-full w-full object-cover" />
                    </div>
                  </div>
                @else
                  &mdash;
                @endif
              </td>
              {{-- Título --}}
              <td class="px-6 py-4 whitespace-nowrap text-base text-gray-900">{{ $play->name }}</td>
              {{-- Productora --}}
              <td class="px-6 py-4 whitespace-nowrap text-base text-gray-900">
                {{ $play->producer?->name ?? '—' }}
              </td>
              {{-- Activo --}}
              <td class="px-6 py-4 whitespace-nowrap text-base text-gray-900">
                {{ $play->active ? '✅' : '❌' }}
              </td>
              {{-- Notas --}}
              <td class="px-6 py-4 whitespace-nowrap text-base text-gray-900">
                <span
                  class="cursor-pointer"
                  title="{{ $play->notes ?: '...' }}"
                >📝</span>
              </td> 
              {{-- Acciones --}}
              <td class="px-6 py-4 whitespace-nowrap text-right text-base text-gray-900">
                <x-secondary-button style="link"
                  @click="$dispatch('open-modal','edit-play-{{ $play->id }}')">
                  {{ __('Edit') }}
                </x-secondary-button>
                <x-danger-button class="ml-2"
                  @click.prevent="$dispatch('open-modal','confirm-delete-play-{{ $play->id }}')">
                  {{ __('Delete') }}
                </x-danger-button>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>

    {{-- Paginación --}}
    <div class="mt-4">{{ $plays->links() }}</div>

    {{-- Modal: Create --}}
    <x-modal-form
      modal-name="create-play"
      max-width="md"
      action="{{ route('plays.store') }}"
      method="POST"
      enctype="multipart/form-data"         {{-- <- MUY IMPORTANTE --}}
      title="{{ __('New Play') }}"
      submit-text="{{ __('Create') }}"
    >
      {{-- Title --}}
      <x-input-label for="name" :value="__('Title')" />
      <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" required />
      <x-input-error :messages="$errors->get('name')" class="mt-2" />

      {{-- Producer --}}
      <x-input-label for="producer_id" :value="__('Producer')" />
      <select id="producer_id" name="producer_id" class="mt-1 block w-full border-gray-300 rounded" required>
        @foreach($producers as $id => $title)
          <option value="{{ $id }}">{{ $title }}</option>
        @endforeach
      </select>
      <x-input-error :messages="$errors->get('producer_id')" class="mt-2" />

      {{-- Active --}}
      <x-input-label for="active" :value="__('Active')" />
      <select id="active" name="active" class="mt-1 block w-full border-gray-300 rounded" required>
        <option value="1">{{ __('Yes') }}</option>
        <option value="0">{{ __('No') }}</option>
      </select>
      <x-input-error :messages="$errors->get('active')" class="mt-2" />

      {{-- Notes --}}
      <x-input-label for="notes" :value="__('Notes')" />
      <textarea id="notes" name="notes" class="mt-1 block w-full border-gray-300 rounded"></textarea>
      <x-input-error :messages="$errors->get('notes')" class="mt-2" />

      {{-- Image --}}
      <x-input-label for="image" :value="__('Image')" />
      <input id="image" name="image" type="file" class="mt-1 block w-full" />
      <x-input-error :messages="$errors->get('image')" class="mt-2" />  
    </x-modal-form>

    {{-- Modals: Edit --}}
    @foreach($plays as $play)
    <x-modal-form
      modal-name="edit-play-{{ $play->id }}"
      max-width="md"
      action="{{ route('plays.update', $play) }}"
      method="PATCH"
      enctype="multipart/form-data"
      title="{{ __('Edit Play') }}"
      submit-text="{{ __('Save') }}"
    >
      {{-- Title --}}
      <x-input-label for="name-{{ $play->id }}" :value="__('Title')" />
        <x-text-input
          id="name-{{ $play->id }}"
          name="name"
          type="text"
          class="mt-1 block w-full"
          :value="old('name', $play->name)"
          required
        />
        <x-input-error :messages="$errors->get('name')" class="mt-2" />

      {{-- Producer --}}
      <x-input-label for="producer_id-{{ $play->id }}" :value="__('Producer')" />
      <select
        id="producer_id-{{ $play->id }}"
        name="producer_id"
        class="mt-1 block w-full border-gray-300 rounded"
        required
      >
        @foreach($producers as $id => $title)
          <option
            value="{{ $id }}"
            {{ old('producer_id', $play->producer_id) == $id ? 'selected' : '' }}
          >
            {{ $title }}
          </option>
        @endforeach
      </select>
      <x-input-error :messages="$errors->get('producer_id')" class="mt-2" />

      {{-- Active --}}
      <x-input-label for="active-{{ $play->id }}" :value="__('Active')" />
      <select
        id="active-{{ $play->id }}"
        name="active"
        class="mt-1 block w-full border-gray-300 rounded"
        required
      >
        <option value="1" {{ $play->active ? 'selected' : '' }}>{{ __('Yes') }}</option>
        <option value="0" {{ !$play->active ? 'selected' : '' }}>{{ __('No') }}</option>
      </select>
      <x-input-error :messages="$errors->get('active')" class="mt-2" />

      {{-- Notes --}}
      <x-input-label for="notes-{{ $play->id }}" :value="__('Notes')" />
      <textarea
        id="notes-{{ $play->id }}"
        name="notes"
        class="mt-1 block w-full border-gray-300 rounded"
      >{{ old('notes', $play->notes) }}</textarea>
      <x-input-error :messages="$errors->get('notes')" class="mt-2" />

      {{-- Image --}}
      <x-input-label for="image-{{ $play->id }}" :value="__('Image')" />
        <input
          id="image-{{ $play->id }}"
          name="image"
          type="file"
          class="mt-1 block w-full"
        />
        @if($play->image)
          <div class="mt-2 inline-block transform transition duration-150 ease-in-out hover:scale-125">
            <div class="h-20 w-20 overflow-hidden rounded">
              <img
                src="{{ Storage::url($play->image) }}"
                alt="{{ $play->name }}"
                class="h-full w-full object-cover"
              />
            </div>
          </div>
        @endif
        <x-input-error :messages="$errors->get('image')" class="mt-2" />
    </x-modal-form>
  @endforeach


    {{-- Modals: Confirm Delete --}}
    @foreach($plays as $play)
      <x-modal name="confirm-delete-play-{{ $play->id }}" focusable>
        <form method="POST" action="{{ route('plays.destroy', $play) }}" class="p-6">
          @csrf @method('DELETE')
          <h2 class="text-lg font-medium text-gray-900">
            {{ __("Are you sure you want to delete “{$play->name}”?") }}
          </h2>
          <div class="mt-4 flex justify-end space-x-2">
            <x-secondary-button
              @click="$dispatch('close-modal','confirm-delete-play-{{ $play->id }}')">
              {{ __('Cancel') }}
            </x-secondary-button>
            <x-danger-button type="submit">{{ __('Delete') }}</x-danger-button>
          </div>
        </form>
      </x-modal>
    @endforeach

  </x-wrapper-views>
</x-app-layout>
