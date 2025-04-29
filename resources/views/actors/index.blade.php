<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('Actors') }}
    </h2>
  </x-slot>

  <x-wrapper-views x-data>
    {{-- Acción: Nuevo Actor --}}
    <x-slot name="actions">
      <x-primary-button @click="$dispatch('open-modal','create-actor')">
        {{ __('New Actor') }}
      </x-primary-button>
    </x-slot>

    {{-- Tabla de actores --}}
    <div class="overflow-x-auto">
      <table class="min-w-full divide-y divide-gray-200">
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
            <th class="px-6 py-3"></th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
          @foreach($actors as $actor)
            <tr>
              {{-- Photo --}}
              <td class="px-6 py-4 whitespace-nowrap">
                @if($actor->image)
                  <div class="inline-block transform transition duration-150 ease-in-out hover:scale-125">
                    <div class="h-16 w-16 overflow-hidden rounded">
                      <img src="{{ Storage::url($actor->image) }}"
                           alt="{{ $actor->first_name }} {{ $actor->last_name }}"
                           class="h-full w-full object-cover" />
                    </div>
                  </div>
                @else
                  &mdash;
                @endif
              </td>

              {{-- First Name --}}
              <td class="px-6 py-4 whitespace-nowrap text-base text-gray-900">
                {{ $actor->first_name }}
              </td>

              {{-- Last Name --}}
              <td class="px-6 py-4 whitespace-nowrap text-base text-gray-900">
                {{ $actor->last_name }}
              </td>

              {{-- Phone --}}
              <td class="px-6 py-4 whitespace-nowrap text-base text-gray-900">
                {{ $actor->phone ?? '—' }}
              </td>

              {{-- Email --}}
              <td class="px-6 py-4 whitespace-nowrap text-base text-gray-900">
                {{ $actor->email ?? '—' }}
              </td>

              {{-- City --}}
              <td class="px-6 py-4 whitespace-nowrap text-base text-gray-900">
                {{ $actor->city ?? '—' }}
              </td>

              {{-- Has Car --}}
              <td class="px-6 py-4 whitespace-nowrap text-base text-gray-900">
                {!! $actor->has_car ? '✅' : '❌' !!}
              </td>

              {{-- Can Drive --}}
              <td class="px-6 py-4 whitespace-nowrap text-base text-gray-900">
                {!! $actor->can_drive ? '✅' : '❌' !!}
              </td>

              {{-- Active --}}
              <td class="px-6 py-4 whitespace-nowrap text-base text-gray-900">
                {!! $actor->active ? '✅' : '❌' !!}
              </td>

              {{-- Notes --}}
              <td class="px-6 py-4 whitespace-nowrap text-base text-gray-900">
                <span
                  class="cursor-pointer"
                  title="{{ $actor->notes ?: '...' }}"
                >📝</span>
              </td> 

              {{-- Acciones --}}
              <td class="px-6 py-4 whitespace-nowrap text-base text-gray-900 text-right">
                <x-secondary-button style="link"
                  @click="$dispatch('open-modal','edit-actor-{{ $actor->id }}')">
                  {{ __('Edit') }}
                </x-secondary-button>
                <x-danger-button class="ml-2"
                  @click.prevent="$dispatch('open-modal','confirm-delete-actor-{{ $actor->id }}')">
                  {{ __('Delete') }}
                </x-danger-button>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>

    {{-- Paginación --}}
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
      @csrf
      {{-- First Name --}}
      <x-input-label for="first_name" :value="__('First Name')" class="mt-4" />
      <x-text-input id="first_name" name="first_name" type="text"
                    class="mt-1 block w-full"
                    :value="old('first_name')" required />
      <x-input-error :messages="$errors->get('first_name')" class="mt-2" />

      {{-- Last Name --}}
      <x-input-label for="last_name" :value="__('Last Name')" class="mt-4" />
      <x-text-input id="last_name" name="last_name" type="text"
                    class="mt-1 block w-full"
                    :value="old('last_name')" required />
      <x-input-error :messages="$errors->get('last_name')" class="mt-2" />

      {{-- Phone --}}
      <x-input-label for="phone" :value="__('Phone')" class="mt-4" />
      <x-text-input id="phone" name="phone" type="text"
                    class="mt-1 block w-full"
                    :value="old('phone')" />
      <x-input-error :messages="$errors->get('phone')" class="mt-2" />

      {{-- Email --}}
      <x-input-label for="email" :value="__('Email')" class="mt-4" />
      <x-text-input id="email" name="email" type="email"
                    class="mt-1 block w-full"
                    :value="old('email')" />
      <x-input-error :messages="$errors->get('email')" class="mt-2" />

      {{-- City --}}
      <x-input-label for="city" :value="__('City')" class="mt-4" />
      <x-text-input id="city" name="city" type="text"
                    class="mt-1 block w-full"
                    :value="old('city')" />
      <x-input-error :messages="$errors->get('city')" class="mt-2" />

      {{-- Has Car --}}
      <div class="flex items-center mt-4">
        <input id="has_car" name="has_car" type="checkbox"
               class="rounded border-gray-300"
               {{ old('has_car') ? 'checked' : '' }} />
        <label for="has_car" class="ml-2 block text-sm text-gray-700">
          {{ __('Has Car') }}
        </label>
      </div>

      {{-- Can Drive --}}
      <div class="flex items-center mt-4">
        <input id="can_drive" name="can_drive" type="checkbox"
               class="rounded border-gray-300"
               {{ old('can_drive') ? 'checked' : '' }} />
        <label for="can_drive" class="ml-2 block text-sm text-gray-700">
          {{ __('Can Drive') }}
        </label>
      </div>

      {{-- Active --}}
      <x-input-label for="active" :value="__('Active')" class="mt-4" />
      <select id="active" name="active"
              class="mt-1 block w-full border-gray-300 rounded" required>
        <option value="1" {{ old('active')=='1' ? 'selected':'' }}>Yes</option>
        <option value="0" {{ old('active')=='0' ? 'selected':'' }}>No</option>
      </select>
      <x-input-error :messages="$errors->get('active')" class="mt-2" />

      {{-- Notes --}}
      <x-input-label for="notes" :value="__('Notes')" class="mt-4" />
      <textarea id="notes" name="notes"
                class="mt-1 block w-full border-gray-300 rounded">{{ old('notes') }}</textarea>
      <x-input-error :messages="$errors->get('notes')" class="mt-2" />

      {{-- Photo --}}
      <x-input-label for="image" :value="__('Image')" />
      <input id="image" name="image" type="file" class="mt-1 block w-full" />
      <x-input-error :messages="$errors->get('image')" class="mt-2" />
    </x-modal-form>

    {{-- Modales Editar y Eliminar --}}
    @foreach($actors as $actor)
      {{-- Edit Actor --}}
      <x-modal-form
        modal-name="edit-actor-{{ $actor->id }}"
        max-width="md"
        action="{{ route('actors.update', $actor) }}"
        method="PATCH"
        enctype="multipart/form-data"
        title="{{ __('Edit Actor') }}"
        submit-text="{{ __('Save') }}"
      >
        @csrf
        @method('PATCH')

        {{-- First Name --}}
        <x-input-label for="first_name-{{ $actor->id }}" :value="__('First Name')" class="mt-4" />
        <x-text-input id="first_name-{{ $actor->id }}" name="first_name" type="text"
                      class="mt-1 block w-full"
                      :value="old('first_name', $actor->first_name)" required />
        <x-input-error :messages="$errors->get('first_name')" class="mt-2" />

        {{-- Last Name --}}
        <x-input-label for="last_name-{{ $actor->id }}" :value="__('Last Name')" class="mt-4" />
        <x-text-input id="last_name-{{ $actor->id }}" name="last_name" type="text"
                      class="mt-1 block w-full"
                      :value="old('last_name', $actor->last_name)" required />
        <x-input-error :messages="$errors->get('last_name')" class="mt-2" />

        {{-- Phone --}}
        <x-input-label for="phone-{{ $actor->id }}" :value="__('Phone')" class="mt-4" />
        <x-text-input id="phone-{{ $actor->id }}" name="phone" type="text"
                      class="mt-1 block w-full"
                      :value="old('phone', $actor->phone)" />
        <x-input-error :messages="$errors->get('phone')" class="mt-2" />

        {{-- Email --}}
        <x-input-label for="email-{{ $actor->id }}" :value="__('Email')" class="mt-4" />
        <x-text-input id="email-{{ $actor->id }}" name="email" type="email"
                      class="mt-1 block w-full"
                      :value="old('email', $actor->email)" />
        <x-input-error :messages="$errors->get('email')" class="mt-2" />

        {{-- City --}}
        <x-input-label for="city-{{ $actor->id }}" :value="__('City')" class="mt-4" />
        <x-text-input id="city-{{ $actor->id }}" name="city" type="text"
                      class="mt-1 block w-full"
                      :value="old('city', $actor->city)" />
        <x-input-error :messages="$errors->get('city')" class="mt-2" />

        {{-- Has Car --}}
        <div class="flex items-center mt-4">
          <input id="has_car-{{ $actor->id }}" name="has_car" type="checkbox"
                 class="rounded border-gray-300"
                 {{ old('has_car', $actor->has_car) ? 'checked' : '' }} />
          <label for="has_car-{{ $actor->id }}" class="ml-2 block text-sm text-gray-700">
            {{ __('Has Car') }}
          </label>
        </div>

        {{-- Can Drive --}}
        <div class="flex items-center mt-4">
          <input id="can_drive-{{ $actor->id }}" name="can_drive" type="checkbox"
                 class="rounded border-gray-300"
                 {{ old('can_drive', $actor->can_drive) ? 'checked' : '' }} />
          <label for="can_drive-{{ $actor->id }}" class="ml-2 block text-sm text-gray-700">
            {{ __('Can Drive') }}
          </label>
        </div>

        {{-- Active --}}
        <x-input-label for="active-{{ $actor->id }}" :value="__('Active')" class="mt-4" />
        <select id="active-{{ $actor->id }}" name="active"
                class="mt-1 block w-full border-gray-300 rounded" required>
          <option value="1" {{ old('active', $actor->active) ? 'selected':'' }}>Yes</option>
          <option value="0" {{ ! old('active', $actor->active) ? 'selected':'' }}>No</option>
        </select>
        <x-input-error :messages="$errors->get('active')" class="mt-2" />

        {{-- Notes --}}
        <x-input-label for="notes-{{ $actor->id }}" :value="__('Notes')" class="mt-4" />
        <textarea id="notes-{{ $actor->id }}" name="notes"
                  class="mt-1 block w-full border-gray-300 rounded">{{ old('notes', $actor->notes) }}</textarea>
        <x-input-error :messages="$errors->get('notes')" class="mt-2" />

        {{-- IMAGE --}}
        <x-input-label for="image-{{ $actor->id }}" :value="__('Image')" />
          <input id="image-{{ $actor->id }}" name="image" type="file" class="mt-1 block w-full" />
          @if($actor->image)
            <div class="mt-2 inline-block transform hover:scale-110">
              <div class="h-20 w-20 overflow-hidden rounded">
                <img src="{{ Storage::url($actor->image) }}"
                     alt="{{ $actor->first_name }} {{ $actor->last_name }}"
                     class="h-full w-full object-cover" />
              </div>
            </div>
          @endif
          <x-input-error :messages="$errors->get('image')" class="mt-2" />
      </x-modal-form>

      {{-- Confirm Delete --}}
      <x-modal name="confirm-delete-actor-{{ $actor->id }}" focusable>
        <form method="POST" action="{{ route('actors.destroy', $actor) }}" class="p-6">
          @csrf @method('DELETE')
          <h2 class="text-lg font-medium text-gray-900">
            {{ __("Are you sure you want to delete “{$actor->first_name} {$actor->last_name}”?") }}
          </h2>
          <div class="mt-4 flex justify-end space-x-2">
            <x-secondary-button
              @click="$dispatch('close-modal','confirm-delete-actor-{{ $actor->id }}')">
              {{ __('Cancel') }}
            </x-secondary-button>
            <x-danger-button type="submit">{{ __('Delete') }}</x-danger-button>
          </div>
        </form>
      </x-modal>
    @endforeach

  </x-wrapper-views>
</x-app-layout>
