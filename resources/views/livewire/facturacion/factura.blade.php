<div class="">
    <div class="h-full p-1 mx-2">
        <div class="py-0 space-y-2">
            <div class="">
                @include('errores')
            </div>
            {{-- datos de la factura --}}
            <div class="flex-col text-gray-500 border border-blue-300 rounded shadow-md">
                <form wire:submit.prevent="save" class="text-sm">
                    <div class="p-1 m-1 space-y-1">
                        <div class="flex p-1 rounded-md bg-blue-50">
                            <h3 class="pl-1 font-semibold">Datos de la factura</h3>
                            <input  wire:model.defer="facturaid" type="hidden"/>
                            @if($tipo!='1')
                            <x-select wire:model.defer="tipo" selectname="tipo" class="w-1/12 py-0 ml-2" >
                                <option value="2">Packaging</option>
                                <option value="3">Propios</option>
                            </x-select>
                            @endif
                        </div>
                        <div class="flex flex-col mx-2 space-y-1 md:space-y-0 md:flex-row md:space-x-4">
                            <div class="w-full form-item md:w-1/12 lg:w-1/12">
                                <x-jet-label for="facturaid">{{ __('Nº Factura') }}</x-jet-label>
                                <input  wire:model.lazy="facturaid" type="number" class="w-full px-0 py-1 text-xs text-center border-gray-300 rounded-md shadow-sm bg-blue-50 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                disabled/>
                            </div>
                            <div class="w-full form-item md:w-1/12 lg:w-3/12">
                                <div class="w-full form-item">
                                    <x-jet-label for="cliente_id">{{ __('Cliente') }}</x-jet-label>
                                    @if($bloqueado=='0')
                                    <x-selectcolor wire:model.lazy="cliente_id" selectname="cliente_id" class="w-full py-1" >
                                        <option value="">-- Selecciona cliente --</option>
                                        @foreach ($clientes as $cliente)
                                        <option value="{{ $cliente->id }}">{{ $cliente->entidad }}</option>
                                        @endforeach
                                    </x-selectcolor>
                                    @else
                                        <input  type="text" value="{{ $fac->cliente->entidad ?? '' }}" class="w-full py-1 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                        disabled/>
                                    @endif
                                </div>
                            </div>
                            <div class="w-full form-item md:w-1/12 lg:w-3/12">
                                <div class="w-full form-item">
                                    <x-jet-label for="contacto_id">{{ __('Contacto') }}</x-jet-label>
                                    @if($bloqueado=='0')
                                    <x-selectcolor wire:model.defer="contacto_id" selectname="contacto_id" class="w-full py-1" >
                                        @if (isset($contactos))
                                            <option value="">-- Selecciona un contacto --</option>
                                            @foreach ($contactos as $contacto)
                                            <option value="{{ $contacto->contacto_id }}">{{ $contacto->entidadcontacto->entidad ?? '-' }}</option>
                                            @endforeach
                                        @else
                                            <option value="">-- Selecciona primero un contacto --</option>
                                        @endif
                                    </x-selectcolor>
                                    @else
                                        <input  type="text" value="{{ $fac->contacto->entidad ?? '' }}" class="w-full py-1 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                        disabled/>
                                    @endif
                                </div>
                            </div>
                            <div class="w-full form-item md:w-1/12 lg:w-2/12">
                                <div class="w-full form-item">
                                    <x-jet-label for="pedidocliente">{{ __('Su Pedido') }}</x-jet-label>
                                    @if($bloqueado=='0')
                                    <x-selectcolor wire:model.defer="pedidocliente" selectname="pedidocliente" class="w-full py-1" >
                                        @if (isset($pedidos))
                                            <option value="">-- Selecciona un pedido --</option>
                                            @foreach ($pedidos as $pedido)
                                            <option value="{{ $pedido['pedidocliente'] }}">{{ $pedido['pedidocliente'] }}</option>
                                            @endforeach
                                        @else
                                            <option value="">-- Selecciona primero un cliente --</option>
                                        @endif
                                    </x-selectcolor>
                                    @else
                                    <input  type="text" value="{{ $pedidocliente }}" class="w-full py-1 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                    disabled/>
                                @endif
                                </div>
                            </div>
                            <div class="w-full form-item md:w-1/12 lg:w-1/12">
                                <x-jet-label for="fecha">{{ __('Fecha Factura') }}</x-jet-label>
                                <input  wire:model.lazy="fecha" type="date" class="w-full py-1 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"/
                                {{ $bloqueado!='0' ? 'disabled' :'' }}>
                            </div>
                            <div class="w-full form-item md:w-1/12 lg:w-1/12">
                                <x-jet-label for="fechavencimiento">{{ __('Fecha Vto') }}</x-jet-label>
                                <input  wire:model.lazy="fechavencimiento" type="date" class="w-full py-1 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"/
                                {{ $bloqueado!='0' ? 'disabled' :'' }}>
                            </div>
                            <div class="w-full form-item md:w-1/12 lg:w-1/12">
                                <x-jet-label for="importe" class="mr-6 text-right">{{ __('Subtotal') }}</x-jet-label>
                                <input  wire:model.lazy="importe" type="text"
                                class="w-full py-1 text-xs text-right bg-blue-100 border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                disabled/>
                            </div>
                            <div class="w-full form-item md:w-1/12 lg:w-1/12">
                                <x-jet-label for="iva" class="mr-6 text-right">{{ __('Iva') }}</x-jet-label>
                                <input  wire:model.lazy="iva" type="text"
                                class="w-full py-1 text-xs text-right bg-blue-100 border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                disabled/>
                            </div>
                            <div class="w-full form-item md:w-1/12 lg:w-1/12">
                                <x-jet-label for="total" class="mr-6 text-right">{{ __('Total') }}</x-jet-label>
                                <input  wire:model.lazy="total" type="text"
                                class="w-full py-1 text-xs text-right bg-blue-100 border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                disabled/>
                            </div>
                            <div class="w-full form-item md:w-1/12 lg:w-1/12">
                                <div class="w-full form-item">
                                    <x-jet-label for="estado">{{ __('Estado') }}</x-jet-label>
                                    <x-selectcolor wire:model.lazy="estado" selectname="estado" class="w-full" >
                                        <option value="0" >Sin enviar</option>
                                        <option value="1" >Env. P.cobro</option>
                                        <option value="2" >Cobrada</option>
                                    </x-selectcolor>
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-col mx-2 md:space-y-0 md:flex-row md:space-x-4">
                            <div class="w-full form-item">
                                <x-jet-label for="observaciones">{{ __('Observaciones') }}</x-jet-label>
                                <textarea wire:model.defer="observaciones"
                                class="w-full py-1 text-xs border-gray-300 rounded-md" rows="2" {{ $deshabilitado }}>{{ old('observaciones') }} </textarea>
                                <input-error for="observaciones" class="w-full text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" />
                            </div>
                        </div>
                    </div>
                    <div class="p-0 m-2 ">
                        <div class="flex flex-col mx-2 md:space-y-0 md:flex-row md:space-x-4">
                            <x-jet-button class="bg-blue-600">{{ __('Guardar') }}</x-jet-button>
                            <x-jet-secondary-button  onclick="location.href = '{{route('facturacion.index')}}'">{{ __('Volver') }}</x-jet-secondary-button>
                            @if($bloqueado!='0')
                                <x-icon.lock/>
                                @else
                                <x-icon.lock-open/>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
            <div class="">
                @if($facturaid)
                    @livewire('facturacion.fdetalle',['facturaid'=>$facturaid,'deshabilitado'=>$deshabilitado],key($facturaid.now()))
                @endif
            </div>
        </div>
    </div>
</div>

