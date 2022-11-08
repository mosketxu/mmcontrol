<div class="">
    <div class="p-1 mx-2 ">
        <div class="flex justify-between space-x-1">
            <div class="flex w-4/12 py-0 mt-0">
                <div class="w-full py-0 mt-0">
                    <h1 class="text-2xl font-semibold text-gray-900"> {{ $titulo }} </h1>
                </div>
            </div>
            <div class="flex flex-row-reverse w-2/12 ">
                <div class="flex w-full">
                    <input type="text" wire:model="search" class="w-full py-1 text-sm border border-blue-100 rounded-lg" placeholder="Búsqueda" autofocus/>
                    @if($search!='')
                            <x-icon.filter-slash-a wire:click="$set('search', '')" class="pb-1" title="reset filter"/>
                    @endif
                </div>
            </div>
        </div>
        <div class="py-1 space-y-4">
            <div class="">
                @include('errores')
            </div>
            {{-- cuerpo --}}
            <div class="flex-col ">
                {{-- titulos --}}
                <div>
                    <div class="flex pt-2 pb-0 pl-2 text-sm text-left text-gray-500 bg-blue-100 rounded-t-md">
                        @if ($campofechavisible==1)
                            <div class="w-2/12 font-light text-left" >{{ __($titcampofecha)}} </div>
                        @endif
                        @if ($campo2visible==1)
                            <div class="w-2/12 pr-2 mr-2 font-light text-right ">{{ __($titcampo2)}} </div>
                        @endif
                        @if ($campo3visible==1)
                            <div class="w-2/12 pr-2 mr-2 font-light text-right ">{{ __($titcampo3)}} </div>
                        @endif
                        @if ($campo4visible==1)
                            <div class="w-4/12 pl-2 ml-2 font-light text-left ">{{ __($titcampo4)}} </div>
                        @endif
                        @if ($campoimgvisible==1)
                            <div class="w-2/12 font-light text-left">{{ __($titcampoimg)}} </div>
                        @endif
                    </div>
                </div>
                {{-- datos --}}
                <div>
                    @foreach ($valores as $valor)
                    <div class="flex w-full py-0 my-0 text-sm text-left bg-white border-t-0 border-y" wire:loading.class.delay="opacity-50">
                        @if ($campofechavisible==1)
                        <div class="flex-col w-2/12 text-left">
                            <input type="date"
                                value="{{ $valor->valorcampofecha }}"
                                wire:change="changeCampo({{ $valor }},'{{ $campofecha }}',$event.target.value)"
                                class="w-full text-sm font-thin text-gray-500 border-0 rounded-md"/>
                        </div>
                        @endif
                        @if ($campo2visible==1)
                        <div class="flex-col w-2/12 text-left">
                            <input type="text" value="{{ $valor->valorcampo2 }}"
                                wire:change="changeCampo({{ $valor }},'{{ $campo2 }}',$event.target.value)"
                                class="w-full pr-2 mr-2 text-sm font-thin text-right text-gray-500 border-0 rounded-md"/>
                        </div>
                        @endif
                        @if ($campo3visible==1)
                        <div class="flex-col w-2/12 text-left">
                            <input type="text" value="{{ $valor->valorcampo3 }}"
                                wire:change="changeCampo({{ $valor }},'{{ $campo3 }}',$event.target.value)"
                                class="w-full pr-2 mr-2 text-sm font-thin text-right text-gray-500 border-0 rounded-md"/>
                        </div>
                        @endif
                        @if ($campo4visible==1)
                        <div class="flex-col w-4/12 text-left">
                            <input type="text" value="{{ $valor->valorcampo4 }}"
                                wire:change="changeCampo({{ $valor }},'{{ $campo4 }}',$event.target.value)"
                                class="w-full pl-2 ml-2 text-sm font-thin text-left text-gray-500 border-0 rounded-md"/>
                        </div>
                        @endif
                        @if ($campoimgvisible==1)
                        <div class="w-2/12 text-left">
                            @if($valor->valorcampoimg)
                                <a href="{{asset('fichasproducto/'.$valor->valorcampoimg) }}" target="_blank" class="w-5 text-blue-500 hover:text-blue-700" title="Ver producto">
                                    <div class="flex">
                                        <x-icon.clip />
                                        <div class="mt-1">
                                            {{ $valor->valorcampo3 }}
                                        </div>
                                    </div>
                                </a>
                                {{-- <a href="#" class="flex text-green-500 hover:text-green-700 " wire:click="presentaAdjunto({{ $valor->id }})" title="Archivo">{{ $valor->valorcampo3 }} <x-icon.clip /></a> --}}
                            @endif
                        </div>
                        @endif
                        <div class="flex flex-row-reverse w-1/12 pr-2 mt-2">
                            @if($editarvisible==1)
                                <x-icon.edit-a wire:click="editar({{ $valor->id }})" class="pl-1"  title="Editar {{ $titulo }}"/>
                            @endif
                                <x-icon.delete-a wire:click.prevent="delete({{ $valor->id }})" onclick="confirm('¿Estás seguro?') || event.stopImmediatePropagation()" class="pl-1"  title="Eliminar detalle"/>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div>
                    {{ $valores->links() }}
                </div>
                <div>
                    <form wire:submit.prevent="save">
                        <div class="flex w-full p-2 my-0 text-sm text-left bg-blue-200 rounded-b-md" wire:loading.class.delay="opacity-50">
                            @if ($campofechavisible==1)
                                <div class="flex-col w-2/12 text-left">
                                    <input type="date" wire:model.defer="valorcampofecha"
                                    class="w-full text-xs text-left border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                    {{ $this->campofechadisabled }} />
                                </div>
                            @endif
                            @if ($campo2visible==1)
                                <div class="flex-col w-2/12 text-left">
                                    <input type="number" step="any" wire:model.defer="valorcampo2"
                                    class="w-full text-xs text-right border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"/>
                                </div>
                            @endif
                            @if ($campo3visible==1)
                                <div class="flex-col w-2/12 text-left">
                                    <input type="number" step="any" wire:model.defer="valorcampo3"
                                    class="w-full text-xs text-right border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"{{ $this->campofechadisabled }} />
                                </div>
                            @endif
                            @if ($campo4visible==1)
                                <div class="flex-col w-4/12 text-left">
                                    <input type="text" wire:model.defer="valorcampo4"
                                    class="w-full text-xs text-left border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"/>
                                </div>
                            @endif
                            @if ($campoimgvisible==1)
                                <div class="flex-col w-2/12 ml-2 text-right">
                                    <input type="file" wire:model.lazy="valorcampoimg" />
                                </div>
                            @endif
                            <div class="flex-col w-1/12 text-right">
                                <button type="submit" class="items-center pl-1 mx-0 mt-2 text-center w-7 "><x-icon.save-a class="text-blue"></x-icon.save-a></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="m-2">
        @if($ruta=='i')
            <x-jet-secondary-button  onclick="location.href = '{{route('producto.index')}}'">{{ __('Volver') }}</x-jet-secondary-button>
        @else
            <x-jet-secondary-button  onclick="location.href = '{{route('producto.edit',$productoid)}}'">{{ __('Volver') }}</x-jet-secondary-button>
        @endif
    </div>
</div>
