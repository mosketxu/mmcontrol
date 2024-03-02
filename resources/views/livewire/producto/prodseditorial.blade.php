<div class="">
    <div class="h-full p-1 mx-2">
        <h1 class="text-2xl font-semibold text-gray-900">{{ $titulo }}</h1>
        <div class="py-1 space-y-2">
            <div class="">
                @include('errores')
            </div>
            <div class="">
                @include('producto.productoeditorialfilters')
            </div>
            <div class="flex-col space-y-1">
                <div>
                    <div>
                        {{ $productos->links() }}
                    </div>
                    <div class="flex w-full py-1 text-sm font-bold text-gray-500 bg-blue-100 rounded-t-md">
                        <div class="flex w-11/12">
                            <div class="w-2/12 ml-2" >{{ __('ISBN') }}</div>
                            <div class="w-4/12 " >{{ __('Título') }}</div>
                            <div class="w-2/12 " >{{ __('Cliente') }} </div>
                            {{-- <div class="w-1/12 " >{{ __('€ Coste') }}</div> --}}
                            <div class="w-4/12 " >{{ __('Observaciones') }}</div>
                        </div>
                        <div class="flex w-1/12 ">
                            <div class="w-full" ></div>
                        </div>
                    </div>
                    <div>
                        @forelse ($productos as $producto)
                        <div class="hover:bg-gray-100 hover:cursor-pointer">
                            <div class="flex items-center w-full text-sm text-gray-500 border-t-0 border-y" wire:loading.class.delay="opacity-50" >
                                <div class="flex items-center w-11/12" onclick="location.href = '{{ route('producto.edit',$producto) }}'">
                                    <div class="w-2/12 ml-2">{{ $producto->isbn }}</div>
                                    <div class="w-4/12">{{ $producto->referencia }}</div>
                                    <div class="w-2/12">{{ $producto->cliente->entidad }}</div>
                                    <div class="w-4/12">
                                            <textarea rows="1" class="w-full p-1 text-sm font-thin text-gray-500 border-0 rounded-md hover:bg-gray-100" disabled>{{ $producto->observaciones }}</textarea>
                                    </div>
                                </div>
                                <div class="items-center flex-none w-1/12 md:flex">
                                    <div class="w-full text-center">
                                        <x-icon.clip-a  class="text-green-500 hover:text-green-700"  href="{{route('producto.archivos',[$producto,'i'])}}"title="Archivos Producto"/>
                                        <x-icon.clipboard-a class="text-pink-500 hover:text-pink-700 " href="{{route('producto.ficha',[$producto->id,$tipo,'n'])}}" target="_blank"   title="Ficha Producto"/>
                                        <x-icon.clipboard-a class="text-orange-500 hover:text-orange-700 " href="{{route('producto.ficha',[$producto->id,$tipo,'r'])}}" target="_blank"   title="Ficha Producto Reducida"/>
                                        <x-icon.delete-a class="w-6" wire:click.prevent="delete({{ $producto->id }})" onclick="confirm('¿Estás seguro?') || event.stopImmediatePropagation()" />
                                    </div>
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
