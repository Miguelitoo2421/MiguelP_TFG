@props(['events', 'rotationInterval'])

<div
    x-data="{
        currentIndex: 0,
        totalSlides: {{ count($events) }},
        isPaused: false,
        init() {
            if (this.totalSlides <= 1) return;
            setInterval(() => {
                if (!this.isPaused) {
                    this.currentIndex = (this.currentIndex + 1) % this.totalSlides;
                }
            }, {{ $rotationInterval * 1000 / 2 }});
        }
    }"
    class="relative w-full h-[250px] overflow-hidden rounded-lg"
    @mouseenter="isPaused = true"
    @mouseleave="isPaused = false"
>
    {{-- Slides --}}
    @foreach($events as $index => $event)
        <div
            x-show="currentIndex === {{ $index }}"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform translate-x-full"
            x-transition:enter-end="opacity-100 transform translate-x-0"
            x-transition:leave="transition ease-in duration-300"
            x-transition:leave-start="opacity-100 transform translate-x-0"
            x-transition:leave-end="opacity-0 transform -translate-x-full"
            class="absolute inset-0"
        >
            <img
                src="{{ $event->play->image_url }}"
                alt="{{ $event->title }}"
                class="w-full h-full object-cover"
            >
            {{-- Overlay con información --}}
            <div class="absolute bottom-0 left-0 right-0 bg-black bg-opacity-50 text-white p-4">
                <h3 class="font-semibold text-lg truncate">{{ $event->title }}</h3>
                <p class="text-sm">{{ $event->scheduled_at->format('d M Y, H:i') }}</p>
            </div>
        </div>
    @endforeach

    {{-- Controles --}}
    <button 
        @click="currentIndex = (currentIndex - 1 + totalSlides) % totalSlides"
        class="absolute left-2 top-1/2 -translate-y-1/2 bg-black bg-opacity-50 text-white rounded-full p-2"
    >
        ←
    </button>
    <button 
        @click="currentIndex = (currentIndex + 1) % totalSlides"
        class="absolute right-2 top-1/2 -translate-y-1/2 bg-black bg-opacity-50 text-white rounded-full p-2"
    >
        →
    </button>

    {{-- Indicadores --}}
    <div class="absolute bottom-16 left-0 right-0 flex justify-center gap-2">
        @foreach($events as $index => $event)
            <button 
                @click="currentIndex = {{ $index }}"
                class="w-2 h-2 rounded-full transition-colors"
                :class="currentIndex === {{ $index }} ? 'bg-white' : 'bg-white/50'"
            ></button>
        @endforeach
    </div>
</div> 