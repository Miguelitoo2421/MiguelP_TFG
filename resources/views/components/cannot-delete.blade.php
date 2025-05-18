@props(['modalId', 'name', 'message'])

<x-modal :name="$modalId" focusable>
  <div class="p-6">
    <h2 class="text-lg font-medium text-gray-900">
      {{ __('Cannot delete ":name"', ['name' => $name]) }}
    </h2>
    <p class="mt-4 text-sm text-gray-600">
      {{ $message }}
    </p>
    <div class="mt-4 flex justify-end space-x-2">
      <x-secondary-button @click="$dispatch('close-modal','{{ $modalId }}')">
        {{ __('Cancel') }}
      </x-secondary-button>
    </div>
  </div>
</x-modal>
