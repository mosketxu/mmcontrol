<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="px-4 mx-auto sm:px-6 lg:px-8">
        <div class="flex justify-between h-12">
            <div class="flex">
                <!-- Logo -->
                <div class="flex items-center shrink-0">
                    <a href="{{ route('dashboard') }}">
                        <x-jet-application-mark class="block w-auto h-9" />
                    </a>
                </div>

                <!-- Navigation Links -->
                {{-- <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-jet-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-jet-nav-link>
                </div> --}}
                @can('entidad.index')
                <div class="hidden pt-2 text-left sm:flex lg:flex lg:ml-20 lg:space-x-8 ">
                    <x-jet-dropdown  align="left"  >
                        <x-slot name="trigger">
                            <span class="inline-flex rounded-md">
                                <button type="button" class="inline-flex items-center px-1 py-2 text-sm font-medium leading-4 text-gray-500 transition bg-white border border-transparent rounded-md bg-blu hover:bg-gray-50 hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-blue-700">
                                    Contactos
                                    <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </span>
                        </x-slot>
                        <x-slot name="content">
                            <div class="w-44">
                                <x-jet-dropdown-link href="{{ route('entidad.tipo','1') }}" class="text-left">
                                    Clientes
                                </x-jet-dropdown-link>
                            </div>
                            <div class="w-44">
                                <x-jet-dropdown-link href="{{ route('entidad.tipo','3') }}" class="text-left">
                                    Proveedores
                                </x-jet-dropdown-link>
                            </div>
                            <div class="w-44">
                                <x-jet-dropdown-link href="{{ route('entidad.tipo','4') }}" class="text-left">
                                    Prospección/Colaboradores
                                </x-jet-dropdown-link>
                            </div>
                            <div class="w-44">
                                <x-jet-dropdown-link href="{{ route('entidad.tipo','0') }}" class="text-left">
                                    Contactos
                                </x-jet-dropdown-link>
                            </div>
                        </x-slot>
                    </x-jet-dropdown>
                </div>
                @endcan
                @can('producto.index')
                <div class="hidden pt-2 text-left sm:flex lg:flex lg:ml-20 lg:space-x-8 ">
                    <x-jet-dropdown  align="left" width="60" >
                        <x-slot name="trigger">
                            <span class="inline-flex rounded-md">
                                <button type="button" class="inline-flex items-center px-1 py-2 text-sm font-medium leading-4 text-gray-500 transition bg-white border border-transparent rounded-md bg-blu hover:bg-gray-50 hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-blue-700">
                                    Productos
                                    <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </span>
                        </x-slot>
                        <x-slot name="content">
                            <div class="w-44">
                                <x-jet-dropdown-link href="{{ route('producto.tipo','1' ) }}" class="text-left">
                                    Editorial
                                </x-jet-dropdown-link>
                            </div>
                            <div class="w-44">
                                <x-jet-dropdown-link href="{{ route('producto.tipo','2' ) }}" class="text-left">
                                    Packaging y propios
                                </x-jet-dropdown-link>
                            </div>
                            <div class="border-t border-gray-100"></div>
                            @can('caracteristicas.index')
                            <div class="w-44">
                                <x-jet-dropdown-link href="{{ route('caracteristicas' ) }}" class="text-left bg-gray-100">
                                    Características
                                </x-jet-dropdown-link>
                            </div>
                            @endcan
                        </x-slot>
                    </x-jet-dropdown>
                </div>
                @endcan
                @can('presupuesto.index')
                <div class="hidden pt-2 text-left sm:flex lg:flex lg:ml-20 lg:space-x-8 ">
                    <x-jet-dropdown  align="left" width="60" >
                        <x-slot name="trigger">
                            <span class="inline-flex rounded-md">
                                <button type="button" class="inline-flex items-center px-1 py-2 text-sm font-medium leading-4 text-gray-500 transition bg-white border border-transparent rounded-md bg-blu hover:bg-gray-50 hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-blue-700">
                                    Pres.Imprenta
                                    <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </span>
                        </x-slot>
                        <x-slot name="content">
                            <div class="w-44">
                                <x-jet-dropdown-link href="{{ route('presupuesto.tipo',['1','i'] ) }}" class="text-left">
                                    Editorial
                                </x-jet-dropdown-link>
                            </div>
                            <div class="w-44">
                                <x-jet-dropdown-link href="{{ route('presupuesto.tipo',['2','i'] ) }}" class="text-left">
                                    Pack/Propios
                                </x-jet-dropdown-link>
                            </div>
                        </x-slot>
                    </x-jet-dropdown>
                </div>
                @endcan
                @can('oferta.index')
                <div class="hidden pt-2 text-left sm:flex lg:flex lg:ml-20 lg:space-x-8 ">
                    <x-jet-dropdown  align="left" width="60" >
                        <x-slot name="trigger">
                            <span class="inline-flex rounded-md">
                                <button type="button" class="inline-flex items-center px-1 py-2 text-sm font-medium leading-4 text-gray-500 transition bg-white border border-transparent rounded-md bg-blu hover:bg-gray-50 hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-blue-700">
                                    Presup.MM
                                    <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </span>
                        </x-slot>
                        <x-slot name="content">
                            <div class="w-44">
                                <x-jet-dropdown-link href="{{ route('oferta.tipo','1' ) }}" class="text-left">
                                    Editorial
                                </x-jet-dropdown-link>
                            </div>
                            <div class="w-44">
                                <x-jet-dropdown-link href="{{ route('oferta.tipo','2' ) }}" class="text-left">
                                    Packaging y propios
                                </x-jet-dropdown-link>
                            </div>
                        </x-slot>
                    </x-jet-dropdown>
                </div>
                @endcan
                @can('pedido.index')
                <div class="hidden pt-2 text-left sm:flex lg:flex lg:ml-20 lg:space-x-8 ">
                    <x-jet-dropdown  align="left" width="60" >
                        <x-slot name="trigger">
                            <span class="inline-flex rounded-md">
                                <button type="button" class="inline-flex items-center px-1 py-2 text-sm font-medium leading-4 text-gray-500 transition bg-white border border-transparent rounded-md bg-blu hover:bg-gray-50 hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-blue-700">
                                    Pedidos
                                    <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </span>
                        </x-slot>
                        <x-slot name="content">
                            <div class="w-44">
                                <x-jet-dropdown-link href="{{ route('pedido.tipo',['1','i'] ) }}" class="text-left">
                                    Editorial
                                </x-jet-dropdown-link>
                            </div>
                            <div class="w-44">
                                <x-jet-dropdown-link href="{{ route('pedido.tipo',['2','i'] ) }}" class="text-left">
                                    Packaging/Propios
                                </x-jet-dropdown-link>
                            </div>
                        </x-slot>
                    </x-jet-dropdown>
                </div>
                @endcan

                @can('facturacion.index')
                <div class="hidden text-left sm:flex lg:flex lg:ml-20 lg:space-x-8 ">
                    <x-jet-nav-link href="{{ route('facturacion.index') }}" :active="request()->routeIs('facturacion.index')">
                        {{ __('Facturación') }}
                    </x-jet-nav-link>
                </div>
                @endcan
                @can('seguridad.index')
                <div class="hidden text-left sm:flex lg:flex lg:ml-20 lg:space-x-8 ">
                    <x-jet-nav-link href="{{ route('seguridad') }}" :active="request()->routeIs('seguridad')">
                        {{ __('Seguridad') }}
                    </x-jet-nav-link>
                </div>
                @endcan
            </div>
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <!-- Settings Dropdown -->
                <div class="relative ml-3">
                    <x-jet-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                <button class="flex text-sm transition border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300">
                                    <img class="object-cover w-8 h-8 rounded-full" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                                </button>
                            @else
                                <span class="inline-flex rounded-md">
                                    <button type="button" class="inline-flex items-center px-1 py-2 text-sm font-medium leading-4 text-gray-500 transition bg-white border border-transparent rounded-md hover:text-gray-700 focus:outline-none">
                                        {{ Auth::user()->name }}
                                        <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </span>
                            @endif
                        </x-slot>
                        <x-slot name="content">
                            <!-- Account Management -->
                            <div class="block px-4 py-2 text-xs text-gray-400">
                                {{ __('Manage Account') }}
                            </div>
                            <x-jet-dropdown-link href="{{ route('profile.show') }}">
                                {{ __('Profile') }}
                            </x-jet-dropdown-link>
                            @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                                <x-jet-dropdown-link href="{{ route('api-tokens.index') }}">
                                    {{ __('API Tokens') }}
                                </x-jet-dropdown-link>
                            @endif
                            <div class="border-t border-gray-100"></div>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-jet-dropdown-link href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-jet-dropdown-link>
                            </form>
                        </x-slot>
                    </x-jet-dropdown>
                </div>
            </div>
            <!-- Hamburger -->
            <div class="flex items-center -mr-2 sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 text-gray-400 transition rounded-md hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500">
                    <svg class="w-6 h-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">

            {{-- <x-jet-responsive-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-jet-responsive-nav-link> --}}
            @can('entidad.index')
            <div class="relative mt-3 ml-3">
                <x-jet-dropdown align="right" width="60" >
                    <x-slot name="trigger">
                        <span class="inline-flex rounded-md">
                            <button type="button" class="inline-flex items-center px-1 py-2 text-sm font-medium leading-4 text-gray-500 transition bg-white border border-transparent rounded-md bg-blu hover:bg-gray-50 hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-blue-700">
                                Contactos
                                <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </span>
                    </x-slot>
                    <x-slot name="content">
                        <div class="w-44">
                            <x-jet-dropdown-link href="{{ route('entidad.tipo','1') }}" class="text-right">
                                {{ __('Clientes') }}
                            </x-jet-dropdown-link>
                            <x-jet-dropdown-link href="{{ route('entidad.tipo','2') }}" class="text-right">
                                {{ __('Proveedores') }}
                            </x-jet-dropdown-link>
                            <x-jet-dropdown-link href="{{ route('entidad.tipo','0') }}" class="text-right">
                                {{ __('Todos') }}
                            </x-jet-dropdown-link>
                        </div>
                    </x-slot>
                </x-jet-dropdown>
            </div>
            @endcan
            @can('producto.index')
            <div class="relative mt-3 ml-3">
                <x-jet-dropdown align="right" width="60" >
                    <x-slot name="trigger">
                        <span class="inline-flex rounded-md">
                            <button type="button" class="inline-flex items-center px-1 py-2 text-sm font-medium leading-4 text-gray-500 transition bg-white border border-transparent rounded-md bg-blu hover:bg-gray-50 hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-blue-700">
                                Packaging/Propios
                                <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </span>
                    </x-slot>
                    <x-slot name="content">
                        <div class="w-44">
                            <x-jet-dropdown-link href="{{ route('producto.tipo','1') }}" class="text-right">
                                {{ __('Editorial') }}
                            </x-jet-dropdown-link>
                            <x-jet-dropdown-link href="{{ route('producto.tipo','2') }}" class="text-right">
                                {{ __('Packaging y propios') }}
                            </x-jet-dropdown-link>
                            <x-jet-dropdown-link href="{{ route('producto.tipo','0') }}" class="text-right">
                                {{ __('Todos') }}
                            </x-jet-dropdown-link>
                            <div class="border-t border-gray-100"></div>
                            @can('caracteristicas.index')
                            <x-jet-dropdown-link href="{{ route('caracteristicas') }}" class="text-right">
                                {{ __('Características') }}
                            </x-jet-dropdown-link>
                            @endcan
                        </div>
                    </x-slot>
                </x-jet-dropdown>
            </div>
            @endcan
            @can('presupuesto.index')
            <div class="relative mt-3 ml-3">
                <x-jet-dropdown align="right" width="60" >
                    <x-slot name="trigger">
                        <span class="inline-flex rounded-md">
                            <button type="button" class="inline-flex items-center px-1 py-2 text-sm font-medium leading-4 text-gray-500 transition bg-white border border-transparent rounded-md bg-blu hover:bg-gray-50 hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-blue-700">
                                Pres.Imprenta
                                <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </span>
                    </x-slot>
                    <x-slot name="content">
                        <div class="w-44">
                            <x-jet-dropdown-link href="{{ route('presupuesto.tipo',['1','i']) }}" class="text-right">
                                {{ __('Editorial') }}
                            </x-jet-dropdown-link>
                            <x-jet-dropdown-link href="{{ route('presupuesto.tipo',['2','i']) }}" class="text-right">
                                {{ __('Packaging/Propios') }}
                            </x-jet-dropdown-link>
                        </div>
                    </x-slot>
                </x-jet-dropdown>
            </div>
            @endcan
            @can('oferta.index')
            <div class="relative mt-3 ml-3">
                <x-jet-dropdown align="right" width="60" >
                    <x-slot name="trigger">
                        <span class="inline-flex rounded-md">
                            <button type="button" class="inline-flex items-center px-1 py-2 text-sm font-medium leading-4 text-gray-500 transition bg-white border border-transparent rounded-md bg-blu hover:bg-gray-50 hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-blue-700">
                                Pres.MM
                                <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </span>
                    </x-slot>
                    <x-slot name="content">
                        <div class="w-44">
                            <x-jet-dropdown-link href="{{ route('oferta.tipo','1') }}" class="text-right">
                                {{ __('Editorial') }}
                            </x-jet-dropdown-link>
                            <x-jet-dropdown-link href="{{ route('oferta.tipo','2') }}" class="text-right">
                                {{ __('Packaging y propios') }}
                            </x-jet-dropdown-link>
                            <x-jet-dropdown-link href="{{ route('oferta.tipo','0') }}" class="text-right">
                                {{ __('Todos') }}
                            </x-jet-dropdown-link>
                        </div>
                    </x-slot>
                </x-jet-dropdown>
            </div>
            @endcan
            @can('pedido.index')
            <div class="relative mt-3 ml-3">
                <x-jet-dropdown align="right" width="60" >
                    <x-slot name="trigger">
                        <span class="inline-flex rounded-md">
                            <button type="button" class="inline-flex items-center px-1 py-2 text-sm font-medium leading-4 text-gray-500 transition bg-white border border-transparent rounded-md bg-blu hover:bg-gray-50 hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-blue-700">
                                Pedidos
                                <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </span>
                    </x-slot>
                    <x-slot name="content">
                        <div class="w-44">
                            <x-jet-dropdown-link href="{{ route('pedido.index',['1','i']) }}" class="text-right">
                                {{ __('Editorial') }}
                            </x-jet-dropdown-link>
                            <x-jet-dropdown-link href="{{ route('pedido.index',['2','i']) }}" class="text-right">
                                {{ __('Packaging/Propios') }}
                            </x-jet-dropdown-link>
                        </div>
                    </x-slot>
                </x-jet-dropdown>
            </div>
            @endcan
            @can('facturacion.index')
            <x-jet-responsive-nav-link href="{{ route('facturacion.index') }}" :active="request()->routeIs('facturacion.index')">
                {{ __('Facturación') }}
            </x-jet-responsive-nav-link>
            @endcan
            @can('seguridad.index')
            <x-jet-responsive-nav-link href="{{ route('seguridad') }}" :active="request()->routeIs('seguridad')">
                {{ __('Seguridad') }}
            </x-jet-responsive-nav-link>
            @endcan
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="flex items-center px-4">
                @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                    <div class="mr-3 shrink-0">
                        <img class="object-cover w-10 h-10 rounded-full" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                    </div>
                @endif

                <div>
                    <div class="text-base font-medium text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="text-sm font-medium text-gray-500">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <!-- Account Management -->
                <x-jet-responsive-nav-link href="{{ route('profile.show') }}" :active="request()->routeIs('profile.show')">
                    {{ __('Profile') }}
                </x-jet-responsive-nav-link>

                @can('seguridad.index')
                <x-jet-responsive-nav-link href="{{ route('seguridad') }}" :active="request()->routeIs('seguridad')">
                    {{ __('Seguridad') }}
                </x-jet-dropdown-link>
                @endcan
                @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                    <x-jet-responsive-nav-link href="{{ route('api-tokens.index') }}" :active="request()->routeIs('api-tokens.index')">
                        {{ __('API Tokens') }}
                    </x-jet-responsive-nav-link>
                @endif

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}" x-data>
                    @csrf

                    <x-jet-responsive-nav-link href="{{ route('logout') }}"
                                   @click.prevent="$root.submit();">
                        {{ __('Log Out') }}
                    </x-jet-responsive-nav-link>
                </form>

                <!-- Team Management -->
                @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
                    <div class="border-t border-gray-200"></div>

                    <div class="block px-4 py-2 text-xs text-gray-400">
                        {{ __('Manage Team') }}
                    </div>

                    <!-- Team Settings -->
                    <x-jet-responsive-nav-link href="{{ route('teams.show', Auth::user()->currentTeam->id) }}" :active="request()->routeIs('teams.show')">
                        {{ __('Team Settings') }}
                    </x-jet-responsive-nav-link>

                    {{-- @can('create', Laravel\Jetstream\Jetstream::newTeamModel()) --}}
                        <x-jet-responsive-nav-link href="{{ route('teams.create') }}" :active="request()->routeIs('teams.create')">
                            {{ __('Create New Team') }}
                        </x-jet-responsive-nav-link>
                    {{-- @endcan --}}

                    <div class="border-t border-gray-200"></div>

                    <!-- Team Switcher -->
                    <div class="block px-4 py-2 text-xs text-gray-400">
                        {{ __('Switch Teams') }}
                    </div>

                    @foreach (Auth::user()->allTeams() as $team)
                        <x-jet-switchable-team :team="$team" component="jet-responsive-nav-link" />
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</nav>
