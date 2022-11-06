<form wire:submit.prevent="save" class="text-sm">
    <div class="p-1 m-2 ">
        <div class="p-1 rounded-md bg-orange-50">
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
                <x-selectcolor wire:model.lazy="producto.cliente_id" selectname="cliente_id" color="blue" class="w-full" >
                    <option value=''>-- Selecciona cliente --</option>
                    @foreach ($clientes as $cliente)
                    <option value="{{ $cliente->id }}">{{ $cliente->entidad }}</option>
                    @endforeach
                </x-selectcolor>
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
            <div class="p-2 border border-orange-300 rounded shadow-md ">
                <div class="p-1 rounded-md bg-orange-50">
                    <h3 class="pl-1 font-semibold">Datos Técnicos</h3>
                </div>
                {{-- formatos --}}
                <div class="w-full form-item">
                    <x-jet-label for="formato">{{ __('Formato') }}</x-jet-label>
                        <x-selectcolor wire:model.lazy="producto.formato" selectname="formato" color="blue" class="w-full form-control" id="formato">
                            <option value="">--Selecciona--</option>
                            @foreach($formatos as $item)
                                <option value="{{ $item->name }}">{{ $item->name }}{{ $item->descripcion }}</option>
                            @endforeach
                        </x-selectcolor>
                </div>
                {{-- Encuadernación --}}
                <div class="w-full form-item">
                    <x-jet-label for="encuadernado">{{ __('Encuadernación') }}</x-jet-label>
                        <x-selectcolor wire:model.lazy="producto.encuadernado" selectname="encuadernado" color="blue" class="w-full form-control" id="encuadernado">
                            <option value="">--Selecciona--</option>
                            @foreach($encuadernaciones as $item)
                                <option value="{{ $item->name }}">{{ $item->name }}{{ $item->descripcion }}</option>
                            @endforeach
                        </x-selectcolor>
                </div>
                {{-- plastificado --}}
                <div class="w-full form-item">
                    <x-jet-label for="plastificado">{{ __('Plastificado') }}</x-jet-label>
                        <x-selectcolor wire:model.lazy="producto.plastificado" selectname="plastificado" color="blue" class="w-full form-control" id="plastificado">
                            <option value="">--Selecciona--</option>
                            @foreach($plastificados as $item)
                                <option value="{{ $item->name }}">{{ $item->name }}{{ $item->descripcion }}</option>
                            @endforeach
                        </x-selectcolor>
                </div>
                {{-- varios --}}
                <div class="flex flex-row space-x-4">
                    <div class="w-full form-item">
                        <x-jet-label for="paginas">{{ __('Páginas') }}</x-jet-label>
                        <input  wire:model.lazy="producto.paginas" type="number" class="w-full py-1 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"/>
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
                        <input  wire:model.lazy="producto.descripnovedad" type="text" class="w-full py-1 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"/>
                    </div>
                </div>
            </div>
            <div class="p-2 border border-green-300 rounded shadow-md ">
                <div class="p-1 rounded-md bg-green-50">
                    <h3 class="pl-1 font-semibold">Interiores</h3>
                </div>
                {{-- gramaje interior --}}
                <div class="w-full form-item">
                    <x-jet-label for="gramajeinterior">{{ __('Gramaje Interior') }}</x-jet-label>
                        <x-selectcolor wire:model.lazy="producto.gramajeinterior" selectname="gramajeinterior" color="blue" class="w-full form-control" id="gramajeinterior">
                            <option value="">--Selecciona--</option>
                            @foreach($gramajesinterior as $item)
                                <option value="{{ $item->name }}">{{ $item->name }}{{ $item->descripcion }}</option>
                            @endforeach
                        </x-selectcolor>
                </div>
                {{-- tinta interior --}}
                <div class="w-full form-item">
                    <x-jet-label for="tintainterior">{{ __('Tinta Interior') }}</x-jet-label>
                        <x-selectcolor wire:model.lazy="producto.tintainterior" selectname="tintainterior" color="blue" class="w-full form-control" id="tintainterior">
                            <option value="">--Selecciona--</option>
                            @foreach($tintasinterior as $item)
                                <option value="{{ $item->name }}">{{ $item->name }}{{ $item->descripcion }}</option>
                            @endforeach
                        </x-selectcolor>
                </div>
                {{-- Material interior --}}
                <div class="w-full form-item">
                    <x-jet-label for="materialinterior">{{ __('Material Interior') }}</x-jet-label>
                        <x-selectcolor wire:model.lazy="producto.materialinterior" selectname="materialinterior" color="blue" class="w-full form-control" id="materialinterior">
                            <option value="">--Selecciona--</option>
                            @foreach($materialesinterior as $item)
                                <option value="{{ $item->name }}">{{ $item->name }}{{ $item->descripcion }}</option>
                            @endforeach
                        </x-selectcolor>
                </div>
                <div class="flex flex-row space-x-4">
                    <div class="form-item">
                        <x-jet-label for="guardas">{{ __('Guardas') }}</x-jet-label>
                        <input type="checkbox" wire:model.lazy="producto.guardas"/>
                    </div>
                    <div class="w-full form-item">
                        <x-jet-label for="descripguardas">{{ __('Descripción guardas') }}</x-jet-label>
                        <input wire:model.lazy="producto.descripguardas" type="text" class="w-full py-1 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"/>
                    </div>
                </div>
                <div class="flex flex-row space-x-4">
                    <div class="form-item">
                        <x-jet-label for="cd">{{ __('CD') }}</x-jet-label>
                        <input type="checkbox" wire:model.lazy="producto.cd"/>
                    </div>
                    <div class="w-full form-item">
                        <x-jet-label for="descripcd">{{ __('Descripción cd') }}</x-jet-label>
                        <input wire:model.lazy="producto.descripcd" type="text" class="w-full py-1 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"/>
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
                        <x-selectcolor wire:model.lazy="producto.gramajecubierta" selectname="gramajecubierta" color="blue" class="w-full form-control" id="gramajecubierta">
                            <option value="">--Selecciona--</option>
                            @foreach($gramajescubierta as $item)
                                <option value="{{ $item->name }}">{{ $item->name }}{{ $item->descripcion }}</option>
                            @endforeach
                        </x-selectcolor>
                </div>
                {{-- Tinta Cubierta --}}
                <div class="w-full form-item">
                    <x-jet-label for="tintacubierta">{{ __('Tinta Cubierta') }}</x-jet-label>
                        <x-selectcolor wire:model.lazy="producto.tintacubierta"  selectname="tintacubierta" color="blue" class="w-full form-control" id="tintacubierta">
                            <option value="">--Selecciona--</option>
                            @foreach($tintascubierta as $item)
                                <option value="{{ $item->name }}">{{ $item->name }}{{ $item->descripcion }}</option>
                            @endforeach
                        </x-selectcolor>
                </div>
                {{-- Material Cubierta --}}
                <div class="w-full form-item">
                    <x-jet-label for="materialcubierta">{{ __('Material Cubierta') }}</x-jet-label>
                        <x-selectcolor wire:model.lazy="producto.materialcubierta"  selectname="materialcubierta" color="blue" class="w-full form-control" id="materialcubierta">
                            <option value="">--Selecciona--</option>
                            @foreach($materialescubierta as $item)
                                <option value="{{ $item->name }}">{{ $item->name }}{{ $item->descripcion }}</option>
                            @endforeach
                        </x-selectcolor>
                </div>
                {{-- Solapas --}}
                <div class="flex flex-row space-x-4">
                    <div class="form-item">
                        <x-jet-label for="solapa">{{ __('Solapas') }}</x-jet-label>
                        <input type="checkbox" wire:model.lazy="producto.solapa"/>
                    </div>
                    <div class="w-full form-item">
                        <x-jet-label for="descripsolapa">{{ __('Descripción Solapa') }}</x-jet-label>
                        <input  wire:model.lazy="producto.descripsolapa" type="text" class="w-full py-1 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
        <div class="flex flex-col mx-2 space-y-2 md:space-y-0 md:flex-row md:space-x-4">
            <div class="w-full form-item sm:w-2/12">
                <x-jet-label for="caja">{{ __('Caja') }}</x-jet-label>
                    <x-selectcolor wire:model.lazy="producto.caja"  selectname="caja" color="blue" class="w-full form-control" id="caja">
                        <option value="">--Selecciona--</option>
                        @foreach($cajas as $item)
                            <option value="{{ $item->name }}">{{ $item->name }}{{ $item->descripcion }}</option>
                        @endforeach
                    </x-selectcolor>
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
                    {{-- @if($producto->adjunto) --}}
                    {{-- <x-icon.clip-a class="w-10 text-green-500 hover:text-green-700 " onclick="location.href = '{{route('producto.adjunto', [$producto]) }}'" title="Adjunto Producto"/> --}}
                    {{-- <a href="{{'http://mmcontrol.test/fichasproducto/'.$producto->adjunto }}" target="_blank" title="ver producto"><x-icon.clip class="text-orange-500 w-7 hover:text-orange-700 "/></a> --}}
                    {{-- @endif --}}
                    @error('ficheropdf') <p class="text-red-500">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>
        <div class="py-1 my-0 ">
            <div class="flex flex-col mx-2 md:space-y-0 md:flex-row md:space-x-4">
                <x-jet-button class="bg-blue-600">{{ __('Guardar') }}</x-jet-button>
                <x-jet-secondary-button  onclick="location.href = '{{route('producto.tipo','1')}}'">{{ __('Volver') }}</x-jet-secondary-button>
            </div>
        </div>
    </div>
</form>
