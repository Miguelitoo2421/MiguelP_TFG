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
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">{{ __('Characters') }}</th>
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
              <td class="px-6 py-4 whitespace-nowrap text-base text-gray-900">
                {{ $play->name }}
              </td>

              {{-- Productora --}}
              <td class="px-6 py-4 whitespace-nowrap text-base text-gray-900">
                {{ $play->producer?->name ?? '—' }}
              </td>

              {{-- Personajes --}}
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                @if($play->characters->isNotEmpty())
                  <div x-data="{ 
                    isOpen: false,
                    removeCharacter(playId, characterId) {
                      fetch(`/plays/${playId}/characters/${characterId}`, {
                        method: 'DELETE',
                        headers: {
                          'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                      }).then(response => {
                        if (response.ok) {
                          window.location.reload();
                        }
                      });
                    }
                  }" class="relative">
                    <div @click="isOpen = !isOpen" 
                         class="flex items-center gap-2 cursor-pointer hover:bg-gray-50 p-1 rounded">
                      <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2 py-1 rounded">
                        {{ $play->characters->first()->name }}
                      </span>
                      @if($play->characters->count() > 1)
                        <svg :class="{'rotate-180': isOpen}" class="w-4 h-4 transition-transform" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                          <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                      @endif
                    </div>

                    {{-- Lista desplegable de characters --}}
                    <div x-show="isOpen" 
                         @click.away="isOpen = false"
                         class="absolute z-10 left-0 mt-1 bg-white border rounded-md shadow-lg py-1 min-w-[200px]">
                      @foreach($play->characters as $character)
                        <div class="px-3 py-1 text-sm text-gray-700 flex justify-between items-center hover:bg-gray-50">
                          {{ $character->name }}
                          <button 
                            @click.stop="removeCharacter({{ $play->id }}, {{ $character->id }})"
                            class="text-red-500 hover:text-red-700"
                            title="Eliminar personaje"
                          >
                            ×
                          </button>
                        </div>
                      @endforeach
                    </div>
                  </div>
                @else
                  <span class="text-gray-400">Characters</span>
                @endif
              </td>

              {{-- Activo --}}
              <td class="px-6 py-4 whitespace-nowrap text-base text-gray-900">
                {{ $play->active ? '✅' : '❌' }}
              </td>

              {{-- Notas --}}
              <td class="px-6 py-4 whitespace-nowrap text-base text-gray-900">
                <span class="cursor-pointer" title="{{ $play->notes ?: '...' }}">
                  📝
                </span>
              </td> 

              {{-- Acciones --}}
              <td class="px-6 py-4 whitespace-nowrap text-right text-base text-gray-900">
                <x-secondary-button style="link"
                  @click="$dispatch('open-modal','edit-play-{{ $play->id }}')">
                  {{ __('✏️') }}
                </x-secondary-button>
                <x-danger-button class="ml-2"
                  @click.prevent="$dispatch('open-modal','confirm-delete-play-{{ $play->id }}')">
                  {{ __('⛌') }}
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
      enctype="multipart/form-data"
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

      {{-- Characters (desplegable) --}}
      <div x-data="{ isOpen: false, selected: [] }" class="mt-4">
        <x-input-label :value="__('Characters')" class="mb-1" />
        
        {{-- Área principal que siempre es visible --}}
        <div class="relative">
          <div @click="isOpen = !isOpen" 
               class="w-full flex items-center justify-between p-2 border rounded-md cursor-pointer hover:bg-gray-50">
            <div class="flex flex-wrap gap-2 min-h-[1.5rem]">
              <template x-if="selected.length === 0">
                <span class="text-gray-500">Selecciona personajes</span>
              </template>
              <template x-if="selected.length > 0">
                <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2 py-1 rounded">
                  <span x-text="selected.length"></span> seleccionados
                </span>
              </template>
            </div>
            <svg :class="{'rotate-180': isOpen}" class="w-5 h-5 transition-transform" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
            </svg>
          </div>

          {{-- Lista desplegable de characters --}}
          <div x-show="isOpen" 
               @click.away="isOpen = false"
               class="absolute z-10 w-full mt-1 bg-white border rounded-md shadow-lg max-h-60 overflow-y-auto">
            <div class="p-2 grid grid-cols-1 gap-1">
              @foreach($characters as $id => $name)
                <label class="flex items-center p-2 hover:bg-gray-50 rounded cursor-pointer">
                  <input
                    type="checkbox"
                    name="characters[]"
                    value="{{ $id }}"
                    x-model="selected"
                    class="form-checkbox rounded"
                  />
                  <span class="ml-2 text-gray-700">{{ $name }}</span>
                </label>
              @endforeach
            </div>
          </div>
        </div>
        <x-input-error :messages="$errors->get('characters')" class="mt-2" />
      </div>

      {{-- Active --}}
      <x-input-label for="active" :value="__('Active')" class="mt-4" />
      <select id="active" name="active" class="mt-1 block w-full border-gray-300 rounded" required>
        <option value="1">{{ __('Yes') }}</option>
        <option value="0">{{ __('No') }}</option>
      </select>
      <x-input-error :messages="$errors->get('active')" class="mt-2" />

      {{-- Notes --}}
      <x-input-label for="notes" :value="__('Notes')" class="mt-4" />
      <textarea id="notes" name="notes" class="mt-1 block w-full border-gray-300 rounded"></textarea>
      <x-input-error :messages="$errors->get('notes')" class="mt-2" />

      {{-- Image --}}
      <x-input-label for="image" :value="__('Image')" class="mt-4" />
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
        <x-input-label for="producer_id-{{ $play->id }}" :value="__('Producer')" class="mt-4" />
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
            >{{ $title }}</option>
          @endforeach
        </select>
        <x-input-error :messages="$errors->get('producer_id')" class="mt-2" />

        {{-- Characters (desplegable) --}}
        <div x-data="{ isOpen: false, selected: {{ json_encode(old('characters', $play->characters->pluck('id')->toArray())) }} }" class="mt-4">
          <x-input-label :value="__('Characters')" class="mb-1" />
          
          {{-- Área principal que siempre es visible --}}
          <div class="relative">
            <div @click="isOpen = !isOpen" 
                 class="w-full flex items-center justify-between p-2 border rounded-md cursor-pointer hover:bg-gray-50">
              <div class="flex flex-wrap gap-2 min-h-[1.5rem]">
                <template x-if="selected.length === 0">
                  <span class="text-gray-500">Selecciona personajes</span>
                </template>
                <template x-if="selected.length > 0">
                  <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2 py-1 rounded">
                    <span x-text="selected.length"></span> seleccionados
                  </span>
                </template>
              </div>
              <svg :class="{'rotate-180': isOpen}" class="w-5 h-5 transition-transform" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
              </svg>
            </div>

            {{-- Lista desplegable de characters --}}
            <div x-show="isOpen" 
                 @click.away="isOpen = false"
                 class="absolute z-10 w-full mt-1 bg-white border rounded-md shadow-lg max-h-60 overflow-y-auto">
              <div class="p-2 grid grid-cols-1 gap-1">
                @foreach($characters as $id => $name)
                  <label class="flex items-center p-2 hover:bg-gray-50 rounded cursor-pointer">
                    <input
                      type="checkbox"
                      name="characters[]"
                      value="{{ $id }}"
                      x-model="selected"
                      class="form-checkbox rounded"
                    />
                    <span class="ml-2 text-gray-700">{{ $name }}</span>
                  </label>
                @endforeach
              </div>
            </div>
          </div>
        </div>
        <x-input-error :messages="$errors->get('characters')" class="mt-2" />

        {{-- Active --}}
        <x-input-label for="active-{{ $play->id }}" :value="__('Active')" class="mt-4" />
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
        <x-input-label for="notes-{{ $play->id }}" :value="__('Notes')" class="mt-4" />
        <textarea
          id="notes-{{ $play->id }}"
          name="notes"
          class="mt-1 block w-full border-gray-300 rounded"
        >{{ old('notes', $play->notes) }}</textarea>
        <x-input-error :messages="$errors->get('notes')" class="mt-2" />

        {{-- Image --}}
        <x-input-label for="image-{{ $play->id }}" :value="__('Image')" class="mt-4" />
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
      <x-confirm-delete
        :modalId="'confirm-delete-play-' . $play->id"
        :name="$play->name"
        :route="route('plays.destroy', $play)"
      />
    @endforeach

    {{-- Modals: Confirm Remove Character --}}
    @foreach($plays as $play)
      @foreach($play->characters as $character)
        <x-confirm-delete
          :modal-id="'confirm-remove-character-' . $play->id . '-' . $character->id"
          :name="$character->name"
          :route="route('plays.characters.remove', ['play' => $play->id, 'character' => $character->id])"
        />
      @endforeach
    @endforeach
  </x-wrapper-views>
</x-app-layout>
