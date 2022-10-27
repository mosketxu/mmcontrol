<x-app-layout>
    {{-- <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Desglose del pedido:') }} {{ $pedido->id }}
        </h2>
    </x-slot> --}}

    <div class="py-3">
        <div class="mx-auto sm:px-6 lg:px-6">
            <div class="overflow-hidden bg-white shadow-xl sm:rounded-lg">
                <div class="grid grid-cols-1 bg-gray-200 bg-opacity-25 md:grid-cols-1">
                    @livewire('pedido.pedido-facturacion',['pedidoid'=>$pedido->id])
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
