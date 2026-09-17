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
                            <th class="px-1 py-3 pl-3 text-xs font-bold leading-4 tracking-wider text-left text-gray-500 bg-blue-50">IBAN</th>
                            <th class="px-1 py-3 pl-3 text-xs font-bold leading-4 tracking-wider text-left text-gray-500 bg-blue-50">BIC</th>
                            <th class="px-1 py-3 pl-3 text-xs font-bold leading-4 tracking-wider text-left text-gray-500 bg-blue-50">Moneda</th>
                            <th class="px-1 py-3 pl-3 text-xs font-bold leading-4 tracking-wider text-center text-gray-500 bg-blue-50">Predeterminada</th>
                            <th class="px-1 py-3 pl-3 text-xs font-bold leading-4 tracking-wider text-left text-gray-500 bg-blue-50"></th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200 ">
                        @foreach ($cuentas as $cuenta)
                            <tr wire:key="cuenta-{{ $cuenta->id }}" wire:loading.class.delay="opacity-50" class="{{ $cuenta->es_defecto ? 'bg-green-50' : '' }}">
                                <td class="px-1 text-xs leading-5 tracking-tighter text-gray-600 whitespace-no-wrap">
                                    <input type="text" value="{{ $cuenta->iban }}"
                                    wire:change="changeCampo({{ $cuenta }},'iban',$event.target.value)"
                                    class="w-full text-xs font-thin text-gray-500 border-0 rounded-md"/>
                                </td>
                                <td class="px-1 text-xs leading-5 tracking-tighter text-gray-600 whitespace-no-wrap">
                                    <input type="text" value="{{ $cuenta->bic }}"
                                    wire:change="changeCampo({{ $cuenta }},'bic',$event.target.value)"
                                    class="w-full text-xs font-thin text-gray-500 border-0 rounded-md"/>
                                </td>
                                <td class="px-1 text-xs leading-5 tracking-tighter text-gray-600 whitespace-no-wrap">
                                    <input type="text" value="{{ $cuenta->moneda }}"
                                    wire:change="changeCampo({{ $cuenta }},'moneda',$event.target.value)"
                                    class="w-full text-xs font-thin text-gray-500 border-0 rounded-md"/>
                                </td>
                                <td class="px-1 text-xs leading-5 tracking-tighter text-center text-gray-600 whitespace-no-wrap">
                                    @if($cuenta->es_defecto)
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-green-100 text-green-700 text-xs font-semibold" title="Cuenta predeterminada">
                                            <svg class="w-3.5 h-3.5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                            </svg>
                                            Predeterminada
                                        </span>
                                    @else
                                        <button type="button"
                                            wire:click="setDefecto({{ $cuenta->id }})"
                                            wire:loading.attr="disabled"
                                            title="Marcar como predeterminada"
                                            class="inline-block w-4 h-4 border-2 border-gray-300 rounded-full hover:border-green-400 focus:outline-none focus:ring-2 focus:ring-green-300"></button>
                                    @endif
                                </td>
                                <td class="px-4">
                                    <div class="flex items-center justify-center space-x-3">
                                        <x-icon.delete-a wire:click.prevent="delete({{ $cuenta->id }})" onclick="confirm('¿Estás seguro?') || event.stopImmediatePropagation()" class="w-6 pl-1" title="Eliminar cuenta"/>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-blue-100">
                        <form wire:submit.prevent="save">
                            <tr>
                                <td class="p-2 text-xs leading-5 tracking-tighter text-gray-600 whitespace-no-wrap">
                                    <input type="text" wire:model.defer="valorcampo1" placeholder="IBAN"
                                    class="w-full text-xs text-left border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" />
                                </td>
                                <td class="p-2 text-xs leading-5 tracking-tighter text-gray-600 whitespace-no-wrap">
                                    <input type="text" wire:model.defer="valorcampo2" placeholder="BIC"
                                    class="w-full text-xs text-left border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" />
                                </td>
                                <td class="p-2 text-xs leading-5 tracking-tighter text-gray-600 whitespace-no-wrap">
                                    <input type="text" wire:model.defer="valorcampo3" placeholder="Moneda"
                                    class="w-full text-xs text-left border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" />
                                </td>
                                <td class="p-2 text-xs text-center text-gray-400">—</td>
                                <td class="p-2">
                                    <button type="submit" class="items-center pl-1 mx-0 mt-2 text-center w-7"><x-icon.save-a class="text-blue"></x-icon.save-a></button>
                                </td>
                            </tr>
                        </form>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
