<x-app-layout>
    <x-slot name="header">
        <div class="flex">
            <div class="w-3/12">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    Albarán {{ $parcialid }} del pedido {{ $pedido->id }}
                </h2>
            </div>
            {{-- <div class="w-7/12">
            </div> --}}
            <div class="flex flex-row-reverse w-9/12">
                <x-button.button  onclick="location.href = ''" color="blue" class="py-1 ">{{ __('Nuevo') }}</x-button.button>
                <div class="flex items-center mr-5 space-x-2">
                    <a href="{{route('pedido.albaran',[$pedido->id,$ruta,$parcialid,'v'=>1])}}" target="_blank" title="Albarán con precios e importes"
                        style="padding:4px 10px;font-size:12px;color:#fff;background:#2563eb;border-radius:6px">Albarán valorado</a>
                    <a href="{{route('pedido.albaran',[$pedido->id,$ruta,$parcialid,'v'=>0])}}" target="_blank" title="Albarán sin precios (para producción)"
                        style="padding:4px 10px;font-size:12px;color:#374151;background:#e5e7eb;border-radius:6px">Sin valorar</a>
                    @if(!Auth::user()->hasRole('Cliente'))
                    <a href="{{route('pedido.albaran.email',[$pedido->id,$ruta,$parcialid])}}" title="Enviar el albarán por email a los contactos del proveedor"
                        style="padding:4px 10px;font-size:12px;color:#fff;background:#16a34a;border-radius:6px">✉ Enviar al proveedor</a>
                    @endif
                </div>
                <div class="mr-5">
                {{-- @if($tipo=='1') --}}
                    @include('pedidos.pedidoeditorial-menu' )
                {{-- @else
                    @include('pedidos.pedidootros-menu' )
                @endif --}}
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-3">
        <div class="mx-auto sm:px-6 lg:px-6">
            <div class="overflow-hidden bg-white shadow-xl sm:rounded-lg">
                @livewire('pedido.pedido-parcial',['pedidoid'=>$pedido->id,'ruta'=>$ruta,'tipo'=>$tipo,'parcialid'=>$parcialid])
            </div>
        </div>
    </div>
</x-app-layout>
