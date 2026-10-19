<div class="flex justify-between space-x-2 text-xs">
    {{-- Factura --}}
    <div class="flex w-1/12 ">
        <div class="w-full">
            <label class="px-1 text-xs text-gray-600">
                Factura
            </label>
            <div class="flex">
                <x-buscador wire:model="search" solo="id" :options="$facturasopciones ?? []" placeholder="Nº factura..." texto="text-xs"/>
                @if($search!='')
                    <x-icon.filter-slash-a wire:click="$set('search', '')" class="pb-1" title="reset filter"/>
                @endif
            </div>
        </div>
    </div>
    <div class="flex w-2/12 ">
        <div class="w-full">
            <label class="px-1 text-xs text-gray-600">
                Cliente
            </label>
            <div class="flex">
                <div style="width:100%"><x-combo wire:model="filtrocliente" :options="$clientes->map(fn($c)=>['id'=>$c->id,'label'=>$c->entidad])->values()->all()" placeholder="-- Todos --" class="w-full py-1 text-xs text-gray-600 bg-white border-blue-300 rounded-md shadow-sm"/></div>
                @if($filtrocliente!='')
                    <x-icon.filter-slash-a wire:click="$set('filtrocliente', '')" class="pb-1" title="reset filter"/>
                @endif
            </div>
        </div>
    </div>
    <div class="flex w-1/12 ">
        <div class="w-full">
            <label class="px-1 text-xs text-gray-600">
                Tipo
            </label>
            <div class="flex">
                <x-combo wire:model="filtroTipo" :options="[['id'=>'1','label'=>'Editorial'],['id'=>'2','label'=>'Packaging'],['id'=>'3','label'=>'Propios']]" placeholder="Todos"/>
                @if($filtroTipo!='')
                    <x-icon.filter-slash-a wire:click="$set('filtroTipo', '')" class="pb-1" title="reset filter"/>
                @endif
            </div>
        </div>
    </div>

    <div class="flex w-1/12">
        <div class="w-full">
            <label class="px-1 text-xs text-gray-600">
                Año Factura
            </label>
            <div class="flex">
                <x-buscador wire:model="filtroanyo" sugerir="anyos" :tipo="$tipo ?? null" placeholder="Año"/>
                @if($filtroanyo!='')
                <x-icon.filter-slash-a wire:click="$set('filtroanyo', '')" class="pb-1" title="reset filter" />
                @endif
            </div>
        </div>
    </div>
    <div class="flex w-1/12">
        <div class="w-full">
            <label class="px-1 text-xs text-gray-600">
                Mes Factura
            </label>
            <div class="flex">
                <x-combo wire:model="filtromes" :options="collect($meses)->map(fn($mes)=>['id'=>$mes->id,'label'=>($mes->mesmayus)])->values()->all()" placeholder="-- selecciona --"/>
                @if($filtromes!='')
                <x-icon.filter-slash-a wire:click="$set('filtromes', '')" class="pb-1" title="reset filter" />
                @endif
            </div>
        </div>
    </div>

    <div class="flex w-3/12 lg:w-4/12">
        <div class="w-full px-2 pb-1 mx-auto bg-gray-100 rounded-md">
            <div class="text-center">
                <label class="px-1 text-xs text-gray-600">Periodo de facturación:</label>
            </div>
            <div class="justify-between flex-none lg:flex">
                <div class="flex mx-auto ">
                    <div class="mt-2 text-xs">De:</div>
                    <input type="date" wire:model.lazy="filtroFi" class="py-1 mx-2 text-xs text-gray-600 placeholder-gray-300 bg-white border-blue-300 rounded-md shadow-sm appearance-none hover:border-gray-400 focus:outline-none"/>
                </div>
                <div class="flex mx-auto ">
                    <div class="mt-2 text-xs">A:</div>
                    <input type="date" wire:model.lazy="filtroFf" class="py-1 mx-2 text-xs text-gray-600 placeholder-gray-300 bg-white border-blue-300 rounded-md shadow-sm appearance-none hover:border-gray-400 focus:outline-none"/>
                </div>
            </div>
        </div>
    </div>

    <div class="flex w-2/12">
        <div class="w-full">
            <label class="px-1 text-xs text-gray-600">
                Estado
            </label>
            <div class="flex">
                <x-combo wire:model="filtroestado" :options="collect($estados)->map(fn($estado,$valor)=>['id'=>$valor,'label'=>($estado[1])])->values()->all()" placeholder="-- selecciona --"/>
                @if($filtroestado!='')
                    <x-icon.filter-slash-a wire:click="$set('filtroestado', '')" class="pb-1" title="reset filter" />
                @endif
            </div>
        </div>
    </div>
    {{-- <div class="flex flex-row-reverse w-2/12">
        <div class="inline-flex mt-3 space-x-2">
            <x-dropdown label="Actions">
                <x-dropdown.item type="button" wire:click="exportSelected" class="flex items-center space-x-2">
                    <x-icon.csv class="text-green-400"></x-icon.csv><span>Export </span>
                </x-dropdown.item>
                <x-dropdown.item type="button" wire:click="$toggle('showDeleteModal')"
                    class="flex items-center space-x-2">
                    <x-icon.trash class="text-red-400"></x-icon.trash> <span>Delete </span>
                </x-dropdown.item>
            </x-dropdown>
        </div>
    </div> --}}
</div>
