<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Producers') }}
        </h2>
    </x-slot>

    <x-wrapper-views x-data>
        {{-- Acción: Nueva productora --}}
        <x-slot name="actions">
            <x-primary-button @click="$dispatch('open-modal','create-producer')">
                {{ __('New Producer') }}
            </x-primary-button>
        </x-slot>

        {{-- Tabla de productoras --}}
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">{{ __('Image') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">{{ __('Name') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">{{ __('Tax ID') }}</th>
                        <th class="px-6 py-3"></th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($producers as $producer)
                        @php
                            $hasPlays = $producer->plays()->exists();
                            $modalId = $hasPlays
                                ? 'cannot-delete-producer-' . $producer->id
                                : 'confirm-delete-producer-' . $producer->id;
                        @endphp
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="inline-block transform transition duration-150 ease-in-out hover:scale-125">
                                    <div class="h-16 w-16 overflow-hidden rounded">
                                        <img src="{{ $producer->image_url }}" alt="{{ $producer->name }}" class="h-full w-full object-cover" />
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-gray-900">{{ $producer->name }}</td>
                            <td class="px-6 py-4 text-gray-900">{{ $producer->cif }}</td>
                            <td class="px-6 py-4 text-right">
                                <x-secondary-button style="link" @click="$dispatch('open-modal','edit-producer-{{ $producer->id }}')">
                                    ✏️
                                </x-secondary-button>
                                <x-danger-button class="ml-2" @click.prevent="$dispatch('open-modal','{{ $modalId }}')">
                                    ⛌
                                </x-danger-button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Paginación --}}
        <div class="mt-4">
            {{ $producers->links() }}
        </div>

        {{-- Modal: Crear --}}
        <x-modal-form
            modal-name="create-producer"
            max-width="md"
            action="{{ route('producers.store') }}"
            method="POST"
            enctype="multipart/form-data"
            title="{{ __('New Producer') }}"
            submit-text="{{ __('Create') }}"
        >
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" required />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />

            <x-input-label for="cif" :value="__('Tax ID')" />
            <x-text-input id="cif" name="cif" type="text" class="mt-1 block w-full" required />
            <x-input-error :messages="$errors->get('cif')" class="mt-2" />

            <x-input-label for="image" :value="__('Image')" />
            <input id="image" name="image" type="file" class="mt-1 block w-full" />
            <x-input-error :messages="$errors->get('image')" class="mt-2" />
        </x-modal-form>

        {{-- Modales: Editar --}}
        @foreach($producers as $producer)
            <x-modal-form
                modal-name="edit-producer-{{ $producer->id }}"
                max-width="md"
                action="{{ route('producers.update', $producer) }}"
                method="PATCH"
                enctype="multipart/form-data"
                title="{{ __('Edit Producer') }}"
                submit-text="{{ __('Save') }}"
            >
                <x-input-label for="name-{{ $producer->id }}" :value="__('Name')" />
                <x-text-input
                    id="name-{{ $producer->id }}"
                    name="name"
                    type="text"
                    class="mt-1 block w-full"
                    :value="old('name', $producer->name)"
                    required
                />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />

                <x-input-label for="cif-{{ $producer->id }}" :value="__('Tax ID')" />
                <x-text-input
                    id="cif-{{ $producer->id }}"
                    name="cif"
                    type="text"
                    class="mt-1 block w-full"
                    :value="old('cif', $producer->cif)"
                    required
                />
                <x-input-error :messages="$errors->get('cif')" class="mt-2" />

                <x-input-label for="image-{{ $producer->id }}" :value="__('Image')" />
                <input id="image-{{ $producer->id }}" name="image" type="file" class="mt-1 block w-full" />
                <div class="mt-2 inline-block transform transition duration-150 ease-in-out hover:scale-125">
                    <div class="h-20 w-20 overflow-hidden rounded">
                        <img src="{{ $producer->image_url }}" alt="{{ $producer->name }}" class="h-full w-full object-cover" />
                    </div>
                </div>
                <x-input-error :messages="$errors->get('image')" class="mt-2" />
            </x-modal-form>
        @endforeach

        {{-- Modales: Confirmar o advertir eliminación --}}
        @foreach($producers as $producer)
            @if($producer->plays()->exists())
                <x-cannot-delete
                    :modalId="'cannot-delete-producer-' . $producer->id"
                    :name="$producer->name"
                    message="{{ __('This producer is assigned to one or more plays and cannot be deleted.') }}"
                />
            @else
                <x-confirm-delete
                    :modalId="'confirm-delete-producer-' . $producer->id"
                    :name="$producer->name"
                    :route="route('producers.destroy', $producer)"
                />
            @endif
        @endforeach
    </x-wrapper-views>
</x-app-layout>
