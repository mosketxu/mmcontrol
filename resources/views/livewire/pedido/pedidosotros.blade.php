<div class="">
    <div class="h-full py-1 mx-2">
        <div class="py-1 space-y-1">
            <div class="">
                @include('errores')
            </div>
            <div class="">
                @include('pedidos.pedidoseditorialfilters')
            </div>
            {{-- tabla pedidos --}}
            <div class="flex-col space-y-4">
                <div>
                    <div class="flex">
                        <div class="flex w-9/12 pt-2 pb-0 pl-2 space-x-2 text-xs font-bold text-gray-500 bg-blue-100 rounded-tl-md">
                            <div class="w-1/12 text-left" >{{ __('Pedido') }} <br>{{ __('Presup.')  }}</div>
                            <div class="w-2/12 text-left" >{{ __('Cliente') }}</div>
                            <div class="w-3/12 text-left" >{{ __('Descripción') }}</div>
                            <div class="w-4/12 text-center">{{ __('Fechas') }}</div>
                            <div class="flex w-2/12"><div class="w-6/12 text-center">Q.Prev.</div><div class="w-6/12 text-center">Q.Real</div></div>
                        </div>
                        <div class="w-3/12 pt-2 pb-0 space-x-2 text-xs font-bold text-gray-500 bg-blue-100 rounded-tr-md">
                            <div class="flex w-3/12">
                                <div class="w-6/12">Estado</div>
                                <div class="w-6/12">Facturado</div>
                            </div>
                            <div class="w-9/12" ></div>
                            </div>
                        </div>
                    <div>
                    @forelse ($pedidos as $pedido)
                        @livewire('pedido.pedidos-pedido',['pedidoId'=>$pedido->id,'tipo'=>'1'],key($pedido->id))
                    @empty
                        <div class="flex w-full text-sm text-left border-t-0 border-y" wire:loading.class.delay="opacity-50">
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
                        {{-- <div class="flex items-center w-full space-x-2 text-xs text-gray-500 border-t-0 border-y hover:bg-gray-100 " wire:loading.class.delay="opacity-50">
                            <div class="flex-col w-1/12 text-left">
                                <div class="pl-2">
                                    <div class="">
                                        {{ $pedido->id }}
                                    </div>
                                    @if($pedido->presupuesto_id)
                                        <div class="">
                                            <a class="text-blue-700 underline" href="{{ route('presupuesto.editar',[$pedido->presupuesto_id,'i']) }}"  title="Pedido">{{ $pedido->presupuesto_id }}</a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="flex-col w-1/12 text-left">{{ $pedido->cliente->entidad }}</div>
                            <div class="flex-col w-2/12 text-left">{{ $pedido->descripcion }}</div>
                            <div class="flex-col w-2/12 text-center bg-green-50">
                                <div class="flex"><div class="w-6/12 text-left">Archivos:</div><div class="w-6/12 text-right">{{ $pedido->farchivos }}</div></div>
                                <div class="flex"><div class="w-6/12 text-left">Plotter:</div><div class="w-6/12 text-right">{{ $pedido->fplotter }}</div></div>
                                <div class="flex"><div class="w-6/12 text-left">Entrega:</div><div class="w-6/12 text-right">{{ $pedido->fentrega }}</div></div>
                            </div>
                            <div class="flex-col w-2/12 bg-gray-50">
                                <div class="flex">
                                    <div class="w-6/12 text-left">Pre:</div>
                                    <div class="w-6/12 text-right">{{ $pedido->tiradaprevista }}</div>
                                </div>
                                <div class="flex">
                                    <div class="w-6/12 text-left">Re:</div>
                                    <div class="w-6/12 text-right">{{ $pedido->tiradareal }}</div></div>
                            </div>
                            <div class="flex-col w-2/12 text-center bg-blue-50">
                                <div class="{{ $pedido->status[0] }}">
                                    {{ $pedido->status[1] }}
                                </div>
                                <div class="{{ $pedido->factu[0] }}">
                                    {{ $pedido->factu[1] }}
                                </div>
                            </div>
                            <div class="w-2/12 space-x-1 text-center lg:space-x-2">
                                <x-icon.edit-a class="" href="{{ route('pedido.editar',[$pedido,'i']) }}"  title="Editar"/>
                                <x-icon.truck-a class="w-5 text-pink-500 hover:text-pink-700 " onclick="location.href = '{{route('pedido.parciales',[$pedido->id,'i'])}}'" title="Albaranes"/>
                                <x-icon.building-circle-arrow-right-a class="w-5 text-gray-500 hover:text-gray-900 " onclick="location.href = '{{route('pedido.distribuciones',[$pedido->id,'i'])}}'" title="Distribuciones"/>
                                <x-icon.clip-a class="w-5 text-green-500 hover:text-green-700 " onclick="location.href = '{{route('pedido.archivos',[$pedido->id,'i'])}}'" title="Archivo"/>
                                <x-icon.triangleexclamation-a class="w-6 text-yellow-500 hover:text-yellow-700 " onclick="location.href = '{{route('pedido.incidencias',[$pedido,'i'])}}'" title="Incidencias"/>
                                <x-icon.sandwatch-a class="w-4 text-orange-700 hover:text-orange-900 " onclick="location.href = '{{route('pedido.retrasos',[$pedido,'i'])}}'" title="Retrasos"/>
                                <x-icon.pdf-a class="w-5 text-red-500 hover:text-red-700 " href="{{route('pedido.entrada',[$pedido,$tipo,'i'])}}" target="_blank" />
                                <x-icon.delete-a class="w-6" wire:click.prevent="delete({{ $pedido->id }})" onclick="confirm('¿Estás seguro?') || event.stopImmediatePropagation()"/>
                            </div>
                        </div>
                        @empty
                        <div class="flex w-full text-sm text-left border-t-0 border-y" wire:loading.class.delay="opacity-50">
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
                    </div> --}}
                </div>
            {{-- <div>
                {{ $pedidos->links() }}
            </div> --}}
        </div>
    </div>
</div>
