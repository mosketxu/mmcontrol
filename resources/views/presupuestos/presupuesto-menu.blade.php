<nav x-data="{ open: false }" class="bg-gray-100 border-b border-gray-100 rounded-md">
    <!-- Administration Navigation Menu -->
    <div class="px-2 mx-auto sm:px-2 lg:px-2">
        <div class="flex justify-between ">
            <div class="flex">
                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:flex">
                    @if(!Auth::user()->hasRole('Cliente'))
                    <x-jet-nav-link href="{{route('presupuesto.editar',[$presupuesto,$ruta])}}" :active="request()->routeIs('presupuesto.editar')">
                        <x-icon.edit class="text-gray-500 hover:text-gray-900"/>Presupuesto
                    </x-jet-nav-link>
                    <x-jet-nav-link href="{{route('presupuesto.archivos',[$presupuesto,$ruta])}}" :active="request()->routeIs('presupuesto.archivos')">
                        <x-icon.clip/>Archivos
                    </x-jet-nav-link>
                    @else
                    <x-jet-nav-link href="{{route('cliente.presupuesto.archivos',[$presupuesto,$ruta])}}" :active="request()->routeIs('presupuesto.archivos')">
                        <x-icon.clip/>Archivos
                    </x-jet-nav-link>
                    @endif
                    <x-jet-nav-link href="{{route('presupuesto.presupuestoPDF',[$presupuesto,'n','ES'])}}" target="_blank"  :active="request()->routeIs('presupuesto.presupuestoPDF')">
                        <x-icon.pdf/>PDF ES
                    </x-jet-nav-link>
                    <x-jet-nav-link href="{{route('presupuesto.presupuestoPDF',[$presupuesto,'n','EN'])}}" target="_blank"  :active="request()->routeIs('presupuesto.presupuestoPDF')">
                        <x-icon.pdf/>PDF EN
                    </x-jet-nav-link>
                </div>
            </div>
        </div>
    </div>
</nav>
