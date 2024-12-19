<nav x-data="{ open: false }" class="bg-gray-100 border-b border-gray-100 rounded-md">
    <!-- Administration Navigation Menu -->
    <div class="w-full px-2 mx-auto sm:px-2 lg:px-2">
        <div class="flex justify-between ">
            <div class="flex mr-5">
                <!-- Navigation Links -->
                <div class="hidden space-x-4 sm:-my-px sm:flex">
                    <x-jet-nav-link href="{{route('pedido.editar',[$pedido,$ruta])}}" :active="request()->routeIs('pedido.editar')">
                        <x-icon.edit class="text-gray-500 hover:text-gray-900"/>
                        <div class="hidden md:flex">Pedido</div>
                    </x-jet-nav-link>
                    <x-jet-nav-link href="{{route('pedido.subpedidos',[$pedido,$ruta])}}" :active="request()->routeIs('pedido.subpedidos')">
                        <x-icon.folder-tree class="bg-green-200 hover:bg-green-500" title="Subpedidos"/>
                        <div class="hidden md:ml-1 md:flex">Subpedidos</div>
                    </x-jet-nav-link>
                    <x-jet-nav-link href="{{route('pedido.tareas',[$pedido,$ruta])}}" :active="request()->routeIs('pedido.tareas')">
                        <x-icon.calendar-day class="bg-green-200 hover:bg-green-500" title="tareas"/>
                        <div class="hidden md:ml-1 md:flex">Subpedidos</div>
                    </x-jet-nav-link>
                    <x-jet-nav-link href="{{route('pedido.parciales',[$pedido,$ruta])}}" :active="request()->routeIs('pedido.parciales')">
                        <x-icon.truck/>
                        <div class="hidden md:flex">Albaranes</div>
                    </x-jet-nav-link>
                    <x-jet-nav-link href="{{route('pedido.distribuciones',[$pedido,$ruta])}}" :active="request()->routeIs('pedido.distribuciones')">
                        <x-icon.building-circle-arrow-right/>
                        <div class="hidden md:flex">Distribuciones</div>
                    </x-jet-nav-link>
                    <x-jet-nav-link href="{{route('pedido.archivos',[$pedido,$ruta])}}" :active="request()->routeIs('pedido.archivos')">
                        <div class="w-5"><x-icon.clip/></div>
                        <div class="hidden md:flex">Archivos</div>
                    </x-jet-nav-link>
                    <x-jet-nav-link href="{{route('pedido.incidencias',[$pedido,$ruta])}}" :active="request()->routeIs('pedido.incidencias')">
                        <x-icon.triangleexclamation class="w-4 text-gray-500 hover:text-gray-900"/>
                        <div class="hidden md:flex">Incidencias</div>
                    </x-jet-nav-link>
                    <x-jet-nav-link href="{{route('pedido.retrasos',[$pedido,$ruta])}}" :active="request()->routeIs('pedido.retrasos')">
                        <x-icon.sandwatch class="w-3 text-gray-500 hover:text-gray-900"/>
                        <div class="hidden md:flex">Retrasos</div>
                    </x-jet-nav-link>
                    <x-jet-nav-link href="{{route('pedido.entrada',[$pedido,$tipo,'i'])}}" target="_blank">
                        <x-icon.pdf class="w-3 text-gray-500 hover:text-gray-900"/>
                        <div class="hidden md:flex">Entrada Pedido</div>
                    </x-jet-nav-link>
                </div>
            </div>
        </div>
    </div>
</nav>
