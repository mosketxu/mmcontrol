<div class="">
    {{-- @livewire('menu',['producto'=>$producto],key($producto->id)) --}}

    <div class="h-full p-1 mx-2">
        <h1 class="text-2xl font-semibold text-gray-900">Productos</h1>
        <div class="py-1 space-y-4">
            @if (session()->has('message'))
                <div id="alert" class="relative px-6 py-2 mb-2 text-white bg-red-200 border-red-500 rounded border-1">
                    <span class="inline-block mx-8 align-middle">
                        {{ session('message') }}
                    </span>
                    <button class="absolute top-0 right-0 mt-2 mr-6 text-2xl font-semibold leading-none bg-transparent outline-none focus:outline-none" onclick="document.getElementById('alert').remove();">
                        <span>×</span>
                    </button>
                </div>
            @endif
            <x-jet-validation-errors></x-jet-validation-errors>
            <div class="">
                @include('producto.productofilters')
            </div>
            {{-- tabla entidades --}}
            <div class="flex-col space-y-4">
                <div>
                    <div class="flex py-2 pl-2 text-sm text-left text-gray-500 bg-blue-100 rounded-t-md">
                        <div class="flex w-3/12 lg:w-3/12" >{{ __('ISBN') }}</div>
                        <div class="flex w-4/12 lg:flex " >{{ __('Referencia') }}</div>
                        <div class="hidden w-2/12 md:flex" >{{ __('Cliente') }} </div>
                        <div class="hidden w-2/12 lg:flex" >{{ __('Proveedor') }}</div>
                        <div class="flex w-1/12 lg:w-1/12" >{{ __('Precio') }}</div>
                        <div class="hidden w-5/12 lg:flex" >{{ __('Observaciones') }}</div>
                        <div class="flex w-2/12" ></div>
                    </div>
                    <div>
                        @forelse ($productos as $producto)
                            <div class="flex w-full text-sm text-left border-t-0 border-y" wire:loading.class.delay="opacity-50">
                                <div class="flex w-3/12 lg:w-3/12">
                                    <input type="text" class="w-full p-1 text-sm font-thin text-gray-500 border-0 rounded-md" value="{{ $producto->isbn }}"  readonly/>
                                </div>
                                <div class="flex w-4/12 lg:flex">
                                    <input type="text" class="w-full p-1 text-sm font-thin text-gray-500 border-0 rounded-md" value="{{ $producto->referencia }}"  readonly/>
                                </div>
                                <div class="hidden w-2/12 lg:flex">
                                    <input type="text" class="w-full p-1 text-sm font-thin text-gray-500 border-0 rounded-md" value="{{ $producto->cliente->entidad }}"  readonly/>
                                </div>
                                <div class="hidden w-2/12 lg:flex">
                                    <input type="text" class="w-full p-1 text-sm font-thin text-gray-500 border-0 rounded-md" value="{{ $producto->proveedor->entidad }}"  readonly/>
                                </div>
                                <div class="flex w-1/12 lg:w-1/12">
                                    <input type="text" class="w-full p-1 text-sm font-thin text-gray-500 border-0 rounded-md" value="{{ $producto->precio }}"  readonly/>
                                </div>
                                <div class="hidden w-5/12 lg:flex">
                                    <input type="text" class="w-full p-1 text-sm font-thin text-gray-500 border-0 rounded-md" value="{{ $producto->observaciones }}"  readonly/>
                                </div>
                                <div  class="flex w-2/12">
                                    @if($producto->fichaproducto)
                                        <x-icon.pdf-a wire:click="presentaPDF({{ $producto }})" title="PDF"/>
                                    @else
                                        <x-icon.pdf-b class="text-blue-100 " title="PDF"/>
                                    @endif

                                    @can('producto.edit')
                                        <x-icon.edit-a href="{{ route('producto.edit',$producto) }}"  title="Editar"/>
                                    @endcan
                                    @can('producto.delete')
                                        <x-icon.delete-a wire:click.prevent="delete({{ $producto->id }})" onclick="confirm('¿Estás seguro?') || event.stopImmediatePropagation()" class="pl-1"/>
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
                </div>
                <div>
                    {{ $productos->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
    <script>
    </script>
@endpush
