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
                    <div class="">
                        <div class="flex w-full pt-2 pb-0 pl-2 space-x-2 text-sm font-bold text-gray-500 bg-blue-100 rounded-t-md">
                            {{-- <div class="flex w-5 h-5 mr-2 font-medium text-center" >
                                <x-input.checkbox wire:model="selectPage" />
                            </div> --}}
                            <div class="w-1/12 text-left" >{{ __('Nº.Factura') }}</div>
                            <div class="w-2/12 text-left" >{{ __('Cliente') }}</div>
                            <div class="w-1/12 text-right" >{{ __('Fecha') }}</div>
                            <div class="w-1/12 text-right" >{{ __('F.Vto') }}</div>
                            <div class="w-1/12 text-right" >{{ __('Importe') }} </div>
                            <div class="w-3/12 text-left">{{ __('Observaciones') }}</div>
                            <div class="w-1/12 text-center" >{{ __('Estado') }}</div>
                            <div class="w-2/12 text-left" ></div>
                        </div>
                    </div>
                    <div>
                        {{-- @if($selectPage)
                        <div class="flex w-full text-sm text-left bg-gray-200 border-t-0 border-y" wire:key="row-message">
                            <div class="flex-col w-full text-left">
                                @unless($selectAll)
                                    <span>Has seleccionado <strong>{{ $facturas->count() }}</strong> facturas, ¿quieres seleccionar el total: <strong>{{ $facturas->total() }}</strong> ?</span>
                                    <x-button.link wire:click="selectAll" class="ml-1 text-blue-600">Select all</x-button.link>
                                @else
                                    <span>Has seleccionado <strong>todas</strong> las {{ $facturas->total() }} facturas</span>
                                @endif
                            </div>
                        </div>
                        @endif --}}
                        @forelse ($facturas as $factura)
                        <div class="flex items-center w-full space-x-2 text-sm text-gray-500 border-t-0 border-y " wire:loading.class.delay="opacity-50">
                            {{-- <div class="flex w-5 h-5 p-2 mr-2 font-medium text-center">
                                <x-input.checkbox wire:model="selected" value="{{ $factura->id }}" />
                            </div> --}}
                            <div class="flex-col w-1/12 my-2 text-left">
                                {{ $factura->id }}
                            </div>
                            <div class="flex-col w-2/12 my-2 text-left">
                                {{ $factura->cliente->entidad }}
                            </div>
                            <div class="flex-col w-1/12 my-2 text-right">
                                {{ $factura->ffactura }}
                            </div>
                            <div class="flex-col w-1/12 my-2 text-right">
                                {{ $factura->ffacturavto }}
                            </div>
                            <div class="flex-col w-1/12 my-2 text-right">
                                {{ $factura->importe }}
                            </div>
                            <div class="flex-col w-3/12 pl-2 my-2 ml-2 text-left">
                                {{ $factura->observaciones }}
                            </div>
                            <div class="flex-col w-1/12 text-right">
                                <select wire:change="changeValor({{ $factura }},'estado',$event.target.value)"
                                    class="w-full text-center py-1 my-1 text-xs text-gray-600 placeholder-gray-300 bg-{{ $factura->status_color[0] }} border-blue-300 rounded-md shadow-sm appearance-none hover:border-gray-400 focus:outline-none">
                                    <option value="0" {{ $factura->estado== '0'? 'selected' : '' }}>Sin enviar</option>
                                    <option value="1" {{ $factura->estado== '1'? 'selected' : '' }}>Env. P.cobro</option>
                                    <option value="2" {{ $factura->estado== '2'? 'selected' : '' }}>Cobrada</option>
                                </select>
                            </div>
                            <div class="w-2/12 space-x-2 text-center ">
                                <x-icon.edit-a href="{{ route('facturacion.edit',$factura) }}"  title="Editar"/>
                                <x-icon.pdf-a href="{{ route('facturacion.show',[$factura->id]) }}" target="_blank" title="Imprimir factura"  title="PDF Factura"/>
                                {{-- <a href="{{route('facturacion.show',[$factura->id])}}" ><x-icon.pdf class="text-red-500 hover:text-red-700 "/></a> --}}
                                <x-icon.delete-a wire:click.prevent="delete({{ $factura->id }})" onclick="confirm('¿Estás seguro?') || event.stopImmediatePropagation()" class="w-6"/>

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
