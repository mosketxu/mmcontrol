{{--
    Combo con búsqueda: se escribe directamente y la lista se filtra mientras se escribe (código y texto a la vez).
    Hay que elegir una opción de la lista. Aspecto único: config/ui.php.
    En formularios Livewire:   <x-combo wire:model="cliente_id" :options="$lista" placeholder="-- Selecciona cliente --" />
    En formularios GET:        <x-combo name="filtrocliente" :valor="$filtrocliente" :options="$lista" />  (envía el formulario al elegir)
    $lista = [['id'=>1,'label'=>'Texto que se ve y en el que se busca'], ...]
    Va dentro de wire:ignore: las opciones se fijan al pintar; si cambian (p. ej. contactos al cambiar de cliente) la clave
    wire:key lleva un hash de las opciones y Livewire repinta el combo.
--}}
@props(['options' => [], 'placeholder' => '-- Selecciona --', 'disabled' => false, 'name' => null, 'valor' => '', 'faceta' => null, 'contexto' => null, 'tipo' => null, 'filtros' => []])
@php
    $wm = $attributes->wire('model')->value();
    // Con faceta, las opciones salen de los registros que cumplen los demás filtros (App\Support\Facetas)
    if ($faceta) $options = \App\Support\Facetas::opciones($contexto, $tipo, $faceta, $filtros);
    $opts = collect($options)->map(fn ($o) => ['id' => (string) $o['id'], 'label' => (string) $o['label']])->values()->all();
@endphp
<div wire:ignore wire:key="combo-{{ $wm ?: $name }}-{{ md5(json_encode($opts)) }}" style="position:relative;width:100%"
    x-data="{
        @if($wm) value: @entangle($attributes->wire('model')), @else value: {{ \Illuminate\Support\Js::from((string) $valor) }}, @endif
        enviar: {{ $wm ? 'false' : 'true' }},
        options: {{ \Illuminate\Support\Js::from($opts) }},
        open: false, q: '', typed: false, hi: 0, st: {},
        calc() { const r = this.$refs.inp.getBoundingClientRect(); const h = window.innerHeight; const below = h - r.bottom - 8, above = r.top - 8; const up = below < 200 && above > below; const mh = Math.max(120, Math.min(260, up ? above : below)); this.st = { position: 'fixed', zIndex: 80, left: r.left + 'px', minWidth: r.width + 'px', maxHeight: mh + 'px', width: 'max-content', maxWidth: (window.innerWidth - r.left - 8) + 'px', top: up ? 'auto' : (r.bottom + 2) + 'px', bottom: up ? (h - r.top + 2) + 'px' : 'auto' } },
        norm(t) { return (t || '').toString().normalize('NFD').replace(/[̀-ͯ]/g, '').toLowerCase() },
        get label() { const o = this.options.find(o => o.id == this.value); return o ? o.label : '' },
        get filtered() {
            const t = this.typed ? this.norm(this.q).split(/\s+/).filter(Boolean) : [];
            return this.options.filter(o => { const n = this.norm(o.label); return t.every(w => n.includes(w)) }).slice(0, 300)
        },
        abrir(el) { this.calc(); this.open = true; this.typed = false; this.q = this.label; this.hi = 0; this.$nextTick(() => el.select()) },
        escribir(v) { this.calc(); this.q = v; this.typed = true; this.open = true; this.hi = 0 },
        elegir(o) { this.value = o ? o.id : ''; this.open = false; this.typed = false; if (this.enviar) this.$nextTick(() => this.$root.closest('form').submit()) },
        cerrar() { this.open = false; this.typed = false },
        mover(d) { const n = this.filtered.length; if (!n) return; this.hi = (this.hi + d + n) % n; this.$nextTick(() => { const e = this.$refs.lista.querySelector('[data-hi]'); if (e) e.scrollIntoView({ block: 'nearest' }) }) },
    }"
    @click.outside="cerrar()">
    @if(!$wm && $name)<input type="hidden" name="{{ $name }}" :value="value">@endif
    <input type="text" x-ref="inp" autocomplete="off" {{ $disabled ? 'disabled' : '' }}
        :value="open ? q : label" :placeholder="'{{ $placeholder }}'"
        @focus="abrir($event.target)" @input="escribir($event.target.value)"
        @keydown.arrow-down.prevent="mover(1)" @keydown.arrow-up.prevent="mover(-1)"
        @keydown.enter.prevent="open && filtered[hi] && elegir(filtered[hi])"
        @keydown.escape="cerrar()" @keydown.tab="cerrar()"
        {{ $attributes->whereDoesntStartWith('wire:')->except('class')->merge(['class' => config('ui.input')]) }}>
    <div x-show="open" x-ref="lista" x-cloak :style="st" @scroll.window="open && calc()" @resize.window="open && calc()"
        style="white-space:nowrap;overflow:auto;background:#fff;border:1px solid #d1d5db;border-radius:6px;box-shadow:0 4px 12px rgba(0,0,0,.15);font-size:13px">
        <div @mousedown.prevent="elegir(null)" style="padding:4px 8px;color:#9ca3af;cursor:pointer">{{ $placeholder }}</div>
        <template x-for="(o, i) in filtered" :key="o.id">
            <div @mousedown.prevent="elegir(o)" @mouseenter="hi = i" :data-hi="i === hi ? '' : null"
                :style="'padding:4px 8px;cursor:pointer;color:#374151;' + (i === hi ? 'background:#dbeafe' : '') + (o.id == value ? ';font-weight:600' : '')"
                x-text="o.label"></div>
        </template>
        <div x-show="!filtered.length" style="padding:4px 8px;color:#9ca3af">Sin resultados</div>
    </div>
</div>
