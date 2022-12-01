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
                        <div class="px-2 m-2 ">
                            <div class="p-1 rounded-md bg-blue-50">
                                <h3 class="pl-1 font-semibold">Descripción Producto</h3>
                                <input  wire:model.defer="pedidoid" type="hidden"/>
                            </div>
                            <div class="flex flex-col mx-2 md:space-y-0 md:flex-row md:space-x-2">
                                <h1>Descripción Producto</h1><br>
                                Páginas: {{ $prod->paginas }} Formato: {{ $prod->formato }} FSC: {{ $prod->FSC }}<br>
                                Interior: {{ $prod->materialinterior }} - {{ $prod->tintainterior }} - {{ $prod->gramajeinterior }} gr<br>
                                Cubierta: {{ $prod->materialcubierta }} - {{ $prod->tintacubierta }} - {{ $prod->gramajecubierta }} gr<br>
                                Plastificado: {{ $prod->plastificado }} Encuadernado: {{ $prod->encuadernado }}<br>
                                @if ($prod->solapa=='1') Solapa: {{ $prod->descripsolapa }} @endif<br>
                                @if ($prod->guardas=='1') Guardas: {{ $prod->descripguardas }}@endif<br>
                                @if ($prod->cd=='1') CD: {{ $prod->descripcd }}@endif <br>
                                @if ($prod->novedad=='1') Novedad: {{ $prod->descripnovedad }} @endif <br>
                                Caja: {{ $prod->caja->name ?? '' }} udxcaja: {{ $prod->udxcaja }}<br>
                        </div>
                        <div class="flex flex-col mx-2 md:space-y-0 md:flex-row md:space-x-2">
                            <div class="w-full form-item">
                                <div class="">
                                    <x-jet-label >{{ __('Formato') }}</x-jet-label>
                                    <input  value="{{ $prod->formato ?? '-' }}" type="text" class="w-full py-1 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                    disabled/>
                                </div>
                                <div class="w-full form-item">
                                    <x-jet-label >{{ __('Extension') }}</x-jet-label>
                                    <input  value="{{ $prod->paginas ?? '-' }}" type="text" class="w-full py-1 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                    disabled/>
                                </div>
                            </div>
                            <div class="w-full form-item">
                                <div class="w-full form-item">
                                    <x-jet-label >{{ __('Material Interior') }}</x-jet-label>
                                    <input  value="{{ $prod->materialinterior ?? '-' }}" type="text" class="w-full py-1 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                    disabled/>
                                </div>
                                <div class="w-full form-item">
                                    <x-jet-label >{{ __('Impresión Interior') }}</x-jet-label>
                                    <input  value="{{ $prod->tintainterior ?? '-' }}" type="text" class="w-full py-1 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                    disabled/>
                                </div>
                            </div>

                            <div class="w-full form-item">
                                <div class="w-full form-item">
                                    <x-jet-label >{{ __('Material Cubierta') }}</x-jet-label>
                                    <input  value="{{ $prod->materialcubierta ?? '-' }}" type="text" class="w-full py-1 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                    disabled/>
                                </div>
                                <div class="w-full form-item">
                                    <x-jet-label >{{ __('Impresión Cubierta') }}</x-jet-label>
                                    <input  value="{{ $prod->tintacubierta ?? '-' }}" type="text" class="w-full py-1 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                    disabled/>
                                </div>
                            </div>
                            <div class="w-full form-item">
                                <div class="w-full form-item">
                                    <x-jet-label >{{ __('Guardas') }}</x-jet-label>
                                    <input  value="{{ $prod->descripcionguardas }}" type="text" class="w-full py-1 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                    disabled/>
                                </div>
                                <div class="w-full form-item">
                                    <x-jet-label >{{ __('Impresión Guardas') }}</x-jet-label>
                                    <input  value="{{ $prod->impresionguardas }}" type="text" class="w-full py-1 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                    disabled/>
                                </div>
                            </div>
                            <div class="w-full form-item">
                                <div class="w-full form-item">
                                    <x-jet-label >{{ __('Acabado') }}</x-jet-label>
                                    <input  value="{{ $prod->acabado }}" type="text" class="w-full py-1 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                    disabled/>
                                </div>
                                <div class="w-full form-item">
                                    <x-jet-label >{{ __('Manipulación') }}</x-jet-label>
                                    <input  value="{{ $prod->manipulacion }}" type="text" class="w-full py-1 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                    disabled/>
                                </div>
                            </div>
                            <div class="w-full form-item">
                                <div class="w-full form-item">
                                    <x-jet-label >{{ __('Entrega') }}</x-jet-label>
                                    <input  value="{{ $prod->entrega }}" type="text" class="w-full py-1 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                    disabled/>
                                </div>
                                <div class="w-full form-item">
                                    <x-jet-label >{{ __('Estado') }}</x-jet-label>
                                    <x-selectcolor wire:model.lazy="estado" selectname="estado" color="blue" class="w-full py-1" >
                                        <option value="0">{{ __('En espera') }}</option>
                                        <option value="1">{{ __('Aceptada') }}</option>
                                        <option value="2">{{ __('Rechazada') }}</option>
                                    </x-selectcolor>
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-col mx-2 md:space-y-0 md:flex-row md:space-x-2">
                            <div class="w-full form-item">
                                <x-jet-label >{{ __('Observaciones') }}</x-jet-label>
                                <textarea wire:model.defer="observaciones" class="w-full text-xs border-gray-300 rounded-md" rows="2">{{ old('observaciones') }} </textarea>
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
