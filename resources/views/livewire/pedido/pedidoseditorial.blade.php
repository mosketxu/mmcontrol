<div class="">
    {{-- @livewire('menu',['entidad'=>$pedido],key($pedido->id)) --}}
    <div class="h-full py-1 mx-2">
        <div class="py-1 space-y-1">
            <div class="">
                @include('errores')
            </div>
            <div class="">
                @if($tipo=='1')
                    @include('pedidos.pedidoseditorialfilters')
                @else
                    {{-- @include('pedidos.pedidosotrosfilters') --}}
                @endif
            </div>
            {{-- tabla pedidos --}}
            <div class="flex-col space-y-4">
                <div>
                    <div class="">
                        {{-- titulos --}}
                        <div class="flex w-full pt-2 pb-0 pl-2 space-x-2 text-xs font-bold text-gray-500 bg-blue-100 rounded-t-md">
                            <div class="w-1/12 text-left" >{{ __('Pedido') }} <br>{{ __('Presup.')  }}</div>
                            <div class="w-2/12 text-left" >{{ __('Cliente') }}</div>
                            <div class="w-3/12 text-left" >{{ __('ISBN/Ref') }} </div>
                            <div class="w-2/12 text-center">{{ __('Fechas') }}</div>
                            <div class="w-1/12 text-center">{{ __('Q.Pre/Q.Real') }}</div>
                            <div class="w-10 text-center">{{ __('Est/Fac') }} </div>
                            <div class="w-2/12" ></div>
                        </div>
                    </div>
                    <div>
                        @forelse ($pedidos as $pedido)
                        @livewire('pedido.pedidos-pedido',['pedidoId'=>$pedido->id,'tipo'=>'1'],key($pedido->id))
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
                            <div class="flex-col w-2/12 text-left">{{ $pedido->cliente->entidad }}</div>
                            <div class="flex-col w-3/12 text-left">{{ $pedido->isbn }} {{ $pedido->referencia }}</div>
                            <div class="flex-col w-2/12 text-center bg-green-50">
                                <span class="font-bold"> Arc:</span>&nbsp;{{ $pedido->farchivos }} <span class="font-bold"> Plo:</span>&nbsp;{{ $pedido->fplotter }} <span class="font-bold"> Ent:</span>&nbsp;{{ $pedido->fentrega }}
                            </div>
                            <div class="flex-col w-1/12 mx-auto text-center bg-gray-50">
                                {{ $pedido->tiradaprevista }}/{{ $pedido->tiradareal }}
                            </div>
                            <div class="flex w-10 mx-auto text-center ">
                                <div class="" >
                                    @if($pedido->estado=='0')
                                        <x-icon.thumbs-up-a class="" title="En curso" wire:click="cambiaEstado({{ $pedido->id}})"/>
                                    @elseif($pedido->estado=='2')
                                        <x-icon.thumbs-down-a class="w-5 " title="Cancelado" wire:click="cambiaEstado({{ $pedido->id}})"/>
                                    @elseif($pedido->estado=='1')
                                        <x-icon.flag-checkered-a class="w-5 text-black hover:text-gray-700 " title="Finalizado" wire:click="cambiaEstado({{ $pedido->id}})"/>
                                    @endif
                                </div>
                            </div>
                            <div class="flex w-10 mx-auto text-center ">
                                <div class="">
                                    @if($pedido->facturado=='1')
                                        <x-icon.thumbs-up-a class="w-5 text-green-500 hover:text-green-700 "  title="Sí" wire:click="cambiaFac({{ $pedido->id}})"/>
                                    @elseif($pedido->facturado=='0')
                                        <x-icon.thumbs-down-a class="w-5 text-red-500 hover:text-red-700 " title="No" wire:click="cambiaFac({{ $pedido->id}})"/>
                                    @elseif($pedido->facturado=='2')
                                        <x-icon.p-a class="w-4 text-black hover:text-gray-700 " title="Parcial" wire:click="cambiaFac({{ $pedido->id}})"/>
                                    @endif
                                </div>
                            </div>
                            <div class="w-2/12 space-x-1 text-center lg:space-x-2">
                                <x-icon.edit-a class="" href="{{ route('pedido.editar',[$pedido,'i']) }}"  title="Editar"/>
                                <x-icon.truck-a class="w-5 text-pink-500 hover:text-pink-700 " onclick="location.href = '{{route('pedido.parciales',[$pedido->id,'i'])}}'" title="Albaranes"/>
                                <x-icon.building-circle-arrow-right-a class="w-5 text-gray-500 hover:text-gray-900 " onclick="location.href = '{{route('pedido.distribuciones',[$pedido->id,'i'])}}'" title="Distribuciones"/>
                                <x-icon.clip-a class="w-5 text-green-500 hover:text-green-700 " onclick="location.href = '{{route('pedido.archivos',[$pedido->id,'i'])}}'" title="Archivo"/>
                                <x-icon.triangleexclamation-a class="w-6 mb-1 text-yellow-500 hover:text-yellow-700 " onclick="location.href = '{{route('pedido.incidencias',[$pedido,'i'])}}'" title="Incidencias"/>
                                <x-icon.sandwatch-a class="w-4 text-orange-700 hover:text-orange-900 " onclick="location.href = '{{route('pedido.retrasos',[$pedido,'i'])}}'" title="Retrasos"/>
                                <x-icon.pdf-a class="text-red-500 hover:text-red-700" href="{{route('pedido.entrada',[$pedido,$tipo,'i'])}}" target="_blank"/>
                                <x-icon.delete-a class="w-6" wire:click.prevent="delete({{ $pedido->id }})" onclick="confirm('¿Estás seguro?') || event.stopImmediatePropagation()" />
                            </div>
                        </div> --}}
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
                    </div>
                </div>
            {{-- <div>
                {{ $pedidos->links() }}
            </div> --}}
        </div>
    </div>
</div>
