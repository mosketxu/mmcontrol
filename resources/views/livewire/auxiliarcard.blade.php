    <div class="relative p-2 bg-white border rounded">
        <style>[x-cloak]{display:none!important}</style>
        <div class="">
            <div class="flex justify-between">
                <div>
                    <h3 class="text-lg font-bold">{{ $titulo }}</h3>
                </div>
                <div>
                    <input type="text" wire:model.live="search" class="w-full py-2 mb-2 text-xs text-gray-600 placeholder-gray-300 bg-white border-blue-300 rounded-md shadow-sm appearance-none hover:border-gray-400 focus:outline-none" placeholder="Búsqueda" autofocus/>
                </div>
            </div>
            <div class="">
                @include('errores')
            </div>
            <div class="min-w-full overflow-hidden overflow-x-auto align-middle shadow sm:rounded-t-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            @if ($campo1visible==1)
                                <th class="px-1 py-3 pl-3 text-xs font-bold leading-4 tracking-wider text-left text-gray-500 bg-blue-50" >{{ __($titcampo1) }}</th>
                            @endif
                            @if ($campo2visible==1)
                                <th class="px-1 py-3 pl-3 text-xs font-bold leading-4 tracking-wider text-left text-gray-500 bg-blue-50" >{{ __($titcampo2) }} </th>
                            @endif
                            @if ($campo3visible==1)
                                <th class="px-1 py-3 pl-3 text-xs font-bold leading-4 tracking-wider text-left text-gray-500 bg-blue-50" >{{ __($titcampo3) }} </th>
                            @endif
                            <th class="px-1 py-3 pl-3 text-xs font-bold leading-4 tracking-wider text-left text-gray-500 bg-blue-50" ></th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200 ">
                        @foreach ($valores as $valor)
                            <tr wire:key="fila-{{ $valor->id }}-{{ $nonce ?? 0 }}" wire:loading.class.delay="opacity-50">
                                @if ($campo1visible==1)
                                <td class="px-1 text-xs leading-5 tracking-tighter text-gray-600 whitespace-no-wrap" >
                                    <input type="text" value="{{ $valor->valorcampo1 }}"
                                    wire:change="changeCampo({{ $valor }},'{{ $campo1 }}',$event.target.value)"
                                    class="w-full text-xs font-thin text-gray-500 border-0 rounded-md"/>
                                </td>
                                @endif
                                @if ($campo2visible==1)
                                    @if($titcampo1=='Caja')
                                        <td class="px-1 text-xs leading-5 tracking-tighter text-gray-600 whitespace-no-wrap">
                                            <select name="{{$valor->campo2}}" id="{{$valor->campo2}}"
                                                wire:change="changeCampo({{ $valor }},'{{ $campo2 }}',$event.target.value)"
                                                class="py-1 text-xs text-gray-600 bg-white border-gray-300 rounded-md shadow-sm appearance-none hover:border-gray-400 focus:outline-none">
                                                <option value="1" {{$valor->valorcampo2=='1' ? 'selected' : ''}}>Editorial</option>
                                                <option value="2" {{$valor->valorcampo2=='2' ? 'selected' : ''}}>Packaging/Otros</option>
                                            </select>
                                        </td>
                                    @else
                                    <td class="px-1 text-xs leading-5 tracking-tighter text-gray-600 whitespace-no-wrap">
                                        <input type="text" value="{{ $valor->valorcampo2 }}"
                                        wire:change="changeCampo({{ $valor }},'{{ $campo2 }}',$event.target.value)"
                                        class="w-full text-xs font-thin text-gray-500 border-0 rounded-md"/>
                                    </td>
                                    @endif
                                @endif
                                @if ($campo3visible==1)
                                <td class="px-1 text-xs leading-5 tracking-tighter text-gray-600 whitespace-no-wrap">
                                    @if (($campo3tipo ?? 'texto') === 'bool')
                                        @php $activo = (bool) $valor->valorcampo3; @endphp
                                        <button type="button"
                                            wire:click="changeCampo({{ $valor }},'{{ $campo3 }}',{{ $activo ? 0 : 1 }})"
                                            wire:loading.attr="disabled"
                                            title="{{ $activo ? 'Activo — clic para desactivar' : 'Inactivo — clic para activar' }}"
                                            class="inline-flex items-center justify-center p-1 transition-transform duration-150 rounded-full hover:scale-110 focus:outline-none focus:ring-2 focus:ring-offset-1 {{ $activo ? 'focus:ring-green-400' : 'focus:ring-rose-300' }}">
                                            @if ($activo)
                                                <svg class="w-6 h-6 text-green-500 drop-shadow-sm" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                                </svg>
                                            @else
                                                <svg class="w-6 h-6 text-rose-400 drop-shadow-sm" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                                </svg>
                                            @endif
                                        </button>
                                    @else
                                        <input type="text" value="{{ $valor->valorcampo3 }}"
                                        wire:change="changeCampo({{ $valor }},'{{ $campo3 }}',$event.target.value)"
                                        class="w-full text-xs font-thin text-gray-500 border-0 rounded-md"/>
                                    @endif
                                </td>
                                @endif
                                <td  class="px-4">
                                    <div class="flex items-center justify-center space-x-3">
                                        @if($editarvisible==1)
                                            <x-icon.edit-a wire:click="editar({{ $valor->id }})" class="pl-1"  title="Editar {{ $titulo }}"/>
                                        @endif
                                        <x-icon.delete-a wire:click.prevent="delete({{ $valor->id }})" onclick="confirm('¿Estás seguro?') || event.stopImmediatePropagation()" class="w-6 pl-1"  title="Eliminar detalle"/>
                                    </div>
                                </td >
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-blue-100">
                        <form wire:submit.prevent="save">
                            <tr >
                                @if ($campo1visible==1)
                                <td class="p-2 text-xs leading-5 tracking-tighter text-gray-600 whitespace-no-wrap" >
                                    <input type="text" wire:model.live="valorcampo1"
                                    class="w-full text-xs text-left border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" />
                                </td>
                                @endif
                                @if ($campo2visible==1)
                                 @if($titcampo1=='Caja')
                                        <td class="p-2 text-xs leading-5 tracking-tighter text-gray-600 whitespace-no-wrap" >
                                            <select wire:model.live="valorcampo2"
                                                class="py-1 text-xs text-gray-600 bg-white border-gray-300 rounded-md shadow-sm appearance-none hover:border-gray-400 focus:outline-none">
                                                <option value="1" {{$valor->valorcampo2=='1' ? 'selected' : ''}}>Editorial</option>
                                                <option value="2" {{$valor->valorcampo2=='2' ? 'selected' : ''}}>Packaging/Otros</option>
                                            </select>
                                        </td>
                                    @else
                                        <td class="p-2 text-xs leading-5 tracking-tighter text-gray-600 whitespace-no-wrap" >
                                            <input type="text" wire:model.live="valorcampo2"
                                            class="w-full text-xs text-left border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" />
                                        </td>
                                    @endif
                                @endif
                                @if ($campo3visible==1)
                                <td class="p-2 text-xs leading-5 tracking-tighter text-gray-600 whitespace-no-wrap" >
                                    @if (($campo3tipo ?? 'texto') === 'bool')
                                        <button type="button" x-data
                                            @click="$wire.valorcampo3 = ($wire.valorcampo3 == 1 ? 0 : 1)"
                                            title="Activo / inactivo del nuevo registro (clic para cambiar)"
                                            class="inline-flex items-center justify-center p-1 transition-transform duration-150 rounded-full hover:scale-110 focus:outline-none">
                                            <svg x-show="$wire.valorcampo3 == 1" class="w-6 h-6 text-green-500 drop-shadow-sm" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                            </svg>
                                            <svg x-cloak x-show="$wire.valorcampo3 != 1" class="w-6 h-6 text-rose-400 drop-shadow-sm" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    @else
                                        <input type="text" wire:model.live="valorcampo3"
                                        class="w-full text-xs text-left border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" />
                                    @endif
                                </td>
                                @endif
                                <td  class="p-2 ">
                                    <button type="submit" class="items-center pl-1 mx-0 mt-2 text-center w-7 "><x-icon.save-a class="text-blue"></x-icon.save-a></button>
                                </td>
                            </tr>
                        </tfoot>
                    </form>
                </table>
            </div>
        </div>
    </div>
