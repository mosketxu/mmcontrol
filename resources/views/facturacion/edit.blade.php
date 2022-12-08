<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between space-x-1">
            <div class="flex w-3/12 py-0 mt-0">
                <div class="w-full py-0 mt-0">
                    <h2 class="text-2xl font-semibold text-gray-900"> {{ __('Factura:') }} {{ $factura->id }} </h2>
                </div>
            </div>
            <div class="flex flex-row-reverse w-9/12 ">
                <a href="{{route('facturacion.show',[$factura->id])}}" target="_blank" title="Imprimir factura"><x-icon.pdf class="text-red-500 hover:text-red-700 mr-5 "/></a>

                <div class="flex">
                    {{-- @include('pedidos.pedido-menu' ) --}}
                </div>
            </div>
        </div>
    </x-slot>
    <div class="p-2">
        <div class="max-w-full mx-auto">
            <div class="overflow-hidden bg-white shadow-xl sm:rounded-lg">
                @livewire('facturacion.factura',['facturaid'=>$factura->id])
            </div>
        </div>
    </div>
</x-app-layout>
