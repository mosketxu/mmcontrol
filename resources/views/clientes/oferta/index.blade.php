<x-guest-layout>
    <x-slot name="header">
        <div class="flex">
            <div class="w-full">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    {{ $titulo }}
                </h2>
            </div>
            <div class="flex flex-row-reverse w-full">
            </div>
        </div>
    </x-slot>
    <div class="p-2">
        <div class="max-w-full mx-auto">
            <div class="overflow-hidden bg-white shadow-xl sm:rounded-lg">
                @livewire('clientes.cliente-ofertas',['tipo'=>$tipo])
            </div>
        </div>
    </div>
</x-guest-layout>
