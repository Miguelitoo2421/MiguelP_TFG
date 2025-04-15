<div class="mt-4" x-data="{ showPassword: false, password: '' }" x-init="password = $refs.input.value">
  @if(isset($label))
      <x-input-label for="{{ $id ?? $name }}" :value="$label" />
  @endif
  <div class="relative">
      <x-text-input id="{{ $id ?? $name }}"
                    class="block mt-1 w-full pr-10"
                    x-bind:type="showPassword ? 'text' : 'password'"
                    x-model="password"
                    x-ref="input"
                    name="{{ $name }}"
                    required autocomplete="{{ $autocomplete ?? 'current-password' }}" />
      <button type="button"
              class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500"
              x-show="password.length > 0"
              x-on:click="showPassword = !showPassword">

          <svg x-show="!showPassword" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500" fill="none"
               viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
          </svg>
          
          <svg x-show="showPassword" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500" fill="none"
               viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.05 10.05 0 012.27-3.363M16.125 5.175A10.05 10.05 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.05 10.05 0 01-1.662 3.023M3 3l18 18" />
          </svg>
      </button>
  </div>
  <x-input-error :messages="$errors->get($name)" class="mt-2" />
</div>
