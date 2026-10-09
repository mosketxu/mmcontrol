{{--
    Combo con búsqueda: se escribe directamente y la lista se filtra mientras se escribe (código y texto a la vez).
    Uso: <x-combo wire:model="cliente_id" :options="$lista" placeholder="-- Selecciona cliente --" />
    $lista = [['id'=>1,'label'=>'Texto que se ve y en el que se busca'], ...]
    Va dentro de wire:ignore: las opciones se fijan al pintar; si cambian (p. ej. contactos al cambiar de cliente) la clave
    wire:key lleva un hash de las opciones y Livewire repinta el combo.
--}}
@props(['options' => [], 'placeholder' => '-- Selecciona --', 'disabled' => false])
@php
    $opts = collect($options)->map(fn ($o) => ['id' => (string) $o['id'], 'label' => (string) $o['label']])->values()->all();
@endphp
<div wire:ignore wire:key="combo-{{ $attributes->wire('model')->value() }}-{{ md5(json_encode($opts)) }}" style="position:relative"
    x-data="{
        value: @entangle($attributes->wire('model')),
        options: {{ \Illuminate\Support\Js::from($opts) }},
        open: false, q: '', typed: false, hi: 0,
        norm(t) { return (t || '').toString().normalize('NFD').replace(/[̀-ͯ]/g, '').toLowerCase() },
        get label() { const o = this.options.find(o => o.id == this.value); return o ? o.label : '' },
        get filtered() {
            const t = this.typed ? this.norm(this.q).split(/\s+/).filter(Boolean) : [];
            return this.options.filter(o => { const n = this.norm(o.label); return t.every(w => n.includes(w)) }).slice(0, 300)
        },
        abrir(el) { this.open = true; this.typed = false; this.q = this.label; this.hi = 0; this.$nextTick(() => el.select()) },
        escribir(v) { this.q = v; this.typed = true; this.open = true; this.hi = 0 },
        elegir(o) { this.value = o ? o.id : ''; this.open = false; this.typed = false },
        cerrar() { this.open = false; this.typed = false },
        mover(d) { const n = this.filtered.length; if (!n) return; this.hi = (this.hi + d + n) % n; this.$nextTick(() => { const e = this.$refs.lista.querySelector('[data-hi]'); if (e) e.scrollIntoView({ block: 'nearest' }) }) },
    }"
    @click.outside="cerrar()">
    <input type="text" autocomplete="off" {{ $disabled ? 'disabled' : '' }}
        :value="open ? q : label" :placeholder="'{{ $placeholder }}'"
        @focus="abrir($event.target)" @input="escribir($event.target.value)"
        @keydown.arrow-down.prevent="mover(1)" @keydown.arrow-up.prevent="mover(-1)"
        @keydown.enter.prevent="open && filtered[hi] && elegir(filtered[hi])"
        @keydown.escape="cerrar()" @keydown.tab="cerrar()"
        {{ $attributes->whereDoesntStartWith('wire:')->merge(['class' => 'w-full py-1 text-sm text-gray-600 bg-white border-gray-300 rounded-md shadow-sm']) }}>
    <div x-show="open" x-ref="lista" x-cloak
        style="position:absolute;left:0;right:0;z-index:60;margin-top:2px;max-height:15rem;overflow:auto;background:#fff;border:1px solid #d1d5db;border-radius:6px;box-shadow:0 4px 12px rgba(0,0,0,.15);font-size:13px">
        <div @mousedown.prevent="elegir(null)" style="padding:4px 8px;color:#9ca3af;cursor:pointer">{{ $placeholder }}</div>
        <template x-for="(o, i) in filtered" :key="o.id">
            <div @mousedown.prevent="elegir(o)" @mouseenter="hi = i" :data-hi="i === hi ? '' : null"
                :style="'padding:4px 8px;cursor:pointer;color:#374151;' + (i === hi ? 'background:#dbeafe' : '') + (o.id == value ? ';font-weight:600' : '')"
                x-text="o.label"></div>
        </template>
        <div x-show="!filtered.length" style="padding:4px 8px;color:#9ca3af">Sin resultados</div>
    </div>
</div>
