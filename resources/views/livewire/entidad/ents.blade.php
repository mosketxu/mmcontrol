<div class="">
    {{-- @livewire('menu') --}}

    <div class="p-1 mx-2">
        <h1 class="text-2xl font-semibold text-gray-900">{{ $entidadtipo->nombreplural }}
        <div class="py-1 space-y-4">
            @if (session()->has('message'))
                <div id="alert" class="relative px-6 py-2 mb-2 text-white bg-red-200 border-red-500 rounded border-1">
                    <span class="inline-block mx-8 align-middle">
                        {{ session('message') }}
                    </span>
                    <button class="absolute top-0 right-0 mt-2 mr-6 text-2xl font-semibold leading-none bg-transparent outline-none focus:outline-none" onclick="document.getElementById('alert').remove();">
                        <span>×</span>
                    </button>
                </div>
            @endif
            <x-jet-validation-errors></x-jet-validation-errors>
            <div class="flex justify-between">
                <div class="flex space-x-2">
                    <div class="w-full text-xs">
                        <input type="text" wire:model="search" class="w-full py-1 border border-blue-100 rounded-lg" placeholder="Búsqueda por nombre o nif..." autofocus/>
                    </div>
                    <div class="w-full text-xs">
                        <div class="flex">
                            <label for="filtroresponsable" class="items-center mx-2 mt-1 text-base">Responsable</label>
                            <select wire:model="filtroresponsable" class="w-full py-1 border border-blue-100 rounded-lg" >
                                <option value=""></option>
                                @foreach ($responsables as $responsable)
                                <option value="{{ $responsable->id }}">{{ $responsable->name }}</option>
                                @endforeach
                            </select>
                            @if($filtroresponsable!='')
                                <x-icon.filter-slash-a wire:click="$set('filtroresponsable', '')" class="pb-1 w-12" title="reset filter"/>
                            @endif
                        </div>
                    </div>
                </div>
                    <x-button.button  onclick="location.href = '{{ route('entidad.nueva',$entidadtipo->id) }}'" color="blue"><x-icon.plus/>Nuevo</x-button.button>
            </div>
            {{-- tabla entidades --}}
            <div class="flex-col space-y-4">
                <div>
                    <div class="flex pl-2 py-2 text-sm text-left text-gray-500 rounded-t-md  bg-blue-100">
                        <div class="w-5/12  flex lg:w-3/12" >{{ __('Entidad') }}</div>
                        <div class="w-1/12  hidden lg:flex " >{{ __('Tipo') }}</div>
                        <div class="w-1/12  hidden md:flex" >{{ __('Nif') }} </div>
                        <div class="w-2/12  hidden lg:flex" >{{ __('Tfno.') }}</div>
                        <div class="w-5/12  flex lg:w-3/12" >{{ __('Email.') }}</div>
                        <div class="w-2/12  flex" ></div>
                    </div>
                    <div>
                        @forelse ($entidades as $entidad)
                            <div class="w-full flex text-sm text-left border-y border-t-0" wire:loading.class.delay="opacity-50">
                                <div class="w-5/12 flex lg:w-3/12">
                                    <input type="text" class="w-full p-1 text-sm font-thin text-gray-500 border-0 rounded-md" value="{{ $entidad->entidad }}"  readonly/>
                                </div>
                                <div class="w-1/12 hidden lg:flex">
                                    <input type="text" class="w-full p-1 text-sm font-thin text-gray-500 border-0 rounded-md" value="{{ $entidad->entidadtipo->nombre ?? '-'}}"  readonly/>
                                </div>
                                <div class="w-1/12 hidden md:flex">
                                    <input type="text" class="w-full p-1 text-sm font-thin text-gray-500 border-0 rounded-md" value="{{ $entidad->nif }}" readonly/>
                                </div>
                                <div class="w-2/12 hidden lg:flex">
                                    <input type="text" class="w-full p-1 text-sm font-thin text-gray-500 border-0 rounded-md" value="{{ $entidad->tfno }}" readonly/>
                                </div>
                                <div class="w-5/12 flex lg:w-3/12">
                                    <input type="text" class="w-full p-1 text-sm font-thin text-gray-500 border-0 rounded-md" value="{{ $entidad->emailgral }}"  readonly/>
                                </div>
                                <div class="w-2/12 flex">
                                    <x-icon.edit-a href="{{ route('entidad.edit',$entidad) }}"  title="Editar"/>
                                    <x-icon.usergroup href="{{ route('entidadcontacto.show',$entidad->id) }}"  title="Contactos"/>
                                    <x-icon.delete-a wire:click.prevent="delete({{ $entidad->id }})" onclick="confirm('¿Estás seguro?') || event.stopImmediatePropagation()" class="pl-1"/>
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
                    {{ $entidades->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
