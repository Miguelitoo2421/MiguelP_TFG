{{-- resources/views/components/modal-form.blade.php --}}
<x-modal :name="$modalName" :maxWidth="$maxWidth" focusable>
  <form
      action="{{ $action }}"
      method="POST"
      {{ $attributes->merge(['class' => 'space-y-6 p-6']) }}
  >
      @csrf
      @if($method !== 'POST')
          @method($method)
      @endif

      <h3 class="text-lg font-medium text-gray-900">{{ $title }}</h3>

      {{ $slot }} {{-- aquí slot para los campos de cada entidad --}}

      <div class="flex justify-center space-x-2 pt-4 border-t">
          <x-secondary-button
              type="button"
              @click="$dispatch('close-modal','{{ $modalName }}')"
          >
              {{ __('Cancel') }}
          </x-secondary-button>
          <x-primary-button type="submit">{{ $submitText }}</x-primary-button>
      </div>
  </form>
</x-modal>
