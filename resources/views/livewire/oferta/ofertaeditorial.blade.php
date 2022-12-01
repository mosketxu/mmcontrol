<div class="">
    <div class="h-full p-1 mx-2">
        <div class="py-0 ">
            <div class="">
                @include('errores')
            </div>
            <div class="">
                {{-- @if($tipo=='1')
                    @include('oferta.ofertaeditorialfilters')
                @else
                    @include('oferta.ofertaotrosfilters')
                @endif --}}
            </div>
            {{-- datos del pedido --}}
            {{-- <div class="h-screen"> --}}
            <div class="flex-col text-gray-500 border border-blue-300 rounded shadow-md">
                <form wire:submit.prevent="save" class="text-sm">
                    <div class="px-2 m-2 ">
                        <div class="p-1 rounded-md bg-blue-50">
                            <h3 class="pl-1 font-semibold">Datos Oferta</h3>
                            <input  wire:model.defer="pedidoid" type="hidden"/>
                        </div>
                        <div class="flex flex-col mx-2 md:space-y-0 md:flex-row md:space-x-2">
                            <div class="w-full form-item">
                                <div class="w-full form-item">
                                    <x-jet-label >{{ __('Cliente') }}</x-jet-label>
                                    <x-selectcolor wire:model.lazy="cliente_id" selectname="cliente_id" color="blue" class="w-full py-1" >
                                        <option value="">-- Selecciona cliente --</option>
                                        @foreach ($clientes as $cliente)
                                        <option value="{{ $cliente->id }}">{{ $cliente->entidad }}</option>
                                        @endforeach
                                    </x-selectcol>
                                </div>
                            </div>
                            <div class="w-full form-item">
                                <div class="w-full form-item">
                                    <x-jet-label >{{ __('Contacto') }}</x-jet-label>
                                    <x-selectcolor wire:model.lazy="contacto_id" selectname="contacto_id" color="blue" class="w-full py-1" >
                                        @if (isset($contactos))
                                            <option value="">-- Selecciona contacto --</option>
                                            @foreach ($contactos as $contacto)
                                            <option value="{{ $contacto->contacto_id }}">{{ $contacto->entidadcontacto->entidad }}</option>
                                            @endforeach
                                        @else
                                            <option value="">-- Selecciona primero un cliente --</option>
                                        @endif
                                    </x-selectcolor>
                                </div>
                            </div>
                            <div class="w-full form-item">
                                <div class="w-full form-item">
                                    <x-jet-label >{{ __('Descripción') }}</x-jet-label>
                                    <input  wire:model.lazy="descripcion" type="text" class="w-full py-1 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"/>
                                </div>
                            </div>
                            <div class="w-full form-item">
                                <div class="w-full form-item">
                                    <x-jet-label >{{ __('Producto') }} </x-jet-label>
                                    <x-selectcolor wire:model.lazy="producto_id" selectname="producto_id" color="blue" class="w-full py-1" >
                                        @if (isset($productos))
                                            <option value="">-- Selecciona un producto --</option>
                                            @foreach ($productos as $producto)
                                            <option value="{{ $producto->id }}" {{ $producto->id == $producto_id ? 'selected' : '' }}>{{ $producto->referencia }}</option>
                                            @endforeach
                                        @else
                                            <option value="">-- Selecciona primero un cliente --</option>
                                        @endif
                                    </x-selectcolor>
                                </div>
                            </div>
                            <div class="w-full form-item">
                                <div class="w-full form-item">
                                    <x-jet-label >{{ __('Prod.IBAN') }}</x-jet-label>
                                    <x-selectcolor wire:model.lazy="producto_id" selectname="producto_id" color="blue" class="w-full py-1" >
                                        @if (isset($productos))
                                            <option value="">-- Selecciona producto --</option>
                                            @foreach ($productos as $producto)
                                            <option value="{{ $producto->id }}">{{ $producto->isbn }}</option>
                                            @endforeach
                                        @else
                                            <option value="">-- Selecciona primero un producto --</option>
                                        @endif
                                    </x-selectcolor>
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-col mx-2 md:space-y-0 md:flex-row md:space-x-2">
                            <div class="w-full form-item">
                                <div class="w-full form-item">
                                    <x-jet-label >{{ __('Acabado') }}</x-jet-label>
                                    <input  wire:model.lazy="acabado" type="text" class="w-full py-1 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"/>
                                </div>
                            </div>
                            <div class="w-full form-item">
                                <div class="w-full form-item">
                                    <x-jet-label >{{ __('Manipulación') }}</x-jet-label>
                                    <input  wire:model.lazy="manipulacion" type="text" class="w-full py-1 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"/>
                                </div>
                            </div>
                            <div class="w-full form-item">
                                <div class="w-full form-item">
                                    <x-jet-label >{{ __('Entrega') }}</x-jet-label>
                                    <input  wire:model.lazy="entrega" type="text" class="w-full py-1 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"/>
                                </div>
                            </div>
                        </div>
                        <div class="px-2 m-2 ">
                            <div class="p-1 rounded-md bg-blue-50">
                                <h3 class="pl-1 font-semibold">Descripción Producto</h3>
                                <input  wire:model.defer="pedidoid" type="hidden"/>
                            </div>
                            <div class="flex flex-col mx-2 md:space-y-0 md:flex-row md:space-x-2">
                                <div class="w-full form-item">
                                    <div class="">
                                        <x-jet-label  class="font-bold">{{ __('Paginas') }}</x-jet-label>
                                        <p>{{ $prod->paginas  }}</p>
                                        <x-jet-label  class="font-bold" >{{ __('Plastificado') }}</x-jet-label>
                                        <p>{{ $prod->plastificado  }}</p>
                                        <x-jet-label  class="font-bold">{{ __('Encuadernado') }}</x-jet-label>
                                        <p>{{ $prod->encuadernado  }}</p>
                                    </div>
                                </div>
                                <div class="w-full form-item">
                                    <div class="">
                                        <x-jet-label  class="font-bold" >{{ __('Interiores') }}</x-jet-label>
                                        <p>Papel: {{ $prod->materialinterior }} </p>
                                        <p>Tintas: {{ $prod->tintainterior }} </p>
                                        <p>Gr {{ $prod->gramajeinterior }} </p>
                                    </div>
                                </div>
                                <div class="w-full form-item">
                                    <div class="">
                                        <x-jet-label class="font-bold">{{ __('Cubierta') }}</x-jet-label>
                                        <p>Papel: {{ $prod->materialcubierta }} </p>
                                        <p>Tintas: {{ $prod->tintacubierta }} </p>
                                        <p>Gr {{ $prod->gramajecubierta }} </p>
                                    </div>
                                </div>
                                <div class="w-full form-item">
                                    @if ($prod->solapa=='1')
                                    <div class="">
                                        <x-jet-label class="font-bold">{{ __('Solapa') }}</x-jet-label>
                                        <p>{{ $prod->descripsolapa  }}</p>
                                    </div>
                                    @endif
                                    @if ($prod->guardas=='1')
                                    <div class="">
                                        <x-jet-label class="font-bold">{{ __('Guardas') }}</x-jet-label>
                                        <p>{{ $prod->descripguardas  }}</p>
                                    </div>
                                    @endif
                                    @if ($prod->cd=='1')
                                    <div class="">
                                        <x-jet-label class="font-bold">{{ __('CD') }}</x-jet-label>
                                        <p>{{ $prod->descripcd  }}</p>
                                    </div>
                                    @endif
                                </div>
                                <div class="w-full form-item">
                                    @if ($prod->novedad=='1')
                                    <div class="">
                                        <x-jet-label class="font-bold">{{ __('Novedad') }}</x-jet-label>
                                        <p>{{ $prod->descripnovedad  }}</p>
                                    </div>
                                    @endif
                                    <div class="">
                                        <x-jet-label class="font-bold">{{ __('Caja') }}</x-jet-label>
                                        <p>{{ $prod->caja->name ?? ''  }} - {{ $prod->udxcaja }} Uds x caja</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-col mx-2 md:space-y-0 md:flex-row md:space-x-2">
                            <div class="w-full form-item">
                                <x-jet-label >{{ __('Observaciones') }}</x-jet-label>
                                <textarea wire:model.defer="observaciones" class="w-full text-xs border-gray-300 rounded-md" rows="1">{{ old('observaciones') }} </textarea>
                                <input-error  class="w-full text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" />
                            </div>
                        </div>
                    </div>
                    <div class="px-2 py-0 pb-2 mx-2 ">
                        <div class="flex flex-col mx-2 mb-2 md:space-y-0 md:flex-row md:space-x-2">
                            <x-jet-button class="bg-blue-600">{{ __('Guardar') }}</x-jet-button>
                            <x-jet-secondary-button  onclick="location.href = '{{route('oferta.tipo',[$tipo,$ruta])}}'">{{ __('Volver') }}</x-jet-secondary-button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="">
                @if($ofertaid)
                    @livewire('oferta.oferta-detalles',['ofertaid'=>$ofertaid],key($ofertaid.now()))
                @endif
            </div>
        </div>
    </div>
</div>
