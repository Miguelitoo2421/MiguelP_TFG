{{-- resources/views/admin/users/index.blade.php --}}
<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800">User Management</h2>
  </x-slot>

  <div x-data>
    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow sm:rounded-lg overflow-hidden">

          {{-- ——— Tabla de usuarios ——— --}}
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Role</th>
                <th class="px-6 py-3"></th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              @foreach($users as $user)
                <tr>
                  <td class="px-6 py-4 whitespace-nowrap">{{ $user->name }}</td>
                  <td class="px-6 py-4 whitespace-nowrap">{{ $user->email }}</td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    {{ $user->roles->pluck('name')->join(', ') }}
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                    {{-- Botón dispara modal de edición --}}
                    <x-secondary-button
                      style="link"
                      @click="$dispatch('open-modal','edit-user-{{ $user->id }}')"
                    >
                      {{ __('Edit') }}
                    </x-secondary-button>

                    <!-- Botón delete user -->
                    <x-danger-button
                      class="ml-2"
                      x-on:click.prevent="$dispatch('open-modal','confirm-delete-{{ $user->id }}')"
                    >Delete</x-danger-button>
                    </form>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>

          {{-- ——— Modales de edición por cada usuario ——— --}}
          @foreach($users as $user)
            <x-modal name="edit-user-{{ $user->id }}" maxWidth="md" focusable>
              <form
                action="{{ route('admin.users.update', $user) }}"
                method="POST"
                class="space-y-6 p-6"
              >
                @csrf @method('PATCH')

                {{-- Nombre --}}
                <div>
                  <x-input-label for="name-{{ $user->id }}" :value="__('Name')" />
                  <x-text-input
                    id="name-{{ $user->id }}"
                    name="name"
                    type="text"
                    class="mt-1 block w-full"
                    :value="old('name', $user->name)"
                    required
                  />
                  <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                {{-- Email --}}
                <div>
                  <x-input-label for="email-{{ $user->id }}" :value="__('Email')" />
                  <x-text-input
                    id="email-{{ $user->id }}"
                    name="email"
                    type="email"
                    class="mt-1 block w-full"
                    :value="old('email', $user->email)"
                    required
                  />
                  <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                {{-- Selección de un solo rol --}}
                <div>
                  <x-input-label :value="__('Role')" />
                  <select
                    name="roles[]"
                    class="mt-1 block w-full border-gray-300 rounded"
                    required
                  >
                    @foreach($roles as $roleName)
                      <option
                        value="{{ $roleName }}"
                        {{ $user->hasRole($roleName) ? 'selected' : '' }}
                      >
                        {{ $roleName }}
                      </option>
                    @endforeach
                  </select>
                  <x-input-error :messages="$errors->get('roles')" class="mt-2" />
                </div>

                {{-- Botones --}}
                <div class="flex justify-end space-x-2 pt-4 border-t">
                  <x-secondary-button
                    type="button"
                    @click="$dispatch('close-modal','edit-user-{{ $user->id }}')"
                  >
                    {{ __('Cancel') }}
                  </x-secondary-button>

                  <x-primary-button type="submit">
                    {{ __('Save') }}
                  </x-primary-button>
                </div>
              </form>
            </x-modal>
          @endforeach

          <!-- Modales de confirmación de borrado -->
          @foreach($users as $user)
            <x-modal name="confirm-delete-{{ $user->id }}" focusable>
              <form
                method="POST"
                action="{{ route('admin.users.destroy', $user) }}"
                class="p-6"
              >
                @csrf
                @method('DELETE')

                <h2 class="text-lg font-medium text-gray-900">
                  ¿Are you sure you want to eliminate {{ $user->name }} profile?
                </h2>

                <div class="mt-4 flex justify-end space-x-2">
                  <x-secondary-button
                    @click="$dispatch('close-modal','confirm-delete-{{ $user->id }}')"
                  >
                    Cancel
                  </x-secondary-button>
                  <x-danger-button type="submit">
                    Delete
                  </x-danger-button>
                </div>
              </form>
            </x-modal>
          @endforeach

          {{-- ——— Paginación ——— --}}
          <div class="p-4">
            {{ $users->links() }}
          </div>

          {{-- ——— Botón y modal para “Register New User” ——— --}}
          <div class="flex justify-center mb-4">
            <x-primary-button
              @click="$dispatch('open-modal','create-user')"
            >
              {{ __('Register New User') }}
            </x-primary-button>
          </div>

          <x-modal name="create-user" maxWidth="md" focusable>
            <form method="POST" action="{{ route('admin.users.store') }}" class="space-y-6 p-6">
              @csrf

              <!-- Name -->
              <div>
                <x-input-label for="name" :value="__('Name')" />
                <x-text-input
                  id="name"
                  name="name"
                  type="text"
                  class="mt-1 block w-full"
                  :value="old('name')"
                  required autofocus
                />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
              </div>

              <!-- Email Address -->
              <div>
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input
                  id="email"
                  name="email"
                  type="email"
                  class="mt-1 block w-full"
                  :value="old('email')"
                  required
                />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
              </div>

              <!-- Password -->
              <div>
                <x-hidden-password
                  name="password"
                  id="password"
                  label="{{ __('Password') }}"
                  autocomplete="new-password"
                />
              </div>

              <!-- Confirm Password -->
              <div>
                <x-hidden-password
                  name="password_confirmation"
                  id="password_confirmation"
                  label="{{ __('Confirm Password') }}"
                  autocomplete="new-password"
                />
              </div>

              <!-- Role -->
                <div>
                  <x-input-label for="role" :value="__('Role')" />
                    <select
                        id="role"
                        name="role"
                        class="mt-1 block w-full border-gray-300 rounded"
                        required
                      >
                      @foreach($roles as $roleName)
                        <option value="{{ $roleName }}">{{ $roleName }}</option>
                      @endforeach
                    </select>
                  <x-input-error :messages="$errors->get('role')" class="mt-2" />
                 </div>

              {{-- Botones del modal de registro --}}
              <div class="flex justify-end space-x-2 pt-4 border-t">
                <x-secondary-button
                  type="button"
                  @click="$dispatch('close-modal','create-user')"
                >
                  {{ __('Cancel') }}
                </x-secondary-button>

                <x-primary-button type="submit">
                  {{ __('Register') }}
                </x-primary-button>
              </div>
            </form>
          </x-modal>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>
