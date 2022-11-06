<div class="flex justify-between space-x-1">
    <div class="flex w-6/12 ">
        <div class="w-full">
            <label class="px-1 text-sm text-gray-600">
                Búsqueda
            </label>
            <div class="flex">
                <input type="text" wire:model="search" class="w-full py-1 border border-blue-100 rounded-lg" placeholder="Búsqueda por nombre o nif..." autofocus/>
                @if($search!='')
                    <x-icon.filter-slash-a wire:click="$set('search', '')" class="pb-1" title="reset filter"/>
                @endif
            </div>
        </div>
    </div>
    <div class="flex w-4/12 ">
        <div class="w-full">
            <label class="px-1 text-sm text-gray-600">
                Responsable
            </label>
            <div class="flex">
                <select wire:model="filtroresponsable" class="w-full py-2 text-xs text-gray-600 bg-white border-blue-300 rounded-md shadow-sm appearance-none hover:border-gray-400 focus:outline-none">
                    <option value=""></option>
                    @foreach ($responsables as $responsable)
                    <option value="{{ $responsable->id }}">{{ $responsable->name }}</option>
                    @endforeach
                </select>
                @if($filtroresponsable!='')
                    <x-icon.filter-slash-a wire:click="$set('filtroresponsable', '')" class="pb-1" title="reset filter"/>
                @endif
            </div>
        </div>
    </div>
    <div class="flex flex-row-reverse w-full">
        <div class="mt-3">
            <x-button.button  onclick="location.href = '{{ route('entidad.nueva',$entidadtipo->id) }}'" color="blue">Nuevo</x-button.button>
        </div>
    </div>
</div>
