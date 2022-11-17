<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between space-x-1">
            <div class="flex w-3/12 py-0 mt-0">
                <div class="w-full py-0 mt-0">
                    <h2 class="text-2xl font-semibold text-gray-900"> {{ __('Pedido:') }} {{ $pedido->id }} </h2>
                </div>
            </div>
            <div class="flex flex-row-reverse w-9/12 ">
                <div class="flex">
                    @include('pedidos.pedido-menu' )
                </div>
            </div>
        </div>
    </x-slot>
    <div class="p-2">
        <div class="max-w-full mx-auto">
            <div class="overflow-hidden bg-white shadow-xl sm:rounded-lg">
                @livewire('pedido.pedido',['pedidoid'=>$pedido->id,'tipo'=>$tipo,'ruta'=>$ruta])
            </div>
        </div>
    </div>
</x-app-layout>
