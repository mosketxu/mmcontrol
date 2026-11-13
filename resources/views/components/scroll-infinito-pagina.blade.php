{{--
    Final de un listado paginado por el CONTROLADOR (Pedidos, Compras): al entrar en la ventana pide la página siguiente por fetch y añade sus filas a [data-lista-filas]
    (scrollInfinitoPagina() está en layouts/app). Uso: <x-scroll-infinito-pagina :siguiente="$pedidos->appends(request()->except('page'))->nextPageUrl()"/> justo tras el listado.
--}}
@props(['siguiente' => null])
@if($siguiente)
    <div data-scroll-siguiente="{{ $siguiente }}" class="py-3 text-sm text-center text-gray-500" x-data x-init="scrollInfinitoPagina($el)">
        <button type="button" class="underline hover:text-gray-700" onclick="this.parentNode.dispatchEvent(new Event('mm-pedir'))">Cargar más…</button>
    </div>
@endif
