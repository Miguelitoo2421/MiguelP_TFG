@props(['event','actors'])

{{-- Modal emergente con detalle y asignación de actores --}}
<div
  {{ $attributes->merge([ 
      'class' => 'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50',
      'x-data' => "{ actors: " . json_encode($actors) . ", casts: {} }"
  ]) }}
>
  <div class="bg-white rounded-lg shadow-xl w-11/12 md:w-2/3 lg:w-1/2 p-6 max-h-[90vh] overflow-auto">
    {{-- Cabecera con detalles básicos --}}
    <h2 class="text-2xl font-bold mb-2">{{ $event->title }}</h2>
    <p class="text-gray-600 mb-4">
      Obra: {{ $event->play->name }}<br>
      Fecha: {{ $event->scheduled_at->format('d M Y, H:i') }}<br>
      Lugar: {{ $event->location->city }}@if($event->location->province), {{ $event->location->province }}@endif
    </p>

    {{-- Sección de personajes con buscador de actores --}}
    <div class="mt-6 space-y-6">
      @foreach($event->play->characters as $character)
        <div 
          x-data="{
            query: '',
            selected: null,
            suggestions: [],
            mastery: 1,
            notes: ''
          }"
          x-init="
            // Si ya existe asignación, cargar valores iniciales
            if (casts[{{ $character->id }}]) {
              const c = casts[{{ $character->id }}];
              selected = actors.find(a => a.id === c.actor_id) || null;
              query = selected?.name || '';
              mastery = c.mastery_level;
              notes = c.notes;
            }
          "
          @input.debounce.300ms="
            if (query.length < 2) { suggestions = []; return; }
            suggestions = actors.filter(a => a.name.toLowerCase().includes(query.toLowerCase()));
          "
          class="border p-4 rounded"
        >
          <p class="font-semibold mb-2">{{ $character->name }}</p>

          {{-- Input de búsqueda --}}
          <input
            type="text"
            x-model="query"
            placeholder="Buscar actor…"
            class="mt-1 block w-full border rounded p-2"
          />
          <ul x-show="suggestions.length" class="border bg-white mt-1 max-h-32 overflow-auto">
            <template x-for="a in suggestions" :key="a.id">
              <li
                @click="
                  selected = a;
                  query = a.name;
                  suggestions = [];
                  casts[{{ $character->id }}] = {
                    actor_id: a.id,
                    mastery_level: mastery,
                    notes: notes
                  };
                "
                class="px-3 py-1 hover:bg-gray-100 cursor-pointer"
                x-text="a.name"
              ></li>
            </template>
          </ul>

          {{-- Mastery & notes --}}
          <div class="mt-4 flex space-x-2">
            <input
              type="number" min="1" max="5"
              x-model="mastery"
              @input="
                if (!casts[{{ $character->id }}]) casts[{{ $character->id }}] = {};
                casts[{{ $character->id }}].mastery_level = mastery;
              "
              class="w-16 border rounded p-2"
            />
            <input
              type="text"
              x-model="notes"
              placeholder="Notas"
              @input="
                if (!casts[{{ $character->id }}]) casts[{{ $character->id }}] = {};
                casts[{{ $character->id }}].notes = notes;
              "
              class="flex-1 border rounded p-2"
            />
          </div>
        </div>
      @endforeach
    </div>

    {{-- Botones de acción --}}
    <div class="mt-6 flex justify-end space-x-2">
      {{-- Guardar asignaciones --}}
      <button
        type="button"
        class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700"
        @click="
          fetch(`{{ url('/events/'.$event->id.'/casts') }}`, {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ casts })
          }).then(r => r.json()).then(() => location.reload());
        "
      >Guardar</button>

      {{-- Cerrar modal --}}
      <button
        type="button"
        class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300"
        @click="openId = null"
      >Cerrar</button>
    </div>
  </div>
</div>
