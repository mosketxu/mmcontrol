<div class="">
    <div class="h-full p-1 mx-2">
        <h1 class="text-2xl font-semibold text-gray-900">{{ $entidadtipo->nombreplural ?? 'Contactos' }}</h1>
        <div class="py-1 space-y-4">
            <div class="">
                @include('errores')
            </div>
            <div class="">
                @include('entidad.entidadfilters')
            </div>
            <div class="flex-col space-y-4">
                <div>
                    <div class="flex w-full py-1 text-sm font-bold text-gray-500 bg-blue-100 rounded-t-md">
                        <div class="flex w-11/12 ">
                            <div class="w-3/12 pl-2 " >{{ $entidadtipo->nombre }}
                                @if($orden=='asc' && $ordenarpor=='entidad')
                                    <x-icon.sort-down-a wire:click="ordenar('entidad')" class="pl-1"  title="Orden"/>
                                @elseif (($orden=='desc' && $ordenarpor=='entidad'))
                                    <x-icon.sort-up-a wire:click="ordenar('entidad')" class="pl-1"  title="Orden"/>
                                @else
                                    <x-icon.sort-a wire:click="ordenar('entidad')" class="pl-1"  title="Orden"/>
                                @endif
                            </div>
                            <div class="w-1/12 ">{{ __('Tipo') }}</div>
                            <div class="w-2/12 " >{{ __('Respble.') }}</div>
                            <div class="w-1/12 " >{{ __('Nif') }} </div>
                            <div class="w-1/12 " >{{ __('Tfno.') }}</div>
                            <div class="w-3/12 " >{{ __('Email') }}</div>
                            <div class="w-1/12 " >{{ __('F.Creación') }}
                                @if($orden=='asc' && $ordenarpor=='created_at')
                                    <x-icon.sort-down-a wire:click="ordenar('created_at')" class="pl-1"  title="Orden"/>
                                @elseif (($orden=='desc' && $ordenarpor=='created_at'))
                                    <x-icon.sort-up-a wire:click="ordenar('created_at')" class="pl-1"  title="Orden"/>
                                @else
                                    <x-icon.sort-a wire:click="ordenar('created_at')" class="pl-1"  title="Orden"/>
                                @endif
                            </div>
                        </div>
                        <div class="flex w-1/12 ">
                        </div>
                    </div>
                    <div>
                        @forelse ($entidades as $entidad)
                        <div class="hover:bg-gray-100 hover:cursor-pointer">
                            <div class="flex items-center w-full text-sm text-gray-500 border-t-0 border-y" wire:loading.class.delay="opacity-50" >
                                <div class="flex items-center w-11/12" onclick="location.href = '{{ route('entidad.edit',$entidad) }}'">
                                    <div class="w-3/12 pl-2 ">{{$entidad->entidad }}</div>
                                    <div class="w-1/12 ">{{ $entidad->entidadtipo->nombrecorto ?? '-'}}</div>
                                    <div class="w-2/12 ">{{ $entidad->responsable}}</div>
                                    <div class="w-1/12 ">{{ $entidad->nif }}</div>
                                    <div class="w-1/12 ">{{ $entidad->tfno }}</div>
                                    <div class="w-3/12 ">{{ $entidad->emailgral }}</div>
                                    <div class="w-1/12 ">{{ $entidad->fechacli }}</div>
                                </div>
                                <div class="items-center w-1/12 text-center " >
                                    <x-icon.usergroup-a href="{{ route('entidad.contactos',$entidad) }}"  title="Contactos"/>
                                    <x-icon.plane-a class="text-gray-900 transform hover:text-black" href="{{ route('entidad.destinos',[$entidad,'i']) }}"  title="Destinos"/>
                                    <x-icon.delete-a wire:click.prevent="delete({{ $entidad->id }})" onclick="confirm('¿Estás seguro?') || event.stopImmediatePropagation()" class="w-6"/>
                                </div>
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
