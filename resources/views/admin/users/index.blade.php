{{-- resources/views/admin/users/index.blade.php --}}
<x-app-layout>
    <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('User Management') }}
      </h2>
    </x-slot>
  
    <x-wrapper-views x-data>
      <div class="flex flex-col">
        {{-- Acción: Registrar nuevo usuario --}}
        <x-slot name="actions">
          <x-primary-button @click="$dispatch('open-modal','create-user')">
            {{ __('Register New User') }}
          </x-primary-button>
        </x-slot>
    
        {{-- Tabla de usuarios --}}
        <div class="overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                  {{ __('Name') }}
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                  {{ __('Email') }}
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                  {{ __('Role') }}
                </th>
                <th scope="col" class="px-6 py-3"></th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              @foreach($users as $user)
                <tr>
                  <td class="px-6 py-4 whitespace-nowrap text-base text-gray-900">{{ $user->name }}</td>
                  <td class="px-6 py-4 whitespace-nowrap text-base text-gray-900">{{ $user->email }}</td>
                  <td class="px-6 py-4 whitespace-nowrap text-base text-gray-900">
                    {{ optional($user->roles->first())->name ?: '-' }}
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                    <x-secondary-button style="link"
                      @click="$dispatch('open-modal','edit-user-{{ $user->id }}')">
                      {{ __('✏️') }}
                    </x-secondary-button>
                    <x-danger-button class="ml-2"
                      @click.prevent="$dispatch('open-modal','confirm-delete-{{ $user->id }}')">
                      {{ __('⛌') }}
                    </x-danger-button>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
    
        {{-- Paginación --}}
        <div class="p-4">
          {{ $users->links() }}
        </div>
      </div>
  
      {{-- Modales de edición con componentización --}}
      @foreach($users as $user)
        <x-modal-form
          modal-name="edit-user-{{ $user->id }}"
          max-width="md"
          action="{{ route('admin.users.update', $user) }}"
          method="PATCH"
          title="{{ __('Edit User') }}"
          submit-text="{{ __('Save') }}"
        >
          {{-- Name --}}
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
  
          {{-- Email --}}
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
  
          {{-- Rol (único) --}}
          <x-input-label for="role-{{ $user->id }}" :value="__('Role')" />
          <select id="role-{{ $user->id }}" name="role" class="mt-1 block w-full border-gray-300 rounded" required>
            @foreach($roles as $roleName)
              <option value="{{ $roleName }}" {{ $user->hasRole($roleName) ? 'selected' : '' }}>
                {{ $roleName }}
              </option>
            @endforeach
          </select>
          <x-input-error :messages="$errors->get('role')" class="mt-2" />
        </x-modal-form>
      @endforeach
  
      {{-- Modales de confirmación de borrado --}}
      @foreach($users as $user)
        <x-confirm-delete
        :modalId="'confirm-delete-' . $user->id"
        :name="$user->name"
        :route="route('admin.users.destroy', $user)"
        :warning="$user->hasRole('admin') ? __('Administrators cannot be deleted.') : null"
      />
      @endforeach
  
      {{-- Modal de creación --}}
      <x-modal-form
        modal-name="create-user"
        max-width="md"
        action="{{ route('admin.users.store') }}"
        method="POST"
        title="{{ __('Register New User') }}"
        submit-text="{{ __('Register') }}"
      >
        {{-- Name --}}
        <x-input-label for="name" :value="__('Name')" />
        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name')" required autofocus />
        <x-input-error :messages="$errors->get('name')" class="mt-2" />
  
        {{-- Email --}}
        <x-input-label for="email" :value="__('Email')" />
        <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email')" required />
        <x-input-error :messages="$errors->get('email')" class="mt-2" />
  
        {{-- Password --}}
        <x-hidden-password name="password" id="password" label="{{ __('Password') }}" autocomplete="new-password" />
        <x-hidden-password name="password_confirmation" id="password_confirmation" label="{{ __('Confirm Password') }}" autocomplete="new-password" />
  
        {{-- Rol (único) --}}
        <x-input-label for="role" :value="__('Role')" />
        <select id="role" name="role" class="mt-1 block w-full border-gray-300 rounded" required>
          @foreach($roles as $roleName)
            <option value="{{ $roleName }}" {{ old('role') == $roleName ? 'selected' : '' }}>{{ $roleName }}</option>
          @endforeach
        </select>
        <x-input-error :messages="$errors->get('role')" class="mt-2" />
      </x-modal-form>
  
    </x-wrapper-views>
  </x-app-layout>
  