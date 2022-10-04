    <div class="relative bg-white border rounded">
        <div class="p-4 ">
            <div class="flex justify-between">
                <div>
                    <h3 class="text-lg font-bold">{{ $titulo }}</h3>
                </div>
                <div>
                    <input type="text" wire:model="search" class="w-full py-2 mb-2 text-xs text-gray-600 placeholder-gray-300 bg-white border-blue-300 rounded-md shadow-sm appearance-none hover:border-gray-400 focus:outline-none" placeholder="Búsqueda" autofocus/>
                </div>
            </div>

            @if ($errors->any())
                <div id="alert" class="relative px-6 py-2 mb-2 text-white bg-red-200 border-red-500 rounded border-1">
                    <ul class="mt-3 text-sm text-red-600 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button class="absolute top-0 right-0 mt-2 mr-6 text-2xl font-semibold leading-none bg-transparent outline-none focus:outline-none" onclick="document.getElementById('alert').remove();">
                        <span>×</span>
                    </button>
                </div>
            @endif

            <div class="min-w-full overflow-hidden overflow-x-auto align-middle shadow sm:rounded-t-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th class="w-1/6 px-1 py-3 pl-3 text-xs font-medium leading-4 tracking-wider text-left text-gray-500 bg-blue-50" >{{ __($campo1) }}</th>
                            <th class="w-4/6 px-1 py-3 pl-3 text-xs font-medium leading-4 tracking-wider text-left text-gray-500 bg-blue-50" >{{ __($campo2) }} </th>
                            <th class="w-1/6 px-1 py-3 pl-3 text-xs font-medium leading-4 tracking-wider text-left text-gray-500 bg-blue-50" ></th>
                        </tr>
                    </thead>
                </table>

            </div>
            <div class="h-64 min-w-full overflow-x-auto overflow-y-auto align-middle shadow sm:rounded-b-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <tbody class="bg-white divide-y divide-gray-200 ">
                        @foreach ($valores as $valor)
                            <tr wire:loading.class.delay="opacity-50">
                                <td class="w-3/12 px-1 text-xs leading-5 tracking-tighter text-gray-600 whitespace-no-wrap" >
                                    <input type="text" value="{{ $valor->nombrecorto }}"
                                    wire:change="changeCorto({{ $valor }},$event.target.value)"
                                    class="w-full text-xs font-thin text-gray-500 border-0 rounded-md"/>
                                </td>
                                <td class="w-8/12 px-1 text-xs leading-5 tracking-tighter text-gray-600 whitespace-no-wrap">
                                    <input type="text" value="{{ $valor->nombre }}"
                                    wire:change="changeNombre({{ $valor }},$event.target.value)"
                                    class="w-full text-xs font-thin text-gray-500 border-0 rounded-md"/>
                                </td>
                                <td  class="w-1/12 px-4">
                                    <div class="flex items-center justify-center space-x-3">
                                        @if($titulo=="Roles")
                                            <x-icon.edit-a href="{{route('roles.edit',$valor) }}" class="pl-1"  title="Editar Role"/>
                                        @endif
                                        <x-icon.delete-a wire:click.prevent="delete({{ $valor->id }})" onclick="confirm('¿Estás seguro?') || event.stopImmediatePropagation()" class="pl-1"  title="Eliminar detalle"/>
                                    </div>
                                </td >
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="min-w-full overflow-hidden overflow-x-auto align-middle shadow sm:rounded-lg">
                <form wire:submit.prevent="save">
                    <table min-w-full divide-y divide-gray-200>
                        <tbody>
                            <tr>
                                <td class="w-3/12 p-2 text-xs leading-5 tracking-tighter text-gray-600 whitespace-no-wrap" >
                                    <input type="text" wire:model.defer="nombrecorto"
                                    class="w-full text-xs text-right border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" />
                                </td>
                                <td class="w-8/12 p-2 text-xs leading-5 tracking-tighter text-gray-600 whitespace-no-wrap" >
                                    <input type="text" wire:model.defer="nombre"
                                    class="w-full text-xs text-right border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" />
                                </td>
                                <td  class="p-2 ">
                                    <button type="submit" class="items-center pl-1 mx-0 mt-2 text-center w-7 "><x-icon.save-a class="text-blue"></x-icon.save-a></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </form>
            </div>
        </div>
    </div>
{{-- </div> --}}
