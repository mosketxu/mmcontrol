<div class="flex justify-between space-x-2 ">
    {{-- Pedido --}}
    <div class="flex w-1/12 ">
        <div class="w-full">
            <label class="px-1 text-sm text-gray-600">
                Pedido
            </label>
            <div class="flex">
                <input type="search" wire:model="search" class="w-full py-1 text-sm border border-blue-100 rounded-lg" autofocus/>
                @if($search!='')
                    <x-icon.filter-slash-a wire:click="$set('search', '')" class="pb-1" title="reset filter"/>
                @endif
            </div>
        </div>
    </div>
    {{-- Referencia --}}
    <div class="flex w-2/12 ">
        <div class="w-full">
            <label class="px-1 text-sm text-gray-600">
                Título
            </label>
            <div class="flex">
                <input type="search" wire:model="filtroreferencia" class="w-full py-1 text-sm border border-blue-100 rounded-lg" autofocus/>
                @if($filtroreferencia!='')
                    <x-icon.filter-slash-a wire:click="$set('filtroreferencia', '')" class="pb-1" title="reset filter"/>
                @endif
            </div>
        </div>
    </div>
    {{-- ISBN --}}
    <div class="flex w-1/12 ">
        <div class="w-full">
            <label class="px-1 text-sm text-gray-600">
                ISBN
            </label>
            <div class="flex">
                <input type="search" wire:model="filtroisbn" class="w-full py-1 text-sm border border-blue-100 rounded-lg" autofocus/>
                @if($filtroisbn!='')
                    <x-icon.filter-slash-a wire:click="$set('filtroisbn', '')" class="pb-1" title="reset filter"/>
                @endif
            </div>
        </div>
    </div>
    <div class="flex w-1/12 ">
        <div class="w-full">
            <label class="px-1 text-sm text-gray-600">
                Rpble.
            </label>
            <div class="flex">
                <select wire:model="filtroresponsable" class="w-full py-1 text-sm text-gray-600 bg-white border-blue-300 rounded-md shadow-sm appearance-none hover:border-gray-400 focus:outline-none">
                    <option value="">Todos</option>
                    @foreach ($responsables as $responsable)
                    <option value="{{ $responsable->responsable }}">{{ $responsable->responsable }}</option>
                    @endforeach
                </select>
                @if($filtroresponsable!='')
                    <x-icon.filter-slash-a wire:click="$set('filtroresponsable', '')" class="pb-1" title="reset filter"/>
                @endif
            </div>
        </div>
    </div>

    <div class="flex w-1/12 ">
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

    <div class="flex w-1/12 ">
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
    <div class="flex w-1/12">
        <div class="w-full">
            <label class="px-1 text-sm text-gray-600">
                Año
            </label>
            <div class="flex">
                <input type="search" wire:model="filtroanyo"
                    class="w-full py-1 text-sm text-gray-600 placeholder-gray-300 bg-white border-blue-300 rounded-md shadow-sm appearance-none hover:border-gray-400 focus:outline-none"
                    placeholder="Año" />
                @if($filtroanyo!='')
                <x-icon.filter-slash-a wire:click="$set('filtroanyo', '')" class="pb-1" title="reset filter" />
                @endif
            </div>
        </div>
    </div>
    <div class="flex w-1/12">
        <div class="w-full">
            <label class="px-1 text-sm text-gray-600">
                Mes
            </label>
            <div class="flex">
                <select wire:model="filtromes"
                    class="w-full py-1 text-sm text-gray-600 bg-white border-blue-300 rounded-md shadow-sm appearance-none hover:border-gray-400 focus:outline-none">
                    <option value="">-- selecciona --</option>
                    @foreach ($meses as $mes )
                    <option value={{ $mes->id}}>{{ $mes->mesmayus }}</option>
                    @endforeach
                </select>
                @if($filtromes!='')
                <x-icon.filter-slash-a wire:click="$set('filtromes', '')" class="pb-1" title="reset filter" />
                @endif
            </div>
        </div>
    </div>
    <div class="flex w-1/12">
        <div class="w-full">
            <label class="px-1 text-sm text-gray-600">
                Estado
            </label>
            <div class="flex">
                <select wire:model="filtroestado"
                    class="w-full py-1 text-sm text-gray-600 bg-white border-blue-300 rounded-md shadow-sm appearance-none hover:border-gray-400 focus:outline-none">
                    <option value="">-- selecciona --</option>
                    <option value="0">En curso</option>
                    <option value="1">Acabado</option>
                    <option value="2">Cancelado</option>
                </select>
                @if($filtroestado!='')
                    <x-icon.filter-slash-a wire:click="$set('filtroestado', '')" class="pb-1" title="reset filter" />
                @endif
            </div>
        </div>
    </div>
    <div class="flex w-1/12">
        <div class="w-full">
            <label class="px-1 text-sm text-gray-600">
                Facturado
            </label>
            <div class="flex">
                <select wire:model="filtrofacturado"
                    class="w-full py-1 text-sm text-gray-600 bg-white border-blue-300 rounded-md shadow-sm appearance-none hover:border-gray-400 focus:outline-none">
                    <option value="">-- selecciona --</option>
                    <option value="0">No</option>
                    <option value="1">Sí</option>
                    <option value="2">Parcial</option>
                </select>
                @if($filtrofacturado!='')
                    <x-icon.filter-slash-a wire:click="$set('filtrofacturado', '')" class="pb-1" title="reset filter" />
                @endif
            </div>
        </div>
    </div>
    <div class="w-5">

        <x-icon.xls-a wire:click="exportSelected" class="mt-3 mr-1 text-green-400 w-7" title="Exportar pedidos"/>
    </div>

</div>
