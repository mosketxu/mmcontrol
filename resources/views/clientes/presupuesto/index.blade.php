<x-guest-layout>
    <x-slot name="header">
        <div class="flex">
            <div class="w-full">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    {{ $titulo }}
                </h2>
            </div>
            {{-- <div class="flex flex-row-reverse w-full">
                <x-button.button  class="py-1" onclick="location.href = '{{ route('presupuesto.nuevo',[$tipo,'i']) }}'" color="blue" >{{ __('Nuevo') }}</x-button.button>
            </div> --}}
        </div>
    </x-slot>
    <div class="p-2">
        <div class="max-w-full mx-auto">
            <div class="overflow-hidden bg-white shadow-xl sm:rounded-lg">
                {{-- clientes.cliente-ofertas --}}
                @livewire('clientes.cliente-presupuestos',['tipo'=>$tipo,'titulo'=>$titulo])
                {{-- @livewire('presupuesto.presupuestos',['tipo'=>$tipo,'titulo'=>$titulo]) --}}
            </div>
        </div>
    </div>
</x-guest-layout>
