<div class="flex space-x-2 ">
    {{-- Cliente --}}
    <div class="flex ">
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

    {{-- Referencia --}}
    {{-- <div class="flex w-4/12 ">
        <div class="w-full">
            <label class="px-1 text-sm text-gray-600">
                Título
            </label>
            <div class="flex">
                <x-buscador wire:model="filtroreferencia" sugerir="referencia" :tipo="$tipo ?? null" placeholder=""/>
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
                <x-buscador wire:model="filtroisbn" sugerir="isbn" :tipo="$tipo ?? null" placeholder=""/>
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
                <x-combo wire:model="filtroproveedor" :options="collect($proveedores)->map(fn($proveedor)=>['id'=>$proveedor->id,'label'=>($proveedor->entidad)])->values()->all()" placeholder="-- Todos --"/>
                @if($filtroproveedor!='')
                    <x-icon.filter-slash-a wire:click="$set('filtroproveedor', '')" class="pb-1" title="reset filter"/>
                @endif
            </div>
        </div>
    </div>
</div>
