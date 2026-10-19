<div class="flex justify-between space-x-1">
    <div class="w-10 text-gray-300 mt-7">
        <x-icon.filter/>
    </div>
    <div class="flex w-2/12 ">
        <div class="w-full">
            <label class="px-1 text-sm text-gray-600">
                Cód.Oferta
            </label>
            <div class="flex">
                <x-buscador wire:model="search" sugerir="oferta" :tipo="$tipo ?? null" placeholder=""/>
                @if($search!='')
                    <x-icon.filter-slash-a wire:click="$set('search', '')" class="pb-1" title="reset filter"/>
                @endif
            </div>
        </div>
    </div>
    <div class="flex w-2/12 ">
        <div class="w-full">
            <label class="px-1 text-sm text-gray-600">
                ISBN
            </label>
            <div class="flex">
                <x-buscador wire:model="filtroisbn" sugerir="isbn" :tipo="$tipo ?? null" placeholder="Búsqueda por ISBN"/>
                @if($filtroisbn!='')
                    <x-icon.filter-slash-a wire:click="$set('filtroisbn', '')" class="pb-1" title="reset filter"/>
                @endif
            </div>
        </div>
    </div>
    <div class="flex w-5/12 ">
        <div class="w-full">
            <label class="px-1 text-sm text-gray-600">
                Titulo/Referencia
            </label>
            <div class="flex">
                <x-buscador wire:model="filtroreferencia" sugerir="referencia" :tipo="$tipo ?? null" placeholder="Búsqueda Entidad/Factura"/>
                @if($filtroreferencia!='')
                    <x-icon.filter-slash-a wire:click="$set('filtroreferencia', '')" class="pb-1" title="reset filter"/>
                @endif
            </div>
        </div>
    </div>
    <div class="flex w-4/12 ">
        <div class="w-full">
            <label class="px-1 text-sm text-gray-600">
                Cliente
            </label>
            <div class="flex">
                <x-combo wire:model="filtrocliente" :options="collect($clientes)->map(fn($cliente)=>['id'=>$cliente->id,'label'=>($cliente->entidad)])->values()->all()" placeholder="-- Todos --"/>
                @if($filtrocliente!='')
                    <x-icon.filter-slash-a wire:click="$set('filtrocliente', '')" class="pb-1" title="reset filter"/>
                @endif
            </div>
        </div>
    </div>
</div>
