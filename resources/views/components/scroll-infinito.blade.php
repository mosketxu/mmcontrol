{{--
    Final de un listado con scroll infinito (Livewire): cuando este bloque entra en la ventana pide el siguiente lote (cargarMas del componente).
    El botón «Cargar más» es el plan B si el navegador no avisa. Uso: <x-scroll-infinito :mas="$productos->hasMorePages()" :n="$productos->count()"/> tras la última fila (no se pasa el paginador: Blade lo convertiría en HTML).
--}}
@props(['mas' => false, 'n' => 0])
@if($mas)
    <div wire:key="scroll-infinito-{{ $n }}" class="py-3 text-sm text-center text-gray-500"
         x-data="{ pedido: false }"
         x-init="const el = $el; const pedir = () => { if (pedido) return; pedido = true; const r = el.closest('[wire\\:id]'); if (r && window.livewire) window.livewire.find(r.getAttribute('wire:id')).call('cargarMas'); };
                 if ('IntersectionObserver' in window) { new IntersectionObserver((e) => { if (e[0].isIntersecting) pedir(); }, { rootMargin: '400px' }).observe(el); }">
        <button type="button" class="underline hover:text-gray-700" @click="pedido = false; pedir()">Cargar más…</button>
    </div>
@endif
