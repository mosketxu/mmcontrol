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
                <div class="flex items-center mr-5 space-x-3">
                    @if(!Auth::user()->hasRole('Cliente'))
                    <a href="{{route('pedido.albaran.email',[$pedido->id,$ruta,$parcialid])}}" title="Enviar al proveedor"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="w-6 text-green-600 hover:text-green-800 hover:scale-125 transform"><path fill="currentColor" d="M48 64C21.5 64 0 85.5 0 112c0 15.1 7.1 29.3 19.2 38.4L236.8 313.6c11.4 8.5 27 8.5 38.4 0L492.8 150.4c12.1-9.1 19.2-23.3 19.2-38.4c0-26.5-21.5-48-48-48H48zM0 176V384c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V176L294.4 339.2c-22.8 17.1-54 17.1-76.8 0L0 176z"/></svg></a>
                    @endif
                    <a href="{{route('pedido.albaran',[$pedido->id,$ruta,$parcialid,'v'=>1])}}" target="_blank" title="Albarán valorado"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" class="w-5 text-red-500 hover:text-red-700 hover:scale-125 transform"><path fill="currentColor" d="M369.9 97.9L286 14C277 5 264.8-.1 252.1-.1H48C21.5 0 0 21.5 0 48v416c0 26.5 21.5 48 48 48h288c26.5 0 48-21.5 48-48V131.9c0-12.7-5.1-25-14.1-34zM332.1 128H256V51.9l76.1 76.1zM48 464V48h160v104c0 13.3 10.7 24 24 24h104v288H48zm250.2-143.7c-12.2-12-47-8.7-64.4-6.5-17.2-10.5-28.7-25-36.8-46.3 3.9-16.1 10.1-40.6 5.4-56-4.2-26.2-37.8-23.6-42.6-5.9-4.4 16.1-.4 38.5 7 67.1-10 23.9-24.9 56-35.4 74.4-20 10.3-47 26.2-51 46.2-3.3 15.8 26 55.2 76.1-31.2 22.4-7.4 46.8-16.5 68.4-20.1 18.9 10.2 41 17 55.8 17 25.5 0 28-28.2 17.5-38.7zm-198.1 77.8c5.1-13.7 24.5-29.5 30.4-35-19 30.3-30.4 35.7-30.4 35zm81.6-190.6c7.4 0 6.7 32.1 1.8 40.8-4.4-13.9-4.3-40.8-1.8-40.8zm-24.4 136.6c9.7-16.9 18-37 24.7-54.7 8.3 15.1 18.9 27.2 30.1 35.5-20.8 4.3-38.9 13.1-54.8 19.2zm131.6-5s-5 6-37.3-7.8c35.1-2.6 40.9 5.4 37.3 7.8z"/><circle cx="296" cy="392" r="92" fill="currentColor"/><text x="296" y="436" text-anchor="middle" font-size="130" font-weight="bold" font-family="Arial,sans-serif" fill="#fff">$</text></svg></a>
                    <a href="{{route('pedido.albaran',[$pedido->id,$ruta,$parcialid,'v'=>0])}}" target="_blank" title="Albarán sin valorar"><x-icon.pdf class="text-red-500 hover:text-red-700 "/></a>
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
