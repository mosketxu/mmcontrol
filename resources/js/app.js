import './bootstrap';

// Livewire 3 empaqueta e inicializa su propio Alpine.js (via @livewireScripts).
// No inicializar Alpine aqui tambien: causaba una segunda instancia de Alpine
// compitiendo con la de Livewire (errores "show is not defined",
// "reading 'entangle'", "reading 'on'" en paginas con componentes Jetstream).
