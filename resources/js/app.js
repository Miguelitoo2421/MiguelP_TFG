import './bootstrap';
import Alpine from 'alpinejs';
import intersect from '@alpinejs/intersect';
import simpleParallax from 'simple-parallax-js/vanilla';

Alpine.plugin(intersect);
window.Alpine = Alpine;

// Autocomplete usando la librería global de Google Maps
window.initLocationAutocomplete = ({ inputId, onPlaceSelected }) => {
  const input = document.getElementById(inputId);
  if (!input || !window.google?.maps?.places?.Autocomplete) return;

  const autocomplete = new google.maps.places.Autocomplete(input, {
    types: ['address'],
  });
  autocomplete.setFields(['address_components', 'geometry']);
  autocomplete.addListener('place_changed', () => {
    const place = autocomplete.getPlace();
    onPlaceSelected(place);
  });
};

// Inicializador de preview de mapa
window.initializeMap = ({ lat = 0, lng = 0, marker = true } = {}) => {
  const mapEl = document.getElementById('map');
  if (!mapEl || !window.google?.maps) return;

  const map = new google.maps.Map(mapEl, {
    center: { lat, lng },
    zoom: 14,
  });
  if (marker) new google.maps.Marker({ position: { lat, lng }, map });
};

// Componente Alpine para el formulario de Locations
document.addEventListener('alpine:init', () => {
  Alpine.data('locationForm', () => ({
    init() {
      initLocationAutocomplete({
        inputId: 'address',
        onPlaceSelected(place) {
          place.address_components.forEach(comp => {
            const v = comp.long_name;
            if (comp.types.includes('locality'))
              document.getElementById('city').value = v;
            if (comp.types.includes('administrative_area_level_2'))
              document.getElementById('province').value = v;
            if (comp.types.includes('administrative_area_level_1'))
              document.getElementById('region').value = v;
            if (comp.types.includes('route'))
              document.getElementById('street_name').value = v;
            if (comp.types.includes('street_number'))
              document.getElementById('street_number').value = v;
            if (comp.types.includes('postal_code'))
              document.getElementById('postal_code').value = v;
          });
          const lat = place.geometry.location.lat();
          const lng = place.geometry.location.lng();
          document.getElementById('latitude').value = lat;
          document.getElementById('longitude').value = lng;
          initializeMap({ lat, lng });
        }
      });
    }
  }));
});

Alpine.start();

// Efecto parallax en imágenes
window.addEventListener('load', () => {
  const images = document.querySelectorAll('.parallax');
  if (!images.length) return;
  new simpleParallax(images, {
    orientation: 'up',
    scale: 1.2,
    overflow: true,
    delay: 0.6,
    transition: 'ease-out',
    maxTransition: 50,
  });
});
