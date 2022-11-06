<nav x-data="{ open: false }" class="bg-gray-100 border-b border-gray-100 rounded-md">
    <!-- Administration Navigation Menu -->
    <div class="px-2 mx-auto sm:px-2 lg:px-2">
        <div class="flex justify-between ">
            <div class="flex">
                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:m-2 sm:flex">
                    <x-jet-nav-link href="{{route('producto.archivos',[$producto,'e'])}}" :active="request()->routeIs('producto.archivos')">
                        <x-icon.clip/>Archivos
                    </x-jet-nav-link>
                </div>
                <div class="hidden space-x-8 sm:-my-px sm:m-2 sm:flex">
                    <x-jet-nav-link href="{{route('producto.ficha', [$producto->id,$tipo]) }}" target="_blank" :active="request()->routeIs('producto.archivos')">
                        <x-icon.pdf class="text-gray-500 hover:text-gray-700"/>Ficha

                        {{-- @if($producto->adjunto) --}}
                        {{-- <x-icon.clip-a class="w-10 text-green-500 hover:text-green-700 " onclick="location.href = '{{route('producto.adjunto', [$producto]) }}'" title="Adjunto Producto"/> --}}
                        {{-- <a href="{{asset('fichasproducto/'.$producto->adjunto) }}" target="_blank" title="ver producto"><x-icon.clip class="text-orange-500 w-7 hover:text-orange-700 "/></a>
                        @endif --}}

                    </x-jet-nav-link>
                </div>
            </div>
        </div>
    </div>
</nav>
