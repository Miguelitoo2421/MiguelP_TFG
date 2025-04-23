import './bootstrap';
import Alpine from 'alpinejs';
import SimpleParallax from 'simple-parallax-js';

window.Alpine = Alpine;

window.addEventListener('load', () => {
  const images = document.querySelectorAll('.parallax');
  new SimpleParallax(images, {
    orientation: 'up',
    scale:       1.2,
    overflow:    true,
    delay:       0.6,
    transition:  'ease-out',
    maxTransition: 50,
  });
});

Alpine.start();
