<div class="">
    <div class="h-full py-1 mx-2">
        <div class="py-1 space-y-1">
            <div class="">
                @include('errores')
            </div>
            <div class="">
                @include('facturacion.facturasfilters')
            </div>
            <div class="flex-col space-y-4">
                <div>
                    <div class="flex w-full py-1 text-sm font-bold text-gray-500 bg-blue-100 rounded-t-md">
                        <div class="flex w-10/12">
                            <div class="w-1/12 pl-2 text-left" >{{ __('Nº.Factura') }}</div>
                            <div class="w-3/12 text-left" >{{ __('Cliente') }}</div>
                            <div class="w-1/12 text-right" >{{ __('Fecha') }}</div>
                            <div class="w-1/12 text-right" >{{ __('F.Vto') }}</div>
                            <div class="w-1/12 text-right" >{{ __('Importe') }} </div>
                            <div class="w-1/12 text-center" >{{ __('Tipo') }} </div>
                            <div class="w-4/12 text-center">{{ __('Observaciones') }}</div>
                        </div>
                        <div class="flex w-2/12 ">
                            <div class="w-6/12 text-center" >{{ __('Estado') }}</div>
                            <div class="w-6/12 " ></div>
                        </div>
                    </div>
                    <div>
                        @forelse ($facturas as $factura)
                        <div class="flex items-center w-full text-sm text-gray-500 border-t-0 border-y hover:bg-gray-100 " wire:loading.class.delay="opacity-50" >
                            {{-- <div class="flex items-center w-10/12"  onclick="location.href = '{{ route('cliente.facturacion.edit',$factura) }}'"> --}}
                            <div class="flex items-center w-10/12" >
                                <div class="w-1/12 pl-2 text-left">{{ $factura->id }}</div>
                                <div class="w-3/12 text-left">{{ $factura->cliente->entidad }}</div>
                                <div class="w-1/12 text-right">{{ $factura->ffactura }}</div>
                                <div class="w-1/12 text-right">{{ $factura->ffacturavto }}</div>
                                <div class="w-1/12 text-right">{{ $factura->importe }}</div>
                                <div class="w-1/12 text-center">{{ $factura->facturatipo[1] }}</div>
                                <div class="w-4/12 text-left"><textarea class="w-full pl-2 text-sm bg-transparent border-0 rounded-md " rows="1" readonly>{{ $factura->observaciones }}</textarea></div>
                            </div>
                            <div class="flex items-center w-2/12 " >
                                <div class="w-6/12 pl-2">
                                    <select
                                        class="w-full text-center py-1 my-1 text-xs text-gray-600 placeholder-gray-300 bg-{{ $factura->status_color[0] }} border-blue-300 rounded-md shadow-sm appearance-none hover:border-gray-400 focus:outline-none"
                                        disabled>
                                        <option value="0" {{ $factura->estado== '0'? 'selected' : '' }}>Sin enviar</option>
                                        <option value="1" {{ $factura->estado== '1'? 'selected' : '' }}>Env. P.cobro</option>
                                        <option value="2" {{ $factura->estado== '2'? 'selected' : '' }}>Cobrada</option>
                                    </select>
                                </div>
                                <div class="w-6/12 text-center ">
                                    <x-icon.pdf-a href="{{ route('cliente.facturacion.show',[$factura->id]) }}" target="_blank" title="Imprimir factura"  title="PDF Factura"/>
                                </div>
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
                    </div>
                </div>
        </div>
    </div>
</div>
