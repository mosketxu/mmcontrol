<x-app-layout>
    <x-slot name="header">
        <div class="flex">
            <div class="w-full">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    @if($tipo=='1')
                        Pedidos Editoriales
                    @else
                        Pedidos otros Productos
                    @endif
                </h2>
            </div>
            {{-- <div class="w-full">
                @include('producto.producto-menu' )
            </div> --}}
            <div class="flex flex-row-reverse w-full">
                <x-button.button  class="py-1" onclick="location.href = '{{ route('pedido.nuevo',[$tipo,$ruta]) }}'" color="blue" >{{ __('Nuevo') }}</x-button.button>
            </div>
        </div>
    </x-slot>
    <div class="p-2">
        <div class="max-w-full mx-auto">
            <div class="overflow-hidden bg-white shadow-xl sm:rounded-lg">
                @livewire('pedido.pedidos',['tipo'=>$tipo])
            </div>
        </div>
    </div>
</x-app-layout>
