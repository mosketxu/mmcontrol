<nav x-data="{ open: false }" class="bg-gray-100 border-b border-gray-100 rounded-md">
    <!-- Administration Navigation Menu -->
    <div class="w-full px-2 mx-auto sm:px-2 lg:px-2">
        <div class="flex justify-between ">
            <div class="flex mr-5">
                <!-- Navigation Links -->
                <div class="space-x-4 sm:-my-px sm:flex">
                    @if (!Auth::user()->hasRole('Cliente'))
                        <x-jet::nav-link href="{{route('compra.editar',[$compra,$ruta])}}" :active="request()->routeIs('compra.editar')">
                            <x-icon.edit class="text-blue-500 hover:text-blue-900" title="Editar"/>
                            <div class="hidden md:flex">Compra</div>
                        </x-jet::nav-link>
                        {{-- Pestañas Albaranes / Distribuciones / Archivos / "Entrada compra":
                             pendientes de implementar en CompraController (módulo Compras parcial). --}}
                    @endif
                 </div>
            </div>
        </div>
    </div>
</nav>
