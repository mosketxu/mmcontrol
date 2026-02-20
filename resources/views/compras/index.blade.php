<x-app-layout>
    <x-slot name="header">
        <div class="flex">
            <div class="w-full">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    @if($tipo=='1')
                        Compras Editorial
                    @else
                        Compras Packaging
                    @endif
                </h2>
            </div>
            <div class="flex flex-row-reverse w-full">
                <x-button.button  class="py-1" onclick="location.href = '{{ route('compra.nuevo',[$tipo,$ruta]) }}'" color="blue" >{{ __('Nuevo') }}</x-button.button>
            </div>
        </div>
    </x-slot>
    <div class="p-2">
        <div class="max-w-full mx-auto">
            <div class="overflow-hidden bg-white shadow-xl sm:rounded-lg">
                <div class="">
                    <div class="h-full py-1 mx-2">
                        <div class="py-1 space-y-1">
                            <div class="">
                                @include('errores')
                            </div>
                            <div class="">
                                @include('compras.comprasfilters')
                                {{ $compras->appends(request()->except('page'))->links() }}
                            </div>
                            <div class="flex-col space-y-4">
                                <div>
                                    <div class="flex">
                                        <div class="flex w-6/12 pt-2 pb-0 pl-2 space-x-2 text-xs font-bold text-gray-500 bg-blue-100 rounded-tl-md">
                                            <div class="w-2/12 text-left md:w-1/12" >{{ __('Nº.') }} </div>
                                            <div class="w-2/12 text-left md:w-1/12" >{{ __('Proveedor') }} </div>
                                            <div class="w-2/12 text-left md:w-1/12" >{{ __('Producto') }} </div>
                                            <div class="w-2/12 text-left md:w-1/12" >{{ __('Descripción') }} </div>
                                            <div class="w-2/12 text-left md:w-1/12" >{{ __('Precio/Ud') }} </div>
                                            <div class="w-2/12 text-left md:w-1/12" >{{ __('Ud.') }} </div>
                                            <div class="w-2/12 text-left md:w-1/12" >{{ __('Cantidad') }} </div>
                                        </div>
                                    </div>
                                <div>
                                    @forelse ($compras as $compra)
                                    <div class="" wire:loading.class.delay="opacity-50">
                                        @livewire('compra.compras',['compra'=>$compra,'tipo'=>$tipo],key("$compra->id"))
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
        </div>
    </div>
    @push('scripts')
    <script>
        Livewire.on('compraEliminado', () => {
            location.reload();
            });
    </script>
    @endpush
    <script>

    </script>
</x-app-layout>
