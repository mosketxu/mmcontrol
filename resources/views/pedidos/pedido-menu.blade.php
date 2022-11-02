<nav x-data="{ open: false }" class="bg-gray-100 border-b border-gray-100 rounded-md">
    <!-- Administration Navigation Menu -->
    <div class="px-4 mx-auto sm:px-6 lg:px-8">
        <div class="flex justify-between ">
            <div class="flex">
                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-jet-nav-link href="{{route('pedido.parciales',[$pedido,'e'])}}" :active="request()->routeIs('pedido.parciales')">
                        <x-icon.cubes/>Parciales
                    </x-jet-nav-link>
                </div>
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-jet-nav-link href="{{route('pedido.facturaciones',[$pedido,'e'])}}" :active="request()->routeIs('pedido.facturaciones')">
                        <x-icon.euro/>Facturaciones
                    </x-jet-nav-link>
                </div>
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-jet-nav-link href="{{route('pedido.archivos',[$pedido,'e'])}}" :active="request()->routeIs('pedido.archivos')">
                        <x-icon.clip/>Archivos
                    </x-jet-nav-link>
                </div>
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-jet-nav-link href="{{route('pedido.incidencias',[$pedido,'e'])}}" :active="request()->routeIs('pedido.incidencias')">
                        Incidencias
                    </x-jet-nav-link>
                </div>
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-jet-nav-link href="{{route('pedido.retrasos',[$pedido,'e'])}}" :active="request()->routeIs('pedido.retrasos')">
                        Retrasos
                    </x-jet-nav-link>
                </div>
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-jet-nav-link href="{{route('pedido.distribuciones',[$pedido,'e'])}}" :active="request()->routeIs('pedido.distribuciones')">
                        Distribuciones
                    </x-jet-nav-link>
                </div>
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-jet-nav-link href="{{route('pedido.presupuesto',[$pedido,'e'])}}" :active="request()->routeIs('pedido.presupuesto')">
                        Presupuesto
                    </x-jet-nav-link>
                </div>
            </div>
        </div>
    </div>
</nav>
