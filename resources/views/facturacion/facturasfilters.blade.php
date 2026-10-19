<div class="flex justify-between space-x-2 text-xs">
    {{-- Factura --}}
    <div class="flex w-1/12 ">
        <div class="w-full">
            <label class="px-1 text-xs text-gray-600">
                Factura
            </label>
            <div class="flex">
                <div wire:ignore style="position:relative;width:100%"
                    x-data="{ value: @entangle('search'), q: @js((string) $search), open: false, hi: 0, options: @js($facturasopciones ?? []),
                        norm(t){ return (t||'').toString().normalize('NFD').replace(/[\u0300-\u036f]/g,'').toLowerCase() },
                        get filtered(){ const t=this.norm(this.q).split(/\s+/).filter(Boolean); return this.options.filter(o=>{const n=this.norm(o.label); return t.every(w=>n.includes(w))}).slice(0,100) },
                        elegir(o){ this.q=o.id; this.value=o.id; this.open=false } }"
                    x-effect="if (value === '' && q !== '') q = ''"
                    @click.outside="open=false">
                    <input type="text" autocomplete="off" x-model="q" placeholder="Nº factura..."
                        @focus="open=true" @input="open=true; hi=0" @input.debounce.500ms="value = q"
                        @keydown.arrow-down.prevent="hi=Math.min(hi+1,filtered.length-1)" @keydown.arrow-up.prevent="hi=Math.max(hi-1,0)"
                        @keydown.enter.prevent="open && filtered[hi] ? elegir(filtered[hi]) : (value = q, open=false)"
                        @keydown.escape="open=false" @keydown.tab="open=false"
                        class="w-full py-1 text-xs border border-blue-100 rounded-lg" autofocus/>
                    <div x-show="open && filtered.length" x-cloak style="position:absolute;left:0;top:100%;z-index:60;min-width:22rem;max-height:15rem;overflow:auto;background:#fff;border:1px solid #d1d5db;border-radius:6px;box-shadow:0 4px 12px rgba(0,0,0,.15);font-size:12px;white-space:nowrap">
                        <template x-for="(o,i) in filtered" :key="o.id">
                            <div @mousedown.prevent="elegir(o)" @mouseenter="hi=i" :style="'padding:4px 8px;cursor:pointer;color:#374151;'+(i===hi?'background:#dbeafe':'')" x-text="o.label"></div>
                        </template>
                    </div>
                </div>
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
                <select wire:model="filtroTipo" class="w-full py-1 text-xs text-gray-600 bg-white border-blue-300 rounded-md shadow-sm appearance-none hover:border-gray-400 focus:outline-none">
                    <option value="">Todos</option>
                    <option value="1">Editorial</option>
                    <option value="2">Packaging</option>
                    <option value="3">Propios</option>
                </select>
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
                <input type="text" wire:model="filtroanyo"
                    class="w-full py-1 text-xs text-gray-600 placeholder-gray-300 bg-white border-blue-300 rounded-md shadow-sm appearance-none hover:border-gray-400 focus:outline-none"
                    placeholder="Año" />
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
                <select wire:model="filtromes"
                    class="w-full py-1 text-xs text-gray-600 bg-white border-blue-300 rounded-md shadow-sm appearance-none hover:border-gray-400 focus:outline-none">
                    <option value="">-- selecciona --</option>
                    @foreach ($meses as $mes )
                    <option value={{ $mes->id}}>{{ $mes->mesmayus }}</option>
                    @endforeach
                </select>
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
                <select wire:model="filtroestado"
                    class="w-full py-1 text-xs text-gray-600 bg-white border-blue-300 rounded-md shadow-sm appearance-none hover:border-gray-400 focus:outline-none">
                    <option value="">-- selecciona --</option>
                    @foreach ($estados as $valor => $estado)
                        <option value="{{ $valor }}">{{ $estado[1] }}</option>
                    @endforeach
                </select>
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
