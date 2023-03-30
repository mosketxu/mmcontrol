<div class="">
    <div class="h-full py-1 mx-2">
        <div class="py-1 space-y-1">
            <div class="">
                @include('errores')
            </div>
            <div class="">
                @include('facturacion.facturasfilters')
            </div>
            {{-- tabla facturas --}}
            <div class="flex-col space-y-4">
                <div>
                    <div class="flex">
                        <div class="flex w-10/12 py-2 space-x-2 text-sm font-bold text-gray-500 bg-blue-100 rounded-tl-md">
                            <div class="w-1/12 text-left pl-2" >{{ __('Nº.Factura') }}</div>
                            <div class="w-3/12 text-left" >{{ __('Cliente') }}</div>
                            <div class="w-1/12 text-right" >{{ __('Fecha') }}</div>
                            <div class="w-1/12 text-right" >{{ __('F.Vto') }}</div>
                            <div class="w-1/12 text-right" >{{ __('Importe') }} </div>
                            <div class="w-5/12 text-center">{{ __('Observaciones') }}</div>
                        </div>
                        <div class="flex w-2/12 py-2 space-x-2 text-sm font-bold text-gray-500 bg-blue-100 rounded-tr-md">
                            <div class="w-6/12 text-center" >{{ __('Estado') }}</div>
                            <div class="w-6/12 " ></div>
                        </div>
                    </div>
                    <div>
                        @forelse ($facturas as $factura)
                        <div class="flex space-x-2">
                            <div class="flex w-10/12 space-x-2 text-sm text-gray-500 border-t-0 border-y items-center cursor-pointer hover:bg-gray-200" wire:loading.class.delay="opacity-50" onclick="location.href = '{{ route('facturacion.edit',$factura) }}'">
                                <div class="w-1/12 text-left pl-2">{{ $factura->id }}</div>
                                <div class="w-3/12 text-left">{{ $factura->cliente->entidad }}</div>
                                <div class="w-1/12 text-right">{{ $factura->ffactura }}</div>
                                <div class="w-1/12 text-right">{{ $factura->ffacturavto }}</div>
                                <div class="w-1/12 text-right">{{ $factura->importe }}</div>
                                <div class="w-5/12 text-left"><textarea class="w-full text-sm border-0 rounded-md bg-transparent" rows="1" readonly>{{ $factura->observaciones }}</textarea></div>
                            </div>
                            <div class="flex w-2/12 space-x-2 text-sm text-gray-500 border-t-0 border-y items-center cursor-pointer hover:bg-gray-200" wire:loading.class.delay="opacity-50" ">
                                <div class="w-6/12 pl-2">
                                    <select wire:change="changeValor({{ $factura }},'estado',$event.target.value)"
                                        class="w-full text-center py-1 my-1 text-xs text-gray-600 placeholder-gray-300 bg-{{ $factura->status_color[0] }} border-blue-300 rounded-md shadow-sm appearance-none hover:border-gray-400 focus:outline-none">
                                        <option value="0" {{ $factura->estado== '0'? 'selected' : '' }}>Sin enviar</option>
                                        <option value="1" {{ $factura->estado== '1'? 'selected' : '' }}>Env. P.cobro</option>
                                        <option value="2" {{ $factura->estado== '2'? 'selected' : '' }}>Cobrada</option>
                                    </select>
                                </div>
                                <div class="w-6/12 text-center ">
                                    {{-- <x-icon.edit-a href="{{ route('facturacion.edit',$factura) }}"  title="Editar"/> --}}
                                    <x-icon.pdf-a href="{{ route('facturacion.show',[$factura->id]) }}" target="_blank" title="Imprimir factura"  title="PDF Factura"/>
                                    <x-icon.delete-a wire:click.prevent="delete({{ $factura->id }})" onclick="confirm('¿Estás seguro?') || event.stopImmediatePropagation()" class="w-7"/>
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
            {{-- <div>
                {{ $facturas->links() }}
            </div> --}}
        </div>
    </div>
</div>
