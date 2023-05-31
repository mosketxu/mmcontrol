<div class="flex justify-between space-x-1">
    <div class="flex w-2/12">
        <div class="w-full">
            <label class="px-1 text-sm text-gray-600">
                Búsqueda
            </label>
            <div class="flex">
                <input type="search" wire:model="search" class="w-full py-1 border border-blue-100 rounded-lg" placeholder="Búsqueda por nombre o nif..." autofocus/>
                {{-- @if($search!='')
                    <x-icon.filter-slash-a wire:click="$set('search', '')" class="pb-1" title="reset filter"/>
                @endif --}}
            </div>
        </div>
    </div>
    <div class="flex w-3/12">
        <div class="w-full">
            <label class="px-1 text-sm text-gray-600">
                Responsable
            </label>
            <div class="flex">
                <input type="search" wire:model="filtroresponsable" class="w-full py-1 border border-blue-100 rounded-lg" placeholder="Búsqueda responsable"/>
                {{-- @if($filtroresponsable!='')
                    <x-icon.filter-slash-a wire:click="$set('filtroresponsable', '')" class="pb-1" title="reset filter"/>
                @endif --}}
            </div>
        </div>
    </div>
    <div class="flex w-5/12">
        <div class="flex-none w-full md:space-x-2 md:flex">
            <div class="w-full md:w-6/12">
                <label class="px-1 text-sm text-gray-600">
                    F.Ini.
                </label>
                <div class="flex w-full">
                    <input type="date" wire:model="filtrofini" class="w-full py-1 border border-blue-100 rounded-lg"/>
                    {{-- @if($filtrofini!='')
                        <x-icon.filter-slash-a wire:click="$set('filtrofini', '')" class="pb-1" title="reset filter"/>
                    @endif --}}
                </div>
            </div>
            <div class="w-full md:w-6/12">
                <label class="px-1 text-sm text-gray-600">
                    F.Fin.
                </label>
                <div class="flex">
                    <input type="date" wire:model="filtroffin" class="w-full py-1 border border-blue-100 rounded-lg"/>
                    {{-- @if($filtroffin!='')
                        <x-icon.filter-slash-a wire:click="$set('filtroffin', '')" class="pb-1" title="reset filter"/>
                    @endif --}}
                </div>
            </div>
        </div>
    </div>
    <div class="flex flex-row-reverse w-2/12">
        <div class="mt-3">
            <x-button.button  onclick="location.href = '{{ route('entidad.nueva',$entidadtipo->id) }}'" color="blue">Nuevo</x-button.button>
        </div>
    </div>
</div>
