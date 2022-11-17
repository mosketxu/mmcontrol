<div class="">
    <div class="p-1 mx-2 ">
        <div class="flex justify-between space-x-1">
            <div class="flex w-3/12 py-0 mt-0">
                <div class="w-full py-0 mt-0">
                    <h1 class="text-2xl font-semibold text-gray-900"> {{ $titulo }} {{ $pedidoid }}</h1>
                </div>
            </div>
            <div class="flex flex-row-reverse w-9/12 ">
                <div class="flex ">
                    <input type="text" wire:model="search" class="w-full py-1 text-sm border border-blue-100 rounded-lg" placeholder="Búsqueda" autofocus/>
                    @if($search!='')
                    <x-icon.filter-slash-a wire:click="$set('search', '')" class="pb-1" title="reset filter"/>
                    @endif
                </div>
                <div class="flex mr-10">
                    @include('pedidos.pedido-menu' )
                </div>
            </div>
        </div>
        <div class="py-1 space-y-4">
            <div class="">
                @include('errores')
            </div>
            {{-- cuerpo --}}
            <div class="flex-col ">
                {{-- titulos --}}
                <div>
                    <div class="flex pt-2 pb-0 pl-2 text-sm text-left text-gray-500 bg-blue-100 rounded-t-md">
                        <div class="w-1/12 font-medium text-left" >{{ __('Factura')}} </div>
                        <div class="w-2/12 font-medium text-center" >{{ __('Fecha')}} </div>
                        <div class="w-1/12 font-medium pr-2 text-right ">{{ __('Cantidad')}} </div>
                        <div class="w-1/12 font-medium pr-2 text-right ">{{ __('Importe')}} </div>
                        <div class="w-4/12 font-medium text-left ml-2">{{ __('Comentario')}} </div>
                        <div class="w-2/12 font-medium text-left ml-2">{{ __('Estado')}} </div>
                    </div>
                </div>
                {{-- datos --}}
                <div>
                    @foreach ($facturas as $factura)
                    <div class="flex w-full py-0 my-0 text-sm text-left bg-white border-t-0 border-y" wire:loading.class.delay="opacity-50">
                        <div class="flex-col w-1/12 text-left">
                            <input type="text" value="{{ $factura->id }}" class="w-full text-sm font-thin text-gray-500 border-0 rounded-md" readonly/>
                        </div>
                        <div class="flex-col w-2/12 text-left">
                            <input type="date" class="w-full text-sm text-center font-thin text-gray-500 border-0 rounded-md" value="{{ $factura->fecha }}"  readonly/>
                        </div>
                        <div class="flex-col w-1/12 text-left">
                            <input type="text" value="{{ $factura->cantidad }}" class="w-full pr-2 mr-2 text-sm font-thin text-right text-gray-500 border-0 rounded-md" readonly/>
                        </div>
                        <div class="flex-col w-1/12 text-left">
                            <input type="text" value="{{ $factura->importe }}" class="w-full pr-2 mr-2 text-sm font-thin text-right text-gray-500 border-0 rounded-md"
                            readonly/>
                        </div>
                        <div class="flex-col w-4/12 text-left">
                            <input type="text" value="{{ $factura->comentario }}" class="w-full pl-2 ml-2 text-sm font-thin text-left text-gray-500 border-0 rounded-md"
                            readonly/>
                        </div>
                        <div class="flex-col w-1/12 text-left">
                            <input type="text" value="{{ $factura->estado }}" class="w-full pl-2 ml-2 text-sm font-thin text-left text-gray-500 border-0 rounded-md"
                            readonly/>
                        </div>
                        <div class="flex flex-row-reverse w-1/12 pr-2 mt-2">
                            <x-icon.edit-a wire:click="editar({{ $factura->id }})" class="pl-1"  title="Editar {{ $titulo }}"/>
                            <x-icon.delete-a wire:click.prevent="delete({{ $factura->id }})" onclick="confirm('¿Estás seguro?') || event.stopImmediatePropagation()" class="pl-1"  title="Eliminar detalle"/>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div>
                    {{ $facturas->links() }}
                </div>
                <div>
                    <form wire:submit.prevent="save">
                        <div class="flex w-full p-2 my-0 text-sm text-left bg-blue-200 rounded-b-md" wire:loading.class.delay="opacity-50">
                            <div class="flex-col w-1/12 text-left">
                            </div>
                            <div class="flex-col w-2/12 text-left">
                                <input type="date" wire:model.defer="fecha"
                                    class="w-full text-xs text-center border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"/>
                            </div>
                            <div class="flex-col w-1/12 text-left">
                                <input type="number" step="any" wire:model.defer="cantidad"
                                    class="w-full text-xs text-right border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"/>
                            </div>
                            <div class="flex-col w-1/12 text-left">
                                <input type="number" step="any" wire:model.defer="importe"
                                    class="w-full text-xs text-right border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"/>
                            </div>
                            <div class="flex-col w-4/12 text-left">
                                <input type="text" wire:model.defer="comentario"
                                    class="w-full text-xs text-left border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"/>
                            </div>
                            <div class="flex-col w-1/12 text-left">
                            </div>
                            <div class="flex-col w-1/12 text-right">
                                <button type="submit" class="items-center pl-1 mx-0 mt-2 text-center w-7 "><x-icon.save-a class="text-blue"></x-icon.save-a></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="m-2">
        @if($ruta=='i')
            <x-jet-secondary-button  onclick="location.href = '{{route('pedido.tipo',[$tipo,$ruta])}}'">{{ __('Volver') }}</x-jet-secondary-button>
        @else
            {{-- <x-jet-secondary-button  onclick="location.href = '{{route('pedido.edit',$pedidoid)}}'">{{ __('Volver') }}</x-jet-secondary-button> --}}
        @endif
    </div>
</div>
