<div class="">
    <div class="h-full p-1 mx-2">
        <div class="py-0 ">
            <div class="">
                @include('errores')
            </div>
            <div class="flex-col space-y-1 text-gray-500 border border-blue-300 rounded shadow-md">
                <form wire:submit.prevent="save" class="text-sm">
                    <div class="p-1 m-1 space-y-1">
                        {{-- Datos generales --}}
                        <div class="">
                            <div class="flex p-1 rounded-md bg-blue-50">
                                <h3 class="pl-1 font-semibold">Datos generales</h3>
                                <input  wire:model.defer="compraid" type="hidden"/>
                            </div>
                            <div class="flex flex-col mx-2 space-y-1 md:space-y-0 md:flex-row md:space-x-2">
                                {{-- fecha --}}
                                <div class="w-full form-item">
                                    <div class="flex py-2">
                                        <x-jet-label for="fecha">{{ __('Fecha compra') }}</x-jet-label>
                                    </div>
                                    <input  wire:model.lazy="fecha" type="date" class="w-full py-1 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"/>
                                </div>
                                {{-- producto ISBN --}}
                                <div class="w-full form-item">
                                    <div class="flex py-2">
                                        <x-jet-label class="h-5 px-2">{{ __('Producto Id') }}</x-jet-label>
                                        <input type="search" wire:model="filtroisbn" class="w-full h-5 px-2 py-1 text-sm border border-blue-100 rounded-lg" autofocus/>
                                        @if($filtroisbn!='')
                                        <x-icon.filter-slash-a wire:click="$set('filtroisbn', '')" class="pb-1" title="reset filter"/>
                                        @endif
                                    </div>
                                    <select wire:model.lazy="productoid"
                                        class="w-full py-1 text-xs text-gray-600 border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                        >
                                        <option value=''>-- Selecciona --</option>
                                        @foreach ($productos as $producto)
                                            <option value="{{ $producto->id }}" >{{ $producto->isbn }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- producto ref --}}
                                <div class="w-full form-item">
                                    <div class="flex py-2">
                                        <x-jet-label class="h-5 px-2">{{ __('Producto Ref.') }}</x-jet-label>
                                        <input type="search" wire:model="filtroreferencia" class="w-full h-5 px-2 py-1 text-sm border border-blue-100 rounded-lg" autofocus/>
                                        @if($filtroreferencia!='')
                                        <x-icon.filter-slash-a wire:click="$set('filtroreferencia', '')" class="pb-1" title="reset filter"/>
                                        @endif
                                    </div>
                                    <select wire:model.lazy="productoid"
                                        class="w-full py-1 text-xs text-gray-600 border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                        >
                                        <option value="">-- Selecciona Referencia --</option>
                                        @foreach ($productos as $producto)
                                        <option value="{{ $producto->id }}">{{ $producto->referencia }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        {{-- Detalle compra --}}
                        <div class="space-y-1">
                            <div class="p-1 rounded-md bg-blue-50">
                                <h3 class="pl-1 font-semibold">Detalle</h3>
                                <input  wire:model.defer="compraid" type="hidden"/>
                            </div>
                            <div class="flex flex-col mx-2 space-y-1 md:space-y-0 md:flex-row md:space-x-2">
                                {{-- Proveedor --}}
                                <div class="w-full form-item">
                                    <x-jet-label for="proveedor_id">{{ __('Proveedor') }}</x-jet-label>
                                    <select wire:model.lazy="proveedor_id"
                                        class="w-full py-1 text-xs text-gray-600 border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                        >
                                        <option value="">-- Selecciona proveedor --</option>
                                        @foreach ($proveedores as $proveedor)
                                        <option value="{{ $proveedor->id }}">{{ $proveedor->entidad }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                {{-- Cantidad --}}
                                <div class="w-full form-item">
                                    <div class="w-full form-item">
                                        <x-jet-label for="cantidad">{{ __('cantidad') }}</x-jet-label>
                                        <input  wire:model.lazy="cantidad" type="text" class="w-full py-1 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                        />
                                    </div>
                                </div>
                                {{-- Precio ud --}}
                                <div class="w-full form-item">
                                    <div class="w-full form-item">
                                        <x-jet-label for="precio">{{ __('Precio') }}</x-jet-label>
                                        <input  wire:model.lazy="precio" type="number" step="any" class="w-full py-1 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                        />
                                    </div>
                                </div>
                                {{-- ud_precio --}}
                                <div class="w-full form-item">
                                    <div class="w-full form-item">
                                        <x-jet-label for="ud_precio">{{ __('Ud.') }}</x-jet-label>
                                        <select wire:model.lazy="ud_precio"
                                        class="w-full py-1 text-xs text-gray-600 border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                            <option value="1">Ud.</option>
                                            <option value="2">Kg</option>
                                        </select>
                                    </div>
                                </div>
                                {{-- Precio tot --}}
                                <div class="w-full form-item">
                                    <div class="w-full form-item">
                                        <x-jet-label for="total">{{ __('Precio Total') }}</x-jet-label>
                                        <input  wire:model.lazy="total"  type="number" step="any" class="w-full py-1 text-xs border-gray-300 rounded-md shadow-sm bg-blue-50 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                        disabled/>
                                    </div>
                                </div>
                                <div class="w-7/12 mx-auto text-center">
                                    <x-jet-label for="observacionesexterno">{{ __('Obs.Ext') }}</x-jet-label>
                                    <textarea wire:model.lazy="observacionesexterno" rows="3"
                                        class="w-full py-1 mx-auto text-xs text-blue-600 border-blue-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"></textarea>
                                </div>
                        </div>
                    </div>
                    <div class="p-1 m-1 ">
                        <div class="flex flex-col mx-2 space-y-1 md:space-y-0 md:flex-row md:space-x-2">
                            <x-jet-button class="bg-blue-600">{{ __('Guardar') }}</x-jet-button>
                            <x-jet-secondary-button  onclick="location.href = '{{route('compra.tipo',[$tipo,'e'])}}'">{{ __('Volver') }}</x-jet-secondary-button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

