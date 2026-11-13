{{--
    Botones de acción de una fila de listado. Si la celda es estrecha (ventana mediana o pequeña) se muestra un solo botón «⋯»
    y al pulsarlo se abre un modal con todas las acciones y su nombre (el atributo title de cada icono).
    Uso: <x-acciones-fila :min="300" titulo="Pedido 2600705"> ...iconos... </x-acciones-fila>
    min = ancho en px que necesitan los iconos en línea; por debajo (ancho de la celda, no de la ventana) pasa al modal.
    Las reglas visuales están en layouts/app.blade.php (clases accfila-*). El slot se pinta dos veces: en línea y en el modal.
--}}
@props(['min' => 140, 'titulo' => 'Acciones'])
<div x-data="{ open: false }" style="width:100%">
    <style>
        @container accfila (max-width: {{ (int) $min }}px) {
            .accfila-m{{ (int) $min }} .accfila-inline { display: none !important; }
            .accfila-m{{ (int) $min }} .accfila-btn { display: inline-flex !important; }
        }
    </style>
    <div class="accfila accfila-m{{ (int) $min }}">
        <div class="accfila-inline">{{ $slot }}</div>
        <button type="button" class="accfila-btn" title="Acciones" @click.stop="open = true">⋯</button>
    </div>
    <div class="accfila-modal" x-show="open" x-cloak @click.self="open = false" @keydown.escape.window="open = false">
        <div class="accfila-panel" @click="open = false">
            <div class="accfila-titulo">
                <span>{{ $titulo }}</span>
                <button type="button" class="accfila-x" @click.stop="open = false" title="Cerrar">✕</button>
            </div>
            <div class="accfila-grid">{{ $slot }}</div>
        </div>
    </div>
</div>
