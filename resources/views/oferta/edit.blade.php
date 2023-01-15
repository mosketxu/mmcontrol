<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between space-x-1">
            <div class="flex w-6/12 py-0 mt-0">
                <div class="w-full py-0 mt-0">
                    <h2 class="text-2xl font-semibold text-gray-900"> {{ $titulo  }} {{ $oferta->id }} </h2>
                </div>
            </div>
            <div class="flex flex-row-reverse w-6/12 space-x-4">
                <x-button.button  class="py-1" onclick="location.href = '{{ route('oferta.nuevo',[$tipo,'i']) }}'" color="blue" >{{ __('Nuevo') }}</x-button.button>
                <a href="{{route('oferta.ficha',[$oferta->id,$oferta->tipo])}}" target="_blank" title="Imprimir Oferta"><x-icon.pdf class="mr-5 text-red-500 hover:text-red-700 "/></a>

                {{-- <div class="flex">
                    @include('ofertas.oferta-menu' )
                </div> --}}
            </div>
        </div>
    </x-slot>
    <div class="p-2">
        <div class="max-w-full mx-auto">
            <div class="overflow-hidden bg-white shadow-xl sm:rounded-lg">
                @livewire('oferta.oferta',['ofertaid'=>$oferta->id,'tipo'=>$tipo,'ruta'=>$ruta])
            </div>
        </div>
    </div>
</x-app-layout>
