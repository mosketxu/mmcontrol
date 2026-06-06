<div class="">
    {{-- @livewire('menu') --}}

    <div class="p-1 mx-2">
        <h1 class="text-2xl font-semibold text-gray-900">Contactos de {{ $entidad->entidad }}</h1>
        <div class="py-1 space-y-4">
            <div class="flex justify-between">
                <div class="flex w-2/4 space-x-2">
                    <input type="text" wire:model="search" class="py-1 border border-blue-100 rounded-lg" placeholder="Búsqueda..." autofocus/>
                </div>
                {{-- <x-button.button  onclick="location.href = '{{ route('entidadcontacto.nuevo',$ent) }}'" color="blue"><x-icon.plus/>Nuevo contacto</x-button.button> --}}
            </div>
            @if (session()->has('success'))
                <div
                    x-data="{ show: true }"
                    x-init="setTimeout(() => show = false, 3000)"
                    x-show="show"
                    class="p-3 mb-4 text-green-700 bg-green-100 border border-green-300 rounded"
                >
                    {{ session('success') }}
                </div>
            @endif

            {{-- tabla contactos --}}
            <div class="flex-col space-y-4">
                <div>
                    <div class="flex items-center py-2 text-sm text-left text-gray-500 bg-blue-100 rounded-t-md">
                        <div class="w-2/12 px-2">{{ __('Contacto') }}</div>
                        <div class="w-1/12 px-2">{{ __('Tfno.') }}</div>
                        <div class="w-3/12 px-2">{{ __('Email Gral.') }}</div>
                        <div class="w-2/12 px-2">{{ __('Departamento') }}</div>
                        <div class="w-3/12 px-2">{{ __('Obs.Contacto') }}</div>
                        <div class="w-1/12 text-center"></div>
                    </div>
                    <div>
                        @forelse ($contactos as $contacto)
                            <div class="flex items-center w-full py-1 text-sm text-left border-t-0 border-y hover:bg-gray-100" wire:loading.class.delay="opacity-50">
                                <div class="w-2/12 px-1">
                                    <input type="text" value="{{ $contacto->entidad }}" class="w-full text-sm font-thin text-gray-500 border-0 rounded-md hover:bg-gray-100"
                                    wire:change="changeEntidad('{{ $contacto->id }}','entidad',$event.target.value)"/>
                                </div>
                                <div class="w-1/12 px-1">
                                    <input type="text" value="{{ $contacto->tfno }}" class="w-full text-sm font-thin text-gray-500 border-0 rounded-md hover:bg-gray-100"
                                    wire:change="changeEntidad('{{ $contacto->id }}','tfno',$event.target.value)"/>
                                </div>
                                <div class="w-3/12 px-1">
                                    <input type="email" value="{{ $contacto->emailgral}}" class="w-full text-sm font-thin text-gray-500 border-0 rounded-md hover:bg-gray-100"
                                    wire:change="changeEntidad('{{ $contacto->id }}','emailgral',$event.target.value)"/>
                                </div>
                                <div class="w-2/12 px-1">
                                    <input type="text" value="{{ $contacto->departamento }}" class="w-full text-sm font-thin text-gray-500 border-0 rounded-md hover:bg-gray-100"
                                    wire:change="changeRelacion('{{ $contacto->id }}','departamento',$event.target.value)"/>
                                </div>
                                <div class="w-3/12 px-1">
                                    <textarea type="text" rows="1" class="w-full text-sm font-thin text-gray-500 border-0 rounded-md hover:bg-gray-100"
                                    wire:change="changeRelacion('{{ $contacto->id }}','comentarios',$event.target.value)">{{ $contacto->comentarios }}</textarea>
                                </div>
                                <div class="flex items-center justify-center w-1/12">
                                    {{-- <x-icon.edit-a href="{{ route('entidad.edit',$contacto->contacto_id) }}"  title="Editar"/> --}}
                                    <x-icon.delete-a wire:click.prevent="delete({{ $contacto['id'] }})" onclick="confirm('¿Estás seguro?') || event.stopImmediatePropagation()" class="w-6 pl-1"  title="Eliminar contacto"/>
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
            </div>
            <div class="flex-col space-y-4">
                {{-- <div class="flex py-2 pl-2 text-sm text-left text-gray-500 bg-green-50 rounded-t-md">
                    <p>Selecciona un contacto o pulsa <a href="{{ route('entidad.createcontacto',$ent->id) }}"><span class="text-blue-600 underline ">AQUÍ</span></a> aqui para crear uno nuevo.</p>
                    <x-jet-validation-errors/>
                </div> --}}
            @if (session()->has('success'))
                <div
                    x-data="{ show: true }"
                    x-init="setTimeout(() => show = false, 3000)"
                    x-show="show"
                    class="p-3 mb-4 text-green-700 bg-green-100 border border-green-300 rounded"
                >
                    {{ session('success') }}
                </div>
            @endif
                <form class="flex items-center w-full py-1 text-sm text-left border-t-0 border-y hover:bg-gray-100" wire:submit.prevent="savecontacto">
                    <input type="hidden" wire:model.defer="entidadId"/>

                    <div class="w-2/12 px-1 form-item">
                        <input type="text"
                            class="w-full text-sm font-thin text-gray-500 border-2 rounded-md hover:bg-gray-100"
                            wire:model.defer="nombre" id="nombre" />
                        <x-jet-input-error for="nombre" />
                    </div>

                    <div class="w-1/12 px-1 form-item">
                        <input type="text"
                            class="w-full text-sm font-thin text-gray-500 border-2 rounded-md hover:bg-gray-100"
                            wire:model.defer="tfno" id="tfno" />
                        <x-jet-input-error for="tfno" />
                    </div>

                    <div class="w-3/12 px-1 form-item">
                        <input type="email"
                            class="w-full text-sm font-thin text-gray-500 border-2 rounded-md hover:bg-gray-100"
                            wire:model.defer="emailgral" id="emailgral"/>
                        <x-jet-input-error for="emailgral" />
                    </div>

                    <div class="w-2/12 px-1 form-item">
                        <input
                            type="text" class="w-full text-sm font-thin text-gray-500 border-2 rounded-md hover:bg-gray-100"
                            wire:model.defer="departamento" id="departamento"/>
                        <x-jet-input-error for="departamento" />
                    </div>

                    <div class="w-3/12 px-1 form-item">
                        <textarea rows="1"
                            class="w-full text-sm font-thin text-gray-500 border-gray-300 rounded-md"
                            wire:model.defer="comentarios" ></textarea>
                        <x-jet-input-error for="comentarios" />
                    </div>

                    <div class="flex items-center justify-center w-1/12">
                        <button type="submit" class="w-7">
                            <x-icon.save-a class="text-blue"></x-icon.save-a>
                        </button>
                    </div>

                </form>
            </div>
            <div class="flex pl-2 mt-2 mb-2 ml-2 space-x-4">
                <div class="space-x-3">
                    {{-- <x-jet-secondary-button  onclick="history.back()">{{ __('Volver') }}</x-jet-secondary-button> --}}
                    {{-- <x-jet-secondary-button  onclick="location.href = '{{route('entidad.index' )}}'">{{ __('Volver') }}</x-jet-secondary-button> --}}
                    <x-jet-secondary-button onclick="location.href='{{ $ruta }}'">{{ __('Volver') }}</x-jet-secondary-button>
                </div>
            </div>
        </div>
    </div>
</div>
