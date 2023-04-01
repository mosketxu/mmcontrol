<div class="flex space-x-2 ">
    {{-- Cliente --}}
    <div class="flex ">
        <div class="w-full">
            <label class="px-1 text-sm text-gray-600">
                Cliente
            </label>
            <div class="flex">
                <select wire:model="filtrocliente" class="w-full py-1 text-sm text-gray-600 bg-white border-blue-300 rounded-md shadow-sm appearance-none hover:border-gray-400 focus:outline-none">
                    <option value=""></option>
                    @foreach ($clientes as $cliente)
                    <option value="{{ $cliente->id }}">{{ $cliente->entidad }}</option>
                    @endforeach
                </select>
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
                <input type="text" wire:model="filtroreferencia" class="w-full py-1 text-sm border border-blue-100 rounded-lg" autofocus/>
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
                <input type="text" wire:model="filtroisbn" class="w-full py-1 text-sm border border-blue-100 rounded-lg" autofocus/>
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
                <select wire:model="filtroproveedor" class="w-full py-1 text-sm text-gray-600 bg-white border-blue-300 rounded-md shadow-sm appearance-none hover:border-gray-400 focus:outline-none">
                    <option value=""></option>
                    @foreach ($proveedores as $proveedor)
                    <option value="{{ $proveedor->id }}">{{ $proveedor->entidad }}</option>
                    @endforeach
                </select>
                @if($filtroproveedor!='')
                    <x-icon.filter-slash-a wire:click="$set('filtroproveedor', '')" class="pb-1" title="reset filter"/>
                @endif
            </div>
        </div>
    </div>
</div>
