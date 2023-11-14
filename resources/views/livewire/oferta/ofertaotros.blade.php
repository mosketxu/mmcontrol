<div class="">
    <div class="h-full p-1 mx-2">
        <div class="py-0 ">
            <div class="">
                @include('errores')
            </div>
            <div class="">
            </div>
            {{-- datos del oferta --}}
            <div class="flex-col text-gray-500 border border-blue-300 rounded shadow-md">
                <form wire:submit.prevent="save" class="text-sm">
                    <div class="px-2 m-2 ">
                        <div class="flex p-1 rounded-md bg-blue-50">
                            <h3 class="pl-1 font-semibold">Datos Oferta</h3>
                            <input  wire:model.defer="ofertaid" type="hidden"/>
                            @if($tipo!='1')
                            <select wire:model.defer="tipo"
                                class="w-full py-1 text-xs text-gray-600 border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                {{$escliente}} {{$deshabilitado}}>
                                <option value="2">Packaging</option>
                                <option value="3">Propios</option>
                            </select>
                            @endif
                        </div>
                        <div class="flex flex-col mx-2 md:space-y-0 md:flex-row md:space-x-2">
                            <div class="w-full form-item">
                                <div class="w-full form-item">
                                    <x-jet-label >{{ __('Fecha') }}</x-jet-label>
                                    <input  wire:model.lazy="fecha" type="date" class="w-full py-1 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                    {{$escliente}} {{$deshabilitado}}/>
                                </div>
                            </div>
                            <div class="w-full form-item">
                                <div class="w-full form-item">
                                    <x-jet-label >{{ __('Cliente') }}</x-jet-label>
                                    <select wire:model.lazy="cliente_id"
                                        class="w-full py-1 text-xs text-gray-600 border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                        {{$escliente}} {{$deshabilitado}}>
                                        <option value="">-- Selecciona cliente --</option>
                                        @foreach ($clientes as $cliente)
                                        <option value="{{ $cliente->id }}">{{ $cliente->entidad }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="w-full form-item">
                                <div class="w-full form-item">
                                    <x-jet-label >{{ __('Contacto') }}</x-jet-label>
                                    <select wire:model.lazy="contacto_id"
                                        class="w-full py-1 text-xs text-gray-600 border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                        {{$escliente}} {{$deshabilitado}}>
                                        @if (isset($contactos))
                                            <option value="">-- Selecciona contacto --</option>
                                            @foreach ($contactos as $contacto)
                                            <option value="{{ $contacto->contacto_id }}">{{ $contacto->entidadcontacto->entidad ?? '-'}}</option>
                                            @endforeach
                                        @else
                                            <option value="">-- Selecciona primero un cliente --</option>
                                        @endif
                                    </select>
                                </div>
                            </div>

                            <div class="w-full form-item">
                                <div class="w-full form-item">
                                    <x-jet-label >{{ __('Descripción') }}</x-jet-label>
                                    <input  wire:model.lazy="descripcion" type="text" class="w-full py-1 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                    {{$escliente}} {{$deshabilitado}}/>
                                </div>
                            </div>
                            <div class="w-full">
                                <x-jet-label >{{ __('Estado') }}</x-jet-label>
                                <select wire:model.lazy="estado"
                                    class="w-full py-1 text-xs text-gray-600 border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                    {{$escliente}} {{$deshabilitado}}>
                                    <option value="0">En Espera</option>
                                    <option value="1">Aceptada</option>
                                    <option value="2">Rechazada</option>
                                </select>
                            </div>
                        </div>
                        <div class="flex flex-col mx-2 md:space-y-0 md:flex-row md:space-x-2">
                            <div class="w-full form-item">
                                <div class="w-full form-item">
                                    <x-jet-label >{{ __('Manipulación') }}</x-jet-label>
                                    <input  wire:model.lazy="manipulacion" type="text" class="w-full py-1 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                    {{$escliente}} {{$deshabilitado}}/>
                                </div>
                            </div>
                            <div class="w-full form-item">
                                <div class="w-full form-item">
                                    <x-jet-label >{{ __('Material') }}</x-jet-label>
                                    <input  wire:model.lazy="material" type="text" class="w-full py-1 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                    {{$escliente}} {{$deshabilitado}}/>
                                </div>
                            </div>
                            <div class="w-full form-item">
                                <div class="w-full form-item">
                                    <x-jet-label >{{ __('Medidas') }}</x-jet-label>
                                    <input  wire:model.lazy="medidas" type="text" class="w-full py-1 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                    {{$escliente}} {{$deshabilitado}}/>
                                </div>
                            </div>
                            <div class="w-full form-item">
                                <div class="w-full form-item">
                                    <x-jet-label >{{ __('Impresión') }}</x-jet-label>
                                    <input  wire:model.lazy="impresion" type="text" class="w-full py-1 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                    {{$escliente}} {{$deshabilitado}}/>
                                </div>
                            </div>
                            <div class="w-full form-item">
                                <div class="w-full form-item">
                                    <x-jet-label >{{ __('Embalaje') }}</x-jet-label>
                                    <input  wire:model.lazy="embalaje" type="text" class="w-full py-1 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                    {{$escliente}} {{$deshabilitado}}/>
                                </div>
                            </div>
                            <div class="w-full form-item">
                                <div class="w-full form-item">
                                    <x-jet-label >{{ __('Transporte') }}</x-jet-label>
                                    <input  wire:model.lazy="transporte" type="text" class="w-full py-1 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                    {{$escliente}} {{$deshabilitado}}/>
                                </div>
                            </div>
                            <div class="w-full form-item">
                                <div class="w-full form-item">
                                    <x-jet-label >{{ __('Troquel') }}</x-jet-label>
                                    <input  wire:model.lazy="troquel" type="text" class="w-full py-1 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                    {{$escliente}} {{$deshabilitado}}/>
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-col mx-2 md:space-y-0 md:flex-row md:space-x-2">
                            <div class="w-full form-item">
                                <x-jet-label >{{ __('Observaciones') }}</x-jet-label>
                                <textarea wire:model.lazy="observaciones" class="w-full text-xs border-gray-300 rounded-md" rows="1" {{$escliente}} {{$deshabilitado}}>{{ old('observaciones') }} </textarea>
                                <input-error  class="w-full text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" />
                            </div>
                        </div>
                    </div>
                    <div class="px-2 py-0 pb-2 mx-2 ">
                        @if(!Auth::user()->hasRole('Cliente'))
                            <div class="flex flex-col mx-2 mb-2 md:space-y-0 md:flex-row md:space-x-2">
                                <x-jet-button class="bg-blue-600">{{ __('Guardar') }}</x-jet-button>
                                <x-jet-secondary-button  onclick="location.href = '{{route('oferta.tipo',[$tipo,$ruta])}}'">{{ __('Volver') }}</x-jet-secondary-button>
                            </div>
                        @else
                            <div class="flex flex-col mx-2 mb-2 md:space-y-0 md:flex-row md:space-x-2">
                                <x-jet-secondary-button  onclick="location.href = '{{route('cliente.oferta.tipo',[$tipo,$ruta])}}'">{{ __('Volver') }}</x-jet-secondary-button>
                            </div>
                        @endif
                    </div>
                </form>
            </div>
            <div class="">
                @if($ofertaid)
                    <div class="p-1 border rounded-md">
                        Otros
                        @livewire('oferta.oferta-proceso',['ofertaid'=>$ofertaid,'deshabilitado'=>$deshabilitado],key($ofertaid.now()))
                    </div>
                    <div class="p-1 border rounded-md">
                        Productos
                        @livewire('oferta.oferta-producto',['ofertaid'=>$ofertaid,'deshabilitado'=>$deshabilitado],key($ofertaid.now()))
                    </div>
                    @if($tipo=='1')
                    <div class="p-1 border rounded-md">
                        {{-- Opciones --}}
                        @livewire('oferta.oferta-detalles',['ofertaid'=>$ofertaid],key($ofertaid.now()))
                    </div>
                    @endif
                @endif
            </div>
        </div>
    </div>
</div>
