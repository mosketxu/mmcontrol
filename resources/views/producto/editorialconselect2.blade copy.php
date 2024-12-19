<form wire:submit.prevent="save" class="text-sm">
    <div class="p-1 m-2 ">
        <div class="p-1 rounded-md bg-blue-50">
            <h3 class="pl-1 font-semibold">Datos generales</h3>
            <input  wire:model.defer="producto.id" type="hidden"/>
            <input  wire:model.defer="tipo" type="hidden"/>
        </div>
        <div class="flex flex-col mx-2 space-y-1 md:space-y-0 md:flex-row md:space-x-4">
            {{-- isbn --}}
            <div class="w-full form-item sm:w-2/12">
                <x-jet-label for="isbn">{{ __('ISBN') }}</x-jet-label>
                <input wire:model.lazy="producto.isbn" type="text" class="w-full py-1 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" required/>
            </div>
            {{-- titulo --}}
            <div class="w-full form-item sm:w-4/12">
                <x-jet-label for="referencia">{{ __('Título') }}</x-jet-label>
                <input wire:model.lazy="producto.referencia" type="text" class="w-full py-1 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" autofocus/>
            </div>
            {{-- cliente --}}
            <div class="w-full form-item sm:w-4/12">
                <x-jet-label for="entidad_id">{{ __('Cliente') }}</x-jet-label>
                <x-select wire:model.lazy="producto.cliente_id" selectname="cliente_id" class="w-full" >
                    <option value=''>-- Selecciona cliente --</option>
                    @foreach ($clientes as $cliente)
                    <option value="{{ $cliente->id }}">{{ $cliente->entidad }}</option>
                    @endforeach
                </x-select>
            </div>
            {{-- precio coste --}}
            <div class="w-full form-item sm:w-1/12">
                <x-jet-label for="preciocoste">{{ __('€ Compra') }}</x-jet-label>
                <input  wire:model.lazy="producto.preciocoste" type="number" step="any" class="w-full py-1 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"/>
            </div>
            {{-- precio venta --}}
            <div class="w-full form-item sm:w-1/12">
                <x-jet-label for="precioventa">{{ __('€ Venta') }}</x-jet-label>
                <input  wire:model.lazy="producto.precioventa" type="number" step="any" class="w-full py-1 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"/>
            </div>
        </div>
    </div>
    <div class="p-2 m-2 ">
        <div class="grid grid-cols-1 gap-2 md:grid-cols-3">
            <div class="p-2 border border-blue-300 rounded shadow-md ">
                <div class="p-1 rounded-md bg-blue-50">
                    <h3 class="pl-1 font-semibold">Datos generales</h3>
                </div>
                {{-- formatos --}}
                <div class="w-full form-item">
                    <x-jet-label for="formato">{{ __('Formato') }}</x-jet-label>
                    <div wire:ignore>
                        <select class="w-full form-control" id="formato">
                            <option value="">Select Option</option>
                            @foreach($formatos as $item)
                                <option value="{{ $item->name }}">{{ $item->name }}{{ $item->descripcion }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                {{-- Encuadernación --}}
                <div class="w-full form-item">
                    <x-jet-label for="encuadernado">{{ __('Encuadernación') }}</x-jet-label>
                    <div wire:ignore>
                        <select class="w-full form-control" id="encuadernado">
                            <option value="">Select Option</option>
                            @foreach($encuadernaciones as $item)
                                <option value="{{ $item->name }}">{{ $item->name }}{{ $item->descripcion }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                {{-- plastificado --}}
                <div class="w-full form-item">
                    <x-jet-label for="plastificado">{{ __('Plastificado') }}</x-jet-label>
                    <div wire:ignore>
                        <select class="w-full form-control" id="plastificado">
                            <option value="">Select Option</option>
                            @foreach($plastificados as $item)
                                <option value="{{ $item->name }}">{{ $item->name }}{{ $item->descripcion }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                {{-- varios --}}
                <div class="flex flex-row space-x-4">
                    <div class="w-full form-item">
                        <x-jet-label for="paginas">{{ __('Páginas') }}</x-jet-label>
                        <input  wire:model.lazy="producto.paginas" type="text" class="w-full py-1 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"/>
                    </div>
                    <div class="w-full form-item">
                        <x-jet-label for="tirada">{{ __('Tirada') }}</x-jet-label>
                        <input  wire:model.lazy="producto.tirada" type="number" class="w-full py-1 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"/>
                    </div>
                    <div class="form-item">
                        <x-jet-label for="FSC">{{ __('FSC') }}</x-jet-label>
                        <input type="checkbox" wire:model.lazy="producto.FSC"/>
                    </div>
                </div>
                {{-- Novedad --}}
                <div class="flex flex-row">
                    <div class="form-item">
                        <x-jet-label for="novedad">{{ __('Novedad') }}</x-jet-label>
                        <input type="checkbox" wire:model.lazy="producto.novedad"/>
                    </div>
                    <div class="w-full form-item">
                        <x-jet-label for="descripnovedad">{{ __('Descripción novedad') }}</x-jet-label>
                        <input  wire:model.lazy="producto.descripnovedad" type="number" class="w-full py-1 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"/>
                    </div>
                </div>
            </div>
            <div class="p-2 border border-blue-300 rounded shadow-md ">
                <div class="p-1 rounded-md bg-blue-50">
                    <h3 class="pl-1 font-semibold">Interiores</h3>
                </div>
                {{-- gramaje interior --}}
                <div class="w-full form-item">
                    <x-jet-label for="gramajeinterior">{{ __('Gramaje Interior') }}</x-jet-label>
                    <div wire:ignore>
                        <select class="w-full form-control" id="gramajeinterior">
                            <option value="">Select Option</option>
                            @foreach($gramajesinterior as $item)
                                <option value="{{ $item->name }}">{{ $item->name }}{{ $item->descripcion }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                {{-- tinta interior --}}
                <div class="w-full form-item">
                    <x-jet-label for="tintainterior">{{ __('Tinta Interior') }}</x-jet-label>
                    <div wire:ignore>
                        <select class="w-full form-control" id="tintainterior">
                            <option value="">Select Option</option>
                            @foreach($tintasinterior as $item)
                                <option value="{{ $item->name }}">{{ $item->name }}{{ $item->descripcion }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                {{-- Material interior --}}
                <div class="w-full form-item">
                    <x-jet-label for="materialinterior">{{ __('Material Interior') }}</x-jet-label>
                    <div wire:ignore>
                        <select class="w-full form-control" id="materialinterior">
                            <option value="">Select Option</option>
                            @foreach($materialesinterior as $item)
                                <option value="{{ $item->name }}">{{ $item->name }}{{ $item->descripcion }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="flex flex-row space-x-4">
                    <div class="form-item">
                        <x-jet-label for="guardas">{{ __('Guardas') }}</x-jet-label>
                        <input type="checkbox" wire:model.lazy="producto.guardas"/>
                    </div>
                    <div class="w-full form-item">
                        <x-jet-label for="descripguardas">{{ __('Descripción guardas') }}</x-jet-label>
                        <input wire:model.lazy="producto.descripguardas" type="number" class="w-full py-1 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"/>
                    </div>
                </div>
                <div class="flex flex-row space-x-4">
                    <div class="form-item">
                        <x-jet-label for="cd">{{ __('CD') }}</x-jet-label>
                        <input type="checkbox" wire:model.lazy="producto.cd"/>
                    </div>
                    <div class="w-full form-item">
                        <x-jet-label for="descripcd">{{ __('Descripción cd') }}</x-jet-label>
                        <input wire:model.lazy="producto.descripcd" type="number" class="w-full py-1 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"/>
                    </div>
                </div>
            </div>
            <div class="p-2 border border-yellow-300 rounded shadow-md ">
                <div class="p-1 rounded-md bg-yellow-50">
                    <h3 class="pl-1 font-semibold">Cubiertas</h3>
                </div>
                {{-- Gramaje Cubierta --}}
                <div class="w-full form-item">
                    <x-jet-label for="gramajecubierta">{{ __('Gramaje Cubierta') }}</x-jet-label>
                    <div wire:ignore>
                        <select class="w-full form-control" id="gramajecubierta">
                            <option value="">Select Option</option>
                            @foreach($gramajescubierta as $item)
                                <option value="{{ $item->name }}">{{ $item->name }}{{ $item->descripcion }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                {{-- Tinta Cubierta --}}
                <div class="w-full form-item">
                    <x-jet-label for="tintacubierta">{{ __('Tinta Cubierta') }}</x-jet-label>
                    <div wire:ignore>
                        <select class="w-full form-control" id="tintacubierta">
                            <option value="">Select Option</option>
                            @foreach($tintascubierta as $item)
                                <option value="{{ $item->name }}">{{ $item->name }}{{ $item->descripcion }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                {{-- Material Cubierta --}}
                <div class="w-full form-item">
                    <x-jet-label for="materialcubierta">{{ __('Material Cubierta') }}</x-jet-label>
                    <div wire:ignore>
                        <select class="w-full form-control" id="materialcubierta">
                            <option value="">Select Option</option>
                            @foreach($materialescubierta as $item)
                                <option value="{{ $item->name }}">{{ $item->name }}{{ $item->descripcion }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                {{-- Solapas --}}
                <div class="flex flex-row space-x-4">
                    <div class="form-item">
                        <x-jet-label for="solapa">{{ __('Solapas') }}</x-jet-label>
                        <input type="checkbox" wire:model.lazy="producto.solapa"/>
                    </div>
                    <div class="w-full form-item">
                        <x-jet-label for="descripsolapa">{{ __('Descripción Solapa') }}</x-jet-label>
                        <input  wire:model.lazy="producto.descripsolapa" type="number" class="w-full py-1 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
        <div class="flex flex-col mx-2 space-y-2 md:space-y-0 md:flex-row md:space-x-4">
            <div class="w-full form-item sm:w-2/12">
                <x-jet-label for="caja">{{ __('Caja') }}</x-jet-label>
                <div wire:ignore>
                    <select class="w-full form-control" id="caja">
                        <option value="">Select Option</option>
                        @foreach($cajas as $item)
                            <option value="{{ $item->name }}">{{ $item->name }}{{ $item->descripcion }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="w-full form-item sm:w-1/12 ">
                <x-jet-label for="udxcaja">{{ __('Uds. x caja') }}</x-jet-label>
                <input  wire:model.lazy="producto.udxcaja" type="number" class="w-full py-1 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"/>
            </div>
            <div class="w-full form-item sm:w-3/12">
                <x-jet-label for="especiflogistica">{{ __('Especificaciónes logísticas') }}</x-jet-label>
                <textarea wire:model.defer="producto.especiflogistica" class="w-full text-xs border-gray-300 rounded-md" rows="2">{{ old('especiflogistica') }} </textarea>
                <input-error for="observaciones" class="w-full text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" />
            </div>
            <div class="w-full form-item sm:w-3/12">
                <x-jet-label for="observaciones">{{ __('Observaciones') }}</x-jet-label>
                <textarea wire:model.defer="producto.observaciones" class="w-full text-xs border-gray-300 rounded-md" rows="2">{{ old('observaciones') }} </textarea>
                <input-error for="observaciones" class="w-full text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" />
            </div>
            <div class="w-full form-item sm:w-2/12 ">
                <x-jet-label for="ficheropdf">{{ __('Ficha producto') }}</x-jet-label>
                <div class="flex">
                    <input type="file" wire:model.lazy="ficheropdf">
                    @if($producto->adjunto)
                        <x-icon.clip-a wire:click="presentaAdjunto({{ $producto }})" class="w-8 text-green-500 hover:text-green-700 " title="archivo adjunto"/>
                    @endif
                    @error('ficheropdf') <p class="text-red-500">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>
        <div class="p-2 m-2 ">
            <div class="flex flex-col mx-2 space-y-4 md:space-y-0 md:flex-row md:space-x-4">
                <x-jet-button class="bg-blue-600">{{ __('Guardar') }}</x-jet-button>
                <!-- <x-jet-secondary-button  onclick="history.back()">{{ __('Volver') }}</x-jet-secondary-button> -->
                <x-jet-secondary-button  onclick="location.href = '{{route('producto.tipo','1')}}'">{{ __('Volver') }}</x-jet-secondary-button>
            </div>
        </div>
    </div>
</form>

<script>
    // esto se pone dentro del push

        // $(document).ready(function () {
        //     $('#formato').val(@json($formatoselected));
        //     $('#formato').select2();
        //     $('#formato').on('change', function (e) {
        //         var data = $('#formato').select2("val");
        //         @this.set('formatoselected', data);
        //     });

        //     $('#gramajeinterior').val(@json($gramajeinteriorselected));
        //     $('#gramajeinterior').select2();
        //     $('#gramajeinterior').on('change', function (e) {
        //         var data = $('#gramajeinterior').select2("val");
        //         @this.set('gramajeinteriorselected', data);
        //     });

        //     $('#tintainterior').val(@json($tintainteriorselected));
        //     $('#tintainterior').select2();
        //     $('#tintainterior').on('change', function (e) {
        //         var data = $('#tintainterior').select2("val");
        //         @this.set('tintainteriorselected', data);
        //     });

        //     $('#materialinterior').val(@json($materialinteriorselected));
        //     $('#materialinterior').select2();
        //     $('#materialinterior').on('change', function (e) {
        //         var data = $('#materialinterior').select2("val");
        //         @this.set('materialinteriorselected', data);
        //     });

        //     $('#gramajecubierta').val(@json($gramajecubiertaselected));
        //     $('#gramajecubierta').select2();
        //     $('#gramajecubierta').on('change', function (e) {
        //         var data = $('#gramajecubierta').select2("val");
        //         @this.set('gramajecubiertaselected', data);
        //     });

        //     $('#tintacubierta').val(@json($tintacubiertaselected));
        //     $('#tintacubierta').select2();
        //     $('#tintacubierta').on('change', function (e) {
        //         var data = $('#tintacubierta').select2("val");
        //         @this.set('tintacubiertaselected', data);
        //     });

        //     $('#materialcubierta').val(@json($materialcubiertaselected));
        //     $('#materialcubierta').select2();
        //     $('#materialcubierta').on('change', function (e) {
        //         var data = $('#materialcubierta').select2("val");
        //         @this.set('materialcubiertaselected', data);
        //     });

        //     $('#encuadernado').val(@json($encuadernadoselected));
        //     $('#encuadernado').select2();
        //     $('#encuadernado').on('change', function (e) {
        //         var data = $('#encuadernado').select2("val");
        //         @this.set('encuadernadoselected', data);
        //     });

        //     $('#plastificado').val(@json($plastificadoselected));
        //     $('#plastificado').select2();
        //     $('#plastificado').on('change', function (e) {
        //         var data = $('#plastificado').select2("val");
        //         @this.set('plastificadoselected', data);
        //     });

        //     $('#caja').val(@json($cajaselected));
        //     $('#caja').select2();
        //     $('#caja').on('change', function (e) {
        //         var data = $('#caja').select2("val");
        //         @this.set('cajaselected', data);
        //     });
        // });
    </script>
