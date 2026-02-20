<div class="h-full p-2 mx-2">
    @include('errores')

    <div class="flex-col space-y-2 text-gray-500 border border-blue-300 rounded shadow-md">
        <form wire:submit.prevent="save" class="p-2 text-sm">

            {{-- Datos generales --}}
            <div class="space-y-2">
                <div class="flex items-center p-2 space-x-2 rounded-md bg-blue-50">
                    <h3 class="font-semibold">{{ $nuevaCompra ? 'Datos generales de la compra nueva:' : 'Datos generales de la compra:' }}</h3>
                    <input wire:model.defer="compraid" type="number" class="w-20 text-xs border-gray-300 rounded-md bg-gray-50" readonly/>
                    <input wire:model.defer="codigo" type="text" class="text-xs bg-gray-100 border-gray-300 rounded-md w-44" readonly/>
                </div>

                <div class="flex flex-col space-y-2 md:flex-row md:space-x-2 md:space-y-0">
                    {{-- Fecha --}}
                    <div class="flex-1">
                        <x-jet-label for="fecha">{{ __('Fecha compra') }}</x-jet-label>
                        <input wire:model.lazy="fecha" type="date" class="w-full py-1 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"/>
                    </div>
                    {{-- Fecha Entrega--}}
                    <div class="flex-1">
                        <x-jet-label for="fechaentreda">{{ __('Fecha entrega') }}</x-jet-label>
                        <input wire:model.lazy="fechaentrega" type="date" class="w-full py-1 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"/>
                    </div>
                    {{-- Descripcion --}}
                    <div class="flex-1">
                        <x-jet-label for="descripcion">{{ __('Descripción') }}</x-jet-label>
                        <input wire:model.lazy="descripcion" type="text" class="w-full py-1 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"/>
                    </div>

                    {{-- Producto --}}
                    <div class="flex-1">
                        <x-jet-label>{{ __('Producto') }}</x-jet-label>
                        <div class="flex">
                            <input type="search" wire:model="filtroisbn" placeholder="Filtrar por ISBN/Cod.Producto..." class="w-full px-2 py-1 mb-1 text-xs border border-blue-100 rounded-md"/>
                            <input type="search" wire:model="filtroreferencia" placeholder="Filtrar Ref..." class="w-full px-2 py-1 mb-1 text-xs border border-blue-100 rounded-md"/>
                        </div>

                        <select wire:model="productoid" class="w-full py-1 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                wire:change="productoSeleccionado">
                            <option value="">-- Selecciona producto --</option>
                            @foreach($productos as $producto)
                                <option value="{{ $producto->id }}">{{ $producto->isbn }} - {{ $producto->referencia }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Proveedor --}}
                    <div class="flex-1">
                        <x-jet-label for="proveedor_id">{{ __('Proveedor') }}</x-jet-label>
                        <select wire:model.lazy="proveedor_id" class="w-full py-1 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                            <option value="">-- Selecciona proveedor --</option>
                            @foreach ($proveedores as $proveedor)
                                <option value="{{ $proveedor->id }}">{{ $proveedor->entidad }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            {{-- Detalle compra --}}
            <div class="mt-4 space-y-2">
                <div class="p-2 font-semibold rounded-md bg-blue-50">Detalle</div>

                <div class="flex flex-col space-y-2 md:flex-row md:space-x-2 md:space-y-0">
                    {{-- Cantidad --}}
                    <div class="flex-1">
                        <x-jet-label for="cantidad">{{ __('Cantidad') }}</x-jet-label>
                        <input wire:model.lazy="cantidad" type="number" min="1" class="w-full py-1 text-xs border-gray-300 rounded-md shadow-sm"
                               wire:input="calcularTotal"/>
                    </div>

                    {{-- Precio --}}
                    <div class="flex-1">
                        <x-jet-label for="precio">{{ __('Precio Ud.') }}</x-jet-label>
                        <input wire:model.lazy="precio" type="number" step="any" min="0" class="w-full py-1 text-xs border-gray-300 rounded-md shadow-sm"
                               wire:input="calcularTotal"/>
                    </div>

                    {{-- Unidad --}}
                    <div class="flex-1">
                        <x-jet-label for="ud_precio">{{ __('Ud.') }}</x-jet-label>
                        <select wire:model.lazy="ud_precio" class="w-full py-1 text-xs border-gray-300 rounded-md shadow-sm">
                            <option value="1">Ud.</option>
                            <option value="2">Kg</option>
                        </select>
                    </div>

                    {{-- Total --}}
                    <div class="flex-1">
                        <x-jet-label for="total">{{ __('Precio Total') }}</x-jet-label>
                        <input wire:model.lazy="total" type="number" step="any" class="w-full py-1 text-xs border-gray-300 rounded-md shadow-sm bg-blue-50" disabled/>
                    </div>
                </div>

                {{-- Observaciones --}}
                <div class="mt-2">
                    <x-jet-label for="observaciones">{{ __('Observaciones') }}</x-jet-label>
                    <textarea wire:model.lazy="observaciones" rows="3" class="w-full py-1 text-xs text-blue-600 border-blue-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"></textarea>
                </div>
            </div>

            {{-- Botones --}}
            <div class="flex flex-col mt-4 space-y-2 md:flex-row md:space-x-2 md:space-y-0">
                <x-jet-button class="bg-blue-600">{{ __('Guardar') }}</x-jet-button>
                <x-jet-secondary-button onclick="location.href='{{ route('compra.tipo', [$tipo,'e']) }}'">{{ __('Volver') }}</x-jet-secondary-button>
            </div>
        </form>
    </div>
</div>
