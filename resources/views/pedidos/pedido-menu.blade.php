<nav x-data="{ open: false }" class="bg-gray-100 border-b border-gray-100 rounded-md">
    <!-- Administration Navigation Menu -->
    <div class="px-2 mx-auto sm:px-2 lg:px-2">
        <div class="flex justify-between ">
            <div class="flex">
                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:flex">
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
                    <x-jet-nav-link href="{{route('pedido.presupuestos',[$pedido,$ruta])}}" :active="request()->routeIs('pedido.presupuestos')">
                        <x-icon.dolarcomment/>Presupuestos
                    </x-jet-nav-link>
                    <x-jet-nav-link href="{{route('pedido.incidencias',[$pedido,$ruta])}}" :active="request()->routeIs('pedido.incidencias')">
                        <x-icon.triangleexclamation class="w-4 text-gray-500 hover:text-gray-900"/> Incidencias
                    </x-jet-nav-link>
                    <x-jet-nav-link href="{{route('pedido.retrasos',[$pedido,$ruta])}}" :active="request()->routeIs('pedido.retrasos')">
                        <x-icon.sandwatch class="w-3 text-gray-500 hover:text-gray-900"/>Retrasos
                    </x-jet-nav-link>
                    {{-- <x-jet-nav-link href="{{route('pedido.facturaciones',[$pedido,$ruta])}}" :active="request()->routeIs('pedido.facturaciones')">
                        <x-icon.euro/>Facturación
                    </x-jet-nav-link> --}}
                </div>
            </div>
        </div>
    </div>
</nav>
