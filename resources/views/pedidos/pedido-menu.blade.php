<nav x-data="{ open: false }" class="bg-gray-100 border-b border-gray-100 rounded-md">
    <!-- Administration Navigation Menu -->
    <div class="px-2 mx-auto sm:px-2 lg:px-2">
        <div class="flex justify-between ">
            <div class="flex">
                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:flex">
                    <x-jet-nav-link href="{{route('pedido.editar',[$pedido,$ruta])}}" :active="request()->routeIs('pedido.editar')">
                        Pedido
                    </x-jet-nav-link>
                    <x-jet-nav-link href="{{route('pedido.parciales',[$pedido,'e'])}}" :active="request()->routeIs('pedido.parciales')">
                        Albaranes
                    </x-jet-nav-link>
                    <x-jet-nav-link href="{{route('pedido.distribuciones',[$pedido,'e'])}}" :active="request()->routeIs('pedido.distribuciones')">
                        Distribuciones
                    </x-jet-nav-link>
                    <x-jet-nav-link href="{{route('pedido.archivos',[$pedido,'e'])}}" :active="request()->routeIs('pedido.archivos')">
                        <x-icon.clip/>Archivos
                    </x-jet-nav-link>
                    <x-jet-nav-link href="{{route('pedido.presupuestos',[$pedido,'e'])}}" :active="request()->routeIs('pedido.presupuestos')">
                        Presupuestos
                    </x-jet-nav-link>
                    <x-jet-nav-link href="{{route('pedido.incidencias',[$pedido,'e'])}}" :active="request()->routeIs('pedido.incidencias')">
                        Incidencias
                    </x-jet-nav-link>
                    <x-jet-nav-link href="{{route('pedido.retrasos',[$pedido,'e'])}}" :active="request()->routeIs('pedido.retrasos')">
                        Retrasos
                    </x-jet-nav-link>
                    <x-jet-nav-link href="{{route('pedido.facturaciones',[$pedido,'e'])}}" :active="request()->routeIs('pedido.facturaciones')">
                        <x-icon.euro/>Facturación
                    </x-jet-nav-link>
                </div>
            </div>
        </div>
    </div>
</nav>
