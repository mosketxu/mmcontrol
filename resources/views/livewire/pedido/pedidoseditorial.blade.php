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
                            <div class="w-3/12 text-left" >{{ __('ISBN/Ref') }} </div>
                            <div class="w-4/12 text-center">{{ __('Fechas') }}</div>
                            <div class="flex w-2/12"><div class="w-6/12 text-center">Q.Prev.</div><div class="w-6/12 text-center">Q.Real</div></div>
                        </div>
                        <div class="w-3/12 pt-2 pb-0 space-x-2 text-xs font-bold text-gray-500 bg-blue-100 rounded-tr-md">
                            <div class="flex w-4/12">
                                <div class="w-6/12">Estado</div>
                                <div class="w-6/12">Facturado</div>
                            </div>
                            <div class="w-8/12" ></div>
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
    </div>
</div>
