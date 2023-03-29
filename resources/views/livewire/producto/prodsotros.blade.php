<div class="">
    {{-- @livewire('menu',['producto'=>$producto],key($producto->id)) --}}

    <div class="h-full p-1 mx-2">
        <h1 class="text-2xl font-semibold text-gray-900">{{ $titulo }}</h1>
        <div class="py-1 space-y-2">
            <div class="">
                @include('errores')
            </div>
            <div class="">
                @include('producto.productootrosfilters')
            </div>
            {{-- tabla entidades --}}
            <div class="flex-col space-y-4">
                <div>
                    <div class="flex py-2 pl-2 space-x-1 text-sm text-left text-gray-500 bg-blue-100 rounded-t-md">
                        <div class="w-full font-light" >{{ __('Cod.') }}</div>
                        <div class="w-full font-light" >{{ __('Referencia') }}</div>
                        <div class="w-full font-light" >{{ __('Cliente') }}</div>
                        <div class="w-full font-light" >{{ __('Material') }} </div>
                        <div class="w-full font-light" >{{ __('Medidas') }}</div>
                        <div class="w-full font-light" >{{ __('Impresion') }}</div>
                        <div class="w-full font-light" >{{ __('Precio Coste') }}</div>
                        <div class="w-full font-light" >{{ __('Precio Venta') }}</div>
                        <div class="w-full font-light" >{{ __('Troquel') }}</div>
                        <div class="w-full font-light" ></div>
                    </div>
                    @forelse ($productos as $producto)
                    <div class="flex py-1 pl-2 space-x-1 text-sm text-left border-t-0 border-y hover:bg-gray-100" wire:loading.class.delay="opacity-50">
                        <div class="w-full">
                            <input type="text" class="w-full p-1 text-sm font-thin text-gray-500 border-0 rounded-md hover:bg-gray-100" value="{{ $producto->isbn }}"  readonly/>
                        </div>
                        <div class="w-full">
                            <input type="text" class="w-full p-1 text-sm font-thin text-gray-500 border-0 rounded-md hover:bg-gray-100" value="{{ $producto->referencia }}"  readonly/>
                        </div>
                        <div class="w-full">
                            <input type="text" class="w-full p-1 text-sm font-thin text-gray-500 border-0 rounded-md hover:bg-gray-100" value="{{ $producto->cliente->entidad }}"  readonly/>
                        </div>
                        <div class="w-full">
                            <input type="text" class="w-full p-1 text-sm font-thin text-gray-500 border-0 rounded-md hover:bg-gray-100" value="{{ $producto->material }}"  readonly/>
                        </div>
                        <div class="w-full">
                            <input type="text" class="w-full p-1 text-sm font-thin text-gray-500 border-0 rounded-md hover:bg-gray-100" value="{{ $producto->medidas }}"  readonly/>
                        </div>
                        <div class="w-full">
                            <input type="text" class="w-full p-1 text-sm font-thin text-gray-500 border-0 rounded-md hover:bg-gray-100" value="{{ $producto->impresion }}"  readonly/>
                        </div>
                        <div class="w-full">
                            <input type="text" class="w-full p-1 text-sm font-thin text-gray-500 border-0 rounded-md hover:bg-gray-100" value="{{ $producto->preciocoste }}"  readonly/>
                        </div>
                        <div class="w-full">
                            <input type="text" class="w-full p-1 text-sm font-thin text-gray-500 border-0 rounded-md hover:bg-gray-100" value="{{ $producto->precioventa }}"  readonly/>
                        </div>
                        <div class="w-full">
                            <input type="text" class="w-full p-1 text-sm font-thin text-gray-500 border-0 rounded-md hover:bg-gray-100" value="{{ $producto->troquel }}"  readonly/>
                        </div>

                        <div class="flex w-full text-right">
                            @can('producto.edit')
                            <a href="{{route('producto.edit',$producto)}}"> <x-icon.edit class="mt-1 text-blue-500 hover:text-blue-700" title="Editar"/></a>
                            @endcan
                            <a href="{{route('producto.archivos',[$producto,'i'])}}"> <x-icon.clip class="text-green-500 hover:text-green-700" title="Archivos Producto"/></a>
                            <a href="{{route('producto.ficha',[$producto->id,$tipo])}}" target="_blank" ><x-icon.clipboard class="text-pink-500 hover:text-pink-700 " title="Ficha Producto"/></a>
                            @can('producto.delete')
                                <x-icon.delete-a wire:click.prevent="delete({{ $producto->id }})" onclick="confirm('¿Estás seguro?') || event.stopImmediatePropagation()" class="w-6 pl-1"/>
                            @endcan
                        </div>
                    </div>
                    @empty
                    <div>
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
                {{-- <div>
                    {{ $productos->links() }}
                </div> --}}
            </div>
        </div>
    </div>
</div>
@push('scripts')
    <script>
    </script>
@endpush
