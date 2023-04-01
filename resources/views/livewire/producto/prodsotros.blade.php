<div class="">
    <div class="h-full p-1 mx-2">
        <h1 class="text-2xl font-semibold text-gray-900">{{ $titulo }}</h1>
        <div class="py-1 space-y-2">
            <div class="">
                @include('errores')
            </div>
            <div class="">
                @include('producto.productootrosfilters')
            </div>
            <div class="flex-col space-y-1">
                <div class="flex w-full py-1 text-sm font-bold text-gray-500 bg-blue-100 rounded-t-md">
                    <div class="flex w-11/12 ">
                        <div class="flex w-1/12 ml-2" >{{ __('Cod.') }}</div>
                        <div class="flex w-2/12" >{{ __('Referencia') }}</div>
                        <div class="flex w-1/12" >{{ __('Cliente') }}</div>
                        <div class="flex w-2/12" >{{ __('Material') }} </div>
                        <div class="flex w-2/12" >{{ __('Medidas') }}</div>
                        <div class="flex w-1/12" >{{ __('Impresion') }}</div>
                        <div class="flex w-1/12" >{{ __('€. Coste') }}</div>
                        <div class="flex w-1/12" >{{ __('€. Venta') }}</div>
                        <div class="flex w-1/12" >{{ __('Troquel') }}</div>
                    </div>
                    <div class="flex w-1/12">
                        <div class="w-full" ></div>
                    </div>
                </div>
                @forelse ($productos as $producto)
                <div class="flex items-center w-full text-sm text-left cursor-pointer border-t-0 border-y hover:bg-gray-100" wire:loading.class.delay="opacity-50">
                    <div class="flex items-center w-11/12 "  onclick="location.href = '{{ route('producto.edit',$producto) }}'">
                        <div class="w-1/12 ml-2">
                            <input type="text" class="w-full p-1 bg-transparent text-sm font-thin text-gray-500 border-0 rounded-md hover:bg-gray-100" value="{{ $producto->isbn }}"  disabled/>
                        </div>
                        <div class="w-2/12">
                            <input type="text" class="w-full p-1 text-sm font-thin text-gray-500 border-0 rounded-md hover:bg-gray-100" value="{{ $producto->referencia }}"  disabled/>
                        </div>
                        <div class="w-1/12">
                            <input type="text" class="w-full p-1 text-sm font-thin text-gray-500 border-0 rounded-md hover:bg-gray-100" value="{{ $producto->cliente->entidad }}"  disabled/>
                        </div>
                        <div class="w-2/12">
                            <input type="text" class="w-fullp-1 text-sm font-thin text-gray-500 border-0 rounded-md hover:bg-gray-100" value="{{ $producto->material }}"  disabled/>
                        </div>
                        <div class="w-1/12">
                            <input type="text" class="w-full p-1 text-sm font-thin text-gray-500 border-0 rounded-md hover:bg-gray-100" value="{{ $producto->medidas }}"  disabled/>
                        </div>
                        <div class="w-1/12">
                            <input type="text" class="w-full p-1 text-sm font-thin text-gray-500 border-0 rounded-md hover:bg-gray-100" value="{{ $producto->impresion }}"  disabled/>
                        </div>
                        <div class="w-1/12">
                            <input type="text" class="w-full p-1 text-sm font-thin text-gray-500 border-0 rounded-md hover:bg-gray-100" value="{{ $producto->preciocoste }}"  disabled/>
                        </div>
                        <div class="w-1/12">
                            <input type="text" class="w-full p-1 text-sm font-thin text-gray-500 border-0 rounded-md hover:bg-gray-100" value="{{ $producto->precioventa }}"  disabled/>
                        </div>
                        <div class="w-1/12">
                            <input type="text" class="w-full p-1 text-sm font-thin text-gray-500 border-0 rounded-md hover:bg-gray-100" value="{{ $producto->troquel }}"  disabled/>
                        </div>
                    </div>
                    <div class="items-center w-1/12 text-center" >
                        <x-icon.clip-a  class="text-green-500 hover:text-green-700"  href="{{route('producto.archivos',[$producto,'i'])}}"title="Archivos Producto"/>
                        <x-icon.clipboard-a class="text-pink-500 hover:text-pink-700 " href="{{route('producto.ficha',[$producto->id,$tipo,'n'])}}" target="_blank"   title="Ficha Producto"/>
                        <x-icon.delete-a class="w-6" wire:click.prevent="delete({{ $producto->id }})" onclick="confirm('¿Estás seguro?') || event.stopImmediatePropagation()" />
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
        </div>
    </div>
</div>
@push('scripts')
    <script>
    </script>
@endpush
