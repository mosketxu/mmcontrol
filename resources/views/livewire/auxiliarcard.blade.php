    <div class="relative p-2 bg-white border rounded">
        <div class="">
            <div class="flex justify-between">
                <div>
                    <h3 class="text-lg font-bold">{{ $titulo }}</h3>
                </div>
                <div>
                    <input type="text" wire:model="search" class="w-full py-2 mb-2 text-xs text-gray-600 placeholder-gray-300 bg-white border-blue-300 rounded-md shadow-sm appearance-none hover:border-gray-400 focus:outline-none" placeholder="Búsqueda" autofocus/>
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
                            <tr wire:loading.class.delay="opacity-50">
                                @if ($campo1visible==1)
                                <td class="px-1 text-xs leading-5 tracking-tighter text-gray-600 whitespace-no-wrap" >
                                    <input type="text" value="{{ $valor->valorcampo1 }}"
                                    wire:change="changeCampo({{ $valor }},'{{ $campo1 }}',$event.target.value)"
                                    class="w-full text-xs font-thin text-gray-500 border-0 rounded-md"/>
                                </td>
                                @endif
                                @if ($campo2visible==1)
                                <td class="px-1 text-xs leading-5 tracking-tighter text-gray-600 whitespace-no-wrap">
                                    <input type="text" value="{{ $valor->valorcampo2 }}"
                                    wire:change="changeCampo({{ $valor }},'{{ $campo2 }}',$event.target.value)"
                                    class="w-full text-xs font-thin text-gray-500 border-0 rounded-md"/>
                                </td>
                                @endif
                                @if ($campo3visible==1)
                                <td class="px-1 text-xs leading-5 tracking-tighter text-gray-600 whitespace-no-wrap">
                                    <input type="text" value="{{ $valor->valorcampo3 }}"
                                    wire:change="changeCampo({{ $valor }},'{{ $campo3 }}',$event.target.value)"
                                    class="w-full text-xs font-thin text-gray-500 border-0 rounded-md"/>
                                </td>
                                @endif
                                <td  class="px-4">
                                    <div class="flex items-center justify-center space-x-3">
                                        @if($editarvisible==1)
                                            <x-icon.edit-a wire:click="editar({{ $valor->id }})" class="pl-1"  title="Editar {{ $titulo }}"/>
                                        @endif
                                        <x-icon.delete-a wire:click.prevent="delete({{ $valor->id }})" onclick="confirm('¿Estás seguro?') || event.stopImmediatePropagation()" class="pl-1"  title="Eliminar detalle"/>
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
                                    <input type="text" wire:model.defer="valorcampo1"
                                    class="w-full text-xs text-left border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" />
                                </td>
                                @endif
                                @if ($campo2visible==1)
                                <td class="p-2 text-xs leading-5 tracking-tighter text-gray-600 whitespace-no-wrap" >
                                    <input type="text" wire:model.defer="valorcampo2"
                                    class="w-full text-xs text-left border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" />
                                </td>
                                @endif
                                @if ($campo3visible==1)
                                <td class="p-2 text-xs leading-5 tracking-tighter text-gray-600 whitespace-no-wrap" >
                                    <input type="text" wire:model.defer="valorcampo3"
                                    class="w-full text-xs text-left border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" />
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
            <div class="">
                @include('errores')
            </div>
        </div>
    </div>
