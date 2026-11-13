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
            {{-- idioma --}}
            <div class="w-1/10 form-item sm:w-2/12">
                <x-jet-label for="idioma_id">{{ __('Idioma') }}</x-jet-label>
                <x-combo wire:model="producto.idioma_id" :options="collect($idiomas)->map(fn($idioma)=>['id'=>$idioma->id,'label'=>($idioma->nombre)])->values()->all()" :disabled="(bool) ($escliente ?: $deshabilitado)" placeholder="-- Selecciona idioma --"/>
            </div>
            {{-- Descripcion --}}
            <div class="w-full form-item sm:w-4/12">
                <x-jet-label for="referencia">{{ __('Referencia') }}</x-jet-label>
                <input wire:model.lazy="producto.referencia" type="text" class="w-full py-1 text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                required {{$escliente}} {{$deshabilitado}}/>
            </div>
            {{-- cliente --}}
            <div class="w-full form-item sm:w-4/12">
                <x-jet-label for="entidad_id">{{ __('Cliente') }}</x-jet-label>
                <x-combo wire:model="producto.cliente_id" :options="$clientes->map(fn($i)=>['id'=>$i->id,'label'=>$i->entidad])->values()->all()" :disabled="(bool) ($escliente ?: $deshabilitado)" placeholder="-- Selecciona cliente --"/>
            </div>
            {{-- estadoproducto --}}
            <div class="w-full form-item md:w-4/12">
                <x-jet-label for="entidad_id">{{ __('Estado') }}</x-jet-label>
                <x-combo wire:model.lazy="producto.productoestado" :options="collect($productosestado)->except([''])->map(fn($l, $v)=>['id'=>$v,'label'=>$l])->values()->all()" placeholder="-- Selecciona Estado --" :disabled="(bool) ($escliente ?: $deshabilitado)" />
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
                        <x-combo wire:model.lazy="producto.caja_id" :options="collect($cajas)->map(fn($caja)=>['id'=>$caja->id,'label'=>($caja->name)])->values()->all()" placeholder="--Selecciona--" :disabled="(bool) ($escliente ?: $deshabilitado)" />
                    </div>
                    <div class="w-full form-item">
                        <x-jet-label for="medidas">{{ __('Medidas (LxAxH)') }}</x-jet-label>
                        <x-sugerido wire:model.defer="producto.medidas" :options="\App\Support\Sugerencias::de('campo:medidas')" :disabled="(bool) ($escliente ?: $deshabilitado)" />
                    </div>
                </div>
                {{-- Caja --}}
                <div class="flex flex-row space-x-4">
                    <div class="w-full form-item">
                        <x-jet-label for="desarrollocaja">{{ __('Desarrollo') }}</x-jet-label>
                        <x-sugerido wire:model.defer="producto.desarrollocaja" :options="\App\Support\Sugerencias::de('campo:desarrollocaja')" :disabled="(bool) ($escliente ?: $deshabilitado)" />
                    </div>
                    <div class="w-full form-item">
                        <x-jet-label for="material">{{ __('Material') }}</x-jet-label>
                        <x-sugerido wire:model.defer="producto.material" :options="\App\Support\Sugerencias::de('campo:material')" :disabled="(bool) ($escliente ?: $deshabilitado)" />
                    </div>
                    <div class="w-full form-item">
                        <x-jet-label for="gramajecaja">{{ __('Gramaje') }}</x-jet-label>
                        <x-sugerido wire:model.defer="producto.gramajecaja" :options="\App\Support\Sugerencias::de('campo:gramajecaja')" :disabled="(bool) ($escliente ?: $deshabilitado)" />
                    </div>
                </div>
                <div class="flex flex-row space-x-4">
                    <div class="w-full form-item">
                        <x-jet-label for="impresion">{{ __('Impresión') }}</x-jet-label>
                        <x-sugerido wire:model.defer="producto.impresion" :options="\App\Support\Sugerencias::de('campo:impresion')" :disabled="(bool) ($escliente ?: $deshabilitado)" />
                    </div>
                    <div class="w-full form-item">
                        <x-jet-label for="acabadocaja">{{ __('Acabado') }}</x-jet-label>
                        <x-sugerido wire:model.defer="producto.acabadocaja" :options="\App\Support\Sugerencias::de('campo:acabadocaja')" :disabled="(bool) ($escliente ?: $deshabilitado)" />
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
                        <x-sugerido wire:model.defer="producto.medidasnido" :options="\App\Support\Sugerencias::de('campo:medidasnido')" :disabled="(bool) ($escliente ?: $deshabilitado)" />
                </div>
                {{-- Material nido --}}
                <div class="w-full form-item">
                    <x-jet-label for="materialnido">{{ __('Material') }}</x-jet-label>
                        <x-sugerido wire:model.defer="producto.materialnido" :options="\App\Support\Sugerencias::de('campo:materialnido')" :disabled="(bool) ($escliente ?: $deshabilitado)" />
                </div>
                {{-- Material nido --}}
                <div class="w-full form-item">
                    <x-jet-label for="impresionnido">{{ __('Impresión') }}</x-jet-label>
                        <x-sugerido wire:model.defer="producto.impresionnido" :options="\App\Support\Sugerencias::de('campo:impresionnido')" :disabled="(bool) ($escliente ?: $deshabilitado)" />
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
                    <x-jet-secondary-button  onclick="volverLista('{{route('cliente.producto.tipo','1')}}')">{{ __('Volver') }}</x-jet-secondary-button>
                @else
                    <x-jet-button class="bg-blue-600">{{ __('Guardar') }}</x-jet-button>
                    {{-- <x-jet-secondary-button  onclick="history.back()">{{ __('Volver') }}</x-jet-secondary-button> --}}
                    <x-jet-secondary-button  onclick="volverLista('{{ $returnUrl }}')">{{ __('Volver') }}</x-jet-secondary-button>
                @endif
            </div>
        </div>
</form>
