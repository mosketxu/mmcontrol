<div class="">
    <div class="h-full p-1 mx-2">
        <h1 class="text-2xl font-semibold text-gray-900">{{ $entidadtipo->nombreplural ?? 'Contactos' }}
        <div class="py-1 space-y-4">
            <div class="">
                @include('errores')
            </div>
            <div class="">
                @include('entidad.entidadfilters')
            </div>
            <div class="flex-col space-y-4">
                <div>
                    <div class="flex w-full py-2 text-sm text-left text-gray-500 bg-blue-100 rounded-t-md">
                        <div class="flex w-11/12 ">
                            <div class="w-3/12 pl-2 " >{{ $entidadtipo->nombre }}</div>
                            <div class="w-1/12 ">{{ __('Tipo') }}</div>
                            <div class="w-2/12 " >{{ __('Respble.') }}</div>
                            <div class="w-1/12 " >{{ __('Nif') }} </div>
                            <div class="w-2/12 " >{{ __('Tfno.') }}</div>
                            <div class="w-3/12 " >{{ __('Email') }}</div>
                        </div>
                        <div class="flex w-1/12 ">
                        </div>
                    </div>
                    <div>
                        @forelse ($entidades as $entidad)
                            <div class="flex items-center w-full text-sm cursor-pointer  text-gray-500 border-t-0 border-y hover:bg-gray-100 hover:cursor-pointer" wire:loading.class.delay="opacity-50" >
                                <div class="flex items-center w-11/12 my-1 cursor-pointer"  onclick="location.href = '{{ route('entidad.edit',$entidad) }}'">
                                    <div class="w-3/12 pl-2  ">
                                        <input type="text" class="w-full p-1 cursor-pointer text-sm font-thin text-gray-500 border-0 rounded-md hover:border-blue-500 focus:border-blue-500 " value="{{ $entidad->entidad }}"  disabled/>
                                    </div>
                                    <div class="w-1/12 ">
                                        <input type="text" class="w-full p-1 cursor-pointer text-sm font-thin text-gray-500 border-0 rounded-md hover:bg-gray-100" value="{{ $entidad->entidadtipo->nombrecorto ?? '-'}}"  disabled/>
                                    </div>
                                    <div class="w-2/12 ">
                                        <input type="text" class="w-full p-1 cursor-pointer text-sm font-thin text-gray-500 border-0 rounded-md hover:bg-gray-100" value="{{ $entidad->responsable}}"  disabled/>
                                    </div>
                                    <div class="w-1/12 ">
                                        <input type="text" class="w-full p-1 cursor-pointer text-sm font-thin text-gray-500 border-0 rounded-md hover:bg-gray-100" value="{{ $entidad->nif }}" disabled/>
                                    </div>
                                    <div class="w-2/12 ">
                                        <input type="text" class="w-full p-1 cursor-pointer text-sm font-thin text-gray-500 border-0 rounded-md hover:bg-gray-100" value="{{ $entidad->tfno }}" disabled/>
                                    </div>
                                    <div class="w-3/12 ">
                                        <input type="text" class="w-full p-1 cursor-pointer text-sm font-thin text-gray-500 border-0 rounded-md hover:bg-gray-100" value="{{ $entidad->emailgral }}"  disabled/>
                                    </div>
                                </div>
                                <div class="items-center text-center w-1/12 " >
                                    <x-icon.usergroup-a href="{{ route('entidad.contactos',$entidad) }}"  title="Contactos"/>
                                    <x-icon.plane-a class="text-gray-900 transform hover:text-black" href="{{ route('entidad.destinos',[$entidad,'i']) }}"  title="Destinos"/>
                                    <x-icon.delete-a wire:click.prevent="delete({{ $entidad->id }})" onclick="confirm('¿Estás seguro?') || event.stopImmediatePropagation()" class="w-6"/>
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
        </div>
    </div>
</div>
