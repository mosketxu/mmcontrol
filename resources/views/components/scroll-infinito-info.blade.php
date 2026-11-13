{{-- «Mostrando 50 de 2266 resultados» (sustituye al texto y los números de la paginación). En los listados de controlador, scrollInfinitoPagina() actualiza data-n. --}}
@props(['n' => 0, 'total' => 0])
<div class="py-1 text-sm text-gray-500">Mostrando <span data-scroll-n>{{ $n }}</span> de {{ $total }} resultados</div>
