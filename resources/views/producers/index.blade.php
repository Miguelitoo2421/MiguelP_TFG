{{-- resources/views/producers/index.blade.php --}}
@php
    // Datos para Alpine
    $producerData = $producers->map(fn($p) => [
        'id'    => $p->id,
        'name'  => $p->name,
        'cif'   => $p->cif,
        'image' => $p->image,
    ]);
@endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Producers') }}
        </h2>
    </x-slot>

    <x-wrapper-views x-data="producersList()">
        {{-- botón “New Producer” --}}
        <x-slot name="actions">
            <x-primary-button @click="$dispatch('open-modal','create-producer')">
                {{ __('New Producer') }}
            </x-primary-button>
        </x-slot>

        {{-- Tabla --}}
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">{{ __('Foto') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">{{ __('Nombre') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">{{ __('CIF') }}</th>
                        <th class="px-6 py-3"></th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <template x-for="producer in all" :key="producer.id">
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <img
                                  :src="producer.image ? `/storage/${producer.image}` : '/images/default-producer.png'"
                                  alt=""
                                  class="h-12 w-12 object-cover rounded"
                                />
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900" x-text="producer.name"></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900" x-text="producer.cif"></td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                                <x-secondary-button style="link" @click="openEditModal(producer)">
                                    {{ __('Edit') }}
                                </x-secondary-button>
                                <x-danger-button class="ml-2" @click.prevent="openDeleteModal(producer)">
                                    {{ __('Delete') }}
                                </x-danger-button>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>

        {{-- Paginación --}}
        <div class="mt-4">{{ $producers->links() }}</div>

        {{-- Modal: Create Producer --}}
        <x-modal name="create-producer" focusable maxWidth="md">
            <form method="POST" action="{{ route('producers.store') }}" enctype="multipart/form-data" class="space-y-6 p-6">
                @csrf
                <div>
                    <x-input-label for="image_create" :value="__('Foto')" />
                    <x-text-input id="image_create" name="image" type="file" class="mt-1 block w-full" />
                    <x-input-error :messages="$errors->get('image')" class="mt-2" />
                </div>
                <div>
                    <x-input-label for="name_create" :value="__('Nombre')" />
                    <x-text-input id="name_create" name="name" type="text" class="mt-1 block w-full" required />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>
                <div>
                    <x-input-label for="cif_create" :value="__('CIF')" />
                    <x-text-input id="cif_create" name="cif" type="text" class="mt-1 block w-full" required />
                    <x-input-error :messages="$errors->get('cif')" class="mt-2" />
                </div>
                <div class="flex justify-end space-x-2 pt-4 border-t">
                    <x-secondary-button @click="$dispatch('close-modal','create-producer')">
                        {{ __('Cancel') }}
                    </x-secondary-button>
                    <x-primary-button type="submit">{{ __('Create') }}</x-primary-button>
                </div>
            </form>
        </x-modal>

        {{-- Modal: Edit Producer (formato unificado) --}}
        <x-modal name="edit-producer" focusable maxWidth="md">
            <form method="POST" :action="`/producers/${editItem.id}`" enctype="multipart/form-data" class="space-y-6 p-6">
                @csrf @method('PATCH')
                <div>
                    <x-input-label for="image_edit" :value="__('Foto')" />
                    <x-text-input id="image_edit" name="image" type="file" class="mt-1 block w-full" />
                    <template x-if="editItem.image">
                        <img :src="`/storage/${editItem.image}`" class="h-20 w-20 mt-2 object-cover rounded" />
                    </template>
                    <x-input-error :messages="$errors->get('image')" class="mt-2" />
                </div>
                <div>
                    <x-input-label for="name_edit" :value="__('Nombre')" />
                    <x-text-input
                        id="name_edit"
                        name="name"
                        type="text"
                        class="mt-1 block w-full"
                        x-model="editItem.name"
                        required
                    />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>
                <div>
                    <x-input-label for="cif_edit" :value="__('CIF')" />
                    <x-text-input
                        id="cif_edit"
                        name="cif"
                        type="text"
                        class="mt-1 block w-full"
                        x-model="editItem.cif"
                        required
                    />
                    <x-input-error :messages="$errors->get('cif')" class="mt-2" />
                </div>
                <div class="flex justify-end space-x-2 pt-4 border-t">
                    <x-secondary-button @click="$dispatch('close-modal','edit-producer')">
                        {{ __('Cancel') }}
                    </x-secondary-button>
                    <x-primary-button type="submit">{{ __('Save') }}</x-primary-button>
                </div>
            </form>
        </x-modal>

        {{-- Modal: Delete Producer --}}
        <x-modal name="delete-producer" focusable>
            <form method="POST" :action="`/producers/${deleteItem.id}`" class="p-6">
                @csrf @method('DELETE')
                <h2 class="text-lg font-medium text-gray-900">
                    {{ __('Are you sure you want to delete') }}
                    <span class="font-bold" x-text="deleteItem.name"></span>?
                </h2>
                <div class="mt-4 flex justify-end space-x-2">
                    <x-secondary-button @click="$dispatch('close-modal','delete-producer')">
                        {{ __('Cancel') }}
                    </x-secondary-button>
                    <x-danger-button type="submit">{{ __('Delete') }}</x-danger-button>
                </div>
            </form>
        </x-modal>
    </x-wrapper-views>

    <script>
        function producersList() {
            return {
                all: @json($producerData),
                editItem: {},
                deleteItem: {},
                openEditModal(item) {
                    this.editItem = { ...item };
                    this.$dispatch('open-modal','edit-producer');
                },
                openDeleteModal(item) {
                    this.deleteItem = { ...item };
                    this.$dispatch('open-modal','delete-producer');
                }
            }
        }
    </script>
</x-app-layout>
