@php $fx = \App\Support\Facetas::desde($__data); @endphp
<div class="flex justify-between space-x-1">
    <div class="flex w-2/12 ">
        <div class="w-full">
            <label class="px-1 text-sm text-gray-600">
                ISBN/Código
            </label>
            <div class="flex">
                <x-buscador wire:model="filtroisbn" faceta="isbn" contexto="pedidos" :filtros="$fx" :tipo="$tipo ?? null" placeholder=""/>
                @if($filtroisbn!='')
                    <x-icon.filter-slash-a wire:click="$set('filtroisbn', '')" class="pb-1" title="reset filter"/>
                @endif
            </div>
        </div>
    </div>
    <div class="flex w-4/12 ">
        <div class="w-full">
            <label class="px-1 text-sm text-gray-600">
                Titulo/Referencia
            </label>
            <div class="flex">
                <x-buscador wire:model="filtroreferencia" faceta="referencia" contexto="pedidos" :filtros="$fx" :tipo="$tipo ?? null" placeholder="Búsqueda Entidad/Factura"/>
                @if($filtroreferencia!='')
                    <x-icon.filter-slash-a wire:click="$set('filtroreferencia', '')" class="pb-1" title="reset filter"/>
                @endif
            </div>
        </div>
    </div>
    <div class="flex w-2/12 ">
        <div class="w-full">
            <label class="px-1 text-sm text-gray-600">
                Cliente
            </label>
            <div class="flex">
                <x-combo faceta="cliente" contexto="pedidos" :tipo="$tipo ?? null" :filtros="$fx" wire:model="filtrocliente" placeholder="-- Todos --"/>
                @if($filtrocliente!='')
                    <x-icon.filter-slash-a wire:click="$set('filtrocliente', '')" class="pb-1" title="reset filter"/>
                @endif
            </div>
        </div>
    </div>
    <div class="flex flex-row-reverse w-2/12 ">
        <div class="mt-3">
            <x-button.button  onclick="location.href = '{{ route('pedido.create') }}'" color="blue"><x-icon.plus/>Nuevo</x-button.button>
        </div>
    </div>
</div>
