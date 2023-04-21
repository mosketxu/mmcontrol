<div class="">
    <div class="h-full p-1 ">
        <div class="py-0 ">
            <div class="">
                @include('errores')
            </div>
            <div class="">
            </div>
            {{-- datos del pedido --}}
            <div class="flex-col text-gray-500 border border-blue-300 rounded shadow-md">
                <form wire:submit.prevent="save" class="text-sm">
                    <div class="p-1 ">
                        {{-- datos oferta --}}
                        <div class="">
                            <div class="flex p-1 rounded-md bg-blue-50">
                                <h3 class="pl-1 font-semibold">Datos generales</h3>
                                <input  wire:model.defer="presupuestoid" type="hidden"/>
                                @if($tipo!='1')
                                <x-select wire:model.defer="tipo" selectname="tipo" class="w-1/12 py-0 ml-2" >
                                    <option value="2">Packaging</option>
                                    <option value="3">Propios</option>
                                </x-select>
                                @endif
                            </div>
                            {{-- fecha-cliente-contacto-estado- --}}
                            <div class="flex flex-col mx-2 md:space-y-0 md:flex-row md:space-x-2">
                                <div class="w-full form-item">
                                    <x-jet-label >{{ __('Fecha') }}</x-jet-label>
                                    <input  wire:model.lazy="fecha" type="date" class="w-full py-1 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"/>
                                </div>
                                <div class="w-full form-item">
                                    <x-jet-label >{{ __('Cliente') }}</x-jet-label>
                                    <x-selectcolor wire:model.lazy="cliente_id" selectname="cliente_id" color="blue" class="w-full py-1" >
                                        <option value="">-- Selecciona cliente --</option>
                                        @foreach ($clientes as $cliente)
                                        <option value="{{ $cliente->id }}">{{ $cliente->entidad }}</option>
                                        @endforeach
                                    </x-selectcol>
                                </div>
                                <div class="w-full form-item">
                                    <x-jet-label >{{ __('Contacto') }}</x-jet-label>
                                    <x-selectcolor wire:model.lazy="contacto_id" selectname="contacto_id" color="blue" class="w-full py-1" >
                                        @if (isset($contactos))
                                            <option value="">-- Selecciona contacto --</option>
                                            @foreach ($contactos as $contacto)
                                            <option value="{{ $contacto->contacto_id }}">{{ $contacto->entidadcontacto->entidad ?? '-'  }}</option>
                                            @endforeach
                                        @else
                                            <option value="">-- Selecciona primero un cliente --</option>
                                        @endif
                                    </x-selectcolor>
                                </div>
                                <div class="w-full">
                                    <x-jet-label >{{ __('Estado') }}</x-jet-label>
                                    <x-selectcolor wire:model.lazy="estado" selectname="estado" color="blue" class="w-full py-1" >
                                        <option value="0">En Espera</option>
                                        <option value="1">Aceptada</option>
                                        <option value="2">Rechazada</option>
                                    </x-selectcolor>
                                </div>
                            </div>
                            {{-- Descrip-isbn titulo --}}
                            <div class="flex flex-col mx-2 md:space-y-0 md:flex-row md:space-x-2">
                                <div class="w-full form-item">
                                    <x-jet-label >{{ __('Descripción') }}</x-jet-label>
                                    <textarea wire:model.defer="descripcion" class="w-full text-xs border-gray-300 rounded-md" rows="1">{{ old('descripcion') }} </textarea>
                                </div>
                                <div class="w-full form-item">
                                    <x-jet-label >{{ __('ISBN') }}</x-jet-label>
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
                                <div class="w-full form-item">
                                    <x-jet-label >{{ __('Título') }} </x-jet-label>
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
                            {{-- manipulacion-entrega-obs --}}
                            <div class="flex flex-col mx-2 md:space-y-0 md:flex-row md:space-x-2">
                                <div class="w-full form-item">
                                    <x-jet-label >{{ __('Manipulación') }}</x-jet-label>
                                    <textarea wire:model.defer="manipulacion" class="w-full text-xs border-gray-300 rounded-md" rows="1">{{ old('manipulacion') }} </textarea>
                                </div>
                                <div class="w-full form-item">
                                    <x-jet-label >{{ __('Entrega') }}</x-jet-label>
                                    <textarea wire:model.defer="entrega" class="w-full text-xs border-gray-300 rounded-md" rows="1">{{ old('entrega') }} </textarea>
                                </div>
                                <div class="w-full mt-1 form-item">
                                    <x-jet-label >{{ __('Observaciones') }}</x-jet-label>
                                    <textarea wire:model.defer="observaciones" class="w-full text-xs border-gray-300 rounded-md" rows="1">{{ old('observaciones') }} </textarea>
                                </div>
                            </div>
                        </div>
                        {{-- descrip producto --}}
                        <div class="px-1 bg-gray-50">
                            <div class="p-1 rounded-md bg-blue-50">
                                <h3 class="pl-1 font-semibold">Descripción Producto</h3>
                                <input  wire:model.defer="pedidoid" type="hidden"/>
                            </div>
                            <div class="flex flex-col mx-1 md:space-y-0 md:flex-row md:space-x-2">
                                <div class="w-full form-item">
                                    <div class="">
                                        <x-jet-label  class="font-bold">{{ __('Paginas') }} <span class="font-light"> {{ $prod->paginas ?? '' }}</span></x-jet-label>
                                        <x-jet-label  class="font-bold" >{{ __('Plastificado') }}<span class="font-light"> {{ $prod->plastificado ?? '' }}</span></x-jet-label>
                                        <x-jet-label  class="font-bold">{{ __('Encuadernado') }}<span class="font-light" > {{ $prod->encuadernado ?? ''  }}</span></x-jet-label>
                                    </div>
                                </div>
                                <div class="w-full form-item">
                                    <div class="">
                                        <x-jet-label  class="font-bold">Papel Int. <span class="font-light"> {{ $prod->materialinterior  ?? ''}} </span></x-jet-label>
                                        <x-jet-label  class="font-bold">Tintas Int.<span class="font-light">  {{ $prod->tintainterior  ?? ''}}</span> </x-jet-label>
                                        <x-jet-label  class="font-bold">Gr. Int. <span class="font-light"> {{  $prod->gramajeinterior  ?? ''}} </span></x-jet-label>
                                    </div>
                                </div>
                                <div class="w-full form-item">
                                    <div class="">
                                        <x-jet-label  class="font-bold">Papel Cub. <span class="font-light"> {{ $prod->materialcubierta  ?? ''}} </span></x-jet-label>
                                        <x-jet-label  class="font-bold">Tintas Cub.<span class="font-light">  {{ $prod->tintacubierta  ?? ''}}</span> </x-jet-label>
                                        <x-jet-label  class="font-bold">Gr. Cub. <span class="font-light"> {{  $prod->gramajecubierta  ?? ''}} </span></x-jet-label>
                                    </div>
                                </div>
                                <div class="w-full form-item">
                                    @if ($prod && $prod->solapa=='1')
                                    <div class="">
                                        <x-jet-label class="font-bold">{{ __('Solapa') }}<span class="font-light"> {{ $prod->descripsolapa  ?? '' }}</span></x-jet-label>
                                    </div>
                                    @endif
                                    @if ($prod && $prod->guardas=='1')
                                    <div class="">
                                        <x-jet-label class="font-bold">{{ __('Guardas') }}<span class="font-light"> {{ $prod->descripguardas  ?? '' }}</span></x-jet-label>
                                    </div>
                                    @endif
                                    @if ($prod && $prod->cd=='1')
                                    <div class="">
                                        <x-jet-label class="font-bold">{{ __('CD') }}<span class="font-light"> {{ $prod->descripcd  ?? '' }}</span></x-jet-label>
                                    </div>
                                    @endif
                                </div>
                                <div class="w-full form-item">
                                    @if ($prod && $prod->novedad=='1')
                                    <div class="">
                                        <x-jet-label class="font-bold">{{ __('Novedad') }}<span class="font-light"> {{ $prod->descripnovedad  ?? '' }}</span></x-jet-label>
                                    </div>
                                    @endif
                                    <div class="">
                                        <x-jet-label class="font-bold">{{ __('Caja') }}<span class="font-light"> {{ $prod->caja->name ?? ''  }} </span></x-jet-label>
                                    </div>
                                    <div class="">
                                        <x-jet-label class="font-bold">{{ __('Udx x Caja') }}<span class="font-light"> {{ $prod->udxcaja  ?? ''}} Uds x caja</span></x-jet-label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="px-1 py-0 pb-1 mx-2 ">
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
