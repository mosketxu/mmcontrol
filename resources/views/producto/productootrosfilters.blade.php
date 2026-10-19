<div class="flex justify-between space-x-1">
    <div class="w-10 mt-8 text-gray-300">
        <x-icon.filter/>
    </div>
    <div class="flex w-2/12 ">
        <div class="w-full">
            <label class="px-1 text-sm text-gray-600">
                Cod./Ref.
            </label>
            <div class="flex">
                <x-buscador wire:model="filtroisbn" :options="$opcisbn ?? []" placeholder="ISBN / Código..." texto="text-xs" ancho="24rem" class="w-full py-2 text-xs text-gray-600 bg-white border border-blue-300 rounded-md shadow-sm"/>
                @if($filtroisbn!='')
                    <x-icon.filter-slash-a wire:click="$set('filtroisbn', '')" class="pb-1" title="reset filter"/>
                @endif
            </div>
        </div>
    </div>
    <div class="flex w-3/12 ">
        <div class="w-full">
            <label class="px-1 text-sm text-gray-600">
                Referencia
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
    <div class="flex w-2/12 ">
        <div class="w-full">
            <label class="px-1 text-sm text-gray-600">
                Caja
            </label>
            <div class="flex">
                <select wire:model="filtrocaja" class="w-full py-2 text-xs text-gray-600 bg-white border-blue-300 rounded-md shadow-sm appearance-none hover:border-gray-400 focus:outline-none">
                    <option value=""></option>
                    @foreach ($cajas as $caja)
                    <option value="{{ $caja->id }}">{{ $caja->name }}</option>
                    @endforeach
                </select>
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
                <select wire:model="filtroidioma" class="w-full py-2 text-xs text-gray-600 bg-white border-blue-300 rounded-md shadow-sm appearance-none hover:border-gray-400 focus:outline-none">
                    <option value=""></option>
                    @foreach ($idiomas as $idioma)
                    <option value="{{ $idioma->id }}">{{ $idioma->nombre }}</option>
                    @endforeach
                </select>
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
                <select wire:model="filtroproductoestado" class="w-full py-2 text-xs text-gray-600 bg-white border-blue-300 rounded-md shadow-sm appearance-none hover:border-gray-400 focus:outline-none">
                    <option value="">-- Seleccionar --</option>
                    @foreach($productosestado as $value => $label)
                        <option value="{{ $value }}"
                        {{ old('estadoproducto', $producto->estadoproducto?->value ?? '') == $value ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($filtroproductoestado!='')
                    <x-icon.filter-slash-a wire:click="$set('filtroproductoestado', '')" class="pb-1" title="reset filter"/>
                @endif
            </div>
        </div>
    </div>
    <div class="flex w-2/12 ">
        <div class="w-full">
            <label class="px-1 text-sm text-gray-600">
                Material
            </label>
            <div class="flex">
                <input type="text" wire:model.lazy="filtromaterial" class="w-full py-2 text-xs text-gray-600 placeholder-gray-300 bg-white border-blue-300 rounded-md shadow-sm appearance-none hover:border-gray-400 focus:outline-none" placeholder="Búsqueda Entidad/Factura" autofocus/>
                @if($filtromaterial!='')
                    <x-icon.filter-slash-a wire:click="$set('filtromaterial', '')" class="pb-1" title="reset filter"/>
                @endif
            </div>
        </div>
    </div>
    <div class="flex w-2/12 ">
        <div class="w-full">
            <label class="px-1 text-sm text-gray-600">
                Impresión
            </label>
            <div class="flex">
                <input type="text" wire:model.lazy="filtroimpresion" class="w-full py-2 text-xs text-gray-600 placeholder-gray-300 bg-white border-blue-300 rounded-md shadow-sm appearance-none hover:border-gray-400 focus:outline-none" placeholder="Búsqueda Entidad/Factura" autofocus/>
                @if($filtroimpresion!='')
                    <x-icon.filter-slash-a wire:click="$set('filtroimpresion', '')" class="pb-1" title="reset filter"/>
                @endif
            </div>
        </div>
    </div>
    <div class="flex flex-row-reverse w-2/12 ">
        <div class="mt-3">
            <x-button.button  onclick="location.href = '{{ route('producto.nuevo',$tipo) }}'" color="blue" >{{ __('Nuevo') }}</x-button.button>
        </div>
        <div class="ml-10">
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
                class="mt-3 mr-1 text-green-400 w-7" title="Exportar productos" title="Exportar productos packaging"/>
        </div>
    </div>
</div>
