<div class="">
    {{-- @livewire('menu',['entidad'=>$entidad],key($entidad->id)) --}}

    <div class="p-1 mx-2">
        <div class="flex flex-row">
            <div class="w-6/12">
                <div class="flex flex-row items-center">
                    <div class="">
                        <h1 class="text-2xl font-semibold text-gray-900">{{ $entidad->entidad }}</h1>
                    </div>
                    <div class="">
                        @if($contacto->id)
                            <h1 class="text-2xl font-semibold text-gray-900">{{ $contacto->contacto }}</h1>
                        @else
                            <h1 class="text-2xl font-semibold text-gray-900">Nuevo contacto</h1>
                        @endif
                    </div>
                </div>
            </div>
            <div class="w-6/12 text-right">
            </div>
        </div>

    </div>
    {{-- Errores --}}
    <div class="px-2 py-1 space-y-4" >
        @if ($errors->any())
        <div id="alert" class="relative px-6 py-2 mb-2 text-white bg-red-200 border-red-500 rounded border-1">
            <ul class="mt-3 text-sm text-red-600 list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button class="absolute top-0 right-0 mt-2 mr-6 text-2xl font-semibold leading-none bg-transparent outline-none focus:outline-none" onclick="document.getElementById('alert').remove();">
                <span>×</span>
            </button>
        </div>
        @endif
        @if (session()->has('message'))
            <div id="alert" class="relative px-6 py-2 mb-2 text-white bg-green-200 border-green-500 rounded border-1" >
                <span class="inline-block mx-8 align-middle" >
                    {{ session('message') }}
                </span>
                <button class="absolute top-0 right-0 mt-2 mr-6 text-2xl font-semibold leading-none bg-transparent outline-none focus:outline-none" onclick="document.getElementById('alert').remove();">
                    <span>×</span>
                </button>
            </div>
        @endif
    </div>


    <div class="flex-col space-y-4 text-gray-500">
        <form wire:submit.prevent="save" class="">
            <div class="px-2 mx-2 my-1 rounded-md bg-blue-50">
                <h3 class="font-semibold ">Datos del contacto</h3>
                <x-jet-input  wire:model.defer="contacto.id" type="hidden"/>
                <hr>
            </div>
            <div class="flex flex-col pl-2 mx-2 space-y-4 md:space-y-0 md:flex-row md:space-x-4">
                <div class="w-full form-item">
                    <x-jet-label for="nombre">{{ __('Nombre') }}</x-jet-label>
                    <x-jet-input wire:model.defer="nombre" type="text" class="w-full " id="nombre" name="nombre" :value="old('nombre') "/>
                    <x-jet-input-error for="nombre" class="mt-2" />
                </div>
                <div class="w-full form-item">
                    <x-jet-label for="cargo">{{ __('Cargo') }}</x-jet-label>
                    <x-jet-input wire:model.defer="cargo" type="text" class="w-full " id="cargo" name="cargo" :value="old('cargo') "/>
                    <x-jet-input-error for="cargo" class="mt-2" />
                </div>
            </div>
            <div class="flex flex-col pl-2 mx-2 space-y-4 md:space-y-0 md:flex-row md:space-x-4">
                <div class="w-full form-item">
                    <x-jet-label for="telefono">{{ __('Teléfono') }}</x-jet-label>
                    <x-jet-input wire:model.defer="telefono" type="text" class="w-full " id="telefono" name="telefono" :value="old('telefono') "/>
                    <x-jet-input-error for="telefono" class="mt-2" />
                </div>
                <div class="w-full form-item">
                    <x-jet-label for="movil">{{ __('Móvil') }}</x-jet-label>
                    <x-jet-input wire:model.defer="movil" type="text" class="w-full " id="movil" name="movil" :value="old('movil') "/>
                    <x-jet-input-error for="movil" class="mt-2" />
                </div>
                <div class="w-full form-item">
                    <x-jet-label for="email">{{ __('Email') }}</x-jet-label>
                    <x-jet-input wire:model.defer="email" type="text" class="w-full " id="email" name="email" :value="old('email') "/>
                    <x-jet-input-error for="email" class="mt-2" />
                </div>
            </div>
            <div class="flex pl-2 mt-2 mb-2 ml-2 space-x-4">
                <div class="space-x-3">
                    <x-jet-button class="bg-blue-600">
                        {{ __('Guardar') }}
                    </x-jet-button>
                    <x-jet-secondary-button  onclick="location.href = '{{route('entidad.contactos',$entidad )}}'">{{ __('Volver') }}</x-jet-secondary-button>
                </div>
            </div>
        </form>
    </div>
</div>
