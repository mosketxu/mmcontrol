<nav x-data="{ open: false }" class="bg-gray-100 border-b border-gray-100 rounded-md">
    <!-- Administration Navigation Menu -->
    <div class="w-full px-2 mx-auto sm:px-2 lg:px-2">
        <div class="flex justify-between ">
            <div class="flex mr-5">
                <!-- Navigation Links -->
                <div class="space-x-4 sm:-my-px sm:flex">
                    @if (!Auth::user()->hasRole('Cliente'))
                        <x-jet-nav-link href="{{route('pedido.editar',[$pedido,$ruta])}}" :active="request()->routeIs('pedido.editar')">
                            <x-icon.edit class="text-blue-500 hover:text-blue-900" title="Editar"/>
                            <div class="hidden md:flex">Pedido</div>
                        </x-jet-nav-link>
                        <x-jet-nav-link href="{{route('pedido.parciales',[$pedido,$ruta])}}" :active="request()->routeIs('pedido.parciales')">
                            <x-icon.truck class="{{ $pedido->parcialescolor[0] }} hover:{{ $pedido->parcialescolor[1] }}" title="Albaranes"/>
                            <div class="hidden md:ml-1 md:flex">Albaranes</div>
                        </x-jet-nav-link>
                        <x-jet-nav-link href="{{route('pedido.distribuciones',[$pedido,$ruta])}}" :active="request()->routeIs('pedido.distribuciones')">
                            <x-icon.building-circle-arrow-right class="{{ $pedido->distribucionescolor[0] }} hover:{{ $pedido->distribucionescolor[1] }} "  title="Distribuciones"/>
                            <div class="hidden md:ml-1 md:flex">Distribuciones</div>
                        </x-jet-nav-link>
                        <x-jet-nav-link href="{{route('pedido.archivos',[$pedido,$ruta])}}" :active="request()->routeIs('pedido.archivos')">
                            <x-icon.clip  class="w-5 {{ $pedido->archivoscolor[0] }} hover:{{ $pedido->archivoscolor[1] }} "  title="Archivos"/>
                            <div class="hidden md:ml-1 md:flex">Archivos</div>
                        </x-jet-nav-link>
                        <x-jet-nav-link href="{{route('pedido.incidencias',[$pedido,$ruta])}}" :active="request()->routeIs('pedido.incidencias')">
                            <x-icon.triangleexclamation class="w-5 {{ $pedido->incidenciascolor[0] }} hover:{{ $pedido->incidenciascolor[1] }} "  title="Incidencias"/>
                            <div class="hidden md:ml-1 md:flex">Incidencias</div>
                        </x-jet-nav-link>
                        <x-jet-nav-link href="{{route('pedido.retrasos',[$pedido,$ruta])}}" :active="request()->routeIs('pedido.retrasos')">
                            <x-icon.sandwatch  class="w-5 {{ $pedido->retrasoscolor[0] }} hover:{{ $pedido->retrasoscolor[1] }} "  title="Retrasos"/>
                            <div class="hidden md:ml-1 md:flex">Retrasos</div>
                        </x-jet-nav-link>
                        <x-jet-nav-link href="{{route('pedido.entrada',[$pedido,$tipo,'i'])}}" target="_blank">
                            <x-icon.pdf class="w-4 text-red-500 hover:text-red-900"/>
                            <div class="hidden md:ml-1 md:flex">Entrada Pedido</div>
                        </x-jet-nav-link>
                    @else
                        <x-jet-nav-link href="{{route('pedido.entrada',[$pedido,$tipo,'i'])}}" target="_blank">
                            <x-icon.pdf class="w-4 text-red-500 hover:text-red-900"/>
                            <div class="hidden md:ml-1 md:flex">Entrada Pedido</div>
                        </x-jet-nav-link>
                    @endif
                 </div>
            </div>
        </div>
    </div>
</nav>
