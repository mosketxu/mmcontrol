<div class="">
    <div class="h-full py-1 mx-2">
        <div class="py-1 space-y-1">
            <div class="">
                @include('errores')
            </div>
            <div class="">
                @if($tipo='1')
                    @include('pedidos.pedidoseditorialfilters')
                @else
                    @include('pedidos.pedidosotrosfilters')
                @endif
            </div>
            {{-- tabla pedidos --}}
            <div class="flex-col space-y-4">
                <div>
                    <div class="flex">
                        <div class="flex w-6/12 pt-2 pb-0 pl-2 space-x-2 text-xs font-bold text-gray-500 bg-blue-100 rounded-tl-md">
                            <div class="w-2/12 text-left md:w-1/12" >{{ __('Pedido') }} <br>{{ __('Presup.')  }}</div>
                            <div class="w-3/12 text-left md:w-2/12" >{{ __('Cliente') }}</div>
                            <div class="w-4/12 text-left md:w-6/12" >{{ $tipo=='1' ? 'ISBN/Ref' : 'Descripción'  }}</div>
                            <div class="flex-none w-2/12 md:flex">
                                <div class="w-full text-center md:w-6/12">Q.Prev.</div>
                                <div class="w-full text-center md:w-6/12">Q.Real</div>
                            </div>
                        </div>
                        <div class="w-3/12 pt-2 pb-0 space-x-2 text-xs font-bold text-gray-500 bg-blue-100 ">
                            <div class="w-full text-center">{{ __('Fechas') }}</div>
                            <div class="flex-none w-4/12 md:flex md:w-full">
                                <div class="flex flex-row w-full pb-1 md:w-4/12">
                                    <label for="filtroarchivos">Ctr.Archivos </label> &nbsp;
                                    <input id="filtroarchivos" type="checkbox" wire:model="filtroarchivos" class=""/>
                                </div>
                                <div class="flex flex-row w-full pb-1 md:w-4/12">
                                    <label for="filtroplotter">Ctr.Plotter</label> &nbsp;
                                    <input id="filtroplotter" type="checkbox" wire:model="filtroplotter" class=""/>
                                </div>
                                <div class="flex flex-row w-full pb-1 md:w-4/12">
                                    <label for="filtroentrega">Ctr.Entrega</label> &nbsp;
                                    <input id="filtroentrega" type="checkbox" wire:model="filtroentrega" class=""/>
                                </div>
                            </div>
                        </div>
                        <div class="w-3/12 pt-2 pb-0 space-x-2 text-xs font-bold text-gray-500 bg-blue-100 rounded-tr-md">
                            <div class="flex-none w-full md:flex md:w-3/12">
                                <div class="w-full md:w-6/12">Estado</div>
                                <div class="w-full md:w-6/12">Facturado</div>
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
            </div>
        </div>
    </div>
</div>
