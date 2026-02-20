<div class="">
    <div class="h-full py-1 mx-2">
        <div class="py-1 space-y-1">
            <div class="">
                @include('errores')
            </div>
            <div class="w-full">
                    @include('compras.comprasfilters')
            </div>
            {{-- tabla presupuesots --}}
            <div class="flex-col space-y-4">
                <div>
                    <div class="">
                        <div>
                            {{ $compras->links() }}
                        </div>
                        <div class="flex w-full pt-2 text-sm font-bold text-gray-500 bg-blue-100 rounded-t-md ">
                            <div class="flex w-9/12">
                                <div class="w-1/12 pl-2 text-left" >{{ __('Número') }}</div>
                                <div class="w-1/12 pl-2 text-left" >{{ __('Código') }}</div>
                                <div class="w-1/12 text-left" >{{ __('Fecha') }}</div>
                                <div class="w-1/12 text-left" >{{ __('Fecha Entrega') }}</div>
                                <div class="w-1/12 text-left" >{{ __('Cod.Prod.') }} </div>
                                <div class="w-1/12 text-left" >{{ __('Ref.Prod.') }} </div>
                                <div class="w-2/12 text-left" >{{ __('Descripcion') }} </div>
                                <div class="w-1/12 text-left" >{{ __('Precio') }} </div>
                                <div class="w-1/12 text-left" >{{ __('Ud.') }} </div>
                                <div class="w-1/12 text-left" >{{ __('Cantidad') }} </div>
                                <div class="w-1/12 text-left" >{{ __('Total') }} </div>
                            </div>
                            <div class="flex w-3/12">
                                <div class="w-full " ></div>
                            </div>
                        </div>
                    </div>
                    <div>
                        @forelse ($compras as $compra)
                        <div class="hover:bg-gray-100 hover:cursor-pointer">
                            <div class="flex items-center w-full text-sm text-gray-500 border-t-0 border-y" wire:loading.class.delay="opacity-50" >
                                @if(!Auth::user()->hasRole('Cliente'))
                                <div class="flex w-9/12" onclick="location.href = '{{ route('compra.editar',[$compra,'i']) }}'">
                                @endif
                                    <div class="w-1/12 pl-2 text-left" >{{ $compra->numero }}</div>
                                    <div class="w-1/12 pl-2 text-left" >{{ $compra->codigo }}</div>
                                    <div class="w-1/12 text-left" >{{ $compra->fecha }}</div>
                                    <div class="w-1/12 text-left" >{{ $compra->fechaentrega }}</div>
                                    <div class="w-1/12 text-left" >{{ $compra->producto->isbn ?? '' }} </div>
                                    <div class="w-1/12 text-left" >{{ $compra->producto->referencia ?? ''  }} </div>
                                    <div class="w-2/12 text-left" >{{ $compra->descripcion }} </div>
                                    <div class="w-1/12 text-left" >{{ $compra->precio }} </div>
                                    <div class="w-1/12 text-left" >{{ $compra->precio_ud }} </div>
                                    <div class="w-1/12 text-left" >{{ $compra->cantidad }} </div>
                                    <div class="w-1/12 text-left" >{{ $compra->total }} </div>
                                </div>
                                <div class="items-center flex-none w-3/12 md:flex">
                                    <div class="w-full space-x-2 text-center md:w-4/12">
                                        {{-- <x-icon.pdf-a class="w-4 text-red-500 hover:text-red-700" href="{{route('compra.compraPDF',[$compra,'n','ES'])}}" target="_blank" title="PDF compra"/> --}}
                                        <x-icon.clip-a class="w-5 text-green-500 hover:text-green-700 " onclick="location.href = '{{route('compra.albaranes',[$compra->id,'i'])}}'" title="Albaranes"/>
                                        <x-icon.clip-a class="w-5 text-green-500 hover:text-green-700 " onclick="location.href = '{{route('compra.archivos',[$compra->id,'i'])}}'" title="Archivos"/>
                                        <x-icon.clip-a class="w-5 text-green-500 hover:text-green-700 " onclick="location.href = '{{route('compra.distribuciones',[$compra->id,'i'])}}'" title="Distribuciones"/>
                                        <x-icon.delete-a class="w-7" wire:click.prevent="delete({{ $compra->id }})" onclick="confirm('¿Estás seguro?') || event.stopImmediatePropagation()"/>
                                    </div>
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
            <div>
                {{ $compras->links() }}
            </div>
        </div>
    </div>
</div>
