<div class="">
    <div class="h-full p-1 mx-2">
        <h1 class="text-2xl font-semibold text-gray-900">Stock/Materiales</h1>
        <div class="py-1 space-y-2">
            <div class="">
                @include('errores')
            </div>
            <div class="">
                @include('pedidos.pedidostockfilters')
            </div>

            <div class="flex-col space-y-1">
                <div>
                    <div>
                        {{-- {{ $movimientos->links() }} --}}
                    </div>
                    <div class="flex w-full py-1 text-sm font-bold text-gray-500 bg-blue-100 rounded-t-md">
                        <div class="flex w-full">
                            <div class="w-3/12 ml-2 " >{{ __('Material') }}</div>
                            <div class="w-2/12 " >{{ __('Pedido') }}</div>
                            <div class="w-2/12 " >{{ __('Fecha Pedido') }}</div>
                            <div class="w-2/12 " >{{ __('Entradas') }} </div>
                            <div class="w-2/12 " >{{ __('Salidas') }} </div>
                            <div class="w-2/12 " >{{ __('Saldo') }}</div>
                        </div>
                    </div>
                    <div>
                        @forelse ($movimientos as $movimiento)
                        <div class="hover:bg-gray-100 ">
                            <div class="flex items-center w-full text-sm text-gray-500 border-t-0 border-y" wire:loading.class.delay="opacity-50" >
                                <div class="flex items-center w-full"">
                                    <div class="w-3/12 ml-2 ">{{ $movimiento->name }}</div>
                                    @if($escliente)
                                    <div class="w-2/12 ml-2 text-blue-700 cursor-pointer " onclick="location.href = '{{ route('cliente.pedido.editar',[$movimiento->pedido,'i']) }}'">{{$movimiento->pedido}}</div>
                                    @else
                                    <div class="w-2/12 ml-2 text-blue-700 cursor-pointer " onclick="location.href = '{{ route('pedido.editar',[$movimiento->pedido,'i']) }}'">{{$movimiento->pedido}}</div>
                                    @endif
                                    <div class="w-2/12 ">{{ \Carbon\Carbon::parse($movimiento->fechapedido)->format('d-m-Y') }}</div>
                                    <div class="w-2/12 ">{{ $movimiento->consumo > 0 ? $movimiento->consumo. ' ' .$movimiento->unidad_consumo : '' }} </div>
                                    <div class="w-2/12 ">{{ $movimiento->consumo < 0 ? $movimiento->consumo. ' ' .$movimiento->unidad_consumo : '' }}  </div>
                                    <div class="w-2/12 ">{{ $movimiento->saldo }}</div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div colspan="10">
                            <div class="flex items-center justify-center">
                                <x-icon.inbox class="w-8 h-8 text-gray-300"/>
                                <span class="py-5 text-xl font-medium text-gray-500">
                                    No se han encontrado datos...
                                </span>
                            </div>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
    <script>
    </script>
@endpush

