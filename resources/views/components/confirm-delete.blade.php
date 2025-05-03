@props(['modalId', 'name', 'route', 'warning' => null])

<x-modal :name="$modalId" focusable>
  <form action="{{ $route }}" method="POST" class="p-6">
    @csrf
    @method('DELETE')

    <h2 class="text-lg font-medium text-gray-900">
      {{ __('Are you sure you want to delete ":name"?', ['name' => $name]) }}
    </h2>

    @if($warning)
      <p class="mt-4 text-sm text-red-600 font-semibold">
        {{ $warning }}
      </p>
    @endif

    <div class="mt-4 flex justify-end space-x-2">
      <x-secondary-button @click="$dispatch('close-modal','{{ $modalId }}')">
        {{ __('Cancel') }}
      </x-secondary-button>

      @unless($warning)
        <x-danger-button type="submit">
          {{ __('Delete') }}
        </x-danger-button>
      @endunless
    </div>
  </form>
</x-modal>
