<div>
    <div class="p-1 mx-2">
        <div class="flex justify-between space-x-1">
            <div class="flex w-6/12 py-0 mt-0">
                <h1 class="text-2xl font-semibold text-gray-900">{{ $titulo }}</h1>
            </div>
            <div class="flex flex-row-reverse w-2/12">
                <div class="flex w-full">
                    <input type="text" wire:model="search" class="w-full py-1 text-sm border border-blue-100 rounded-lg" placeholder="Busqueda" autofocus/>
                    @if($search!='')
                        <x-icon.filter-slash-a wire:click="$set('search', '')" class="pb-1" title="reset filter"/>
                    @endif
                </div>
            </div>
        </div>

        <div class="py-1 space-y-4">
            <div>
                @include('errores')
            </div>

            <div class="flex-col">
                <div class="flex w-full py-1 pl-2 text-sm font-bold text-gray-500 bg-blue-100 rounded-t-md">
                    <div class="w-1/12">Fecha</div>
                    <div class="w-2/12">Contacto</div>
                    <div class="w-2/12">Nombre</div>
                    <div class="w-2/12">Accion</div>
                    <div class="w-2/12">Descripcion</div>
                    <div class="w-2/12">Proxima accion</div>
                    <div class="w-1/12"></div>
                </div>

                @foreach ($acciones as $accionItem)
                    <div class="flex w-full py-0 my-0 text-sm text-left bg-white border-t-0 border-y" wire:loading.class.delay="opacity-50">
                        <div class="flex-col w-1/12 text-left">
                            <input type="date" value="{{ optional($accionItem->fechaaccion)->format('Y-m-d') }}"
                                wire:change="changeCampo({{ $accionItem->id }},'fechaaccion',$event.target.value)"
                                class="w-full px-0 mx-0 text-sm font-thin text-gray-500 border-0 rounded-md"/>
                        </div>
                        <div class="flex-col w-2/12 text-left">
                            <select wire:change="changeCampo({{ $accionItem->id }},'contacto_id',$event.target.value)"
                                class="w-full text-sm font-thin text-gray-500 border-0 rounded-md">
                                <option value="">--</option>
                                @foreach ($contactos as $contacto)
                                    <option value="{{ $contacto->id }}" @selected($accionItem->contacto_id == $contacto->id)>
                                        {{ $contacto->entidadcontacto->entidad ?? '' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex-col w-2/12 text-left">
                            <input type="text" value="{{ $accionItem->nombre }}"
                                wire:change="changeCampo({{ $accionItem->id }},'nombre',$event.target.value)"
                                class="w-full text-sm font-thin text-left text-gray-500 border-0 rounded-md"/>
                        </div>
                        <div class="flex-col w-2/12 text-left">
                            <textarea rows="1" wire:change="changeCampo({{ $accionItem->id }},'accion',$event.target.value)"
                                class="w-full text-sm font-thin text-left text-gray-500 border-0 rounded-md">{{ $accionItem->accion }}</textarea>
                        </div>
                        <div class="flex-col w-2/12 text-left">
                            <textarea rows="1" wire:change="changeCampo({{ $accionItem->id }},'descripcion',$event.target.value)"
                                class="w-full text-sm font-thin text-left text-gray-500 border-0 rounded-md">{{ $accionItem->descripcion }}</textarea>
                        </div>
                        <div class="flex-col w-2/12 text-left">
                            <input type="text" value="{{ $accionItem->proximaaccion }}"
                                wire:change="changeCampo({{ $accionItem->id }},'proximaaccion',$event.target.value)"
                                class="w-full text-sm font-thin text-left text-gray-500 border-0 rounded-md"/>
                        </div>
                        <div class="flex flex-row-reverse w-1/12 pr-2 mt-2">
                            <x-icon.delete-a wire:click.prevent="delete({{ $accionItem->id }})" onclick="confirm('Estas seguro?') || event.stopImmediatePropagation()" class="w-6 pl-1" title="Eliminar accion"/>
                        </div>
                    </div>
                @endforeach

                <form wire:submit.prevent="save">
                    <div class="flex w-full p-2 my-0 text-sm text-left bg-blue-200 rounded-b-md" wire:loading.class.delay="opacity-50">
                        <div class="flex-col w-1/12 text-left">
                            <input type="date" wire:model.defer="fechaaccion"
                                class="w-full text-xs text-left border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"/>
                        </div>
                        <div class="flex-col w-2/12 text-left">
                            <select wire:model.defer="contacto_id"
                                class="w-full text-xs text-left border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <option value="">-- Contacto --</option>
                                @foreach ($contactos as $contacto)
                                    <option value="{{ $contacto->id }}">{{ $contacto->entidadcontacto->entidad ?? '' }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex-col w-2/12 text-left">
                            <input type="text" wire:model.defer="nombre"
                                class="w-full text-xs text-left border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"/>
                        </div>
                        <div class="flex-col w-2/12 text-left">
                            <textarea rows="1" wire:model.defer="accion"
                                class="w-full text-xs text-left border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"></textarea>
                        </div>
                        <div class="flex-col w-2/12 text-left">
                            <textarea rows="1" wire:model.defer="descripcion"
                                class="w-full text-xs text-left border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"></textarea>
                        </div>
                        <div class="flex-col w-2/12 text-left">
                            <input type="text" wire:model.defer="proximaaccion"
                                class="w-full text-xs text-left border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"/>
                        </div>
                        <div class="flex-col w-1/12 text-left">
                            <button type="submit" class="items-center pl-1 mx-0 mt-2 text-center w-7">
                                <x-icon.save-a class="text-blue"></x-icon.save-a>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="m-2">
        @if($ruta=='i')
            <x-jet-secondary-button onclick="location.href = '{{route('entidad.tipo','1')}}'">{{ __('Volver') }}</x-jet-secondary-button>
        @else
            <x-jet-secondary-button onclick="location.href = '{{route('entidad.tipo',$ent->id)}}'">{{ __('Volver') }}</x-jet-secondary-button>
        @endif
    </div>
</div>
