<x-app-layout>
    <x-slot name="header">
        <div class="flex">
            <div class="w-full">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    Nueva Factura
                </h2>
            </div>
            <div class="w-full">
                {{-- @include('pedido.pedido-menu' ) --}}
            </div>
            <div class="flex flex-row-reverse w-full">
                <x-button.button  onclick="location.href = '{{ route('facturacion.create') }}'" color="blue" >{{ __('Nuevo') }}</x-button.button>
            </div>
        </div>
    </x-slot>
    <div class="p-2">
        <div class="max-w-full mx-auto">
            <div class="overflow-hidden bg-white shadow-xl sm:rounded-lg">
                @livewire('facturacion.factura',['facturaid'=>''])
            </div>
        </div>
    </div>
</x-app-layout>
