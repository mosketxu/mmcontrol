<nav x-data="{ open: false }" class="bg-gray-100 border-b border-gray-100 rounded-md">
    <!-- Administration Navigation Menu -->
    <div class="w-full px-2 mx-auto sm:px-2 lg:px-2">
        <div class="flex justify-between ">
            <div class="flex mr-5">
                <!-- Navigation Links -->
                <div class="space-x-4 sm:-my-px sm:flex">
                    @if (!Auth::user()->hasRole('Cliente'))
                        <x-jet-nav-link href="{{route('compra.editar',[$compra,$ruta])}}" :active="request()->routeIs('compra.editar')">
                            <x-icon.edit class="text-blue-500 hover:text-blue-900" title="Editar"/>
                            <div class="hidden md:flex">Compra</div>
                        </x-jet-nav-link>
                        <x-jet-nav-link href="{{route('compra.albaranes',[$compra,$ruta])}}" :active="request()->routeIs('compra.albaranes')">
                            <x-icon.truck class="{{ $compra->albaranescolor[0] }} hover:{{ $compra->albaranescolor[1] }}" title="Albaranes"/>
                            <div class="hidden md:ml-1 md:flex">Albaranes</div>
                        </x-jet-nav-link>
                        <x-jet-nav-link href="{{route('compra.distribuciones',[$compra,$ruta])}}" :active="request()->routeIs('compra.distribuciones')">
                            <x-icon.building-circle-arrow-right class="{{ $compra->distribucionescolor[0] }} hover:{{ $compra->distribucionescolor[1] }} "  title="Distribuciones"/>
                            <div class="hidden md:ml-1 md:flex">Distribuciones</div>
                        </x-jet-nav-link>
                        <x-jet-nav-link href="{{route('compra.archivos',[$compra,$ruta])}}" :active="request()->routeIs('compra.archivos')">
                            <x-icon.clip  class="w-5 {{ $compra->archivoscolor[0] }} hover:{{ $compra->archivoscolor[1] }} "  title="Archivos"/>
                            <div class="hidden md:ml-1 md:flex">Archivos</div>
                        </x-jet-nav-link>
                        <x-jet-nav-link href="{{route('compra.entrada',[$compra,$tipo,'i'])}}" target="_blank">
                            <x-icon.pdf class="w-4 text-red-500 hover:text-red-900"/>
                            <div class="hidden md:ml-1 md:flex">Entrada compra</div>
                        </x-jet-nav-link>
                    @endif
                 </div>
            </div>
        </div>
    </div>
</nav>
