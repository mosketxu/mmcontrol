<form wire:submit.prevent="save" class="text-sm">
    <div class="p-1 m-2 ">
        <div class="p-1 rounded-md bg-blue-50">
            <h3 class="pl-1 font-semibold">Datos generales</h3>
            <input  wire:model.defer="producto.id" type="hidden"/>
            <input  wire:model.defer="tipo" type="hidden"/>
        </div>
        <div class="flex flex-col mx-2 space-y-1 md:space-y-0 md:flex-row md:space-x-4">
            {{-- Cod/ref --}}
            <div class="w-full form-item sm:w-3/12">
                <x-jet-label for="isbn">{{ __('Cod.') }}</x-jet-label>
                <input wire:model.lazy="producto.isbn" type="text" class="w-full py-1 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                required autofocus {{$escliente}} {{$deshabilitado}}/>
            </div>
            {{-- Descripcion --}}
            <div class="w-full form-item sm:w-5/12">
                <x-jet-label for="referencia">{{ __('Referencia') }}</x-jet-label>
                <input wire:model.lazy="producto.referencia" type="text" class="w-full py-1 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                required {{$escliente}} {{$deshabilitado}}/>
            </div>
            {{-- cliente --}}
            <div class="w-full form-item sm:w-4/12">
                <x-jet-label for="entidad_id">{{ __('Cliente') }}</x-jet-label>
                <select wire:model.lazy="producto.cliente_id"
                    class="w-full py-1 text-xs text-gray-600 border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 "
                    {{$escliente}} {{$deshabilitado}}>
                    <option value=''>-- Selecciona cliente --</option>
                    @foreach ($clientes as $cliente)
                    <option value="{{ $cliente->id }}">{{ $cliente->entidad }}</option>
                    @endforeach
                </select>
            </div>
            {{-- estadoproducto --}}
            <div class="w-full form-item md:w-4/12">
                <x-jet-label for="entidad_id">{{ __('Estado') }}</x-jet-label>
                <select wire:model.lazy="producto.productoestado"
                    class="w-full py-1 text-xs text-gray-600 border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 "
                    {{$escliente}} {{$deshabilitado}} >
                    <option value=''>-- Selecciona Estado --</option>
                   @foreach($productosestado as $value => $label)
                        <option value="{{ $value }}"
                        {{ old('estadoproducto', $producto->estadoproducto?->value ?? '') == $value ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <div class="p-2 m-2 ">
        <div class="grid grid-cols-1 gap-2 md:grid-cols-3">
            {{-- Cajas --}}
            <div class="p-2 space-y-1 border border-blue-300 rounded shadow-md ">
                <div class="p-1 rounded-md bg-blue-50">
                    <h3 class="pl-1 font-semibold">Datos Caja</h3>
                </div>
                {{-- Caja --}}
                <div class="flex flex-row space-x-4">
                    <div class="w-full form-item">
                        <x-jet-label for="caja">{{ __('Caja') }}</x-jet-label>
                        <select wire:model.lazy="producto.caja_id"
                            class="w-full py-1 text-xs text-gray-600 border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 "
                            {{$escliente}} {{$deshabilitado}} >
                            <option value="">--Selecciona--</option>
                            @foreach($cajas as $caja)
                                <option value="{{ $caja->id }}">{{ $caja->name }}</option>
                            @endforeach
                        <select>
                    </div>
                    <div class="w-full form-item">
                        <x-jet-label for="medidas">{{ __('Medidas (LxAxH)') }}</x-jet-label>
                        <input  wire:model.lazy="producto.medidas" type="text" class="w-full py-1 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                        {{$escliente}} {{$deshabilitado}}/>
                    </div>
                </div>
                {{-- Caja --}}
                <div class="flex flex-row space-x-4">
                    <div class="w-full form-item">
                        <x-jet-label for="desarrollocaja">{{ __('Desarrollo') }}</x-jet-label>
                        <input  wire:model.lazy="producto.desarrollocaja" type="text" class="w-full py-1 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                        {{$escliente}} {{$deshabilitado}}/>
                    </div>
                    <div class="w-full form-item">
                        <x-jet-label for="material">{{ __('Material') }}</x-jet-label>
                        <input  wire:model.lazy="producto.material" type="text" class="w-full py-1 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                        {{$escliente}} {{$deshabilitado}}/>
                    </div>
                    <div class="w-full form-item">
                        <x-jet-label for="gramajecaja">{{ __('Gramaje') }}</x-jet-label>
                        <input  wire:model.lazy="producto.gramajecaja" type="text" class="w-full py-1 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                        {{$escliente}} {{$deshabilitado}}/>
                    </div>
                </div>
                <div class="flex flex-row space-x-4">
                    <div class="w-full form-item">
                        <x-jet-label for="impresion">{{ __('Impresión') }}</x-jet-label>
                        <input  wire:model.lazy="producto.impresion" type="text" class="w-full py-1 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                        {{$escliente}} {{$deshabilitado}}/>
                    </div>
                    <div class="w-full form-item">
                        <x-jet-label for="acabadocaja">{{ __('Acabado') }}</x-jet-label>
                        <input  wire:model.lazy="producto.acabadocaja" type="text" class="w-full py-1 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                        {{$escliente}} {{$deshabilitado}}/>
                    </div>

                </div>

            </div>
            {{-- Nido --}}
            <div class="p-2 space-y-1 border border-green-300 rounded shadow-md ">
                <div class="p-1 rounded-md bg-green-50">
                    <h3 class="pl-1 font-semibold">Nido</h3>
                </div>
                {{-- Medidas nido   --}}
                <div class="w-full form-item">
                    <x-jet-label for="medidasnido">{{ __('Medidas') }}</x-jet-label>
                        <input  wire:model.lazy="producto.medidasnido" type="text" class="w-full py-1 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                        {{$escliente}} {{$deshabilitado}}/>
                </div>
                {{-- Material nido --}}
                <div class="w-full form-item">
                    <x-jet-label for="materialnido">{{ __('Material') }}</x-jet-label>
                        <input  wire:model.lazy="producto.materialnido" type="text" class="w-full py-1 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                        {{$escliente}} {{$deshabilitado}}/>
                </div>
                {{-- Material nido --}}
                <div class="w-full form-item">
                    <x-jet-label for="impresionnido">{{ __('Impresión') }}</x-jet-label>
                        <input  wire:model.lazy="producto.impresionnido" type="text" class="w-full py-1 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                        {{$escliente}} {{$deshabilitado}}/>
                </div>
            </div>
            {{-- Otros --}}
            <div class="p-2 border border-yellow-300 rounded shadow-md ">
                <div class="p-1 rounded-md bg-yellow-50">
                    <h3 class="pl-1 font-semibold">Otros</h3>
                </div>
                <div class="w-full form-item">
                    <x-jet-label for="procesospack">{{ __('Procesos') }}</x-jet-label>
                        <textarea wire:model.defer="producto.procesospack" class="w-full text-xs border-gray-300 rounded-md" rows="3" {{$escliente}} {{$deshabilitado}}>>{{ old('procesospack') }} </textarea>
                        <input-error for="procesospack" class="w-full text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" />
                </div>
                <div class="w-full form-item">
                    <x-jet-label for="manipulacion">{{ __('Manipulación') }}</x-jet-label>
                    <textarea wire:model.defer="producto.manipulacion" class="w-full text-xs border-gray-300 rounded-md" rows="3" {{$escliente}} {{$deshabilitado}}>>{{ old('manipulacion') }} </textarea>
                    <input-error for="manipulacion" class="w-full text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" />
                </div>
            </div>
        </div>

        {{-- observaciones --}}
        <div class="w-full pt-2 form-item">
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
                    <x-jet-secondary-button  onclick="location.href = '{{route('producto.tipo','2')}}'">{{ __('Volver') }}</x-jet-secondary-button>
                @endif
            </div>
        </div>
</form>
