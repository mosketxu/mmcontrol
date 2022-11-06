<x-app-layout>
    <x-slot name="header">
        <div class="flex">
            <div class="">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    {{ __('Producto:') }} {{ $producto->id }}
                </h2>
            </div>
            <div class="ml-5">
                @include('producto.producto-menu' )
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
