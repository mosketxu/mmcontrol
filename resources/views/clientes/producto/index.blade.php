<x-guest-layout>
    <div class="p-2">
        <div class="max-w-full mx-auto">
            <div class="overflow-hidden bg-white shadow-xl sm:rounded-lg">
                @livewire('clientes.cliente-prods',['tipo'=>$tipo,'cliente'=>$cliente,'titulo'=>$titulo])
            </div>
        </div>
    </div>
</x-guest-layout>
