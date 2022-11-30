<x-app-layout>
    <x-slot name="header">
        <div class="flex">
            <div class="">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    {{ __('Características') }}
                </h2>
            </div>
            <div class="ml-5">
                @include('seguridad.caracteristicas-menu')
            </div>
        </div>
    </x-slot>

    <div class="py-3">
        <div class="mx-auto sm:px-6 lg:px-6">
            <div class="overflow-hidden bg-white shadow-xl sm:rounded-lg">
                <div class="grid grid-cols-1 bg-gray-200 bg-opacity-25 md:grid-cols-1">
                    @if($tipo=='caja') @livewire('seguridad.caja') @endif
                    @if($tipo=='encuadernacion') @livewire('seguridad.encuadernacion') @endif
                    @if($tipo=='formato') @livewire('seguridad.formato') @endif
                    @if($tipo=='gramaje') @livewire('seguridad.gramaje') @endif
                    @if($tipo=='material') @livewire('seguridad.material') @endif
                    @if($tipo=='plastificado') @livewire('seguridad.plastificado') @endif
                    @if($tipo=='tinta') @livewire('seguridad.tinta') @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
