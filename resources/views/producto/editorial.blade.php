<form wire:submit.prevent="save" class="text-sm">
    <div class="p-1 m-2 ">
        <div class="p-1 rounded-md bg-blue-50">
            <h3 class="pl-1 font-semibold">Datos generales</h3>
            <input  wire:model.defer="producto.id" type="hidden"/>
            <input  wire:model.defer="tipo" type="hidden"/>
        </div>
        <div class="flex flex-col mx-2 space-y-1 md:space-y-0 md:flex-row md:space-x-4">
            {{-- isbn --}}
            <div class="w-full form-item md:w-3/12">
                <x-jet-label for="isbn">{{ __('ISBN') }}</x-jet-label>
                <input wire:model.lazy="producto.isbn" type="text" class="w-full py-1 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                {{$escliente}} {{$deshabilitado}}/>
            </div>
            {{-- titulo --}}
            <div class="w-full form-item md:w-5/12">
                <x-jet-label for="referencia">{{ __('Título') }}</x-jet-label>
                <input wire:model.lazy="producto.referencia" type="text" class="w-full py-1 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" autofocus
                {{$escliente}} {{$deshabilitado}}/>
            </div>
            {{-- cliente --}}
            <div class="w-full form-item md:w-4/12">
                <x-jet-label for="entidad_id">{{ __('Cliente') }}</x-jet-label>
                <select wire:model.lazy="producto.cliente_id"
                    class="w-full py-1 text-xs text-gray-600 border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 "
                    {{$escliente}} {{$deshabilitado}} >
                    <option value=''>-- Selecciona cliente --</option>
                    @foreach ($clientes as $cliente)
                    <option value="{{ $cliente->id }}">{{ $cliente->entidad }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="p-2 m-2 ">
        <div class="grid grid-cols-1 gap-2 md:grid-cols-3">
            <div class="p-2 border border-blue-300 rounded shadow-md ">
                <div class="p-1 rounded-md bg-blue-50">
                    <h3 class="pl-1 font-semibold">Datos Técnicos</h3>
                </div>
                {{-- formatos --}}
                <div class="w-full form-item">
                    <x-jet-label for="formato">{{ __('Formato') }}</x-jet-label>
                        <select wire:model.lazy="producto.formato"
                        class="w-full py-1 text-xs text-gray-600 border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 "
                            {{$escliente}} {{$deshabilitado}} >
                            <option value="">--Selecciona--</option>
                            @foreach($formatos as $item)
                                <option value="{{ $item->name }}">{{ $item->name }}{{ $item->descripcion }}</option>
                            @endforeach
                        <select>
                </div>
                {{-- Encuadernación --}}
                <div class="w-full form-item">
                    <x-jet-label for="encuadernado">{{ __('Encuadernación') }}</x-jet-label>
                        <select wire:model.lazy="producto.encuadernado"
                            class="w-full py-1 text-xs text-gray-600 border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 "
                            {{$escliente}} {{$deshabilitado}} >
                            <option value="">--Selecciona--</option>
                            @foreach($encuadernaciones as $item)
                                <option value="{{ $item->name }}">{{ $item->name }}{{ $item->descripcion }}</option>
                            @endforeach
                        </select>
                </div>
                {{-- plastificado --}}
                <div class="w-full form-item">
                    <x-jet-label for="plastificado">{{ __('Plastificado') }}</x-jet-label>
                    <select wire:model.lazy="producto.plastificado"
                        class="w-full py-1 text-xs text-gray-600 border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 "
                        {{$escliente}} {{$deshabilitado}} >
                        <option value="">--Selecciona--</option>
                        @foreach($plastificados as $item)
                            <option value="{{ $item->name }}">{{ $item->name }}{{ $item->descripcion }}</option>
                        @endforeach
                    <select>
                </div>
                {{-- varios --}}
                <div class="flex flex-row space-x-4">
                    <div class="w-full form-item">
                        <x-jet-label for="paginas">{{ __('Páginas') }}</x-jet-label>
                        <input  wire:model.lazy="producto.paginas" type="text" class="w-full py-1 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                        {{$escliente}} {{$deshabilitado}}/>
                    </div>
                    <div class="w-full form-item">
                        <x-jet-label for="tipoimpresion">{{ __('Tipo Impresion') }}</x-jet-label>
                        <select wire:model.lazy="producto.tipoimpresion"
                            class="w-full py-1 text-xs text-gray-600 border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 "
                            {{$escliente}} {{$deshabilitado}} >
                            <option value="">--Selecciona--</option>
                            <option value="Estandár">Estandár</option>
                            <option value="Premium">Premium</option>
                        <select>
                    </div>

                    <div class="form-item">
                        <x-jet-label for="FSC">{{ __('FSC') }}</x-jet-label>
                        <input type="checkbox" wire:model.lazy="producto.FSC"
                        {{$escliente}} {{$deshabilitado}}/>
                    </div>
                </div>
                {{-- Novedad --}}
                <div class="flex flex-row">
                    <div class="form-item">
                        <x-jet-label for="novedad">{{ __('Novedad') }}</x-jet-label>
                        <input type="checkbox" wire:model.lazy="producto.novedad"
                        {{$escliente}} {{$deshabilitado}}/>
                    </div>
                    <div class="w-full form-item">
                        <x-jet-label for="descripnovedad">{{ __('Descripción novedad') }}</x-jet-label>
                        <input  wire:model.lazy="producto.descripnovedad" type="text" class="w-full py-1 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                        {{$escliente}} {{$deshabilitado}}/>
                    </div>
                </div>
            </div>
            {{-- Interiores --}}
            <div class="p-2 border border-green-300 rounded shadow-md ">
                <div class="p-1 rounded-md bg-green-50">
                    <h3 class="pl-1 font-semibold">Interiores</h3>
                </div>
                {{-- gramaje interior   --}}
                <div class="w-full form-item">
                    <x-jet-label for="gramajeinterior">{{ __('Gramaje Interior') }}</x-jet-label>
                    <select wire:model.lazy="producto.gramajeinterior"
                        class="w-full py-1 text-xs text-gray-600 border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 "
                        {{$escliente}} {{$deshabilitado}} >
                        <option value="">--Selecciona--</option>
                        @foreach($gramajesinterior as $item)
                            <option value="{{ $item->name }}">{{ $item->name }}{{ $item->descripcion }}</option>
                        @endforeach
                    </select>
                </div>
                {{-- tinta interior --}}
                <div class="w-full form-item">
                    <x-jet-label for="tintainterior">{{ __('Tinta Interior') }}</x-jet-label>
                    <select wire:model.lazy="producto.tintainterior"
                        class="w-full py-1 text-xs text-gray-600 border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 "
                        {{$escliente}} {{$deshabilitado}} >
                        <option value="">--Selecciona--</option>
                        @foreach($tintasinterior as $item)
                            <option value="{{ $item->name }}">{{ $item->name }}{{ $item->descripcion }}</option>
                        @endforeach
                    </select>
                </div>
                {{-- Material interior  --}}
                <div class="w-full form-item">
                    <x-jet-label for="materialinterior">{{ __('Material Interior') }}</x-jet-label>
                    <select wire:model.lazy="producto.materialinterior"
                        class="w-full py-1 text-xs text-gray-600 border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 "
                        {{$escliente}} {{$deshabilitado}}/>
                        <option value="">--Selecciona--</option>
                        @foreach($materialesinterior as $item)
                            <option value="{{ $item->name }}">{{ $item->name }}{{ $item->descripcion }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex flex-row space-x-4">
                    <div class="form-item">
                        <x-jet-label for="guardas">{{ __('Guardas') }}</x-jet-label>
                        <input type="checkbox" wire:model.lazy="producto.guardas" {{$escliente}} {{$deshabilitado}}/>
                    </div>
                    <div class="w-full form-item">
                        <x-jet-label for="descripguardas">{{ __('Descripción guardas') }}</x-jet-label>
                        <input wire:model.lazy="producto.descripguardas" type="text" class="w-full py-1 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" {{$escliente}} {{$deshabilitado}}/>
                    </div>
                </div>
                <div class="flex flex-row space-x-4">
                    <div class="form-item">
                        <x-jet-label for="cd">{{ __('CD') }}</x-jet-label>
                        <input type="checkbox" wire:model.lazy="producto.cd" {{$escliente}} {{$deshabilitado}}/>
                    </div>
                    <div class="w-full form-item">
                        <x-jet-label for="descripcd">{{ __('Descripción cd') }}</x-jet-label>
                        <input wire:model.lazy="producto.descripcd" type="text" class="w-full py-1 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" {{$escliente}} {{$deshabilitado}}/>
                    </div>
                </div>
            </div>
            {{-- Cubiertas --}}
            <div class="p-2 border border-yellow-300 rounded shadow-md ">
                <div class="p-1 rounded-md bg-yellow-50">
                    <h3 class="pl-1 font-semibold">Cubiertas</h3>
                </div>
                {{-- Gramaje Cubierta --}}
                <div class="w-full form-item">
                    <x-jet-label for="gramajecubierta">{{ __('Gramaje Cubierta') }}</x-jet-label>
                    <select wire:model.lazy="producto.gramajecubierta"
                        class="w-full py-1 text-xs text-gray-600 border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 "
                        {{$escliente}} {{$deshabilitado}}/>
                        <option value="">--Selecciona--</option>
                        @foreach($gramajescubierta as $item)
                            <option value="{{ $item->name }}">{{ $item->name }}{{ $item->descripcion }}</option>
                        @endforeach
                    </select>
                </div>
                {{-- Tinta Cubierta --}}
                <div class="w-full form-item">
                    <x-jet-label for="tintacubierta">{{ __('Tinta Cubierta') }}</x-jet-label>
                    <select wire:model.lazy="producto.tintacubierta"
                        class="w-full py-1 text-xs text-gray-600 border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 "
                        {{$escliente}} {{$deshabilitado}} >
                        <option value="">--Selecciona--</option>
                        @foreach($tintascubierta as $item)
                            <option value="{{ $item->name }}">{{ $item->name }}{{ $item->descripcion }}</option>
                        @endforeach
                    </select>
                </div>
                {{-- Material Cubierta --}}
                <div class="w-full form-item">
                    <x-jet-label for="materialcubierta">{{ __('Material Cubierta') }}</x-jet-label>
                    <select wire:model.lazy="producto.materialcubierta"
                        class="w-full py-1 text-xs text-gray-600 border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 "
                        {{$escliente}} {{$deshabilitado}} >
                        <option value="">--Selecciona--</option>
                        @foreach($materialescubierta as $item)
                            <option value="{{ $item->name }}">{{ $item->name }}{{ $item->descripcion }}</option>
                        @endforeach
                    </select>
                </div>
                {{-- Solapas --}}
                <div class="flex flex-row space-x-4">
                    <div class="form-item">
                        <x-jet-label for="solapa">{{ __('Solapas') }}</x-jet-label>
                        <input type="checkbox" wire:model.lazy="producto.solapa" {{$escliente}} {{$deshabilitado}}/>
                    </div>
                    <div class="w-full form-item">
                        <x-jet-label for="descripsolapa">{{ __('Descripción Solapa') }}</x-jet-label>
                        <input  wire:model.lazy="producto.descripsolapa" type="text" class="w-full py-1 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" {{$escliente}} {{$deshabilitado}}/>
                    </div>
                </div>
            </div>
        </div>
    </div>
        <div class="flex flex-col mx-2 space-y-2 md:space-y-0 md:flex-row md:space-x-4">
            {{-- cajas --}}
            <div class="w-full form-item md:w-2/12">
                <x-jet-label for="caja">{{ __('Caja') }}</x-jet-label>
                    <select wire:model.lazy="producto.caja_id"
                        class="w-full py-1 text-xs text-gray-600 border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 "
                        {{$escliente}} {{$deshabilitado}} >
                        <option value="">--Selecciona--</option>
                        @foreach($cajas as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}{{ $item->descripcion }}</option>
                        @endforeach
                    </select>
            </div>
            {{-- etiqueta --}}
            <div class="w-full form-item md:w-1/12 ">
                <x-jet-label for="etiqueta">{{ __('Etiqueta') }}</x-jet-label>
                <input  wire:model.lazy="producto.etiqueta" type="text" class="w-full py-1 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" {{$escliente}} {{$deshabilitado}}/>
            </div>
            <div class="w-full form-item md:w-1/12 ">
                <x-jet-label for="udxcaja">{{ __('Uds. x caja') }}</x-jet-label>
                <input  wire:model.lazy="producto.udxcaja" type="number" class="w-full py-1 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" {{$escliente}} {{$deshabilitado}}/>
            </div>
            {{-- observaciones --}}
            <div class="w-full form-item md:w-8/12">
                <x-jet-label for="observaciones">{{ __('Observaciones') }}</x-jet-label>
                <textarea wire:model.defer="producto.observaciones" class="w-full text-xs border-gray-300 rounded-md" rows="2" {{$escliente}} {{$deshabilitado}}>>{{ old('observaciones') }} </textarea>
                <input-error for="observaciones" class="w-full text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" />
            </div>
        </div>
        <div class="py-1 my-0 ">
            <div class="flex flex-col mx-2 md:space-y-0 md:flex-row md:space-x-4">
                @if(Auth::user()->hasRole('Cliente'))
                    {{-- <x-jet-secondary-button  onclick="history.back()">{{ __('Volver') }}</x-jet-secondary-button> --}}
                    <x-jet-secondary-button  onclick="location.href = '{{route('cliente.producto.tipo','1')}}'">{{ __('Volver') }}</x-jet-secondary-button>
                @else
                    <x-jet-button class="bg-blue-600">{{ __('Guardar') }}</x-jet-button>
                    {{-- <x-jet-secondary-button  onclick="history.back()">{{ __('Volver') }}</x-jet-secondary-button> --}}
                    <x-jet-secondary-button  onclick="location.href = '{{route('producto.tipo','1')}}'">{{ __('Volver') }}</x-jet-secondary-button>
                @endif
            </div>
        </div>
    </div>
</form>
