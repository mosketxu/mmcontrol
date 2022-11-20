<x-app-layout>
    <x-slot name="header">
        <div class="flex">
            <div class="w-full">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    Albarán {{ $parcialid }} del pedido {{ $pedido->id }}
                </h2>
            </div>
            <div class="w-full">
                {{-- @include('pedido.pedido-menu' ) --}}
            </div>
            <div class="flex flex-row-reverse w-full">
                <x-button.button  onclick="location.href = ''" color="blue" >{{ __('Nuevo') }}</x-button.button>
                <a href="{{route('pedido.albaran',[$parcialid])}}" target="_blank" ><x-icon.pdf class="text-red-500 hover:text-red-700 mr-5 "/></a>
            </div>
        </div>
    </x-slot>

    <div class="py-3">
        <div class="mx-auto sm:px-6 lg:px-6">
            <div class="overflow-hidden bg-white shadow-xl sm:rounded-lg">
                @livewire('pedido.pedido-parcial',['pedidoid'=>$pedido->id,'ruta'=>$ruta,'tipo'=>$pedido->tipo,'parcialid'=>$parcialid])
            </div>
        </div>
    </div>
</x-app-layout>
