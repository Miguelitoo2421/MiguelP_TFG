// resources/js/app.js (o donde tengas tu entrypoint)

import simpleParallax from 'simple-parallax-js';
import './bootstrap';
import Alpine from 'alpinejs';
window.Alpine = Alpine;

// En lugar de DOMContentLoaded:
window.addEventListener('load', () => {
  const images = document.querySelectorAll('.parallax');
  if (images.length) {
    new simpleParallax(images, {
      scale:       1.2,
      delay:       0.2,
      transition:  'cubic-bezier(0,0,0,1)',
      overflow:    true,
    });
  }
});

Alpine.start();
