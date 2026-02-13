<div class="flex justify-between space-x-1">
    <div class="w-10 mt-8 text-gray-300">
        <x-icon.filter/>
    </div>
    <div class="flex w-2/12 ">
        <div class="w-full">
            <label class="px-1 text-sm text-gray-600">
                Cod./Ref.
            </label>
            <div class="flex">
                <input type="text" wire:model.lazy="filtroisbn" class="w-full py-2 text-xs text-gray-600 placeholder-gray-300 bg-white border-blue-300 rounded-md shadow-sm appearance-none hover:border-gray-400 focus:outline-none" autofocus/>
                @if($filtroisbn!='')
                    <x-icon.filter-slash-a wire:click="$set('filtroisbn', '')" class="pb-1" title="reset filter"/>
                @endif
            </div>
        </div>
    </div>
    <div class="flex w-3/12 ">
        <div class="w-full">
            <label class="px-1 text-sm text-gray-600">
                Referencia
            </label>
            <div class="flex">
                <input type="text" wire:model.lazy="filtroreferencia" class="w-full py-2 text-xs text-gray-600 placeholder-gray-300 bg-white border-blue-300 rounded-md shadow-sm appearance-none hover:border-gray-400 focus:outline-none" placeholder="Búsqueda Entidad/Factura" autofocus/>
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
                <select wire:model="filtrocliente" class="w-full py-2 text-xs text-gray-600 bg-white border-blue-300 rounded-md shadow-sm appearance-none hover:border-gray-400 focus:outline-none">
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
        <div class="flex w-1/12 ">
        <div class="w-full">
            <label class="px-1 text-sm text-gray-600">
                Estado
            </label>
            <div class="flex">
                <select wire:model="filtroproductoestado" class="w-full py-2 text-xs text-gray-600 bg-white border-blue-300 rounded-md shadow-sm appearance-none hover:border-gray-400 focus:outline-none">
                    <option value="">-- Seleccionar --</option>
                    @foreach($productosestado as $value => $label)
                        <option value="{{ $value }}"
                        {{ old('estadoproducto', $producto->estadoproducto?->value ?? '') == $value ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($filtroproductoestado!='')
                    <x-icon.filter-slash-a wire:click="$set('filtrocliente', '')" class="pb-1" title="reset filter"/>
                @endif
            </div>
        </div>
    </div>
    <div class="flex w-2/12 ">
        <div class="w-full">
            <label class="px-1 text-sm text-gray-600">
                Material
            </label>
            <div class="flex">
                <input type="text" wire:model.lazy="filtromaterial" class="w-full py-2 text-xs text-gray-600 placeholder-gray-300 bg-white border-blue-300 rounded-md shadow-sm appearance-none hover:border-gray-400 focus:outline-none" placeholder="Búsqueda Entidad/Factura" autofocus/>
                @if($filtromaterial!='')
                    <x-icon.filter-slash-a wire:click="$set('filtromaterial', '')" class="pb-1" title="reset filter"/>
                @endif
            </div>
        </div>
    </div>
    <div class="flex w-2/12 ">
        <div class="w-full">
            <label class="px-1 text-sm text-gray-600">
                Impresión
            </label>
            <div class="flex">
                <input type="text" wire:model.lazy="filtroimpresion" class="w-full py-2 text-xs text-gray-600 placeholder-gray-300 bg-white border-blue-300 rounded-md shadow-sm appearance-none hover:border-gray-400 focus:outline-none" placeholder="Búsqueda Entidad/Factura" autofocus/>
                @if($filtroimpresion!='')
                    <x-icon.filter-slash-a wire:click="$set('filtroimpresion', '')" class="pb-1" title="reset filter"/>
                @endif
            </div>
        </div>
    </div>
    <div class="flex flex-row-reverse w-2/12 ">
        <div class="mt-3">
            <x-button.button  onclick="location.href = '{{ route('producto.nuevo',$tipo) }}'" color="blue" >{{ __('Nuevo') }}</x-button.button>
        </div>
    </div>
</div>
