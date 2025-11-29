import './bootstrap';

import Alpine from 'alpinejs';
import initGlobe from './components/hero-globe.js';

// Make globe initializer available globally
window.initGlobe = initGlobe;

window.Alpine = Alpine;

Alpine.start();
