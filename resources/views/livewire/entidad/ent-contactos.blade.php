<div class="">
    {{-- @livewire('menu') --}}

    <div class="p-1 mx-2">

        <h1 class="text-2xl font-semibold text-gray-900">Contactos de {{ $entidad->entidad }}
        <div class="py-1 space-y-4">
            <div class="flex justify-between">
                <div class="flex w-2/4 space-x-2">
                    <input type="text" wire:model="search" class="py-1 border border-blue-100 rounded-lg" placeholder="Búsqueda..." autofocus/>
                </div>
                    <x-button.button  onclick="location.href = '{{ route('entidadcontacto.nuevo',$entidad) }}'" color="blue"><x-icon.plus/>Nuevo contacto</x-button.button>
            </div>
            {{-- tabla contactos --}}
            <div class="flex-col space-y-4">
                <div>
                    <div class="flex pl-2 py-2 text-sm text-left text-gray-500 rounded-t-md  bg-blue-100">
                        <div class="w-4/12 flex lg:w-4/12" >{{ __('Contacto') }}</div>
                        <div class="w-2/12 hidden lg:flex" >{{ __('Cargo') }}</div>
                        <div class="w-1/12 hidden lg:flex" >{{ __('Tfno.') }}</div>
                        <div class="w-2/12 flex lg:w-1/12" >{{ __('Móvil.') }}</div>
                        <div class="w-4/12 flex lg:w-4/12" >{{ __('Email.') }}</div>
                        <div class="w-1/12 flex " ></div>
                    </div>
                    <div>
                        @forelse ($contactos as $contacto)
                            <div class="w-full flex text-sm text-left border-y border-t-0" wire:loading.class.delay="opacity-50">
                                <div class="w-4/12 flex lg:w-4/12">
                                    <input type="text" value="{{ $contacto->contacto }}" class="w-full text-sm font-thin text-gray-500 border-0 rounded-md"
                                        readonly/>
                                </div>
                                <div class="w-2/12 hidden lg:flex">
                                    <input type="text" value="{{ $contacto->cargo}}" class="w-full text-sm font-thin text-gray-500 border-0 rounded-md"
                                        readonly/>
                                </div>
                                <div class="w-1/12 hidden lg:flex">
                                    <input type="text" value="{{ $contacto->telefono }}" class="w-full text-sm font-thin text-gray-500 border-0 rounded-md"
                                        readonly/>
                                </div>
                                <div class="w-2/12 flex lg:w-1/12">
                                    <input type="text" value="{{ $contacto->movil}}" class="w-full text-sm font-thin text-gray-500 border-0 rounded-md"
                                        readonly/>
                                </div>
                                <div class="w-4/12 flex lg:w-4/12">
                                    <input type="email" value="{{ $contacto->email }}" class="w-full text-sm font-thin text-gray-500 border-0 rounded-md"
                                        readonly/>
                                </div>
                                <div class="w-1/12 flex ">
                                    <x-icon.edit-a href="{{ route('entidadcontacto.edit',$contacto->id) }}"  title="Editar"/>
                                    <x-icon.delete-a wire:click.prevent="delete({{ $contacto->id }})" onclick="confirm('¿Estás seguro?') || event.stopImmediatePropagation()" class="pl-1"/>
                                </div>
                            </div>
                        @empty
                            <div>
                                <div colspan="10">
                                    <div class="flex items-center justify-center">
                                        <x-icon.inbox class="w-8 h-8 text-gray-300"/>
                                        <span class="py-5 text-xl font-medium text-gray-500">
                                            No se han encontrado datos...
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>
                <div>
                    {{ $contactos->links() }}
                </div>
            </div>
            <div class="flex pl-2 mt-2 mb-2 ml-2 space-x-4">
                <div class="space-x-3">
                    {{-- <x-jet-button class="bg-blue-600">
                        {{ __('Guardar') }}
                    </x-jet-button> --}}
                    <x-jet-secondary-button  onclick="location.href = '{{route('entidad.index' )}}'">{{ __('Volver') }}</x-jet-secondary-button>
                </div>
            </div>

        </div>
    </div>
</div>
