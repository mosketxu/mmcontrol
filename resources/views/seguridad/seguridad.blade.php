<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center gap-y-2">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                {{ __('Seguridad') }}
            </h2>

            <nav class="flex flex-wrap gap-2 ml-6">
                @foreach (['usuarios' => 'Usuarios', 'roles' => 'Roles', 'responsables' => 'Responsables', 'permisos' => 'Permisos', 'cuentasbancarias' => 'Cuentas Bancarias'] as $slug => $label)
                    <a href="{{ route('seguridad', $slug) }}"
                        class="px-4 py-1.5 text-sm font-medium rounded-md transition
                            {{ $tab === $slug
                                ? 'bg-blue-600 text-white shadow-sm'
                                : 'bg-white text-gray-600 border border-gray-300 hover:bg-gray-50 hover:text-gray-800' }}">
                        {{ __($label) }}
                    </a>
                @endforeach
            </nav>
        </div>
    </x-slot>

    <div class="py-3">
        <div class="mx-auto sm:px-6 lg:px-6">
            <div class="overflow-hidden bg-white shadow-xl sm:rounded-lg">
                <div class="p-1 bg-gray-200 bg-opacity-25">
                    @switch($tab)
                        @case('usuarios')
                            @livewire('seguridad.usuarios')
                            @break
                        @case('roles')
                            @livewire('seguridad.roles')
                            @break
                        @case('responsables')
                            @livewire('seguridad.responsables')
                            @break
                        @case('permisos')
                            @livewire('seguridad.permisos')
                            @break
                        @case('cuentasbancarias')
                            @livewire('seguridad.cuentas-bancarias')
                            @break
                    @endswitch
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
