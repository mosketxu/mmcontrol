<div class="">
    <div class="p-1 mx-2 ">
        <div class="flex justify-between space-x-1">
            <div class="flex w-3/12 py-0 mt-0">
                <div class="w-full py-0 mt-0">
                    <h1 class="text-2xl font-semibold text-gray-900"> Subpedidos del Pedido: {{ $pedidoid }}</h1>
                </div>
            </div>
            <div class="flex flex-row-reverse w-9/12 ">
                <div class="flex">
                    <input type="text" wire:model="search" class="w-full py-1 text-sm border border-blue-100 rounded-lg" placeholder="Búsqueda" autofocus/>
                    @if($search!='')
                    <x-icon.filter-slash-a wire:click="$set('search', '')" class="pb-1" title="reset filter"/>
                    @endif
                </div>
                <div class="flex ">
                        @include('pedidos.pedidoeditorial-menu' )
                </div>
            </div>
        </div>
        <div class="py-1 space-y-4">
            <div class="">
                @include('errores')
            </div>
            {{-- cuerpo --}}
            <div class="flex-col ">
                {{-- titulos --}}
                    <div class="flex pt-1 pb-0 text-sm text-left text-gray-500 bg-blue-100 rounded-t-md">
                        <div class="flex-col w-2/12 text-left">
                            <input type="text" value="Referencia/ISBN" class="w-full text-sm font-thin text-gray-500 bg-blue-100 border-none" readonly />
                        </div>
                        <div class="flex-col w-1/12 ">
                            <input type="text" value="Unidades" class="w-full text-sm font-thin text-gray-500 bg-blue-100 border-none" readonly />
                        </div>
                        <div class="flex-col w-2/12 text-left">
                            <input type="text" value="Otros" class="w-full text-sm font-thin text-gray-500 bg-blue-100 border-none" readonly />
                        </div>
                        <div class="flex-col w-2/12 text-left">
                            <input type="text" value="F.Archivos" class="w-full text-sm font-thin text-gray-500 bg-blue-100 border-none" readonly />
                        </div>
                        <div class="flex-col w-2/12 text-left">
                            <input type="text" value="F.Plotters" class="w-full text-sm font-thin text-gray-500 bg-blue-100 border-none" readonly />
                        </div>
                        <div class="flex-col w-2/12 text-left">
                            <input type="text" value="F.Entrega" class="w-full text-sm font-thin text-gray-500 bg-blue-100 border-none" readonly />
                        </div>
                        <div class="flex flex-row-reverse w-1/12 pr-2 mt-2">
                            <p></p>
                        </div>
                    </div>
                </div>
                {{-- datos --}}
                <div>
                    @forelse ($subpedidos as $subpedido)
                    <div class="flex w-full py-0 my-0 space-x-1 text-sm text-left bg-white border-t-0 border-y" wire:loading.class.delay="opacity-50">
                        <div class="flex-col w-2/12 text-left">
                            <input type="text" value="{{ $subpedido->referencia }}"
                                wire:change="changeCampo({{ $subpedido }},'referencia',$event.target.value)"
                                class="w-full text-sm font-thin text-gray-500 border-0 rounded-md"
                                {{$escliente}}/>
                        </div>
                        <div class="flex-col w-1/12 text-left">
                            <input type="number" value="{{ $subpedido->unidades }}"
                                wire:change="changeCampo({{ $subpedido }},'unidades',$event.target.value)"
                                class="w-full text-sm font-thin text-gray-500 border-0 rounded-md"
                                {{$escliente}}/>
                        </div>
                        <div class="flex-col w-2/12 text-left">
                            <input type="text" value="{{ $subpedido->otros }}"
                                wire:change="changeCampo({{ $subpedido }},'otros',$event.target.value)"
                                class="w-full text-sm font-thin text-gray-500 border-0 rounded-md"
                                {{$escliente}}/>
                        </div>
                        <div class="flex-col w-2/12 text-left">
                            <input type="date" value="{{ $subpedido->fecha_archivos }}"
                                wire:change="changeCampo({{ $subpedido }},'fecha_archivos',$event.target.value)"
                                class="w-full text-sm font-thin text-gray-500 border-0 rounded-md"
                                {{$escliente}}/>
                        </div>
                        <div class="flex-col w-2/12 text-left">
                            <input type="date" value="{{ $subpedido->fecha_plotters }}"
                                wire:change="changeCampo({{ $subpedido }},'fecha_plotters',$event.target.value)"
                                class="w-full text-sm font-thin text-gray-500 border-0 rounded-md"
                                {{$escliente}}/>
                        </div>
                        <div class="flex-col w-2/12 text-left">
                            <input type="date" value="{{ $subpedido->fecha_entrega }}"
                                wire:change="changeCampo({{ $subpedido }},'fecha_entrega',$event.target.value)"
                                class="w-full text-sm font-thin text-gray-500 border-0 rounded-md"
                                {{$escliente}}/>
                        </div>
                        <div class="flex flex-row-reverse w-1/12 pr-2 mt-2">
                            @if(!Auth::user()->hasRole('Cliente'))
                                <x-icon.delete-a wire:click.prevent="delete({{ $subpedido->id }})" onclick="confirm('¿Estás seguro?') || event.stopImmediatePropagation()" class="w-6 mx-1"  title="Eliminar subpedido"/>
                            @endif
                            @if(!Auth::user()->hasRole('Cliente'))
                                @if($editarvisible=='1')
                                    <x-icon.edit-a wire:click="editar({{ $subpedido->id }})" class="mx-1"  title="Editar {{ $titulo }}"/>
                                @endif
                            @endif
                        </div>
                    </div>
                    @empty
                            <div>
                                <div colspan="10">
                                    <div class="flex items-center justify-center">
                                        <x-icon.inbox class="w-8 h-8 text-gray-300"/>
                                        <span class="py-5 text-xl font-medium text-gray-500">
                                            No se han encontrado datos...
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @endforelse
                </div>
                <div>
                    @if(!Auth::user()->hasRole('Cliente'))
                    <form wire:submit.prevent="save">
                        <div class="flex w-full p-2 my-0 text-sm text-left bg-blue-200 rounded-b-md" wire:loading.class.delay="opacity-50">
                            <div class="flex-col w-1/12">
                                <input type="text" step="any" wire:model.defer="referencia"
                                    class="w-full text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"/>
                            </div>
                            <div class="flex-col w-2/12">
                                <input type="number" wire:model.defer="unidades"
                                    class="w-full text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"/>
                            </div>
                            <div class="flex-col w-2/12">
                                <input type="text" step="any" wire:model.defer="otros"
                                    class="w-full text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"/>
                            </div>
                            <div class="flex-col w-2/12 text-left">
                                <input type="date" wire:model.defer="fecha_archivos"
                                class="w-full text-xs text-left border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"/>
                            </div>
                            <div class="flex-col w-2/12 text-left">
                                <input type="date" wire:model.defer="fecha_plotters"
                                class="w-full text-xs text-left border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"/>
                            </div>
                            <div class="flex-col w-2/12 text-left">
                                <input type="date" wire:model.defer="fecha_entrega"
                                class="w-full text-xs text-left border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"/>
                            </div>
                            <div class="flex-col w-1/12 text-right">
                                <button type="submit" class="items-center pl-1 mx-0 mt-2 text-center w-7 "><x-icon.save-a class="text-blue"></x-icon.save-a></button>
                            </div>
                        </div>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="m-2">
        {{-- <x-jet-secondary-button  onclick="history.back()">{{ __('Volver') }}</x-jet-secondary-button> --}}
        @if(!Auth::user()->hasRole('Cliente'))
            @if($ruta=='i')
                <x-jet-secondary-button  onclick="location.href = '{{route('pedido.tipo',[$tipo,$ruta])}}'">{{ __('Volver') }} </x-jet-secondary-button>
            @else
                <x-jet-secondary-button  onclick="location.href = '{{route('pedido.editar',[$pedidoid,$ruta])}}'">{{ __('Volver') }} </x-jet-secondary-button>
            @endif
        @else
            @if($ruta=='i')
                <x-jet-secondary-button  onclick="location.href = '{{route('cliente.pedido.tipo',[$tipo,$ruta])}}'">{{ __('Volver') }} </x-jet-secondary-button>
            @else
                <x-jet-secondary-button  onclick="location.href = '{{route('cliente.pedido.editar',[$pedidoid,$ruta])}}'">{{ __('Volver') }} </x-jet-secondary-button>
            @endif
        @endif
    </div>
</div>
