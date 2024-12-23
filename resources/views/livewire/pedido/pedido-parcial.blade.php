<div class="">
    <div class="h-full p-1 mx-2">
        <div class="py-0 space-y-2">
            <div class="">
                @include('errores')
            </div>
            {{-- datos del parcial --}}
            <div class="grid grid-cols-3 gap-1 p-2 m-2 border">
                <div class="">
                    <div class="w-full ">Nº Albarán: {{ $parcial->id }}</div>
                    <div class="w-full ">Fecha: {{ $parcial->fecha }}</div>
                    <div class="w-full ">Cliente: {{ $entidad->entidad }}</div>
                    <div class="w-full ">Comentario: {{ $parcial->comentario }}</div>
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
                            <div class="flex w-full ml-2 space-x-2">
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
                            <div class="flex w-full ml-2 space-x-2">
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
                            <div class="flex w-full ml-2 space-x-2">
                                <label for="" >Tfno.:</label>
                                <input type="text" wire:model="parcial.tfno"
                                    class="w-full py-1 my-0.5 text-sm font-thin text-left text-gray-500 border-gray-200 border-1 rounded-md"/>
                            </div>
                        </div>
                        <div class="flex">
                            <div class="flex w-full space-x-2">
                                <label for="" >Observaciones:</label>
                                <textarea wire:model="parcial.observaciones" rows="1"
                                class="w-full py-1 my-0.5 text-sm font-thin text-left text-gray-500 border-gray-200 border-1 rounded-md"></textarea>
                            </div>
                        </div>
                        <div class="flex">
                            <div class="flex w-full mt-2 space-x-2">
                                <x-jet-button class="bg-blue-600">{{ __('Guardar') }}</x-jet-button>
                                {{-- <x-jet-secondary-button  onclick="history.back()">{{ __('Volver') }}</x-jet-secondary-button> --}}
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

