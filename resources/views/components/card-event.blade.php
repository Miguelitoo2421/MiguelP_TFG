{{-- resources/views/components/card-event.blade.php --}}
@props(['event'])


<div {{ $attributes->merge(['class'=>'bg-white shadow rounded-lg overflow-hidden cursor-pointer transform transition duration-200 hover:scale-105']) }}>
  <div class="h-48 bg-gray-100">
    <img
      src="{{ $event->play->image_url }}"
      alt="{{ $event->play->name }}"
      class="h-full w-full object-cover"
    />
  </div>
  <div class="p-4 space-y-2">
    <h3 class="text-lg font-semibold">{{ $event->title }}</h3>
    <p class="text-sm text-gray-600">
      <time datetime="{{ $event->scheduled_at->toIso8601String() }}">
        {{ $event->scheduled_at->format('d M Y, H:i') }}
      </time>
    </p>
    <p class="text-sm text-gray-600">
      📍 {{ $event->location->city }}
      @if($event->location->province), {{ $event->location->province }}@endif
    </p>
    <div class="pt-2 flex justify-end space-x-2">
      <x-secondary-button
        size="sm"
        style="link"
        @click.stop="$dispatch('open-modal','edit-event-{{ $event->id }}')"
      >✏️</x-secondary-button>
      <x-danger-button
        size="sm"
        @click.stop.prevent="$dispatch('open-modal','confirm-delete-event-{{ $event->id }}')"
      >⛌</x-danger-button>
    </div>
  </div>
</div>
