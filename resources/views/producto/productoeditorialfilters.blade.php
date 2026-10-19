<div class="flex justify-between space-x-1">
    <div class="w-10 mt-8 text-gray-300">
        <x-icon.filter/>
    </div>
    <div class="flex w-2/12 ">
        <div class="w-full">
            <label class="px-1 text-sm text-gray-600">
                ISBN/Código
            </label>
            <div class="flex">
                <x-buscador wire:model="filtroisbn" :options="$opcisbn ?? []" placeholder="ISBN / Código..." texto="text-xs" ancho="24rem" class="w-full py-2 text-xs text-gray-600 bg-white border border-blue-300 rounded-md shadow-sm"/>
                @if($filtroisbn!='')
                    <x-icon.filter-slash-a wire:click="$set('filtroisbn', '')" class="pb-1" title="reset filter"/>
                @endif
            </div>
        </div>
    </div>
    <div class="flex w-4/12 ">
        <div class="w-full">
            <label class="px-1 text-sm text-gray-600">
                Titulo/Referencia
            </label>
            <div class="flex">
                <x-buscador wire:model="filtroreferencia" :options="$opcreferencia ?? []" placeholder="Título / Referencia..." texto="text-xs" ancho="30rem" class="w-full py-2 text-xs text-gray-600 bg-white border border-blue-300 rounded-md shadow-sm"/>
                @if($filtroreferencia!='')
                    <x-icon.filter-slash-a wire:click="$set('filtroreferencia', '')" class="pb-1" title="reset filter"/>
                @endif
            </div>
        </div>
    </div>
    <div class="flex w-2/12 ">
        <div class="w-full">
            <label class="px-1 text-sm text-gray-600">
                Cliente
            </label>
            <div class="flex">
                <div style="width:100%"><x-combo wire:model="filtrocliente" :options="isset($clientes) ? $clientes->map(fn($c)=>['id'=>$c->id,'label'=>$c->entidad])->values()->all() : []" placeholder="-- Todos --" class="w-full py-2 text-xs text-gray-600 bg-white border-blue-300 rounded-md shadow-sm"/></div>
                @if($filtrocliente!='')
                    <x-icon.filter-slash-a wire:click="$set('filtrocliente', '')" class="pb-1" title="reset filter"/>
                @endif
            </div>
        </div>
    </div>
    <div class="flex w-1/12 ">
        <div class="w-full">
            <label class="px-1 text-sm text-gray-600">
                Idioma
            </label>
            <div class="flex">
                <x-combo wire:model="filtroidioma" :options="collect($idiomas)->map(fn($idioma)=>['id'=>$idioma->id,'label'=>($idioma->nombre)])->values()->all()" placeholder="-- Todos --"/>
                @if($filtroidioma!='')
                    <x-icon.filter-slash-a wire:click="$set('filtroidioma', '')" class="pb-1" title="reset filter"/>
                @endif
            </div>
        </div>
    </div>
    <div class="flex w-1/12 ">
        <div class="w-full">
            <label class="px-1 text-sm text-gray-600">
                Estado
            </label>
            <div class="flex">
                <x-combo wire:model="filtroproductoestado" :options="collect($productosestado)->map(fn($label,$value)=>['id'=>$value,'label'=>($label)])->values()->all()" placeholder="-- Selecciona Estado --"/>
                @if($filtroproductoestado!='')
                    <x-icon.filter-slash-a wire:click="$set('filtroproductoestado', '')" class="pb-1" title="reset filter"/>
                @endif
            </div>
        </div>
    </div>
    <div class="flex flex-row-reverse w-2/12 gap-4">
        <div class="mt-3">
            @if(!Auth::user()->hasRole('Cliente'))
            <x-button.button  onclick="location.href = '{{ route('producto.nuevo',$tipo) }}'" color="blue" >{{ __('Nuevo') }}</x-button.button>
            @endif
        </div>
        <div >
            <x-icon.xls-a href="{{ route('producto.export',[
                    'tipo' => $tipo,
                    'filtroisbn' => $filtroisbn,
                    'filtroproductoestado' => $filtroproductoestado,
                    'filtroreferencia' => $filtroreferencia,
                    'filtrocliente' => $filtrocliente,
                    'filtroidioma' => $filtroidioma,
                    'filtromaterial' => $filtromaterial,
                    'filtroimpresion' => $filtroimpresion,
                    'filtrocaja' => $filtrocaja
                ]) }}"
                class="mt-3 mr-1 text-green-400 w-7" title="Exportar productos"/>
        </div>
    </div>
</div>
