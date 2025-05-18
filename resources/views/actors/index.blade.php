<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('Actors') }}
    </h2>
  </x-slot>

  <x-wrapper-views x-data>
    <x-slot name="actions">
      <x-primary-button @click="$dispatch('open-modal','create-actor')">
        {{ __('New Actor') }}
      </x-primary-button>
    </x-slot>

    <div class="overflow-x-auto">
      <table class="min-w-full divide-y divide-gray-200 table-fixed">
        <thead class="bg-gray-50">
          <tr>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">{{ __('Photo') }}</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">{{ __('First Name') }}</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">{{ __('Last Name') }}</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">{{ __('Phone') }}</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">{{ __('Email') }}</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">{{ __('City') }}</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">{{ __('Car') }}</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">{{ __('Drive') }}</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">{{ __('Active') }}</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">{{ __('Notes') }}</th>
            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase w-32"></th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
          @foreach($actors as $actor)
            <tr>
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="inline-block transform transition duration-150 ease-in-out hover:scale-125">
                  <div class="h-16 w-16 overflow-hidden rounded">
                    <img
                      src="{{ $actor->image_url }}"
                      alt="{{ $actor->first_name }} {{ $actor->last_name }}"
                      class="h-full w-full object-cover"
                    />
                  </div>
                </div>
              </td>
              <td class="px-6 py-4 text-base text-gray-900 truncate">{{ $actor->first_name }}</td>
              <td class="px-6 py-4 text-base text-gray-900 truncate">{{ $actor->last_name }}</td>
              <td class="px-6 py-4 text-base text-gray-900 truncate">{{ $actor->phone ?? '—' }}</td>
              <td class="px-6 py-4 text-base text-gray-900 truncate">{{ $actor->email ?? '—' }}</td>
              <td class="px-6 py-4 text-base text-gray-900 truncate">{{ $actor->city ?? '—' }}</td>
              <td class="px-6 py-4 text-base text-gray-900">{!! $actor->has_car ? '✅' : '❌' !!}</td>
              <td class="px-6 py-4 text-base text-gray-900">{!! $actor->can_drive ? '✅' : '❌' !!}</td>
              <td class="px-6 py-4 text-base text-gray-900">{!! $actor->active ? '✅' : '❌' !!}</td>
              <td class="px-6 py-4 text-base text-gray-900">
                <span class="cursor-pointer" title="{{ $actor->notes ?: '...' }}">📝</span>
              </td>
              <td class="px-6 py-4 text-right">
                <div class="inline-flex items-center space-x-2 whitespace-nowrap w-32">
                  <x-secondary-button
                    style="link"
                    @click="$dispatch('open-modal','edit-actor-{{ $actor->id }}')"
                  >✏️</x-secondary-button>
                  <x-danger-button
                    @click.prevent="$dispatch('open-modal','confirm-delete-actor-{{ $actor->id }}')"
                  >⛌</x-danger-button>
                </div>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>

    <div class="mt-4">{{ $actors->links() }}</div>

    {{-- Modal: Crear Actor --}}
    <x-modal-form
      modal-name="create-actor"
      max-width="md"
      action="{{ route('actors.store') }}"
      method="POST"
      enctype="multipart/form-data"
      title="{{ __('New Actor') }}"
      submit-text="{{ __('Create') }}"
    >
      <x-input-label for="first_name" :value="__('First Name')" />
      <x-text-input id="first_name" name="first_name" type="text" class="mt-1 block w-full" required />
      <x-input-error :messages="$errors->get('first_name')" class="mt-2" />

      <x-input-label for="last_name" :value="__('Last Name')" />
      <x-text-input id="last_name" name="last_name" type="text" class="mt-1 block w-full" required />
      <x-input-error :messages="$errors->get('last_name')" class="mt-2" />

      <x-input-label for="phone" :value="__('Phone')" />
      <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full" />
      <x-input-error :messages="$errors->get('phone')" class="mt-2" />

      <x-input-label for="email" :value="__('Email')" />
      <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" />
      <x-input-error :messages="$errors->get('email')" class="mt-2" />

      <x-input-label for="city" :value="__('City')" />
      <x-text-input id="city" name="city" type="text" class="mt-1 block w-full" />
      <x-input-error :messages="$errors->get('city')" class="mt-2" />

      <x-input-label for="image" :value="__('Image')" />
      <input id="image" name="image" type="file" class="mt-1 block w-full" />
      <x-input-error :messages="$errors->get('image')" class="mt-2" />

      <div class="mt-4">
        <label class="inline-flex items-center">
          <input type="checkbox" name="has_car" class="form-checkbox">
          <span class="ml-2">{{ __('Has Car') }}</span>
        </label>
      </div>

      <div class="mt-2">
        <label class="inline-flex items-center">
          <input type="checkbox" name="can_drive" class="form-checkbox">
          <span class="ml-2">{{ __('Can Drive') }}</span>
        </label>
      </div>

      <x-input-label for="active" :value="__('Active')" class="mt-4" />
      <select id="active" name="active" class="mt-1 block w-full border-gray-300 rounded">
        <option value="1">{{ __('Yes') }}</option>
        <option value="0">{{ __('No') }}</option>
      </select>
      <x-input-error :messages="$errors->get('active')" class="mt-2" />

      <x-input-label for="notes" :value="__('Notes')" class="mt-4" />
      <textarea id="notes" name="notes" class="mt-1 block w-full border-gray-300 rounded"></textarea>
      <x-input-error :messages="$errors->get('notes')" class="mt-2" />
    </x-modal-form>

    {{-- Modales Editar y Eliminar --}}
    @foreach($actors as $actor)
      {{-- Modal Editar --}}
      <x-modal-form
        modal-name="edit-actor-{{ $actor->id }}"
        max-width="md"
        action="{{ route('actors.update', $actor) }}"
        method="PATCH"
        enctype="multipart/form-data"
        title="{{ __('Edit Actor') }}"
        submit-text="{{ __('Save') }}"
      >
        <x-input-label for="first_name-{{ $actor->id }}" :value="__('First Name')" />
        <x-text-input id="first_name-{{ $actor->id }}" name="first_name" type="text" class="mt-1 block w-full" :value="old('first_name', $actor->first_name)" required />
        <x-input-error :messages="$errors->get('first_name')" class="mt-2" />

        <x-input-label for="last_name-{{ $actor->id }}" :value="__('Last Name')" />
        <x-text-input id="last_name-{{ $actor->id }}" name="last_name" type="text" class="mt-1 block w-full" :value="old('last_name', $actor->last_name)" required />
        <x-input-error :messages="$errors->get('last_name')" class="mt-2" />

        <x-input-label for="phone-{{ $actor->id }}" :value="__('Phone')" />
        <x-text-input id="phone-{{ $actor->id }}" name="phone" type="text" class="mt-1 block w-full" :value="old('phone', $actor->phone)" />
        <x-input-error :messages="$errors->get('phone')" class="mt-2" />

        <x-input-label for="email-{{ $actor->id }}" :value="__('Email')" />
        <x-text-input id="email-{{ $actor->id }}" name="email" type="email" class="mt-1 block w-full" :value="old('email', $actor->email)" />
        <x-input-error :messages="$errors->get('email')" class="mt-2" />

        <x-input-label for="city-{{ $actor->id }}" :value="__('City')" />
        <x-text-input id="city-{{ $actor->id }}" name="city" type="text" class="mt-1 block w-full" :value="old('city', $actor->city)" />
        <x-input-error :messages="$errors->get('city')" class="mt-2" />

        <x-input-label for="image-{{ $actor->id }}" :value="__('Image')" />
        <input id="image-{{ $actor->id }}" name="image" type="file" class="mt-1 block w-full" />
        @if($actor->image)
          <div class="mt-2 inline-block transform hover:scale-110">
            <div class="h-20 w-20 overflow-hidden rounded">
              <img src="{{ $actor->image_url }}" alt="{{ $actor->first_name }} {{ $actor->last_name }}" class="h-full w-full object-cover" />
            </div>
          </div>
        @endif
        <x-input-error :messages="$errors->get('image')" class="mt-2" />

        <div class="mt-4">
          <label class="inline-flex items-center">
            <input type="checkbox" name="has_car" class="form-checkbox" {{ old('has_car', $actor->has_car) ? 'checked' : '' }}>
            <span class="ml-2">{{ __('Has Car') }}</span>
          </label>
        </div>

        <div class="mt-2">
          <label class="inline-flex items-center">
            <input type="checkbox" name="can_drive" class="form-checkbox" {{ old('can_drive', $actor->can_drive) ? 'checked' : '' }}>
            <span class="ml-2">{{ __('Can Drive') }}</span>
          </label>
        </div>

        <x-input-label for="active-{{ $actor->id }}" :value="__('Active')" class="mt-4" />
        <select id="active-{{ $actor->id }}" name="active" class="mt-1 block w-full border-gray-300 rounded">
          <option value="1" {{ old('active', $actor->active) ? 'selected':'' }}>{{ __('Yes') }}</option>
          <option value="0" {{ !old('active', $actor->active) ? 'selected':'' }}>{{ __('No') }}</option>
        </select>
        <x-input-error :messages="$errors->get('active')" class="mt-2" />

        <x-input-label for="notes-{{ $actor->id }}" :value="__('Notes')" class="mt-4" />
        <textarea id="notes-{{ $actor->id }}" name="notes" class="mt-1 block w-full border-gray-300 rounded">{{ old('notes', $actor->notes) }}</textarea>
        <x-input-error :messages="$errors->get('notes')" class="mt-2" />
      </x-modal-form>

      {{-- Modal eliminar actor --}}
      <x-confirm-delete
        :modal-id="'confirm-delete-actor-' . $actor->id"
        :name="$actor->first_name . ' ' . $actor->last_name"
        :route="route('actors.destroy', $actor)"
      />
    @endforeach
  </x-wrapper-views>
</x-app-layout>
