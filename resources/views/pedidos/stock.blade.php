<x-app-layout>
    <div class="p-2">
        <div class="max-w-full mx-auto">
            <div class="overflow-hidden bg-white shadow-xl sm:rounded-lg">
                @livewire('pedido.stock',['tipo'=>$tipo,'titulo'=>$titulo])
            </div>
        </div>
    </div>
</x-app-layout>
