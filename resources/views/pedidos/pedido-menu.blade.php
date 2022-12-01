<nav x-data="{ open: false }" class="bg-gray-100 border-b border-gray-100 rounded-md">
    <!-- Administration Navigation Menu -->
    <div class="w-full px-2 mx-auto sm:px-2 lg:px-2">
        <div class="flex justify-between ">
            <div class="flex mr-5">
                <!-- Navigation Links -->
                <div class="hidden space-x-2 sm:-my-px sm:flex">
                    <x-jet-nav-link href="{{route('pedido.editar',[$pedido,$ruta])}}" :active="request()->routeIs('pedido.editar')">
                        <x-icon.edit class="text-gray-500 hover:text-gray-900"/>Pedido
                    </x-jet-nav-link>
                    <x-jet-nav-link href="{{route('pedido.parciales',[$pedido,$ruta])}}" :active="request()->routeIs('pedido.parciales')">
                        <x-icon.truck/>Albaranes
                    </x-jet-nav-link>
                    <x-jet-nav-link href="{{route('pedido.distribuciones',[$pedido,$ruta])}}" :active="request()->routeIs('pedido.distribuciones')">
                        <x-icon.building-circle-arrow-right/>Distribuciones
                    </x-jet-nav-link>
                    <x-jet-nav-link href="{{route('pedido.archivos',[$pedido,$ruta])}}" :active="request()->routeIs('pedido.archivos')">
                        <x-icon.clip/>Archivos
                    </x-jet-nav-link>
                    <x-jet-nav-link href="{{route('pedido.incidencias',[$pedido,$ruta])}}" :active="request()->routeIs('pedido.incidencias')">
                        <x-icon.triangleexclamation class="w-4 text-gray-500 hover:text-gray-900"/> Incidencias
                    </x-jet-nav-link>
                    <x-jet-nav-link href="{{route('pedido.retrasos',[$pedido,$ruta])}}" :active="request()->routeIs('pedido.retrasos')">
                        <x-icon.sandwatch class="w-3 text-gray-500 hover:text-gray-900"/>Retrasos
                    </x-jet-nav-link>
                    <x-jet-nav-link href="{{route('pedido.entrada',[$pedido,$tipo,'i'])}}" target="_blank">
                        <x-icon.pdf class="w-3 text-gray-500 hover:text-gray-900"/>Entrada Pedido
                    </x-jet-nav-link>
                    {{-- <x-jet-nav-link href="{{route('pedido.facturaciones',[$pedido,$ruta])}}" :active="request()->routeIs('pedido.facturaciones')">
                        <x-icon.euro/>Facturación
                    </x-jet-nav-link> --}}
                </div>
            </div>
        </div>
    </div>
</nav>
