<form wire:submit.prevent="save" class="text-sm">
    <div class="p-2 m-2 ">
        <div class="p-1 rounded-md bg-blue-50">
            <h3 class="pl-1 font-semibold">Datos generales</h3>
            <input  wire:model.defer="producto.id" type="hidden"/>
            <input  wire:model.defer="tipo" type="hidden"/>
        </div>
        <div class="flex flex-col mx-2 space-y-4 md:space-y-0 md:flex-row md:space-x-4">
            <div class="w-2/12 form-item sm:w-full">
                <x-jet-label for="isbn">{{ __('ISBN') }}</x-jet-label>
                <input wire:model.lazy="producto.isbn" type="text" class="w-full py-2 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" required/>
            </div>
            <div class="w-10/12 form-item sm:w-full">
                <x-jet-label for="referencia">{{ __('Título') }}</x-jet-label>
                <input wire:model.lazy="producto.referencia" type="text" class="w-full text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" autofocus/>
            </div>
            <div class="w-full form-item">
                <x-jet-label for="entidad_id">{{ __('Cliente') }}</x-jet-label>
                <x-select wire:model.lazy="producto.cliente_id" selectname="cliente_id" class="w-full" >
                    <option value=''>-- Selecciona cliente --</option>
                    @foreach ($clientes as $cliente)
                    <option value="{{ $cliente->id }}">{{ $cliente->entidad }}</option>
                    @endforeach
                </x-select>
            </div>
        </div>
    </div>
    <div class="p-2 m-2 ">
        <div class="flex flex-col mx-2 space-y-4 md:space-y-0 md:flex-row md:space-x-4">
            <div class="w-full form-item">
                <x-jet-label for="preciocoste">{{ __('€ Precio Compra') }}</x-jet-label>
                <input  wire:model.lazy="producto.preciocoste" type="number" step="any" class="w-full py-2 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"/>
            </div>
            <div class="w-full form-item">
                <x-jet-label for="precioventa">{{ __('€ Precio Venta') }}</x-jet-label>
                <input  wire:model.lazy="producto.precioventa" type="number" step="any" class="w-full py-2 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"/>
            </div>
        </div>
    </div>
    <div class="p-2 m-2 ">
        <div class="flex flex-col mx-2 space-y-4 md:space-y-0 md:flex-row md:space-x-4">
            {{-- formatos --}}
            <div class="w-full form-item md:1/6">
                <x-jet-label for="formato">{{ __('Formato') }}</x-jet-label>
                <div wire:ignore>
                    <select class="form-control w-full" id="formato">
                        <option value="">Select Option</option>
                        @foreach($formatos as $item)
                            <option value="{{ $item->name }}">{{ $item->name }}{{ $item->descripcion }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            {{-- Encuadernación --}}
            <div class="w-full form-item md:1/6">
                <x-jet-label for="encuadernado">{{ __('Encuadernación') }}</x-jet-label>
                <div wire:ignore>
                    <select class="form-control w-full" id="encuadernado">
                        <option value="">Select Option</option>
                        @foreach($encuadernaciones as $item)
                            <option value="{{ $item->name }}">{{ $item->name }}{{ $item->descripcion }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            {{-- plastificado --}}
            <div class="w-full form-item md:1/6">
                <x-jet-label for="plastificado">{{ __('Plastificado') }}</x-jet-label>
                <div wire:ignore>
                    <select class="form-control w-full" id="plastificado">
                        <option value="">Select Option</option>
                        @foreach($plastificados as $item)
                            <option value="{{ $item->name }}">{{ $item->name }}{{ $item->descripcion }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="flex flex-col mx-2 space-y-4 md:space-y-0 md:flex-row md:space-x-4">
            {{-- gramaje interior --}}
            <div class="w-1/6 form-item sm:w-full ">
                <x-jet-label for="gramajeinterior">{{ __('Gramaje Interior') }}</x-jet-label>
                <div wire:ignore>
                    <select class="form-control  w-full" id="gramajeinterior">
                        <option value="">Select Option</option>
                        @foreach($gramajesinterior as $item)
                            <option value="{{ $item->name }}">{{ $item->name }}{{ $item->descripcion }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            {{-- tinta interior --}}
            <div class="w-1/6 form-item sm:w-full ">
                <x-jet-label for="tintainterior">{{ __('Tinta Interior') }}</x-jet-label>
                <div wire:ignore>
                    <select class="form-control  w-full" id="tintainterior">
                        <option value="">Select Option</option>
                        @foreach($tintasinterior as $item)
                            <option value="{{ $item->name }}">{{ $item->name }}{{ $item->descripcion }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            {{-- Material interior --}}
            <div class="w-1/6 form-item sm:w-full ">
                <x-jet-label for="materialinterior">{{ __('Material Interior') }}</x-jet-label>
                <div wire:ignore>
                    <select class="form-control  w-full" id="materialinterior">
                        <option value="">Select Option</option>
                        @foreach($materialesinterior as $item)
                            <option value="{{ $item->name }}">{{ $item->name }}{{ $item->descripcion }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            {{-- Gramaje Cubierta --}}
            <div class="w-1/6 form-item sm:w-full ">
                <x-jet-label for="gramajecubierta">{{ __('Gramaje Cubierta') }}</x-jet-label>
                <div wire:ignore>
                    <select class="form-control  w-full" id="gramajecubierta">
                        <option value="">Select Option</option>
                        @foreach($gramajescubierta as $item)
                            <option value="{{ $item->name }}">{{ $item->name }}{{ $item->descripcion }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            {{-- Tinta Cubierta --}}
            <div class="w-1/6 form-item sm:w-full ">
                <x-jet-label for="tintacubierta">{{ __('Tinta Cubierta') }}</x-jet-label>
                <div wire:ignore>
                    <select class="form-control  w-full" id="tintacubierta">
                        <option value="">Select Option</option>
                        @foreach($tintascubierta as $item)
                            <option value="{{ $item->name }}">{{ $item->name }}{{ $item->descripcion }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            {{-- Material Cubierta --}}
            <div class="w-1/6 form-item sm:w-full ">
                <x-jet-label for="materialcubierta">{{ __('Material Cubierta') }}</x-jet-label>
                <div wire:ignore>
                    <select class="form-control w-full" id="materialcubierta">
                        <option value="">Select Option</option>
                        @foreach($materialescubierta as $item)
                            <option value="{{ $item->name }}">{{ $item->name }}{{ $item->descripcion }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="flex flex-col mx-2 space-y-4 md:space-y-0 md:flex-row md:space-x-4">

            {{-- Caja --}}
            <div class="w-full form-item sm:w-full">
                <x-jet-label for="caja">{{ __('Caja') }}</x-jet-label>
                <div wire:ignore>
                    <select class="form-control" id="caja">
                        <option value="">Select Option</option>
                        @foreach($cajas as $item)
                            <option value="{{ $item->name }}">{{ $item->name }}{{ $item->descripcion }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="w-full form-item">
                <x-jet-label for="udxcaja">{{ __('Uds. x caja') }}</x-jet-label>
                <input  wire:model.lazy="producto.udxcaja" type="number" class="w-full py-2 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"/>
            </div>
            <div class="w-full form-item">
                <x-jet-label for="paginas">{{ __('Páginas') }}</x-jet-label>
                <input  wire:model.lazy="producto.paginas" type="number" class="w-full py-2 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"/>
            </div>
            <div class="w-full form-item">
                <x-jet-label for="tirada">{{ __('Tirada') }}</x-jet-label>
                <input  wire:model.lazy="producto.tirada" type="number" class="w-full py-2 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"/>
            </div>
            <div class="w-full form-item">
                <x-jet-label for="FSC">{{ __('FSC') }}</x-jet-label>
                <input  wire:model.lazy="producto.FSC" type="checkbox" class="w-full py-2 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"/>
            </div>
            <div class="w-full form-item">
                <x-jet-label for="solapa">{{ __('Solapas') }}</x-jet-label>
                <input  wire:model.lazy="producto.solapa" type="checkbox" class="w-full py-2 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"/>
            </div>
            <div class="w-full form-item">
                <x-jet-label for="descripsolapa">{{ __('Descripción Solapa') }}</x-jet-label>
                <input  wire:model.lazy="producto.descripsolapa" type="number" class="w-full py-2 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"/>
            </div>
            <div class="w-full form-item">
                <x-jet-label for="guardas">{{ __('Guardas') }}</x-jet-label>
                <input  wire:model.lazy="producto.guardas" type="checkbox" class="w-full py-2 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"/>
            </div>
            <div class="w-full form-item">
                <x-jet-label for="descripguardas">{{ __('Descripción guardas') }}</x-jet-label>
                <input  wire:model.lazy="producto.descripguardas" type="number" class="w-full py-2 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"/>
            </div>
            <div class="w-full form-item">
                <x-jet-label for="novedad">{{ __('Novedad') }}</x-jet-label>
                <input  wire:model.lazy="producto.novedad" type="checkbox" class="w-full py-2 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"/>
            </div>
            <div class="w-full form-item">
                <x-jet-label for="descripnovedad">{{ __('Descripción novedad') }}</x-jet-label>
                <input  wire:model.lazy="producto.descripnovedad" type="number" class="w-full py-2 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"/>
            </div>
            <div class="w-full form-item">
                <x-jet-label for="cd">{{ __('cd') }}</x-jet-label>
                <input  wire:model.lazy="producto.cd" type="checkbox" class="w-full py-2 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"/>
            </div>
            <div class="w-full form-item">
                <x-jet-label for="descripcd">{{ __('Descripción cd') }}</x-jet-label>
                <input  wire:model.lazy="producto.descripcd" type="number" class="w-full py-2 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"/>
            </div>
            <div class="w-full form-item">
                <x-jet-label for="especiflogistica">{{ __('Especificaciónes logísticas') }}</x-jet-label>
                <input  wire:model.lazy="producto.especiflogistica" type="number" class="w-full py-2 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"/>
            </div>
        </div>
    </div>

    <div class="p-2 m-2 ">
        <div class="flex flex-col mx-2 space-y-4 md:space-y-0 md:flex-row md:space-x-4">
            <div class="w-full form-item">
                <x-jet-label for="preciocoste">{{ __('€ Precio Compra') }}</x-jet-label>
                <input  wire:model.lazy="producto.preciocoste" type="number" step="any" class="w-full py-2 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"/>
            </div>
            <div class="w-full form-item">
                <x-jet-label for="precioventa">{{ __('€ Precio Venta') }}</x-jet-label>
                <input  wire:model.lazy="producto.precioventa" type="number" step="any" class="w-full py-2 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"/>
            </div>
        </div>

    </div>


    <div class="p-2 m-2 ">
        <div class="flex flex-col mx-2 space-y-4 md:space-y-0 md:flex-row md:space-x-4">
            <div class="w-full form-item">
                <x-jet-label for="observaciones">{{ __('Observaciones') }}</x-jet-label>
                <textarea wire:model.defer="producto.observaciones" class="w-full text-xs border-gray-300 rounded-md" rows="2">{{ old('observaciones') }} </textarea>
                <input-error for="observaciones" class="w-full text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" />
            </div>
        </div>
    </div>
    <div class="p-2 m-2 ">
        <div class="flex flex-col mx-2 space-y-4 md:space-y-0 md:flex-row md:space-x-4">
            <div class="w-full form-item">
                <x-jet-label for="ficheropdf">{{ __('Ficha producto') }}</x-jet-label>
                <div class="flex">
                    <input type="file" wire:model.lazy="ficheropdf">
                    @if($producto->fichaproducto)
                        <x-icon.pdf-a wire:click="presentaPDF({{ $producto }})" class="pt-2 ml-2" title="PDF"/>
                    @endif
                    @error('ficheropdf') <p class="text-red-500">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>
    </div>
    <div class="p-2 m-2 ">
        <div class="flex flex-col mx-2 space-y-4 md:space-y-0 md:flex-row md:space-x-4">
            <x-jet-button class="bg-blue-600">{{ __('Guardar') }}</x-jet-button>
            <x-jet-secondary-button  onclick="location.href = '{{route('producto.tipo','1')}}'">{{ __('Volver') }}</x-jet-secondary-button>
        </div>
    </div>
</form>
