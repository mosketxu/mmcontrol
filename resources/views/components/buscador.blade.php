{{--
    Cuadro de búsqueda con sugerencias (combo en el que se puede escribir): al escribir se filtra el listado y se sugieren
    valores; elegir uno lo pone en el campo. A diferencia de x-combo, lo escrito vale como filtro aunque no se elija nada.
    Aspecto único: config/ui.php.
    Sugerencias: :options="[['id'=>'valor que se pone','label'=>'texto que se ve'], ...]"  o  sugerir="isbn" (ver App\Support\Sugerencias).
    En Livewire:  <x-buscador wire:model="filtroisbn" sugerir="isbn" :tipo="$tipo" placeholder="ISBN..." />
    En GET:       <x-buscador name="filtroisbn" :valor="$filtroisbn" sugerir="isbn" :tipo="$tipo" />  (envía el formulario al elegir o con Enter)
--}}
@props(['options' => null, 'sugerir' => null, 'tipo' => null, 'placeholder' => '', 'name' => null, 'valor' => '', 'ancho' => '22rem'])
@php
    $wm = $attributes->wire('model')->value();
    $lista = $options ?? ($sugerir ? \App\Support\Sugerencias::de($sugerir, $tipo) : []);
    $opts = collect($lista)->map(fn ($o) => ['id' => (string) $o['id'], 'label' => (string) $o['label']])->values()->all();
@endphp
<div wire:ignore style="position:relative;width:100%"
    x-data="{ @if($wm) value: @entangle($attributes->wire('model')), @else value: {{ \Illuminate\Support\Js::from((string) $valor) }}, @endif
        enviar: {{ $wm ? 'false' : 'true' }}, q: '', open: false, hi: 0, st: {}, options: {{ \Illuminate\Support\Js::from($opts) }},
        calc() { const r = this.$refs.inp.getBoundingClientRect(); const h = window.innerHeight; const below = h - r.bottom - 8, above = r.top - 8; const up = below < 200 && above > below; const mh = Math.max(120, Math.min(260, up ? above : below)); this.st = { position: 'fixed', zIndex: 80, left: r.left + 'px', minWidth: 'max(' + r.width + 'px, {{ $ancho }})', maxHeight: mh + 'px', width: 'max-content', maxWidth: (window.innerWidth - r.left - 8) + 'px', top: up ? 'auto' : (r.bottom + 2) + 'px', bottom: up ? (h - r.top + 2) + 'px' : 'auto' } },
        norm(t){ return (t||'').toString().normalize('NFD').replace(/[̀-ͯ]/g,'').toLowerCase() },
        get filtered(){ const t=this.norm(this.q).split(/\s+/).filter(Boolean); return this.options.filter(o=>{const n=this.norm(o.label); return t.every(w=>n.includes(w))}).slice(0,100) },
        poner(v){ this.value = v; if (this.enviar) this.$nextTick(() => this.$root.closest('form').submit()) },
        elegir(o){ this.q=o.id; this.open=false; this.poner(o.id) } }"
    x-init="q = value || ''; $watch('value', v => { if (!v) q = '' })"
    @click.outside="open=false">
    @if(!$wm && $name)<input type="hidden" name="{{ $name }}" :value="value">@endif
    <input type="text" x-ref="inp" autocomplete="off" x-model="q" placeholder="{{ $placeholder }}"
        @focus="calc(); open=true" @input="calc(); open=true; hi=0" @if($wm) @input.debounce.500ms="value = q" @endif
        @keydown.arrow-down.prevent="hi=Math.min(hi+1,filtered.length-1)" @keydown.arrow-up.prevent="hi=Math.max(hi-1,0)"
        @keydown.enter.prevent="open && filtered[hi] ? elegir(filtered[hi]) : (open=false, poner(q))"
        @keydown.escape="open=false" @keydown.tab="open=false" @if(!$wm) @change="poner(q)" @endif
        {{ $attributes->whereDoesntStartWith('wire:')->except('class')->merge(['class' => config('ui.input')]) }}>
    <div x-show="open && filtered.length" x-cloak :style="st" @scroll.window="open && calc()" @resize.window="open && calc()" style="white-space:nowrap;overflow:auto;background:#fff;border:1px solid #d1d5db;border-radius:6px;box-shadow:0 4px 12px rgba(0,0,0,.15);font-size:13px">
        <template x-for="(o,i) in filtered" :key="o.id + '|' + i">
            <div @mousedown.prevent="elegir(o)" @mouseenter="hi=i" :style="'padding:4px 8px;cursor:pointer;color:#374151;'+(i===hi?'background:#dbeafe':'')" x-text="o.label"></div>
        </template>
    </div>
</div>
