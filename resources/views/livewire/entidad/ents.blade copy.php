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
                            <x-icon.filter-slash-a wire:click="$set('filtroresponsable', '')" class="pb-1" title="reset filter"/>
                            @endif
                        </div>
                    </div>
                </div>
                    <x-button.button  onclick="location.href = '{{ route('entidad.nueva',$entidadtipo->id) }}'" color="blue"><x-icon.plus/>Nuevo</x-button.button>
            </div>
            {{-- tabla entidades --}}
            <div class="flex-col space-y-4">
                <x-table>
                    <x-slot name="head">
                        <x-table.heading class="pl-4 text-left " >{{ __('Entidad') }}</x-table.heading>
                        <x-table.heading class="pl-4 text-left " >{{ __('Tipo') }}</x-table.heading>
                        <x-table.heading class="pl-4 text-left " >{{ __('Nif') }} </x-table.heading>
                        <x-table.heading class="pl-4 text-left " >{{ __('Responsable') }}</x-table.heading>
                        <x-table.heading class="pl-4 text-left " >{{ __('Tfno.') }}</x-table.heading>
                        <x-table.heading class="pl-4 text-left " >{{ __('Email.') }}</x-table.heading>
                        <x-table.heading class="px-4" colspan="2"/>
                    </x-slot>
                    <x-slot name="body">
                        @forelse ($entidades as $entidad)
                            <x-table.row wire:loading.class.delay="opacity-50">
                                <x-table.cell >
                                    <input type="text" value="{{ $entidad->entidad }}" class="w-full text-sm font-thin text-gray-500 truncate border-0 rounded-md"  readonly/>
                                </x-table.cell>
                                <x-table.cell >
                                    <input type="text" value="{{ $entidad->entidadtipo->nombre ?? '-'}}" class="w-full text-sm font-thin text-gray-500 truncate border-0 rounded-md"  readonly/>
                                </x-table.cell>
                                <x-table.cell >
                                    <input type="text" value="{{ $entidad->nif }}" class="w-full text-sm font-thin text-gray-500 truncate border-0 rounded-md"  readonly/>
                                </x-table.cell>
                                <x-table.cell >
                                    @if(Auth::user()->hasRole(['Admin']))
                                        <select   wire:change="changeValor({{ $entidad }},'responsable_id',$event.target.value)"
                                            class="w-40 py-2 text-xs text-gray-600 placeholder-gray-300 bg-white border-blue-300 rounded-md shadow-sm appearance-none hover:border-gray-400 focus:outline-none">
                                        @foreach ($responsables as $responsable)
                                            <option value="{{ $responsable->id }}" {{ $responsable->id== $entidad->responsable_id? 'selected' : '' }}>{{ $responsable->name }}</option>
                                        @endforeach
                                    </select>
                                    @else
                                        <input type="text" value="{{ $entidad->responsable->name ?? 'no def'}}" class="w-full text-sm font-thin text-gray-500 truncate border-0 rounded-md"  readonly/>
                                    @endif
                                </x-table.cell>
                                <x-table.cell >
                                    <input type="text" value="{{ $entidad->tfno }}" class="w-full text-sm font-thin text-gray-500 truncate border-0 rounded-md"  readonly/>
                                </x-table.cell>
                                <x-table.cell >
                                    <input type="text" value="{{ $entidad->emailgral }}" class="w-full text-sm font-thin text-gray-500 truncate border-0 rounded-md"  readonly/>
                                </x-table.cell>
                                <x-table.cell class=" px-4">
                                    <div class="flex items-center justify-center space-x-3">
                                        <x-icon.edit-a href="{{ route('entidad.edit',$entidad) }}"  title="Editar"/>
                                        <x-icon.usergroup href="{{ route('entidadcontacto.show',$entidad->id) }}"  title="Contactos"/>
                                        <x-icon.delete-a wire:click.prevent="delete({{ $entidad->id }})" onclick="confirm('¿Estás seguro?') || event.stopImmediatePropagation()" class="pl-1"/>
                                    </div>
                                </x-table.cell>
                            </x-table.row>
                        @empty
                            <x-table.row>
                                <x-table.cell colspan="10">
                                    <div class="flex items-center justify-center">
                                        <x-icon.inbox class="w-8 h-8 text-gray-300"/>
                                        <span class="py-5 text-xl font-medium text-gray-500">
                                            No se han encontrado datos...
                                        </span>
                                    </div>
                                </x-table.cell>
                            </x-table.row>
                        @endforelse
                    </x-slot>
                </x-table>
                <div>
                    {{ $entidades->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
