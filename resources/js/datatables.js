// resources/js/datatables.js
import $ from 'jquery';
import 'datatables.net-dt';

// Hacer jQuery disponible globalmente
window.$ = window.jQuery = $;

// No configuramos idioma global aquí porque cada tabla define su propio idioma

export default $;
