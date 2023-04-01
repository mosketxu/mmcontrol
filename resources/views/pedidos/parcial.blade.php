<x-app-layout>
    <x-slot name="header">
        <div class="flex">
            <div class="w-3/12">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    Albarán {{ $parcialid }} del pedido {{ $pedido->id }}
                </h2>
            </div>
            {{-- <div class="w-7/12">
            </div> --}}
            <div class="flex flex-row-reverse w-9/12">
                <x-button.button  onclick="location.href = ''" color="blue" class="py-1 ">{{ __('Nuevo') }}</x-button.button>
                <a href="{{route('pedido.albaran',[$pedido->id,$ruta,$parcialid])}}" target="_blank" ><x-icon.pdf class="mr-5 text-red-500 hover:text-red-700 "/></a>
                <div class="mr-5">
                {{-- @if($tipo=='1') --}}
                    @include('pedidos.pedidoeditorial-menu' )
                    adas
                {{-- @else
                    @include('pedidos.pedidootros-menu' )
                @endif --}}
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-3">
        <div class="mx-auto sm:px-6 lg:px-6">
            <div class="overflow-hidden bg-white shadow-xl sm:rounded-lg">
                @livewire('pedido.pedido-parcial',['pedidoid'=>$pedido->id,'ruta'=>$ruta,'tipo'=>$tipo,'parcialid'=>$parcialid])
            </div>
        </div>
    </div>
</x-app-layout>
