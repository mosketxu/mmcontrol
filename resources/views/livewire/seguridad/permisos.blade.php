<div class="relative p-2 bg-white border rounded">
    <style>[x-cloak]{display:none!important}</style>

    <div x-data="{ open: {} }">
        <div class="flex flex-wrap items-center justify-between gap-2">
            <h3 class="text-lg font-bold">Permisos</h3>
            <div class="flex items-center gap-2">
                <button type="button"
                    @click="open = { @foreach ($grupos as $g => $ps) @js($g): true, @endforeach }"
                    class="px-2 py-1 text-xs text-gray-600 border border-gray-300 rounded hover:bg-gray-50">Expandir todo</button>
                <button type="button" @click="open = {}"
                    class="px-2 py-1 text-xs text-gray-600 border border-gray-300 rounded hover:bg-gray-50">Contraer todo</button>
                <input type="text" wire:model.live="search"
                    class="py-2 text-xs text-gray-600 placeholder-gray-300 bg-white border-blue-300 rounded-md shadow-sm appearance-none hover:border-gray-400 focus:outline-none"
                    placeholder="Búsqueda" />
            </div>
        </div>

        <div>
            @include('errores')
        </div>

        <div class="min-w-full mt-1 overflow-hidden overflow-x-auto align-middle shadow sm:rounded-t-lg">
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr>
                        <th class="px-1 py-3 pl-3 text-xs font-bold leading-4 tracking-wider text-left text-gray-500 bg-blue-50">Permiso</th>
                        <th class="px-1 py-3 bg-blue-50"></th>
                    </tr>
                </thead>

                @forelse ($grupos as $grupo => $permisos)
                    <tbody class="bg-white" wire:key="grupo-{{ $loop->index }}">
                        {{-- Cabecera del grupo --}}
                        <tr class="border-b cursor-pointer select-none bg-gray-50 hover:bg-gray-100"
                            @click="open[@js($grupo)] = !open[@js($grupo)]">
                            <td class="px-2 py-2" colspan="2">
                                <span class="inline-flex items-center gap-2 text-sm font-semibold text-gray-700">
                                    <span class="inline-flex items-center justify-center w-5 h-5 transition bg-blue-100 border border-blue-900 rounded text-blue-900 hover:bg-blue-200">
                                        <svg x-show="!(open[@js($grupo)] || $wire.search)" class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="3.5" viewBox="0 0 24 24" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14M5 12h14" />
                                        </svg>
                                        <svg x-cloak x-show="open[@js($grupo)] || $wire.search" class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="3.5" viewBox="0 0 24 24" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14" />
                                        </svg>
                                    </span>
                                    {{ ucfirst($grupo) }}
                                    <span class="px-1.5 text-xs font-medium text-gray-500 bg-gray-200 rounded-full">{{ $permisos->count() }}</span>
                                </span>
                            </td>
                        </tr>

                        {{-- Permisos del grupo --}}
                        @foreach ($permisos as $permiso)
                            <tr x-cloak x-show="open[@js($grupo)] || $wire.search"
                                class="border-b border-gray-100"
                                wire:key="perm-{{ $permiso->id }}-{{ $nonce }}"
                                wire:loading.class.delay="opacity-50">
                                <td class="py-1 pr-2 pl-12">
                                    <input type="text" value="{{ $permiso->name }}"
                                        wire:change="changeCampo({{ $permiso }},'name',$event.target.value)"
                                        class="w-full text-xs font-thin text-gray-600 border-0 rounded-md hover:bg-gray-50 focus:bg-white" />
                                </td>
                                <td class="px-4">
                                    <div class="flex items-center justify-center">
                                        <x-icon.delete-a wire:click.prevent="delete({{ $permiso->id }})"
                                            onclick="confirm('¿Eliminar el permiso {{ $permiso->name }}?') || event.stopImmediatePropagation()"
                                            class="w-6" title="Eliminar permiso" />
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                @empty
                    <tbody>
                        <tr><td class="px-3 py-4 text-xs text-gray-400" colspan="2">No hay permisos que coincidan con la búsqueda.</td></tr>
                    </tbody>
                @endforelse

                <tfoot class="bg-blue-100">
                    <form wire:submit.prevent="save">
                        <tr>
                            <td class="p-2" colspan="2">
                                <div class="flex items-center gap-2">
                                    <input type="text" wire:model.live="valorcampo2" placeholder="Nuevo permiso (p.ej. modulo.index)"
                                        class="flex-1 text-xs text-left border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" />
                                    <button type="submit" class="w-7 pl-1 mx-0 text-center"><x-icon.save-a class="text-blue" /></button>
                                </div>
                            </td>
                        </tr>
                    </form>
                </tfoot>
            </table>
        </div>
    </div>
</div>
