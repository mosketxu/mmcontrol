{{--
    Cuadro de búsqueda con sugerencias (combo en el que se puede escribir): al escribir se filtra el listado y se sugieren
    valores; elegir uno lo pone en el campo. A diferencia de x-combo, lo escrito vale como filtro aunque no se elija nada.
    Uso: <x-buscador wire:model="search" :options="[['id'=>'valor que se pone','label'=>'texto que se ve'], ...]" placeholder="..." />
    Va dentro de wire:ignore: las opciones se fijan al pintar.
--}}
@props(['options' => [], 'placeholder' => '', 'texto' => 'text-sm', 'ancho' => '22rem'])
@php
    $opts = collect($options)->map(fn ($o) => ['id' => (string) $o['id'], 'label' => (string) $o['label']])->values()->all();
@endphp
<div wire:ignore style="position:relative;width:100%"
    x-data="{ value: @entangle($attributes->wire('model')), q: '', open: false, hi: 0, st: '',
        calc() { const r = this.$refs.inp.getBoundingClientRect(); const h = window.innerHeight; const below = h - r.bottom - 8, above = r.top - 8; const up = below < 200 && above > below; const mh = Math.max(120, Math.min(260, up ? above : below)); this.st = 'position:fixed;z-index:80;left:' + r.left + 'px;min-width:max(' + r.width + 'px, {{ $ancho }});max-height:' + mh + 'px;' + (up ? 'bottom:' + (h - r.top + 2) + 'px;' : 'top:' + (r.bottom + 2) + 'px;') }, options: {{ \Illuminate\Support\Js::from($opts) }},
        norm(t){ return (t||'').toString().normalize('NFD').replace(/[̀-ͯ]/g,'').toLowerCase() },
        get filtered(){ const t=this.norm(this.q).split(/\s+/).filter(Boolean); return this.options.filter(o=>{const n=this.norm(o.label); return t.every(w=>n.includes(w))}).slice(0,100) },
        elegir(o){ this.q=o.id; this.value=o.id; this.open=false } }"
    x-init="q = value || ''; $watch('value', v => { if (!v) q = '' })"
    @click.outside="open=false">
    <input type="text" x-ref="inp" autocomplete="off" x-model="q" placeholder="{{ $placeholder }}"
        @focus="calc(); open=true" @input="calc(); open=true; hi=0" @input.debounce.500ms="value = q"
        @keydown.arrow-down.prevent="hi=Math.min(hi+1,filtered.length-1)" @keydown.arrow-up.prevent="hi=Math.max(hi-1,0)"
        @keydown.enter.prevent="open && filtered[hi] ? elegir(filtered[hi]) : (value = q, open=false)"
        @keydown.escape="open=false" @keydown.tab="open=false"
        {{ $attributes->whereDoesntStartWith('wire:')->merge(['class' => 'w-full py-1 '.$texto.' text-gray-600 bg-white border border-blue-100 rounded-lg']) }}>
    <div x-show="open && filtered.length" x-cloak :style="st" @scroll.window="open && calc()" @resize.window="open && calc()" style="overflow:auto;background:#fff;border:1px solid #d1d5db;border-radius:6px;box-shadow:0 4px 12px rgba(0,0,0,.15);font-size:13px;white-space:nowrap">
        <template x-for="(o,i) in filtered" :key="o.id + '|' + i">
            <div @mousedown.prevent="elegir(o)" @mouseenter="hi=i" :style="'padding:4px 8px;cursor:pointer;color:#374151;'+(i===hi?'background:#dbeafe':'')" x-text="o.label"></div>
        </template>
    </div>
</div>
