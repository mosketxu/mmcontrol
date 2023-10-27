<x-guest-layout>
    <x-slot name="header">
        <div class="flex">
            <div class="w-full">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    Acceso a la informacion de: {{$cliente->name}}
                </h2>
            </div>
        </div>
    </x-slot>
    <div class="p-2">
        <div class="max-w-full mx-auto">
            <div class="overflow-hidden bg-white shadow-xl sm:rounded-lg">
                {{-- @livewire('presupuesto.presupuestos',['tipo'=>$tipo,'titulo'=>$titulo]) --}}
            </div>
        </div>
    </div>
</x-guest-layout>
