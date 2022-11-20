<div class="">
    <div class="h-full p-1 mx-2">
        <div class="py-0 space-y-2">
            <div class="">
                @include('errores')
            </div>
            {{-- datos del parcial --}}
            <div class="grid grid-cols-4 gap-1 border m-2 p-2">
                <div class="">
                    <div class="w-full ">ALBARÁN NÚM.{{ $parcial->id }}</div>
                    <div class="w-full ">Fecha: {{ $parcial->fecha }}</div>
                    <div class="w-full ">Cantidad: {{ $parcial->cantidad }}</div>
                    <div class="w-full ">Importe: {{ $parcial->importe }}</div>
                    <div class="w-full ">Comentario: {{ $parcial->comentario }}</div>
                </div>
                <div class="">
                    <p>CLIENTE: {{ $entidad->entidad }}</p>
                    <p>DOMICILIO: {{ $entidad->direccion }}</p>
                    <p>POBLACIÓN: {{ $entidad->localidad }} ({{$entidad->cp  }})</p>
                    <p>TEL./: {{ $entidad->telefono }}</p>
                    <p>PERSONA DE CONTACTO: {{ $pedido->contacto->entidad }}</p>
                </div>
                <div class="col-span-2 text-sm text-gray-600">
                    <form wire:submit.prevent="save" class="">
                        <div class="flex">
                            <div class="flex w-full space-x-2 font-bold">
                                <label class="">Enviar a: </label>
                                <x-selectcolor wire:model.lazy="destinocalculado" selectname="destino" color="blue" class="w-8/12 " >
                                    <option value="">-- Selecciona un destino  --</option>
                                    @foreach ($destinos as $destino)
                                    <option value="{{ $destino->id }}">{{ $destino->destino }}</option>
                                    @endforeach
                                </x-selectcolor>
                            </div>
                        </div>
                        <div class="flex ">
                            <div class="flex w-full space-x-2">
                                <label class="" for="">Destino: </label>
                                <input type="text" wire:model="parcial.destino"
                                        class="w-full py-1 my-0.5 text-sm font-thin text-left text-gray-500 border-gray-200 border-1 rounded-md"/>
                            </div>
                            <div class="flex w-full space-x-2 ml-2">
                                <label class="" for="" >Atención:</label>
                                <input type="text" wire:model="parcial.atencion"
                                        class="w-full py-1 my-0.5 text-sm font-thin text-left text-gray-500 border-gray-200 border-1 rounded-md"/>
                            </div>
                        </div>
                        <div class="flex">
                            <div class="flex w-full space-x-2">
                                <label class="" for="">Dirección: </label>
                                <input type="text" wire:model="parcial.direccion"
                                class="w-full py-1 my-0.5 text-sm font-thin text-left text-gray-500 border-gray-200 border-1 rounded-md"/>
                            </div>
                        </div>
                        <div class="flex">
                            <div class="flex w-full space-x-2">
                                <label for="">Población: </label>
                                <input type="text" wire:model="parcial.localidad"
                                    class="w-full py-1 my-0.5 text-sm font-thin text-left text-gray-500 border-gray-200 border-1 rounded-md"/>
                            </div>
                            <div class="flex w-full space-x-2 ml-2">
                                <label for="" >Cod.Postal:</label>
                                <input type="text" wire:model="parcial.cp"
                                        class="w-full py-1 my-0.5 text-sm font-thin text-left text-gray-500 border-gray-200 border-1 rounded-md"/>
                            </div>
                        </div>
                        <div class="flex">
                            <div class="flex w-full space-x-2">
                                <label for="" >Horario:</label>
                                <input type="text" wire:model="parcial.horario"
                                    class="w-full py-1 my-0.5 text-sm font-thin text-left text-gray-500 border-gray-200 border-1 rounded-md"/>
                            </div>
                            <div class="flex w-full space-x-2 ml-2">
                                <label for="" >Tfno.:</label>
                                <input type="text" wire:model="parcial.tfno"
                                    class="w-full py-1 my-0.5 text-sm font-thin text-left text-gray-500 border-gray-200 border-1 rounded-md"/>
                            </div>
                        </div>
                        <div class="flex">
                            <div class="flex w-full space-x-2">
                                <label for="" >Observaciones:</label>
                                <input type="text" wire:model="parcial.observaciones"
                                    class="w-full py-1 my-0.5 text-sm font-thin text-left text-gray-500 border-gray-200 border-1 rounded-md"/>
                            </div>
                        </div>
                        <div class="flex">
                            <div class="flex w-full space-x-2 mt-2">
                                <x-jet-button class="bg-blue-600">{{ __('Guardar') }}</x-jet-button>
                                <x-jet-secondary-button  onclick="location.href = '{{route('pedido.parciales',[$pedido,$ruta])}}'">{{ __('Volver') }}</x-jet-secondary-button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            </div>
                <div class="">
                    @livewire('pedido.pedidoparcial-detalle',['parcialid'=>$parcial->id])
                </div>
            </div>
        </div>
    </div>
</div>

