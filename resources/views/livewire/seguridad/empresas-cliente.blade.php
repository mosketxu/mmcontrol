<div class="relative p-2 bg-white border rounded">
    <div class="">
        <div class="flex justify-between">
            <div>
                <h3 class="text-lg font-bold">Empresas Asociadas</h3>
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
                        <th class="px-1 py-3 pl-3 text-xs font-bold leading-4 tracking-wider text-left text-gray-500 bg-blue-50" >Nombre</th>
                        <th class="px-1 py-3 pl-3 text-xs font-bold leading-4 tracking-wider text-left text-gray-500 bg-blue-50" ></th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200 ">
                    @forelse ($empresasasociadas as $userempresa)
                    <tr wire:loading.class.delay="opacity-50">
                        <td class="px-1 text-xs leading-5 tracking-tighter text-gray-600 whitespace-no-wrap" >
                            <input type="text" value="{{ $userempresa->entidad }}"
                            class="w-full text-xs font-thin text-gray-500 border-0 rounded-md"/>
                        </td>
                        <td  class="px-4">
                            <div class="flex items-center justify-center space-x-3">
                                <x-icon.delete-a wire:click.prevent="delete({{$userempresa->id}})" onclick="confirm('¿Estás seguro?') || event.stopImmediatePropagation()" class="w-6 pl-1"  title="Eliminar empresa"/>
                            </div>
                        </td >
                    </tr>
                    @empty
                    <tr col-2 wire:loading.class.delay="opacity-50">
                        <td class="px-1 text-xs leading-5 tracking-tighter text-gray-600 whitespace-no-wrap" >
                            <p class="w-full text-xs font-thin text-gray-500 border-0 rounded-md">
                                @if($cliente->hasRole('Cliente'))
                                    No tiene acceso a ninguna empresa
                                @else
                                    Es miembro de Milimetrica y tiene acceso a todas las empresas.
                                @endif
                            </p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
                <tfoot class="bg-blue-100">
                    <tr >
                        <td>
                            <x-combo wire:model.lazy="empresaId" :options="collect($empresasdisponibles)->map(fn($empresa)=>['id'=>$empresa->id,'label'=>($empresa->entidad)])->values()->all()" placeholder="--Selecciona Empresa--" />
                        </td>
                        <td class="p-2 "><x-icon.save-a wire:click="save()" class="text-blue"></x-icon.save-a></button></td>
                    </tr>
                </tfoot>
            </table>
        </div>
        <div class="">
            @include('errores')
        </div>
    </div>
</div>
