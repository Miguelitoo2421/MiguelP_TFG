{{-- resources/views/events/index.blade.php --}}
<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('Events') }}
    </h2>
  </x-slot>

  <x-wrapper-views x-data>
    <x-slot name="actions">
      <x-primary-button @click="$dispatch('open-modal','create-event')">
        {{ __('New Event') }}
      </x-primary-button>
    </x-slot>

    {{-- Grid de tarjetas --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
      @foreach($events as $event)
        <x-card-event :event="$event" />
      @endforeach
    </div>

    {{-- Paginación --}}
    <div class="mt-6">
      {{ $events->links() }}
    </div>

    {{-- Modal: Crear Evento --}}
    <x-modal-form
      modal-name="create-event"
      max-width="md"
      action="{{ route('events.store') }}"
      method="POST"
      title="{{ __('New Event') }}"
      submit-text="{{ __('Create') }}"
    >
      <x-input-label for="title" :value="__('Title')" />
      <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" required />

      <x-input-label for="play_id" :value="__('Play')" class="mt-4" />
      <select id="play_id" name="play_id" class="mt-1 block w-full border-gray-300 rounded" required>
        @foreach($plays as $play)
          <option value="{{ $play->id }}">{{ $play->name }}</option>
        @endforeach
      </select>

      <x-input-label for="location_id" :value="__('Location')" class="mt-4" />
      <select id="location_id" name="location_id" class="mt-1 block w-full border-gray-300 rounded" required>
        @foreach($locations as $loc)
          <option value="{{ $loc->id }}">
            {{ $loc->city }}@if($loc->province), {{ $loc->province }}@endif
          </option>
        @endforeach
      </select>

      <x-input-label for="scheduled_at" :value="__('Date & Time')" class="mt-4" />
      <x-text-input id="scheduled_at" name="scheduled_at" type="datetime-local" class="mt-1 block w-full" required />
    </x-modal-form>

    {{-- Modales Editar y Eliminar --}}
    @foreach($events as $event)
      <x-modal-form
        modal-name="edit-event-{{ $event->id }}"
        max-width="md"
        action="{{ route('events.update', $event) }}"
        method="PATCH"
        title="{{ __('Edit Event') }}"
        submit-text="{{ __('Save') }}"
      >
        <x-input-label for="title-{{ $event->id }}" :value="__('Title')" />
        <x-text-input
          id="title-{{ $event->id }}"
          name="title"
          type="text"
          class="mt-1 block w-full"
          :value="old('title', $event->title)"
          required
        />

        <x-input-label for="play_id-{{ $event->id }}" :value="__('Play')" class="mt-4" />
        <select
          id="play_id-{{ $event->id }}"
          name="play_id"
          class="mt-1 block w-full border-gray-300 rounded"
          required
        >
          @foreach($plays as $play)
            <option
              value="{{ $play->id }}"
              {{ $play->id == old('play_id', $event->play_id) ? 'selected' : '' }}
            >{{ $play->name }}</option>
          @endforeach
        </select>

        <x-input-label for="location_id-{{ $event->id }}" :value="__('Location')" class="mt-4" />
        <select
          id="location_id-{{ $event->id }}"
          name="location_id"
          class="mt-1 block w-full border-gray-300 rounded"
          required
        >
          @foreach($locations as $loc)
            <option
              value="{{ $loc->id }}"
              {{ $loc->id == old('location_id', $event->location_id) ? 'selected' : '' }}
            >
              {{ $loc->city }}@if($loc->province), {{ $loc->province }}@endif
            </option>
          @endforeach
        </select>

        <x-input-label for="scheduled_at-{{ $event->id }}" :value="__('Date & Time')" class="mt-4" />
        <x-text-input
          id="scheduled_at-{{ $event->id }}"
          name="scheduled_at"
          type="datetime-local"
          class="mt-1 block w-full"
          :value="old('scheduled_at', $event->scheduled_at->format('Y-m-d\TH:i'))"
          required
        />

      </x-modal-form>

      <x-confirm-delete
        :modal-id="'confirm-delete-event-'.$event->id"
        :name="$event->title"
        :route="route('events.destroy', $event)"
      />
    @endforeach

  </x-wrapper-views>
</x-app-layout>
