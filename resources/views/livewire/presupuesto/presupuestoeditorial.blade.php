<div class="">
    <div class="h-full p-1 mx-2">
        <div class="py-0 space-y-2">
            <div class="">
                @include('errores')
            </div>
            <div class="">
                    {{-- @include('presupuestos.presupuestoeditorialfilters') --}}
            </div>
            {{-- datos del presupuesto --}}
            <div class="flex-col space-y-1 text-gray-500 border border-blue-300 rounded shadow-md">
                <form wire:submit.prevent="save" class="text-sm">
                    <div class="p-2 m-2 space-y-2">
                        <div class="p-1 rounded-md bg-blue-50">
                            <h3 class="pl-1 font-semibold">Datos generales</h3>
                            <input  wire:model.defer="presupuestoid" type="hidden"/>
                        </div>
                        <div class="flex flex-col mx-2 space-y-1 md:space-y-0 md:flex-row md:space-x-2">
                            <div class="w-full form-item">
                                <div class="w-full form-item">
                                    <x-jet-label for="cliente_id">{{ __('Cliente') }}</x-jet-label>
                                    <x-selectcolor wire:model.lazy="cliente_id" selectname="cliente_id" class="w-full" >
                                        <option value="">-- Selecciona cliente --</option>
                                        @foreach ($clientes as $cliente)
                                        <option value="{{ $cliente->id }}">{{ $cliente->entidad }}</option>
                                        @endforeach
                                    </x-selectcolor>
                                </div>
                            </div>
                            <div class="w-full form-item">
                                <div class="w-full form-item">
                                    <x-jet-label for="contacto_id">{{ __('Contacto') }}</x-jet-label>
                                    <x-selectcolor wire:model.lazy="contacto_id" selectname="contacto_id" class="w-full" >
                                        @if (isset($contactos))
                                            @if(!$contacto_id) <option value="">-- Selecciona contacto --</option> @endif
                                            @foreach ($contactos as $contacto)
                                            <option value="{{ $contacto->contacto_id }}" {{ $contacto->contacto_id == $this->contacto_id ? "selected" : ""}}>{{ $contacto->entidadcontacto->entidad }}</option>
                                            @endforeach
                                        @else
                                            <option value="">-- Selecciona primero un cliente --</option>
                                        @endif
                                    </x-selectcolor>
                                </div>
                            </div>
                            <div class="w-full form-item">
                                <div class="w-full form-item">
                                    <x-jet-label >{{ __('ISBN/Cód.') }}</x-jet-label>
                                    <x-selectcolor wire:model.lazy="productoeditorialid" selectname="productoeditorialid" class="w-full" >
                                        <option value=''>-- Selecciona ISBN --</option>
                                        @foreach ($productos as $producto)
                                        <option value="{{ $producto->id }}">{{ $producto->isbn .' - '. $producto->referencia}}</option>
                                        @endforeach
                                    </x-selectcolor>
                                </div>
                            </div>
                            <div class="w-full form-item">
                                <div class="w-full form-item">
                                    <x-jet-label >{{ __('Título/Ref.') }}</x-jet-label>
                                    <x-selectcolor wire:model.lazy="productoeditorialid" selectname="productoeditorialid" class="w-full" >
                                        <option value="">-- Selecciona Referencia --</option>
                                        @foreach ($productos as $producto)
                                        <option value="{{ $producto->id }}">{{ $producto->referencia .' - '. $producto->isbn}}</option>
                                        @endforeach
                                    </x-selectcolor>
                                </div>
                            </div>
                            <div class="w-full form-item">
                                <div class="w-full form-item">
                                    <x-jet-label for="proveedor_id">{{ __('Proveedor') }}</x-jet-label>
                                    <x-selectcolor wire:model.lazy="proveedor_id" selectname="proveedor_id" class="w-full" >
                                        <option value="">-- Selecciona proveedor --</option>
                                        @foreach ($proveedores as $proveedor)
                                        <option value="{{ $proveedor->id }}">{{ $proveedor->entidad }}</option>
                                        @endforeach
                                    </x-selectcolor>
                                </div>
                            </div>
                            <div class="w-full form-item">
                                <div class="w-full form-item">
                                    <x-jet-label for="responsable">{{ __('Responsable') }}</x-jet-label>
                                    <x-selectcolor wire:model.lazy="responsable" selectname="responsable" class="w-full" >
                                        <option value="">-- Selecciona el responsable --</option>
                                        <option value="Josep Maria">Josep Maria</option>
                                        <option value="Marta">Marta</option>
                                        <option value="Anna">Anna</option>
                                    </x-selectcolor>
                               </div>
                            </div>
                        </div>
                        <div class="flex flex-col mx-2 space-y-1 md:space-y-0 md:flex-row md:space-x-2">
                            <div class="w-full form-item">
                                <div class="w-full form-item">
                                    <x-jet-label for="fechapresupuesto">{{ __('Fecha presupuesto') }}</x-jet-label>
                                    <input  wire:model.lazy="fechapresupuesto" type="date" class="w-full py-1 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"/>
                                </div>
                            </div>
                            <div class="w-full form-item">
                                <div class="w-full form-item">
                                    <x-jet-label for="tirada">{{ __('Tirada') }}</x-jet-label>
                                    <input  wire:model.lazy="tirada" type="number" class="w-full py-1 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"/>
                                </div>
                            </div>
                            <div class="w-full form-item">
                                <div class="w-full form-item">
                                    <x-jet-label for="precio_ud">{{ __('Precio Ud.') }}</x-jet-label>
                                    <input  wire:model.lazy="precio_ud" type="number" step="any" class="w-full py-1 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"/>
                               </div>
                            </div>
                            <div class="w-full form-item">
                                <div class="w-full form-item">
                                    <x-jet-label for="preciototal">{{ __('Precio Total') }}</x-jet-label>
                                    <input  wire:model.lazy="preciototal"  type="number" step="any" class="w-full py-1 text-xs border-gray-300 rounded-md shadow-sm bg-blue-50 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                    disabled/>
                                </div>
                            </div>
                            <div class="w-full form-item">
                                <div class="w-full form-item">
                                    <x-jet-label for="facturadopor">{{ __('Factura') }}</x-jet-label>
                                    <x-selectcolor wire:model.lazy="facturadopor" selectname="facturadopor" class="w-full" >
                                        <option value="">- ¿Quién factura? -</option>
                                        <option value="1">Milimetrica</option>
                                        <option value="0">Proveedor</option>
                                    </x-selectcolor>
                                </div>
                            </div>
                            <div class="w-full form-item">
                                <div class="w-full form-item">
                                    <x-jet-label for="uds_caja">{{ __('Uds x Caja') }}</x-jet-label>
                                    <input  wire:model.lazy="uds_caja" type="number" class="w-full py-1 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"/>
                                </div>
                            </div>
                            <div class="w-full form-item">
                                <div class="w-full mx-auto">
                                    <x-jet-label for="estado">{{ __('Estado') }}</x-jet-label>
                                    <x-selectcolor wire:model.lazy="estado" selectname="estado" class="w-full" >
                                        <option value="0">{{ __('En curso') }}</option>
                                        <option value="1">{{ __('Finalizado') }}</option>
                                        <option value="2">{{ __('Cancelado') }}</option>
                                    </x-selectcolor>
                                </div>
                            </div>
                            <div class="w-full text-center form-item">
                                <div class="w-full form-item">
                                    <x-jet-label for="espedido">{{ __('Es Pedido') }}</x-jet-label>
                                    <input type="checkbox" wire:model.lazy="espedido"  class="" />
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-col mx-2 space-y-1 md:space-y-0 md:flex-row md:space-x-2">
                            <div class="w-full form-item">
                                <x-jet-label for="otros">{{ __('Otros') }}</x-jet-label>
                                <textarea wire:model.defer="otros" class="w-full text-xs border-gray-300 rounded-md" rows="2">{{ old('observaciones') }} </textarea>
                                <input-error for="otros" class="w-full text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" />
                            </div>
                        </div>
                    </div>
                    <div class="p-2 m-2 ">
                        <div class="flex flex-col mx-2 space-y-1 md:space-y-0 md:flex-row md:space-x-2">
                            <x-jet-button class="bg-blue-600">{{ __('Guardar') }}</x-jet-button>
                            <x-jet-secondary-button  onclick="location.href = '{{route('presupuesto.tipo',[$tipo,$ruta])}}'">{{ __('Volver') }}</x-jet-secondary-button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

