<x-app-layout>
    <x-slot name="header">
        <div class="flex">
            <div class="w-full">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    @if($producto->tipo=='1')
                        Título: {{ $producto->referencia }}
                    @else
                            Producto: {{ $producto->referencia }}
                    @endif
                </h2>
            </div>
            <div class="w-full">
                @include('producto.producto-menu' )
            </div>
            <div class="flex flex-row-reverse w-full">
                <x-button.button  onclick="location.href = '{{ route('producto.nuevo',$tipo) }}'" color="blue"><x-icon.plus/>Nuevo</x-button.button>
            </div>
        </div>
    </x-slot>
    <div class="p-2">
        <div class="max-w-full mx-auto">
            <div class="overflow-hidden bg-white shadow-xl sm:rounded-lg">
                @livewire('producto.prod',['producto'=>$producto,'tipo'=>$producto->tipo],key($producto->id))
            </div>
        </div>
    </div>
</x-app-layout>
