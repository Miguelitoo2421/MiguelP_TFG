@props(['event','actors'])

@php
    $initialCasts = [];
    foreach ($event->play->characters as $character) {
        $ac = $event->actorCharacters->firstWhere('character_id', $character->id);
        $initialCasts[$character->id] = [
            'actor_id'    => $ac->actor_id ?? null,
            'notes'       => $ac->notes ?? '',
            'suggestions' => [],
        ];
    }
@endphp

<div
  {{ $attributes->merge([ 
      'class' => 'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50'
  ]) }}
  x-data="{
    actors: {{ Illuminate\Support\Js::from($actors) }},
    casts: {{ Illuminate\Support\Js::from($initialCasts) }},
    searchQueries: {},
    getSuggestions(rawQuery) {
      const query = (rawQuery || '').trim().toLowerCase();
      if (query.length < 2) return [];
      return this.actors.filter(actor => {
        const fullName = (`${actor.first_name} ${actor.last_name}`).trim().toLowerCase();
        return fullName.includes(query);
      });
    }
  }"
>
  <div class="bg-white rounded-lg shadow-xl w-11/12 md:w-2/3 lg:w-1/2 p-6 max-h-[90vh] overflow-auto">
    <h2 class="text-2xl font-bold mb-2">{{ $event->title }}</h2>
    <p class="text-gray-600 mb-4">
      Obra: {{ $event->play->name }}<br>
      Fecha: {{ $event->scheduled_at->format('d M Y, H:i') }}<br>
      Lugar: {{ $event->location->city }}@if($event->location->province), {{ $event->location->province }}@endif
    </p>

    <div class="mt-6 space-y-6">
      @foreach($event->play->characters as $character)
        <div class="border p-4 rounded">
          <p class="font-semibold mb-2">{{ $character->name }}</p>

          {{-- Buscador autocompletado --}}
          <input
            type="text"
            x-model="searchQueries[{{ $character->id }}]"
            placeholder="Buscar actor…"
            class="mt-1 block w-full border rounded p-2"
            @input.debounce.300ms="
              casts[{{ $character->id }}].suggestions =
                getSuggestions(searchQueries[{{ $character->id }}]);
            "
          />
          <ul
            x-show="casts[{{ $character->id }}].suggestions.length"
            class="border bg-white mt-1 max-h-32 overflow-auto"
          >
            <template x-for="actor in casts[{{ $character->id }}].suggestions" :key="actor.id">
              <li
                @click.prevent="
                  casts[{{ $character->id }}].actor_id = actor.id;
                  casts[{{ $character->id }}].suggestions = [];
                  searchQueries[{{ $character->id }}] = '';
                "
                class="px-3 py-1 hover:bg-gray-100 cursor-pointer"
                x-text="`${actor.first_name} ${actor.last_name}`"
              ></li>
            </template>
          </ul>

          {{-- Notas --}}
          <div class="mt-4">
            <input
              type="text"
              x-model="casts[{{ $character->id }}].notes"
              placeholder="Notas"
              class="w-full border rounded p-2"
            />
          </div>

          {{-- Mostrar actor seleccionado separado --}}
          <template x-if="casts[{{ $character->id }}].actor_id">
            <p class="mt-2 text-sm text-gray-700">
              selected actor: 
              <span x-text="(() => {
                const a = actors.find(x => x.id === casts[{{ $character->id }}].actor_id);
                return a ? `${a.first_name} ${a.last_name}` : '';
              })()"></span>
            </p>
          </template>
        </div>
      @endforeach
    </div>

    <div class="mt-6 flex justify-end space-x-2">
      <button
        type="button"
        class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700"
        @click.prevent="
          fetch('{{ route("events.casts.store", $event) }}', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ casts })
          }).then(res => {
            if (res.ok) location.reload();
          });
        "
      >Guardar</button>
      <button
        type="button"
        class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300"
        @click="openId = null"
      >Cerrar</button>
    </div>
  </div>
</div>
