
{{-- <div class="flex justify-between space-x-1"> --}}
    {{-- <div class="w-0 mt-8 text-gray-300">
        <x-icon.filter/>
    </div> --}}
    <div class="flex w-full ">
        <div class="w-2/12">
            <label class="px-1 text-sm text-gray-600">
                Categoria
            </label>
            <div class="flex">
                <select wire:model="filtrocategoria" class="w-full py-2 text-xs text-gray-600 bg-white border-blue-300 rounded-md shadow-sm appearance-none hover:border-gray-400 focus:outline-none">
                    {{-- <option value="">Todos</option> --}}
                    @foreach ($categorias as $categoria)
                        <option value="{{ $categoria->id }}">{{ $categoria->name }}</option>
                    @endforeach
                </select>
                @if($filtrocategoria!='')
                    <x-icon.filter-slash-a wire:click="$set('filtrocategoria', '')" class="pb-1" title="reset filter"/>
                @endif
            </div>
        </div>
    </div>
{{-- </div> --}}
