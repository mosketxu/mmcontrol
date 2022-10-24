<div class="">
    {{-- @livewire('menu') --}}

    <div class="p-1 mx-2">
        <h1 class="text-2xl font-semibold text-gray-900">Contactos de {{ $ent->entidad }}
        <div class="py-1 space-y-4">
            <div class="flex justify-between">
                <div class="flex w-2/4 space-x-2">
                    <input type="text" wire:model="search" class="py-1 border border-blue-100 rounded-lg" placeholder="Búsqueda..." autofocus/>
                </div>
                {{-- <x-button.button  onclick="location.href = '{{ route('entidadcontacto.nuevo',$ent) }}'" color="blue"><x-icon.plus/>Nuevo contacto</x-button.button> --}}
            </div>
            {{-- tabla contactos --}}
            <div class="flex-col space-y-4">
                <div>
                    <div class="flex py-2 pl-2 text-sm text-left text-gray-500 bg-blue-100 rounded-t-md">
                        <div class="flex w-4/12 lg:w-4/12" >{{ __('Contacto') }}</div>
                        <div class="hidden w-2/12 lg:flex" >{{ __('Nif') }}</div>
                        <div class="hidden w-1/12 lg:flex" >{{ __('Tfno.') }}</div>
                        <div class="flex w-3/12 lg:w-1/12" >{{ __('Email Gral.') }}</div>
                        <div class="flex w-3/12 lg:w-4/12" >{{ __('Departamento') }}</div>
                        <div class="flex w-3/12 lg:w-4/12" >{{ __('Obs.Contacto') }}</div>
                        <div class="flex w-1/12 " ></div>
                    </div>
                    <div>
                        @forelse ($contactos as $contacto)
                        <div class="flex w-full text-sm text-left border-t-0 border-y" wire:loading.class.delay="opacity-50">
                            <div class="flex w-4/12 lg:w-4/12">
                                <input type="text" value="{{ $contacto->entidad }}" class="w-full text-sm font-thin text-gray-500 border-0 rounded-md" readonly/>
                            </div>
                            <div class="w-2/12 lg:flex">
                                <input type="text" value="{{ $contacto->nif  }}" class="w-full text-sm font-thin text-gray-500 border-0 rounded-md" readonly/>
                            </div>
                            <div class="hidden w-1/12 lg:flex">
                                    <input type="text" value="{{ $contacto->tfno }}" class="w-full text-sm font-thin text-gray-500 border-0 rounded-md"
                                        readonly/>
                                </div>
                                <div class="flex w-3/12 lg:w-1/12">
                                    <input type="text" value="{{ $contacto->emailgral}}" class="w-full text-sm font-thin text-gray-500 border-0 rounded-md"
                                        readonly/>
                                </div>
                                <div class="flex w-3/12 lg:w-4/12">
                                    <input type="email" value="{{ $contacto->departamento }}" class="w-full text-sm font-thin text-gray-500 border-0 rounded-md"
                                        readonly/>
                                </div>
                                <div class="flex w-3/12 lg:w-4/12">
                                    <input type="email" value="{{ $contacto->comentarios }}" class="w-full text-sm font-thin text-gray-500 border-0 rounded-md"
                                        readonly/>
                                </div>
                                <div class="flex w-1/12 ">
                                    <x-icon.edit-a href="{{ route('entidad.edit',$contacto->contacto_id) }}"  title="Editar"/>
                                    <x-icon.delete-a wire:click.prevent="delete({{ $contacto['id'] }})" onclick="confirm('¿Estás seguro?') || event.stopImmediatePropagation()" class="pl-1"  title="Eliminar contacto"/>
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
            <div class="min-w-full overflow-hidden overflow-x-auto align-middle shadow sm:rounded-lg">
                <div class="flex py-2 pl-2 text-sm text-left text-gray-500 bg-green-50 rounded-t-md">
                    <p>Selecciona un contacto o pulsa <a href="{{ route('entidad.createcontacto',$ent->id) }}"><span class="text-blue-600 underline ">AQUÍ</span></a> aqui para crear uno nuevo.</p>
                    <x-jet-validation-errors/>
                </div>
                <form wire:submit.prevent="savecontacto">
                    <div class="flex flex-col my-2 space-y-4 md:space-y-0 md:flex-row md:space-x-2">
                        <x-jet-input  wire:model.defer="entidad.id" type="hidden"/>
                        <div class="w-full form-item">
                            <x-jet-label for="contacto" >{{ __('Contacto') }}</x-jet-label>
                            <x-select wire:model.defer="contacto"  selectname="contacto" class="w-full">
                                <option value="">-- Elige un contacto --</option>
                                @foreach ($entidades as $entidad)
                                <option value="{{ $entidad->id }}">{{ $entidad->entidad }}</option>
                                @endforeach
                            </x-select>
                        </div>
                        <div class="w-full form-item">
                            <x-jet-label for="departamento">{{ __('Departamento') }}</x-jet-label>
                            <x-jet-input  wire:model.defer="departamento" type="text" id="departamento" class="w-full" :value="old('departamento') "/>
                            <x-jet-input-error for="departamento" class="mt-2" />
                        </div>
                        <div class="w-full form-item">
                            <x-jet-label for="comentarios">{{ __('Comentario') }}</x-jet-label>
                            <x-jet-input  wire:model.defer="comentario" type="text" id="comentarios"  class="w-full" :value="old('comentarios')" />
                            <x-jet-input-error for="comentarios" class="mt-2" />
                        </div>
                        <div class="w-full form-item">
                            <x-jet-button class="mt-5 bg-blue-600">
                                {{ __('Añadir contacto') }}
                            </x-jet-button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="flex pl-2 mt-2 mb-2 ml-2 space-x-4">
                <div class="space-x-3">
                    <x-jet-secondary-button  onclick="location.href = '{{route('entidad.index' )}}'">{{ __('Volver') }}</x-jet-secondary-button>
                </div>
            </div>
        </div>
    </div>
</div>
