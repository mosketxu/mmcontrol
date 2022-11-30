<nav x-data="{ open: false }" class="bg-gray-100 border-b border-gray-100 rounded-md">
    <!-- Administration Navigation Menu -->
    <div class="px-4 mx-auto sm:px-6 lg:px-8">
        <div class="flex justify-between ">
            <div class="flex">
                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-jet-nav-link href="{{ route('caracteristicas','encuadernacion') }}" :active="request()->routeIs('encuadernacion')">
                        {{ __('Encuadernación') }}
                    </x-jet-nav-link>
                </div>
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-jet-nav-link href="{{ route('caracteristicas','caja') }}" :active="request()->routeIs('caja')">
                        {{ __('Cajas') }}
                    </x-jet-nav-link>
                </div>
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-jet-nav-link href="{{ route('caracteristicas','formato') }}" :active="request()->routeIs('formato')">
                        {{ __('Formatos') }}
                    </x-jet-nav-link>
                </div>
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-jet-nav-link href="{{ route('caracteristicas','gramaje') }}" :active="request()->routeIs('gramaje')">
                        {{ __('Gramajes') }}
                    </x-jet-nav-link>
                </div>
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-jet-nav-link href="{{ route('caracteristicas','material') }}" :active="request()->routeIs('material')">
                        {{ __('Materiales') }}
                    </x-jet-nav-link>
                </div>
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-jet-nav-link href="{{ route('caracteristicas','plastificado') }}" :active="request()->routeIs('plastificado')">
                        {{ __('Plastificados') }}
                    </x-jet-nav-link>
                </div>
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-jet-nav-link href="{{ route('caracteristicas','tinta') }}" :active="request()->routeIs('tinta')">
                        {{ __('Tintas') }}
                    </x-jet-nav-link>
                </div>
            </div>
        </div>
    </div>
</nav>
