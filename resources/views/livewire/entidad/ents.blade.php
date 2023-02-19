<div class="">
    {{-- @livewire('menu') --}}
    <div class="h-full p-1 mx-2">
        <h1 class="text-2xl font-semibold text-gray-900">{{ $entidadtipo->nombreplural ?? 'Contactos' }}
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
            <div class="">
                @include('entidad.entidadfilters')
            </div>
            {{-- tabla entidades --}}
            <div class="flex-col space-y-4">
                <div>
                    <div class="flex py-2 pl-2 text-sm text-left text-gray-500 bg-blue-100 rounded-t-md">
                        <div class="flex w-5/12 font-light lg:w-3/12" >{{ $entidadtipo->nombre }}</div>
                        <div class="hidden w-1/12 font-light lg:flex " >{{ __('Tipo') }}</div>
                        <div class="hidden w-2/12 font-light md:w-2/12" >{{ __('Responsable') }}</div>
                        <div class="hidden w-1/12 font-light md:flex" >{{ __('Nif') }} </div>
                        <div class="hidden w-2/12 font-light lg:flex" >{{ __('Tfno.') }}</div>
                        <div class="flex w-5/12 font-light lg:w-3/12" >{{ __('Email') }}</div>
                        <div class="flex " ></div>
                    </div>
                    <div>
                        @forelse ($entidades as $entidad)
                            <div class="flex w-full text-sm text-left border-t-0 border-y py-1 hover:bg-gray-100" wire:loading.class.delay="opacity-50">
                                <div class="flex w-5/12 lg:w-3/12">
                                    <input type="text" class="w-full p-1 text-sm font-thin text-gray-500 border-0 rounded-md hover:bg-gray-100" value="{{ $entidad->entidad }}"  readonly/>
                                </div>
                                <div class="hidden w-1/12 lg:flex">
                                    <input type="text" class="w-full p-1 text-sm font-thin text-gray-500 border-0 rounded-md hover:bg-gray-100" value="{{ $entidad->entidadtipo->nombrecorto ?? '-'}}"  readonly/>
                                </div>
                                <div class="hidden w-2/12 md:w-2/12">
                                    <input type="text" class="w-full p-1 text-sm font-thin text-gray-500 border-0 rounded-md hover:bg-gray-100" value="{{ $entidad->responsable}}"  readonly/>
                                </div>
                                <div class="hidden w-1/12 md:flex">
                                    <input type="text" class="w-full p-1 text-sm font-thin text-gray-500 border-0 rounded-md hover:bg-gray-100" value="{{ $entidad->nif }}" readonly/>
                                </div>
                                <div class="hidden w-2/12 lg:flex">
                                    <input type="text" class="w-full p-1 text-sm font-thin text-gray-500 border-0 rounded-md hover:bg-gray-100" value="{{ $entidad->tfno }}" readonly/>
                                </div>
                                <div class="flex w-5/12 lg:w-3/12">
                                    <input type="text" class="w-full p-1 text-sm font-thin text-gray-500 border-0 rounded-md hover:bg-gray-100" value="{{ $entidad->emailgral }}"  readonly/>
                                </div>
                                <div class="flex ">
                                    <x-icon.edit-a href="{{ route('entidad.edit',$entidad) }}"  title="Editar"/>
                                    <x-icon.usergroup href="{{ route('entidad.contactos',$entidad) }}"  title="Contactos"/>
                                    <x-icon.plane-a class="text-gray-900 transform hover:text-black" href="{{ route('entidad.destinos',[$entidad,'i']) }}"  title="Destinos"/>
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
