// resources/js/app.js
import './bootstrap';
import Alpine from 'alpinejs';
import intersect from '@alpinejs/intersect';
import simpleParallax from 'simple-parallax-js/vanilla';

Alpine.plugin(intersect);

window.Alpine = Alpine;

window.addEventListener('load', () => {
  const images = document.querySelectorAll('.parallax');
  // Usa el mismo identificador en minúscula
  new simpleParallax(images, {
    orientation:   'up',
    scale:         1.2,
    overflow:      true,
    delay:         0.6,
    transition:    'ease-out',
    maxTransition: 50,
  });
});

Alpine.start();
