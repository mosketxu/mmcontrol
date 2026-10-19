@php $fx = \App\Support\Facetas::desde($__data); @endphp
<div class="flex justify-between space-x-2 ">
    {{-- Pedido --}}
    <div class="flex w-1/12 ">
        <div class="w-full">
            <label class="px-1 text-sm text-gray-600">
                Nº.Presup
            </label>
            <div class="flex">
                <x-buscador wire:model="search" faceta="numero" contexto="presupuestos" :filtros="$fx" :tipo="$tipo ?? null" placeholder=""/>
                @if($search!='')
                    <x-icon.filter-slash-a wire:click="$set('search', '')" class="pb-1" title="reset filter"/>
                @endif
            </div>
        </div>
    </div>
    {{-- Cliente --}}
    <div class="flex w-2/12 ">
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
    <div class="flex w-1/12 ">
        <div class="w-full">
            <label class="px-1 text-sm text-gray-600">
                Idioma
            </label>
            <div class="flex">
                <x-combo faceta="idioma" contexto="presupuestos" :tipo="$tipo ?? null" :filtros="$fx" wire:model="filtroidioma" placeholder="-- Todos --"/>
                @if($filtroidioma!='')
                    <x-icon.filter-slash-a wire:click="$set('filtroidioma', '')" class="pb-1" title="reset filter"/>
                @endif
            </div>
        </div>
    </div>
    {{-- Referencia --}}
    <div class="flex w-2/12 ">
        <div class="w-full">
            <label class="px-1 text-sm text-gray-600">
                Descripción
            </label>
            <div class="flex">
                <x-buscador wire:model="filtroreferencia" faceta="referencia" contexto="presupuestos" :filtros="$fx" :tipo="$tipo ?? null" placeholder=""/>
                @if($filtroreferencia!='')
                    <x-icon.filter-slash-a wire:click="$set('filtroreferencia', '')" class="pb-1" title="reset filter"/>
                @endif
            </div>
        </div>
    </div>

        {{-- ISBN --}}
        <div class="flex w-2/12 ">
            <div class="w-full">
                <label class="px-1 text-sm text-gray-600">
                    Cod./Ref.
                </label>
                <div class="flex">
                    <x-buscador wire:model="filtroisbn" faceta="isbn" contexto="presupuestos" :filtros="$fx" :tipo="$tipo ?? null" placeholder=""/>
                    @if($filtroisbn!='')
                        <x-icon.filter-slash-a wire:click="$set('filtroisbn', '')" class="pb-1" title="reset filter"/>
                    @endif
                </div>
            </div>
        </div>
    {{-- Proveedor  --}}
    {{-- <div class="flex w-2/12 ">
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
    </div> --}}
    {{-- Año --}}
    <div class="flex w-1/12">
        <div class="w-full">
            <label class="px-1 text-sm text-gray-600">
                Año
            </label>
            <div class="flex">
                <x-buscador wire:model="filtroanyo" sugerir="anyos" :tipo="$tipo ?? null" placeholder="Año"/>
                @if($filtroanyo!='')
                <x-icon.filter-slash-a wire:click="$set('filtroanyo', '')" class="pb-1" title="reset filter" />
                @endif
            </div>
        </div>
    </div>
    {{-- Mes --}}
    <div class="flex w-1/12">
        <div class="w-full">
            <label class="px-1 text-sm text-gray-600">
                Mes
            </label>
            <div class="flex">
                <x-combo wire:model="filtromes" :options="collect($meses)->map(fn($mes)=>['id'=>$mes->id,'label'=>($mes->mesmayus)])->values()->all()" placeholder="-- selecciona --"/>
                @if($filtromes!='')
                <x-icon.filter-slash-a wire:click="$set('filtromes', '')" class="pb-1" title="reset filter" />
                @endif
            </div>
        </div>
    </div>
    {{-- Estado --}}
    <div class="flex w-1/12">
        <div class="w-full">
            <label class="px-1 text-sm text-gray-600">
                Estado
            </label>
            <div class="flex">
                <x-combo wire:model="filtroestado" :options="[['id'=>'0','label'=>'Enviado'],['id'=>'1','label'=>'Aceptado'],['id'=>'2','label'=>'Rechazado']]" placeholder="-- selecciona --"/>
                @if($filtroestado!='')
                    <x-icon.filter-slash-a wire:click="$set('filtroestado', '')" class="pb-1" title="reset filter" />
                @endif
            </div>
        </div>
    </div>
    <div class="flex w-1/12">
        <div class="w-full">
            <label class="px-1 text-sm text-gray-600">
                Ok Externo
            </label>
            <div class="flex">
                <x-combo wire:model="filtrookexterno" :options="[['id'=>'1','label'=>'Ok Externo']]" placeholder="-- selecciona --"/>
                @if($filtrookexterno!='')
                    <x-icon.filter-slash-a wire:click="$set('filtrookexterno', '')" class="pb-1" title="reset filter" />
                @endif
            </div>
        </div>
    </div>

    {{-- <div class="flex flex-row-reverse w-2/12"> --}}
        {{-- <div class="inline-flex mt-3 space-x-2">
            <x-dropdown label="Actions">
                <x-dropdown.item type="button" wire:click="exportSelected" class="flex items-center space-x-2">
                    <x-icon.csv class="text-green-400"></x-icon.csv><span>Export </span>
                </x-dropdown.item>
                <x-dropdown.item type="button" wire:click="$toggle('showDeleteModal')"
                    class="flex items-center space-x-2">
                    <x-icon.trash class="text-red-400"></x-icon.trash> <span>Delete </span>
                </x-dropdown.item>
            </x-dropdown>
        </div> --}}
    {{-- </div> --}}
</div>
