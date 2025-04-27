<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('Locations') }}
    </h2>
  </x-slot>

  <x-wrapper-views x-data>
    {{-- Action: New Location --}}
    <x-slot name="actions">
      <x-primary-button @click="$dispatch('open-modal','create-location')">
        {{ __('New Location') }}
      </x-primary-button>
    </x-slot>

    {{-- Locations table --}}
    <div class="overflow-x-auto">
      <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
          <tr>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">{{ __('City') }}</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">{{ __('Province') }}</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">{{ __('Region') }}</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">{{ __('Street') }}</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">{{ __('Postal Code') }}</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">{{ __('Phone') }}</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">{{ __('Map URL') }}</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">{{ __('Active') }}</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">{{ __('Notes') }}</th>
            <th class="px-6 py-3"></th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
          @foreach($locations as $location)
            <tr>
              <td class="px-6 py-4 whitespace-nowrap">{{ $location->city }}</td>
              <td class="px-6 py-4 whitespace-nowrap">{{ $location->province  ?: '—' }}</td>
              <td class="px-6 py-4 whitespace-nowrap">{{ $location->region    ?: '—' }}</td>
              <td class="px-6 py-4 whitespace-nowrap">
                @if($location->street_name)
                  {{ "{$location->street_type} {$location->street_name}, {$location->street_number}" }}
                @else
                  &mdash;
                @endif
              </td>
              <td class="px-6 py-4 whitespace-nowrap">{{ $location->postal_code ?: '—' }}</td>
              <td class="px-6 py-4 whitespace-nowrap">{{ $location->phone       ?: '—' }}</td>
              <td class="px-6 py-4 whitespace-nowrap text-indigo-600">
                @if($location->url_map)
                  <a href="{{ $location->url_map }}" target="_blank" class="underline">{{ __('Link') }}</a>
                @else
                  &mdash;
                @endif
              </td>
              <td class="px-6 py-4 whitespace-nowrap">{{ $location->active ? '✅' : '❌' }}</td>
              <td class="px-6 py-4 whitespace-nowrap">
                <span title="{{ $location->notes ?: '...' }}">📝</span>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-right">
                <x-secondary-button style="link"
                  @click="$dispatch('open-modal','edit-location-{{ $location->id }}')">
                  {{ __('Edit') }}
                </x-secondary-button>
                <x-danger-button class="ml-2"
                  @click.prevent="$dispatch('open-modal','confirm-delete-location-{{ $location->id }}')">
                  {{ __('Delete') }}
                </x-danger-button>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>

    {{-- Pagination --}}
    <div class="mt-4">{{ $locations->links() }}</div>

    {{-- Modal: Create Location --}}
    <x-modal-form
      modal-name="create-location"
      max-width="lg"
      action="{{ route('locations.store') }}"
      method="POST"
      enctype="multipart/form-data"
      title="{{ __('New Location') }}"
      submit-text="{{ __('Create') }}"
    >
      @csrf
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        {{-- City --}}
        <div>
          <x-input-label for="city" :value="__('City')" />
          <x-text-input id="city" name="city" type="text" class="mt-1 block w-full"
                        :value="old('city')" required maxlength="50"/>
          <x-input-error :messages="$errors->get('city')" class="mt-2" />
        </div>
        {{-- Province --}}
        <div>
          <x-input-label for="province" :value="__('Province')" />
          <x-text-input id="province" name="province" type="text" class="mt-1 block w-full"
                        :value="old('province')" maxlength="50"/>
          <x-input-error :messages="$errors->get('province')" class="mt-2" />
        </div>
        {{-- Region --}}
        <div>
          <x-input-label for="region" :value="__('Region')" />
          <x-text-input id="region" name="region" type="text" class="mt-1 block w-full"
                        :value="old('region')" maxlength="50"/>
          <x-input-error :messages="$errors->get('region')" class="mt-2" />
        </div>
        {{-- Street Type --}}
        <div>
          <x-input-label for="street_type" :value="__('Street Type')" />
          <x-text-input id="street_type" name="street_type" type="text" class="mt-1 block w-full"
                        :value="old('street_type')" maxlength="100"/>
          <x-input-error :messages="$errors->get('street_type')" class="mt-2" />
        </div>
        {{-- Street Name --}}
        <div>
          <x-input-label for="street_name" :value="__('Street Name')" />
          <x-text-input id="street_name" name="street_name" type="text" class="mt-1 block w-full"
                        :value="old('street_name')" maxlength="100"/>
          <x-input-error :messages="$errors->get('street_name')" class="mt-2" />
        </div>
        {{-- Street Number --}}
        <div>
          <x-input-label for="street_number" :value="__('Street Number')" />
          <x-text-input id="street_number" name="street_number" type="text" class="mt-1 block w-full"
                        :value="old('street_number')" maxlength="20"/>
          <x-input-error :messages="$errors->get('street_number')" class="mt-2" />
        </div>
        {{-- Postal Code --}}
        <div>
          <x-input-label for="postal_code" :value="__('Postal Code')" />
          <x-text-input id="postal_code" name="postal_code" type="text" class="mt-1 block w-full"
                        :value="old('postal_code')" maxlength="20"/>
          <x-input-error :messages="$errors->get('postal_code')" class="mt-2" />
        </div>
        {{-- Phone --}}
        <div>
          <x-input-label for="phone" :value="__('Phone')" />
          <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full"
                        :value="old('phone')" maxlength="20"/>
          <x-input-error :messages="$errors->get('phone')" class="mt-2" />
        </div>
        {{-- Map URL --}}
        <div>
          <x-input-label for="url_map" :value="__('Map URL')" />
          <x-text-input id="url_map" name="url_map" type="url" class="mt-1 block w-full"
                        :value="old('url_map')" maxlength="255"/>
          <x-input-error :messages="$errors->get('url_map')" class="mt-2" />
        </div>
        {{-- Active --}}
        <div>
          <x-input-label for="active" :value="__('Active')" />
          <select id="active" name="active" class="mt-1 block w-full border-gray-300 rounded" required>
            <option value="1" {{ old('active')=='1' ? 'selected':'' }}>{{ __('Yes') }}</option>
            <option value="0" {{ old('active')=='0' ? 'selected':'' }}>{{ __('No') }}</option>
          </select>
          <x-input-error :messages="$errors->get('active')" class="mt-2" />
        </div>
        {{-- Notes --}}
        <div class="md:col-span-2">
          <x-input-label for="notes" :value="__('Notes')" />
          <textarea id="notes" name="notes" class="mt-1 block w/full border-gray-300 rounded" maxlength="255">{{ old('notes') }}</textarea>
          <x-input-error :messages="$errors->get('notes')" class="mt-2" />
        </div>
      </div>
    </x-modal-form>

    {{-- Modals: Edit Location --}}
    @foreach($locations as $location)
      <x-modal-form
        modal-name="edit-location-{{ $location->id }}"
        max-width="lg"
        action="{{ route('locations.update', $location) }}"
        method="PATCH"
        enctype="multipart/form-data"
        title="{{ __('Edit Location') }}"
        submit-text="{{ __('Save') }}"
      >
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          {{-- City --}}
          <div>
            <x-input-label for="city-{{ $location->id }}" :value="__('City')" />
            <x-text-input id="city-{{ $location->id }}" name="city" type="text"
                          class="mt-1 block w-full"
                          :value="old('city', $location->city)" required maxlength="50"/>
            <x-input-error :messages="$errors->get('city')" class="mt-2" />
          </div>
          {{-- Province --}}
          <div>
            <x-input-label for="province-{{ $location->id }}" :value="__('Province')" />
            <x-text-input id="province-{{ $location->id }}" name="province" type="text"
                          class="mt-1 block w-full"
                          :value="old('province', $location->province)" maxlength="50"/>
            <x-input-error :messages="$errors->get('province')" class="mt-2" />
          </div>
          {{-- Region --}}
          <div>
            <x-input-label for="region-{{ $location->id }}" :value="__('Region')" />
            <x-text-input id="region-{{ $location->id }}" name="region" type="text"
                          class="mt-1 block w-full"
                          :value="old('region', $location->region)" maxlength="50"/>
            <x-input-error :messages="$errors->get('region')" class="mt-2" />
          </div>
          {{-- Street Type --}}
          <div>
            <x-input-label for="street_type-{{ $location->id }}" :value="__('Street Type')" />
            <x-text-input id="street_type-{{ $location->id }}" name="street_type" type="text"
                          class="mt-1 block w-full"
                          :value="old('street_type', $location->street_type)" maxlength="100"/>
            <x-input-error :messages="$errors->get('street_type')" class="mt-2" />
          </div>
          {{-- Street Name --}}
          <div>
            <x-input-label for="street_name-{{ $location->id }}" :value="__('Street Name')" />
            <x-text-input id="street_name-{{ $location->id }}" name="street_name" type="text"
                          class="mt-1 block w-full"
                          :value="old('street_name', $location->street_name)" maxlength="100"/>
            <x-input-error :messages="$errors->get('street_name')" class="mt-2" />
          </div>
          {{-- Street Number --}}
          <div>
            <x-input-label for="street_number-{{ $location->id }}" :value="__('Street Number')" />
            <x-text-input id="street_number-{{ $location->id }}" name="street_number" type="text"
                          class="mt-1 block w-full"
                          :value="old('street_number', $location->street_number)" maxlength="20"/>
            <x-input-error :messages="$errors->get('street_number')" class="mt-2" />
          </div>
          {{-- Postal Code --}}
          <div>
            <x-input-label for="postal_code-{{ $location->id }}" :value="__('Postal Code')" />
            <x-text-input id="postal_code-{{ $location->id }}" name="postal_code" type="text"
                          class="mt-1 block w-full"
                          :value="old('postal_code', $location->postal_code)" maxlength="20"/>
            <x-input-error :messages="$errors->get('postal_code')" class="mt-2" />
          </div>
          {{-- Phone --}}
          <div>
            <x-input-label for="phone-{{ $location->id }}" :value="__('Phone')" />
            <x-text-input id="phone-{{ $location->id }}" name="phone" type="text"
                          class="mt-1 block w-full"
                          :value="old('phone', $location->phone)" maxlength="20"/>
            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
          </div>
          {{-- Map URL --}}
          <div>
            <x-input-label for="url_map-{{ $location->id }}" :value="__('Map URL')" />
            <x-text-input id="url_map-{{ $location->id }}" name="url_map" type="url"
                          class="mt-1 block w-full"
                          :value="old('url_map', $location->url_map)" maxlength="255"/>
            <x-input-error :messages="$errors->get('url_map')" class="mt-2" />
          </div>
          {{-- Active --}}
          <div>
            <x-input-label for="active-{{ $location->id }}" :value="__('Active')" />
            <select id="active-{{ $location->id }}" name="active"
                    class="mt-1 block w-full border-gray-300 rounded" required>
              <option value="1" {{ old('active', $location->active)==1 ? 'selected':'' }}>{{ __('Yes') }}</option>
              <option value="0" {{ old('active', $location->active)==0 ? 'selected':'' }}>{{ __('No') }}</option>
            </select>
            <x-input-error :messages="$errors->get('active')" class="mt-2" />
          </div>
          {{-- Notes --}}
          <div class="md:col-span-2">
            <x-input-label for="notes-{{ $location->id }}" :value="__('Notes')" />
            <textarea id="notes-{{ $location->id }}" name="notes"
                      class="mt-1 block w-full border-gray-300 rounded" maxlength="255">{{ old('notes', $location->notes) }}</textarea>
            <x-input-error :messages="$errors->get('notes')" class="mt-2" />
          </div>
        </div>
      </x-modal-form>

      {{-- Confirm Delete --}}
      <x-modal name="confirm-delete-location-{{ $location->id }}" focusable>
        <form action="{{ route('locations.destroy', $location) }}" method="POST" class="p-6">
          @csrf @method('DELETE')
          <h2 class="text-lg font-medium text-gray-900">
            {{ __('Are you sure you want to delete “:city”?', ['city' => $location->city]) }}
          </h2>
          <div class="mt-4 flex justify-end space-x-2">
            <x-secondary-button @click="$dispatch('close-modal','confirm-delete-location-{{ $location->id }}')">
              {{ __('Cancel') }}
            </x-secondary-button>
            <x-danger-button type="submit">{{ __('Delete') }}</x-danger-button>
          </div>
        </form>
      </x-modal>
    @endforeach

  </x-wrapper-views>
</x-app-layout>
