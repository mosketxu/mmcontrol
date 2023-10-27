<x-app-layout>
    <x-slot name="header">
        <div class="flex">
            <div class="w-full">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    {{ $titulo }}
                </h2>
            </div>
            <div class="w-full">
                @if(!Auth::user()->hasRole('Cliente'))
                    @include('producto.producto-menu' )
                @else
                    @include('clientes.producto.producto-cliente-menu' )
                @endif
            </div>
            <div class="flex flex-row-reverse w-full">
                <x-button.button  onclick="location.href = '{{ route('producto.nuevo',$tipo) }}'" color="blue"><x-icon.plus/>Nuevo</x-button.button>
            </div>
        </div>
    </x-slot>
    <div class="p-2">
        <div class="max-w-full mx-auto">
            <div class="overflow-hidden bg-white shadow-xl sm:rounded-lg">
                @livewire('producto.prod',['producto'=>$producto,'tipo'=>$producto->tipo,'titulo'=>$titulo],key($producto->id))
            </div>
        </div>
    </div>
</x-app-layout>
