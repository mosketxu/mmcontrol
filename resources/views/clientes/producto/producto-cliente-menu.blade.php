<nav x-data="{ open: false }" class="bg-gray-100 border-b border-gray-100 rounded-md">
    <!-- Administration Navigation Menu -->
    <div class="px-2 mx-auto sm:px-2 lg:px-2">
        <div class="flex justify-between ">
            <div class="flex">
                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:m-2 sm:flex">
                    <x-jet-nav-link href="{{route('cliente.producto.archivos',[$producto,'e'])}}" :active="request()->routeIs('cliente.producto.archivos')">
                        <x-icon.clip/>Archivos
                    </x-jet-nav-link>
                </div>
                <div class="hidden space-x-8 sm:-my-px sm:m-2 sm:flex">
                    <x-jet-nav-link href="{{route('cliente.producto.ficha', [$producto->id,$tipo,'n']) }}" target="_blank" :active="request()->routeIs('cliente.producto.ficha')">
                        <x-icon.pdf class="text-gray-500 hover:text-gray-700"/>Ficha
                    </x-jet-nav-link>
                </div>
                <div class="hidden space-x-8 sm:-my-px sm:m-2 sm:flex">
                    <x-jet-nav-link href="{{route('cliente.producto.ficha', [$producto->id,$tipo,'r']) }}" target="_blank" :active="request()->routeIs('cliente.producto.ficha')">
                        <x-icon.pdf class="text-gray-500 hover:text-gray-700"/>Ficha reducida
                    </x-jet-nav-link>
                </div>
            </div>
        </div>
    </div>
</nav>
