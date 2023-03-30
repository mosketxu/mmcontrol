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
                            <div class="w-1/12 flex"><div class="w-6/12 text-center">Q.Prev.</div><div class="w-6/12 text-center">Q.Real</div></div>
                            <div class="w-1/12 flex"><div class="w-6/12">Est</div><div class="w-6/12">Fac</div></div>
                            <div class="w-2/12" ></div>
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
                    </div>
                </div>
            {{-- <div>
                {{ $pedidos->links() }}
            </div> --}}
        </div>
    </div>
</div>
