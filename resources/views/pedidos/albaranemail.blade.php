<x-app-layout>
    <x-slot name="header">
        <div class="flex">
            <div class="w-6/12">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    Enviar albarán {{ $parcialid }} del pedido {{ $pedido->id }} al proveedor
                </h2>
            </div>
            <div class="flex flex-row-reverse w-6/12">
                <a href="{{ route('pedido.parcial',[$pedido->id,$ruta,$parcialid]) }}" style="padding:4px 10px;font-size:12px;color:#374151;background:#e5e7eb;border-radius:6px">Volver al albarán</a>
            </div>
        </div>
    </x-slot>
    <div class="py-3">
        <div class="mx-auto sm:px-6 lg:px-6">
            <div class="overflow-hidden bg-white shadow-xl sm:rounded-lg">
                @livewire('pedido.pedido-parcial-email',['pedidoid'=>$pedido->id,'parcialid'=>$parcialid,'ruta'=>$ruta])
            </div>
        </div>
    </div>
</x-app-layout>
