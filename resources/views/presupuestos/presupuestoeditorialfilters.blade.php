@php $fx = \App\Support\Facetas::desde($__data); @endphp
<div class="flex space-x-2 ">
    {{-- Cliente --}}
    <div class="flex ">
        <div class="w-full">
            <label class="px-1 text-sm text-gray-600">
                Cliente
            </label>
            <div class="flex">
                <x-combo faceta="cliente" contexto="presupuestos" :tipo="$tipo ?? null" :filtros="$fx" wire:model="filtrocliente" placeholder="-- Todos --"/>
                @if($filtrocliente!='')
                    <x-icon.filter-slash-a wire:click="$set('filtrocliente', '')" class="pb-1" title="reset filter"/>
                @endif
            </div>
        </div>
    </div>

    {{-- Referencia --}}
    {{-- <div class="flex w-4/12 ">
        <div class="w-full">
            <label class="px-1 text-sm text-gray-600">
                Título
            </label>
            <div class="flex">
                <x-buscador wire:model="filtroreferencia" faceta="referencia" contexto="presupuestos" :filtros="$fx" :tipo="$tipo ?? null" placeholder=""/>
                @if($filtroreferencia!='')
                    <x-icon.filter-slash-a wire:click="$set('filtroreferencia', '')" class="pb-1" title="reset filter"/>
                @endif
            </div>
        </div>
    </div> --}}
    {{-- ISBN --}}
    {{-- <div class="flex w-2/12 ">
        <div class="w-full">
            <label class="px-1 text-sm text-gray-600">
                ISBN
            </label>
            <div class="flex">
                <x-buscador wire:model="filtroisbn" faceta="isbn" contexto="presupuestos" :filtros="$fx" :tipo="$tipo ?? null" placeholder=""/>
                @if($filtroisbn!='')
                    <x-icon.filter-slash-a wire:click="$set('filtroisbn', '')" class="pb-1" title="reset filter"/>
                @endif
            </div>
        </div>
    </div> --}}
    {{-- Proveedor  --}}
    <div class="flex ">
        <div class="w-full">
            <label class="px-1 text-sm text-gray-600">
                Proveedor
            </label>
            <div class="flex">
                <x-combo faceta="proveedor" contexto="presupuestos" :tipo="$tipo ?? null" :filtros="$fx" wire:model="filtroproveedor" placeholder="-- Todos --"/>
                @if($filtroproveedor!='')
                    <x-icon.filter-slash-a wire:click="$set('filtroproveedor', '')" class="pb-1" title="reset filter"/>
                @endif
            </div>
        </div>
    </div>
</div>
