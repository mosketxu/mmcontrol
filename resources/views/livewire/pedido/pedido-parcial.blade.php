<div class="">
    <div class="h-full p-1 mx-2">
        <div class="py-0 space-y-2">
            <div class="">
                @include('errores')
            </div>
            {{-- datos del parcial --}}
            <div class="flex m-2 p-2">
                <div class="w-full ">ALBARÁN NÚM.{{ $parcial->id }}</div>
                <div class="w-full ">Fecha: {{ $parcial->fecha }}</div>
                <div class="w-full ">Cantidad: {{ $parcial->cantidad }}</div>
                <div class="w-full ">Importe: {{ $parcial->importe }}</div>
                <div class="w-full ">Comentario: {{ $parcial->comentario }}</div>
            </div>
            <div class="border m-2 p-2">
                <div class="">
                    <p>CLIENTE: {{ $entidad->entidad }}</p>
                    <p>DOMICILIO: {{ $entidad->direccion }}</p>
                    <p>POBLACIÓN: {{ $entidad->localidad }} ({{$entidad->cp  }})</p>
                    <p>TEL./: {{ $entidad->telefono }}</p>
                    <p>PERSONA DE CONTACTO: {{ $pedido->contacto->entidad }}</p>
                </div>
                <div class="">
                    @livewire('pedido.pedidoparcial-detalle',['parcialid'=>$parcial->id])
                </div>
                <div class="">
                    <div class="">
                        <div class="flex">
                            <div class="ml-2 w-24">Enviar a: </div>
                            <x-select wire:model.lazy="destinocalculado" selectname="destino" class="w-4/12 my-0 py-0" >
                                <option value="">-- Selecciona un destino  --</option>
                                @foreach ($destinos as $destino)
                                <option value="{{ $destino->id }}">{{ $destino->destino }}</option>
                                @endforeach
                            </x-select>
                        </div>
                        <form wire:submit.prevent="save" class="text-sm">
                        <div class="ml-2">
                            <div class="flex">
                                <div class="mt-2 w-24"><label for="">Destino: </label></div>
                                <input type="text" wire:model="parcial.destino"
                                    class="w-4/12 py-1 my-0.5 text-sm font-thin text-left text-gray-500 border-gray-200 border-1 rounded-md"/>
                            </div>
                            <div class="flex">
                                <div class="mt-2 w-24"><label for="" >Atención:</label></div>
                                <input type="text" wire:model="parcial.atencion"
                                    class="w-4/12 py-1 my-0.5 text-sm font-thin text-left text-gray-500 border-gray-200 border-1 rounded-md"/>
                            </div>
                            <div class="flex">
                                <div class="mt-2 w-24"><label for="" >Dirección:</label></div>
                                <input type="text" wire:model="parcial.direccion"
                                    class="w-4/12 py-1 my-0.5 text-sm font-thin text-left text-gray-500 border-gray-200 border-1 rounded-md"/>
                            </div>
                            <div class="flex">
                                <div class="mt-2 w-24"><label for="" >Población:</label></div>
                                <input type="text" wire:model="parcial.localidad"
                                    class="w-4/12 py-1 my-0.5 text-sm font-thin text-left text-gray-500 border-gray-200 border-1 rounded-md"/>
                            </div>
                            <div class="flex">
                                <div class="mt-2 w-24"><label for="" >CP:</label></div>
                                <input type="text" wire:model="parcial.cp"
                                    class="w-4/12 py-1 my-0.5 text-sm font-thin text-left text-gray-500 border-gray-200 border-1 rounded-md"/>
                            </div>
                            <div class="flex">
                                <div class="mt-2 w-24"><label for="" >Horario:</label></div>
                                <input type="text" wire:model="parcial.horario"
                                    class="w-4/12 py-1 my-0.5 text-sm font-thin text-left text-gray-500 border-gray-200 border-1 rounded-md"/>
                            </div>
                            <div class="flex">
                                <div class="mt-2 w-24"><label for="" >Tfno.:</label></div>
                                <input type="text" wire:model="parcial.tfno"
                                    class="w-4/12 py-1 my-0.5 text-sm font-thin text-left text-gray-500 border-gray-200 border-1 rounded-md"/>
                            </div>
                            <div class="flex">
                                <div class="mt-2 w-24"><label for="" >Observaciones:</label></div>
                                <input type="text" wire:model="parcial.observaciones"
                                    class="w-4/12 py-1 my-0.5 text-sm font-thin text-left text-gray-500 border-gray-200 border-1 rounded-md"/>
                        </div>
                            </div>
                        <div class="p-2 m-2 ">
                            <div class="flex flex-col mx-2 space-y-4 md:space-y-0 md:flex-row md:space-x-4">
                                <x-jet-button class="bg-blue-600">{{ __('Guardar') }}</x-jet-button>
                                <x-jet-secondary-button  onclick="location.href = '{{route('pedido.tipo',$tipo)}}'">{{ __('Volver') }}</x-jet-secondary-button>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

