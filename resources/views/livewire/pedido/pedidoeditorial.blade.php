<div class="">
    <div class="h-full p-1 mx-2">
        <div class="py-0 space-y-2">
            <div class="">
                @include('errores')
            </div>
            <div class="">
                {{-- @include('pedidos.pedidoeditorialfilters') --}}
            </div>
            {{-- datos del pedido --}}
            <div class="flex-col space-y-4 text-gray-500 border border-blue-300 rounded shadow-md">
                <form wire:submit.prevent="save" class="text-sm">
                    <div class="p-2 m-2 space-y-2">
                        <div class="p-1 rounded-md bg-blue-50">
                            <h3 class="pl-1 font-semibold">Datos generales</h3>
                            <input  wire:model.defer="pedidoid" type="hidden"/>
                        </div>
                        <div class="flex flex-col mx-2 space-y-4 md:space-y-0 md:flex-row md:space-x-4">
                            <div class="w-full form-item">
                                <div class="w-full form-item">
                                    <x-jet-label for="cliente_id">{{ __('Cliente') }}</x-jet-label>
                                    <x-select wire:model.lazy="cliente_id" selectname="cliente_id" class="w-full" >
                                        <option value="">-- Selecciona cliente --</option>
                                        @foreach ($clientes as $cliente)
                                        <option value="{{ $cliente->id }}">{{ $cliente->entidad }}</option>
                                        @endforeach
                                    </x-select>
                                </div>
                            </div>
                            <div class="w-full form-item">
                                <div class="w-full form-item">
                                    <x-jet-label for="contacto_id">{{ __('Contacto') }}</x-jet-label>
                                    <x-select wire:model.lazy="contacto_id" selectname="contacto_id" class="w-full" >
                                        @if (isset($contactos))
                                            @if(!$contacto_id) <option value="">-- Selecciona contacto --</option> @endif
                                            @foreach ($contactos as $contacto)
                                            <option value="{{ $contacto->contacto_id }}" {{ $contacto->contacto_id == $this->contacto_id ? "selected" : ""}}>{{ $contacto->entidadcontacto->entidad }}</option>
                                            @endforeach
                                        @else
                                            <option value="">-- Selecciona primero un cliente --</option>
                                        @endif
                                    </x-select>
                                </div>
                            </div>
                            <div class="w-full form-item">
                                <div class="w-full form-item">
                                    <x-jet-label for="oferta_id">{{ __('Oferta') }}</x-jet-label>
                                    <x-select wire:model.lazy="oferta_id" selectname="oferta_id" class="w-full" >
                                        @if (isset($ofertas))
                                            <option value="">-- Selecciona la oferta aceptada --</option>
                                            @foreach ($ofertas as $oferta)
                                            <option value="{{ $oferta->id }}">{{ $oferta->id }}</option>
                                            @endforeach
                                        @else
                                            <option value="">-- Selecciona primero un cliente --</option>
                                        @endif
                                    </x-select>
                                </div>
                            </div>
                            <div class="w-full form-item">
                                <x-jet-label for="pedidocliente">{{ __('Pedido Cliente') }}</x-jet-label>
                                <input  wire:model.lazy="pedidocliente" type="text" class="w-full py-1.5 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"/>
                            </div>
                            <div class="w-full form-item">
                                <div class="w-full form-item">
                                    <x-jet-label >{{ __('ISBN/Cód.') }}</x-jet-label>
                                    <x-select wire:model.lazy="productoeditorialid" selectname="productoeditorialid" class="w-full" >
                                        <option value=''>-- Selecciona ISBN --</option>
                                        @foreach ($productos as $producto)
                                        <option value="{{ $producto->id }}">{{ $producto->isbn .' - '. $producto->referencia}}</option>
                                        @endforeach
                                    </x-select>
                                </div>
                            </div>
                            <div class="w-full form-item">
                                <div class="w-full form-item">
                                    <x-jet-label >{{ __('Título/Ref.') }}</x-jet-label>
                                    <x-select wire:model.lazy="productoeditorialid" selectname="productoeditorialid" class="w-full" >
                                        <option value="">-- Selecciona Referencia --</option>
                                        @foreach ($productos as $producto)
                                        <option value="{{ $producto->id }}">{{ $producto->referencia .' - '. $producto->isbn}}</option>
                                        @endforeach
                                    </x-select>
                                </div>
                            </div>
                            <div class="w-full form-item">
                                <div class="w-full form-item">
                                    <x-jet-label >{{ __('Proveedor') }}</x-jet-label>
                                    <x-select wire:model.lazy="proveedor_id" selectname="proveedor_id" class="w-full" >
                                        <option value="">-- Selecciona proveedor --</option>
                                        @foreach ($proveedores as $proveedor)
                                        <option value="{{ $proveedor->id }}">{{ $proveedor->entidad }}</option>
                                        @endforeach
                                    </x-select>
                                </div>
                            </div>
                            <div class="w-full form-item">
                                <x-jet-label for="responsable">{{ __('Responsable') }}</x-jet-label>
                                <x-select wire:model.lazy="responsable" selectname="responsable" class="w-full" >
                                    <option value="">-- Selecciona el responsable --</option>
                                    <option value="Josep Maria">Josep Maria</option>
                                    <option value="Marta">Marta</option>
                                    <option value="Anna">Anna</option>
                                </x-select>
                            </div>
                        </div>
                        <div class="flex flex-col mx-2 space-y-4 md:space-y-0 md:flex-row md:space-x-4">
                            <div class="w-full form-item">
                                <x-jet-label for="fechapedido">{{ __('Fecha pedido') }}</x-jet-label>
                                <input  wire:model.lazy="fechapedido" type="date" class="w-full py-1.5 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"/>
                            </div>
                            <div class="w-full form-item">
                                <x-jet-label for="fechaarchivos">{{ __('Fecha archivos') }}</x-jet-label>
                                <input  wire:model.lazy="fechaarchivos" type="date" class="w-full py-1.5 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"/>
                            </div>
                            <div class="w-full form-item">
                                <x-jet-label for="fechaplotter">{{ __('Fecha plotter') }}</x-jet-label>
                                <input  wire:model.lazy="fechaplotter" type="date" class="w-full py-1.5 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"/>
                            </div>
                            <div class="w-full form-item">
                                <x-jet-label for="fechaentrega">{{ __('Fecha entrega') }}</x-jet-label>
                                <input  wire:model.lazy="fechaentrega" type="date" class="w-full py-1.5 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"/>
                            </div>
                            <div class="w-full form-item">
                                <x-jet-label for="muestra">{{ __('Muestra') }}</x-jet-label>
                                <input  wire:model.lazy="muestra" type="text" class="w-full py-1.5 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"/>
                            </div>
                            <div class="w-full form-item">
                                <x-jet-label for="pruebacolor">{{ __('Prueba Color') }}</x-jet-label>
                                <input  wire:model.lazy="pruebacolor" type="text" class="w-full py-1.5 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"/>
                            </div>
                        </div>
                        <div class="flex flex-col mx-2 space-y-4 md:space-y-0 md:flex-row md:space-x-4">
                            <div class="w-full form-item">
                                <x-jet-label for="tiradaprevista">{{ __('Tirada Prevista') }}</x-jet-label>
                                <input  wire:model.lazy="tiradaprevista" type="number" class="w-full py-1.5 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"/>
                            </div>
                            <div class="w-full form-item">
                                <x-jet-label for="tiradareal">{{ __('Tirada Real') }}</x-jet-label>
                                <input  wire:model.lazy="tiradareal" type="number" class="w-full py-1.5 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"/>
                            </div>
                            <div class="w-full form-item">
                                <x-jet-label for="precio">{{ __('€ Precio Venta') }}</x-jet-label>
                                <input  wire:model.lazy="precio"  type="number" step="any" class="w-full py-1.5 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"/>
                            </div>
                            <div class="w-full form-item">
                                <x-jet-label for="preciototal">{{ __('€ Precio total') }}</x-jet-label>
                                <input  wire:model.lazy="preciototal"  type="number" step="any" class="w-full py-1.5 text-xs bg-blue-50 border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                disabled/>
                            </div>
                            <div class="w-full form-item">
                                <div class="w-full form-item">
                                    <x-jet-label for="facturadopor">{{ __('Factura') }}</x-jet-label>
                                    <x-select wire:model.lazy="facturadopor" selectname="facturadopor" class="w-full" >
                                        <option value="">- ¿Quién factura? -</option>
                                        <option value="1">Milimetrica</option>
                                        <option value="0">Proveedor</option>
                                    </x-select>
                                </div>
                            </div>
                        {{-- </div>
                        <div class="flex flex-col mx-2 space-y-4 md:space-y-0 md:flex-row md:space-x-4"> --}}
                            {{-- <div class="w-full form-item">
                                <x-jet-label for="parcial">{{ __('Parcial') }}</x-jet-label>
                                <input  wire:model.lazy="parcial" type="text" class="w-full py-1.5 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"/>
                            </div> --}}
                            <div class="w-full form-item">
                                <div class="w-full form-item">
                                    <x-jet-label for="estado">{{ __('Estado') }}</x-jet-label>
                                    <x-select wire:model.lazy="estado" selectname="estado" class="w-full" >
                                        <option value="0">{{ __('En curso') }}</option>
                                        <option value="1">{{ __('Finalizado') }}</option>
                                        <option value="2">{{ __('Cancelado') }}</option>
                                    </x-select>
                                </div>
                            </div>
                            <div class="w-full form-item">
                                <div class="w-full form-item">
                                    <x-jet-label for="facturado">{{ __('Facturado') }}</x-jet-label>
                                    <x-select wire:model.lazy="facturado" selectname="facturado" class="w-full" >
                                        <option value="0">{{ __('No') }}</option>
                                        <option value="1">{{ __('Sí') }}</option>
                                        <option value="2">{{ __('Parcial') }}</option>
                                    </x-select>
                                </div>
                            </div>
                            <div class="w-full form-item">
                                <div class="w-full mx-auto">
                                    <x-jet-label for="caja_id">{{ __('Caja') }}</x-jet-label>
                                    <select wire:model.lazy="caja_id"
                                        class="w-full py-1.5 text-xs text-gray-600 border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                            <option value="">--Selecciona Caja--</option>
                                            @foreach ($cajas as $caja )
                                                <option value="{{ $caja->id }}">{{ $caja->name }}</option>
                                            @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="w-full form-item">
                                <x-jet-label for="uds_caja">{{ __('Uds x Caja') }}</x-jet-label>
                                <input  wire:model.lazy="uds_caja" type="number" class="w-full py-1.5 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"/>
                            </div>
                        </div>
                        <div class="flex flex-col mx-2 space-y-4 md:space-y-0 md:flex-row md:space-x-4">
                            <div class="w-full form-item">
                                <x-jet-label for="otros">{{ __('Otros') }}</x-jet-label>
                                <textarea wire:model.defer="otros" class="w-full text-xs border-gray-300 rounded-md" rows="2">{{ old('observaciones') }} </textarea>
                                <input-error for="otros" class="w-full text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" />
                            </div>
                        </div>
                    </div>
                    <div class="p-2 m-2 ">
                        <div class="flex flex-col mx-2 space-y-4 md:space-y-0 md:flex-row md:space-x-4">
                            <x-jet-button class="bg-blue-600">{{ __('Guardar') }}</x-jet-button>
                            <x-jet-secondary-button  onclick="location.href = '{{route('pedido.tipo',[$tipo,$ruta])}}'">{{ __('Volver') }}</x-jet-secondary-button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

