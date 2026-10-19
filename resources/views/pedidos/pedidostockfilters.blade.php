
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
                <x-combo wire:model="filtrocategoria" :options="collect($categorias)->map(fn($categoria)=>['id'=>$categoria->id,'label'=>($categoria->name)])->values()->all()" placeholder="Todos"/>
                @if($filtrocategoria!='')
                    <x-icon.filter-slash-a wire:click="$set('filtrocategoria', '')" class="pb-1" title="reset filter"/>
                @endif
            </div>
        </div>
    </div>
{{-- </div> --}}
