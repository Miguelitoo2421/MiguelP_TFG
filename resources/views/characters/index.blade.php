<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('Characters') }}
    </h2>
  </x-slot>

  <x-wrapper-views x-data>
    {{-- Acción: Nuevo Personaje --}}
    <x-slot name="actions">
      <x-primary-button @click="$dispatch('open-modal','create-character')">
        {{ __('New Character') }}
      </x-primary-button>
    </x-slot>

    {{-- Tabla --}}
    <div class="overflow-x-auto">
      <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
          <tr>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">{{ __('Image') }}</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">{{ __('Name') }}</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">{{ __('Notes') }}</th>
            <th class="px-6 py-3"></th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
          @foreach($characters as $character)
            @php
              $deleteModal = $character->plays->count() > 0
                  ? "cannot-delete-character-{$character->id}"
                  : "confirm-delete-character-{$character->id}";
            @endphp
            <tr>
              {{-- Imagen --}}
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="inline-block transform transition duration-150 ease-in-out hover:scale-125">
                  <div class="h-16 w-16 overflow-hidden rounded">
                    <img
                      src="{{ $character->image_url }}"
                      alt="{{ $character->name }}"
                      class="h-full w-full object-cover"
                    />
                  </div>
                </div>
              </td>

              {{-- Nombre --}}
              <td class="px-6 py-4 whitespace-nowrap text-base text-gray-900">
                {{ $character->name }}
              </td>

              {{-- Notas --}}
              <td class="px-6 py-4 whitespace-nowrap text-base text-gray-900">
                <span title="{{ $character->notes ?: '...' }}">📝</span>
              </td>

              {{-- Acciones --}}
              <td class="px-6 py-4 whitespace-nowrap text-base text-right">
                <x-secondary-button style="link"
                  @click="$dispatch('open-modal','edit-character-{{ $character->id }}')">
                  ✏️
                </x-secondary-button>
                <x-danger-button class="ml-2"
                  @click.prevent="$dispatch('open-modal', '{{ $deleteModal }}')">
                  ⛌
                </x-danger-button>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>

    {{-- Paginación --}}
    <div class="mt-4">{{ $characters->links() }}</div>

    {{-- Modal: Crear --}}
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

      <x-input-label for="notes" :value="__('Notes')" />
      <textarea id="notes" name="notes" class="mt-1 block w-full border-gray-300 rounded"></textarea>
      <x-input-error :messages="$errors->get('notes')" class="mt-2" />

      <x-input-label for="image" :value="__('Image')" />
      <input id="image" name="image" type="file" class="mt-1 block w-full" />
      <x-input-error :messages="$errors->get('image')" class="mt-2" />
    </x-modal-form>

    {{-- Modal: Editar --}}
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

        <x-input-label for="notes-{{ $character->id }}" :value="__('Notes')" />
        <textarea
          id="notes-{{ $character->id }}"
          name="notes"
          class="mt-1 block w-full border-gray-300 rounded"
        >{{ old('notes', $character->notes) }}</textarea>
        <x-input-error :messages="$errors->get('notes')" class="mt-2" />

        <x-input-label for="image-{{ $character->id }}" :value="__('Photo')" />
        <input id="image-{{ $character->id }}" name="image" type="file" class="mt-1 block w-full" />
        <div class="mt-2 inline-block transform transition duration-150 ease-in-out hover:scale-125">
          <div class="h-20 w-20 overflow-hidden rounded">
            <img
              src="{{ $character->image_url }}"
              alt="{{ $character->name }}"
              class="h-full w-full object-cover"
            />
          </div>
        </div>
        <x-input-error :messages="$errors->get('image')" class="mt-2" />
      </x-modal-form>
    @endforeach

    {{-- Modals reutilizables --}}
    @foreach($characters as $character)
      @php
        $modalId = "confirm-delete-character-{$character->id}";
        $modalName = $character->name;
      @endphp

      @if($character->plays->count() > 0)
      <x-cannot-delete
        :modal-id="'cannot-delete-character-' . $character->id"
        :name="$character->name"
        :message="__('This character is assigned to one or more plays and cannot be deleted.')"
      />
      @else
        <x-confirm-delete
          :modal-id="$modalId"
          :name="$modalName"
          :route="route('characters.destroy', $character)"
        />
      @endif
    @endforeach
  </x-wrapper-views>
</x-app-layout>
