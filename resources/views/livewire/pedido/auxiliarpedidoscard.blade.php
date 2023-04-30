<div class="">
    <div class="p-1 mx-2 ">
        <div class="flex justify-between space-x-1">
            <div class="flex w-3/12 py-0 mt-0">
                <div class="w-full py-0 mt-0">
                    <h1 class="text-2xl font-semibold text-gray-900"> {{ $titulo }} {{ $pedidoid }}</h1>
                </div>
            </div>
            <div class="flex flex-row-reverse w-9/12 ">
                <div class="flex">
                    <input type="text" wire:model="search" class="w-full py-1 text-sm border border-blue-100 rounded-lg" placeholder="Búsqueda" autofocus/>
                    @if($search!='')
                    <x-icon.filter-slash-a wire:click="$set('search', '')" class="pb-1" title="reset filter"/>
                    @endif
                </div>
                <div class="flex ">
                    {{-- @if($tipo=='1') --}}
                        @include('pedidos.pedidoeditorial-menu' )
                    {{-- @else
                        @include('pedidos.pedidootros-menu' )
                    @endif --}}
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
                    <div class="flex pt-1 pb-0 text-sm text-left text-gray-500 bg-blue-100 rounded-t-md">
                        @if ($campofechavisible==1)
                            <div class="flex-col {{ $longcampofecha }} text-left">
                                <input type="text" value="{{ $titcampofecha }}" class="w-full text-sm font-thin text-gray-500 bg-blue-100 border-none" readonly />
                            </div>
                        @endif
                        @if ($campo2visible==1)
                            <div class="flex-col {{ $longcampo2 }} ">
                                <input type="text" value="{{ $titcampo2 }}" class="w-full {{ $textcampo2 }} text-sm font-thin text-gray-500 bg-blue-100 border-none" readonly />
                            </div>
                        @endif
                        @if ($campo3visible==1)
                            <div class="flex-col {{ $longcampo3 }} text-left">
                                <input type="text" value="{{ $titcampo3 }}" class="w-full {{ $textcampo3 }} text-sm font-thin text-gray-500 bg-blue-100 border-none" readonly />
                            </div>
                        @endif
                        @if ($campo4visible==1)
                            <div class="flex-col {{ $longcampo4 }} text-left">
                                <input type="text" value="{{ $titcampo4 }}" class="w-full {{ $textcampo4 }} text-sm font-thin text-gray-500 bg-blue-100 border-none" readonly />
                            </div>
                        @endif
                        @if ($campo5visible==1)
                            <div class="flex-col {{ $longcampo5 }} text-left">
                                <input type="text" value="{{ $titcampo5 }}" class="w-full {{ $textcampo5 }} text-sm font-thin text-gray-500 bg-blue-100 border-none" readonly />
                            </div>
                        @endif
                        @if ($campo6visible==1)
                            <div class="flex-col {{ $longcampo6 }} text-left">
                                <input type="text" value="{{ $titcampo6 }}" class="w-full {{ $textcampo6 }} text-sm font-thin text-gray-500 bg-blue-100 border-none" readonly />
                            </div>
                        @endif
                        @if ($campoimgvisible==1)
                            <div class="flex-col {{ $longcampoimg }} text-left">
                                <input type="text" value="{{ $titcampoimg }}" class="w-full text-sm font-thin text-gray-500 bg-blue-100 border-none" readonly />
                            </div>
                        @endif
                        <div class="flex flex-row-reverse w-1/12 pr-2 mt-2">
                            <p></p>
                        </div>
                    </div>
                </div>
                {{-- datos --}}
                <div>
                    @forelse ($valores as $valor)
                    <div class="flex w-full py-0 my-0 space-x-1 text-sm text-left bg-white border-t-0 border-y" wire:loading.class.delay="opacity-50">
                        @if ($campofechavisible==1)
                        <div class="flex-col {{ $longcampofecha }} text-left">
                            <input type="date"
                                value="{{ $valor->valorcampofecha }}"
                                wire:change="changeCampo({{ $valor }},'{{ $campofecha }}',$event.target.value)"
                                class="w-full text-sm font-thin text-gray-500 border-0 rounded-md"
                                $campofechadisabled />
                        </div>
                        @endif
                        @if ($campo2visible==1)
                        <div class="flex-col {{ $longcampo2 }} {{ $textcampo2 }}">
                            @if($tipocampo2=='combo')
                            <x-selectcolor wire:model.lazy="valor.valorcampo2" selectname="valorcampo2" color="blue" class="w-full"
                                wire:change="changeCampo({{ $valor }},'{{ $campo2 }}',$event.target.value)">
                                @foreach ($seleccionables2 as $seleccion)
                                <option value="{{ $seleccion->id }}">{{ $seleccion->referencia }}</option>
                                @endforeach
                            </x-selectcolor>
                            @else
                            <input type="{{ $tipocampo2 }}" value="{{ $valor->valorcampo2 }}"
                                wire:change="changeCampo({{ $valor }},'{{ $campo2 }}',$event.target.value)"
                                class="w-full text-sm font-thin {{ $textcampo2 }} text-gray-500 border-0 rounded-md"
                                {{ $campo2disabled }}/>
                            @endif
                        </div>
                        @endif
                        @if ($campo3visible==1)
                        <div class="flex-col {{ $longcampo3 }} {{ $textcampo3 }}">
                            @if($tipocampo3=='combo')
                                <x-select selectname="valorcampo3" class="w-full mt-1 border-none"
                                    wire:change="changeCampo({{ $valor }},'{{ $campo3 }}',$event.target.value)">
                                    {{-- {{ $pedido->estado== '0'? 'selected' : '' }} --}}
                                    @foreach ($seleccionables3 as $seleccion)
                                        <option value="{{ $seleccion->id }}" {{ $seleccion->id==$valor->valorcampo3 ? 'selected' :''  }}>{{ $seleccion->$campo3selectname }}</option>
                                    @endforeach
                                </x-select>
                            @else
                            <input type="{{ $tipocampo3 }}" value="{{ $valor->valorcampo3 }}"
                                wire:change="changeCampo({{ $valor }},'{{ $campo3 }}',$event.target.value)"
                                class="w-full text-sm font-thin {{ $textcampo3 }} text-gray-500 border-0 rounded-md"
                                {{ $campo3disabled }}/>
                            @endif
                        </div>
                        @endif
                        @if ($campo4visible==1)
                        <div class="flex-col {{ $longcampo4 }} {{ $textcampo4 }}">
                            @if($tipocampo4 =="textarea")
                                <textarea  rows="2" cols="{{ $colstextarea4 }}"
                                    wire:change="changeCampo({{ $valor }},'{{ $campo4 }}',$event.target.value)"
                                    class="block text-xs font-thin text-left text-gray-500 border-0 rounded-md">{{ $valor->valorcampo4 }}</textarea>
                            @else
                            <input type="{{ $tipocampo4 }}" value="{{ $valor->valorcampo4 }}"
                                wire:change="changeCampo({{ $valor }},'{{ $campo4 }}',$event.target.value)"
                                class="w-full {{ $textcampo4 }} text-sm font-thin text-gray-500 border-0 rounded-md"
                                {{ $campo4disabled }}/>
                            @endif
                        </div>
                        @endif
                        @if ($campo5visible==1)
                        <div class="flex-col {{ $longcampo5 }} {{ $textcampo5 }}">
                            <input type="{{ $tipocampo5 }}" value="{{ $valor->valorcampo5 }}"
                                wire:change="changeCampo({{ $valor }},'{{ $campo5 }}',$event.target.value)"
                                class="w-full text-sm font-thin {{ $textcampo5 }} text-gray-500 border-0 rounded-md"
                                {{ $campo5disabled }}/>
                        </div>
                        @endif
                        @if ($campo6visible==1)
                        <div class="flex-col {{ $longcampo6 }} {{ $textcampo6 }}">
                            <input type="{{ $tipocampo6 }}" value="{{ $valor->valorcampo6 }}"
                                wire:change="changeCampo({{ $valor }},'{{ $campo6 }}',$event.target.value)"
                                class="w-full text-sm font-thin {{ $textcampo6 }} text-gray-500 border-0 rounded-md"
                                {{ $campo6disabled }}/>
                        </div>
                        @endif

                        @if ($campoimgvisible==1)
                        <div class="{{ $longcampoimg }} ml-8 text-left">
                            @if($valor->valorcampoimg)
                                <a href="{{asset('archivospedido/'.$valor->valorcampoimg) }}" target="_blank" class="w-5 text-blue-500 hover:text-blue-700" title="Ver producto">
                                    <div class="flex">
                                        <x-icon.clip />
                                        <div class="mt-1">
                                            {{ $valor->valorcampo3 }}
                                        </div>
                                    </div>
                                </a>

                            @endif
                        </div>
                        @endif
                        <div class="flex flex-row-reverse w-1/12 pr-2 mt-2">
                            <x-icon.delete-a wire:click.prevent="delete({{ $valor->id }})" onclick="confirm('¿Estás seguro?') || event.stopImmediatePropagation()" class="w-6 mx-1"  title="Eliminar detalle"/>
                            @if($pdfvisible=='1')
                                <a href="{{route($routepdf,[$pedidoid,$ruta,$valor->id])}}" target="_blank" ><x-icon.pdf class="mx-1 text-red-500 hover:text-red-700 "/></a>
                            @endif
                            @if($editarvisible=='1')
                                <x-icon.edit-a wire:click="editar({{ $valor->id }})" class="mx-1"  title="Editar {{ $titulo }}"/>
                            @endif
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
                {{-- <div>
                    {{ $valores->links() }}
                </div> --}}
                <div>
                    <form wire:submit.prevent="save">
                        <div class="flex w-full p-2 my-0 text-sm text-left bg-blue-200 rounded-b-md" wire:loading.class.delay="opacity-50">
                            @if ($campofechavisible==1)
                                <div class="flex-col {{ $longcampofecha }} text-left">
                                    <input type="date" wire:model.defer="valorcampofecha"
                                    class="w-full text-xs text-left border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                    {{ $this->campofechadisabled }} />
                                </div>
                            @endif
                            @if ($campo2visible==1)
                                <div class="flex-col {{ $longcampo2 }} {{ $textcampo2 }}">
                                    @if($tipocampo2=='combo')
                                        <x-selectcolor wire:model.lazy="valorcampo2" selectname="valorcampo2" color="blue" class="w-full" >
                                            <option value="">-- Selecciona --</option>
                                            @forelse ($seleccionables2 as $seleccion)
                                                <option value="{{ $seleccion->id }}">{{ $seleccion->referencia }}</option>
                                            @empty
                                                <option value=""></option>
                                            @endforelse
                                        </x-selectcolor>
                                    @else
                                        @if($campo2disabled=='1')
                                        <input type="{{ $tipocampo2 }}" step="any" wire:model.defer="valorcampo2"
                                            class="w-full text-xs {{ $textcampo2 }} border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                            {{ $this->campo2disabled }} />
                                        @endif
                                    @endif
                                </div>
                            @endif
                            @if ($campo3visible==1)
                                <div class="flex-col {{ $longcampo3 }} {{ $textcampo3 }}">
                                    @if($tipocampo3=='combo')
                                        <x-select wire:model.lazy="valorcampo3" selectname="valorcampo3"  class="w-full h-8 " >
                                            <option value="">-- Selecciona --</option>
                                            @forelse ( $seleccionables3 as $seleccion )
                                                <option value="{{ $seleccion->id }}">{{ $seleccion->$campo3selectname }}</option>
                                            @empty
                                                <option value=""></option>
                                            @endforelse
                                        </x-select>
                                    @else
                                    <input type="{{ $tipocampo3 }}" step="any" wire:model.defer="valorcampo3"
                                        class="w-full text-xs {{ $textcampo3 }} border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                        {{ $this->campo3disabled }} />
                                    @endif
                                </div>
                            @endif
                            @if ($campo4visible==1)
                                <div class="flex-col {{ $longcampo4 }} {{ $textcampo4 }}">
                                    @if($tipocampo4 =="textarea")
                                        <textarea  rows="2" cols="{{ $colstextarea4 }}"
                                        wire:model.defer="valorcampo4" class="block text-xs font-thin text-gray-500 border-0 rounded-md"></textarea>
                                @else
                                    <input type="{{ $tipocampo4 }}" wire:model.defer="valorcampo4"
                                    class="w-full text-xs {{ $textcampo4 }} border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"/>
                                    @endif
                                </div>
                            @endif
                            @if ($campo5visible==1)
                            <div class="flex-col {{ $longcampo5 }} {{ $textcampo5 }}">
                                <input type="{{ $tipocampo5 }}" step="any" wire:model.defer="valorcampo5"
                                class="w-full text-xs {{ $textcampo5 }} border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                {{ $this->campo5disabled }} />
                            </div>
                            @endif
                            @if ($campo6visible==1)
                                <div class="flex-col {{ $longcampo6 }} {{ $textcampo6 }}">
                                    <input type="{{ $tipocampo6 }}" step="any" wire:model.defer="valorcampo6"
                                    class="w-full text-xs {{ $textcampo6 }} border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                    {{ $this->campo6disabled }} />
                                </div>
                            @endif
                            @if ($campoimgvisible==1)
                                <div class="flex-col {{ $longcampoimg }} ml-2 text-right">
                                    <input type="file" wire:model.lazy="valorcampoimg" />
                                    {{-- <x-input.filepond wire:model="valorcampoimg" /> --}}
                                </div>
                            @endif
                            @if(isset($distribuciones))
                                <x-select selectname="distribucion" wire:model.lazy="distribucion">
                                    <option value="">--Elige distribución--</option>
                                    @foreach ($distribuciones as $distribucion )
                                        <option value="{{ $distribucion->id }}">{{ $distribucion->destino }}</option>
                                    @endforeach
                                </x-select>
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
            <x-jet-secondary-button  onclick="location.href = '{{route('pedido.tipo',[$tipo,$ruta])}}'">{{ __('Volver') }} </x-jet-secondary-button>
        @else
            <x-jet-secondary-button  onclick="location.href = '{{route('pedido.editar',[$pedidoid,$ruta])}}'">{{ __('Volver') }} </x-jet-secondary-button>
        @endif
    </div>
</div>
