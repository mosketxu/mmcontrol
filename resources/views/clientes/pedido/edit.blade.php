<x-guest-layout>
    <x-slot name="header">
        <div class="flex justify-between space-x-1">
            <div class="flex w-4/12 py-0 mt-0">
                <div class="w-full py-0 mt-0">
                    <h2 class="text-2xl font-semibold text-gray-900"> {{ $titulo }}: {{ $pedido->id }} </h2>
                </div>
            </div>
            <div class="flex flex-row-reverse w-8/12">
                {{-- <x-button.button  class="py-1 ml-4" onclick="location.href = '{{ route('pedido.nuevo',[$tipo,$ruta]) }}'" color="blue" >{{ __('Nuevo') }}</x-button.button> --}}
                {{-- @if($tipo=='1') --}}
                    @include('pedidos.pedidoeditorial-menu' )
                {{-- @else
                    @include('pedidos.pedidootros-menu' )
                @endif --}}
            </div>
        </div>
    </x-slot>
    <div class="p-2">
        <div class="max-w-full mx-auto">
            <div class="overflow-hidden bg-white shadow-xl sm:rounded-lg">
                @livewire('pedido.pedido',['pedidoid'=>$pedido->id,'tipo'=>$tipo,'ruta'=>$ruta,'titulo'=>$titulo])
            </div>
        </div>
    </div>
</x-guest-layout>
