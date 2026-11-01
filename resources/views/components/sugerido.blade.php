{{--
    Texto libre con sugerencias: se escribe lo que se quiera y, mientras se escribe, aparece la lista de valores ya usados
    que contienen lo escrito (sin acentos ni mayúsculas, por palabras). Elegir uno lo copia; si no, se guarda lo escrito.
    Uso:  <x-sugerido wire:model.defer="producto.material" :options="\App\Support\Sugerencias::de('campo:material', 2)" />
    $options = lista de textos, o [['id'=>texto,'label'=>texto], ...]. Aspecto único: config/ui.php.
--}}
@props(['options' => [], 'placeholder' => '', 'disabled' => false])
@php
    $opts = collect($options)->map(fn ($o) => is_array($o) ? (string) ($o['label'] ?? $o['id'] ?? '') : (string) $o)
        ->map(fn ($t) => trim($t))->filter()->unique()->values()->all();
@endphp
<div wire:ignore style="position:relative;width:100%"
    x-data="{
        value: @entangle($attributes->wire('model')),
        options: {{ \Illuminate\Support\Js::from($opts) }},
        open: false, hi: -1, st: {},
        calc() { const r = this.$refs.inp.getBoundingClientRect(); const h = window.innerHeight; const below = h - r.bottom - 8, above = r.top - 8; const up = below < 200 && above > below; const mh = Math.max(120, Math.min(260, up ? above : below)); this.st = { position: 'fixed', zIndex: 80, left: r.left + 'px', minWidth: r.width + 'px', maxHeight: mh + 'px', width: 'max-content', maxWidth: (window.innerWidth - r.left - 8) + 'px', top: up ? 'auto' : (r.bottom + 2) + 'px', bottom: up ? (h - r.top + 2) + 'px' : 'auto' } },
        norm(t) { return (t || '').toString().normalize('NFD').replace(/[̀-ͯ]/g, '').toLowerCase() },
        get filtered() {
            const t = this.norm(this.value).split(/\s+/).filter(Boolean);
            return this.options.filter(o => { const n = this.norm(o); return t.every(w => n.includes(w)) && n !== this.norm(this.value) }).slice(0, 200)
        },
        abrir() { if (!this.options.length) return; this.calc(); this.open = true; this.hi = -1 },
        escribir(v) { this.value = v; this.abrir() },
        elegir(o) { this.value = o; this.open = false; this.hi = -1 },
        mover(d) { const n = this.filtered.length; if (!n) return; if (!this.open) this.abrir(); this.hi = (this.hi + d + n) % n; this.$nextTick(() => { const e = this.$refs.lista.querySelector('[data-hi]'); if (e) e.scrollIntoView({ block: 'nearest' }) }) },
    }"
    @click.outside="open = false">
    <input type="text" x-ref="inp" autocomplete="off" {{ $disabled ? 'disabled' : '' }}
        :value="value ?? ''" placeholder="{{ $placeholder }}"
        @focus="abrir()" @input="escribir($event.target.value)"
        @keydown.arrow-down.prevent="mover(1)" @keydown.arrow-up.prevent="mover(-1)"
        @keydown.enter="if (open && hi >= 0 && filtered[hi]) { $event.preventDefault(); elegir(filtered[hi]) }"
        @keydown.escape="open = false" @keydown.tab="open = false"
        {{ $attributes->whereDoesntStartWith('wire:')->except('class')->merge(['class' => config('ui.input')]) }}>
    <div x-show="open && filtered.length" x-ref="lista" x-cloak :style="st" @scroll.window="open && calc()" @resize.window="open && calc()"
        style="white-space:nowrap;overflow:auto;background:#fff;border:1px solid #d1d5db;border-radius:6px;box-shadow:0 4px 12px rgba(0,0,0,.15);font-size:13px">
        <template x-for="(o, i) in filtered" :key="o">
            <div @mousedown.prevent="elegir(o)" @mouseenter="hi = i" :data-hi="i === hi ? '' : null"
                :style="'padding:4px 8px;cursor:pointer;color:#374151;' + (i === hi ? 'background:#dbeafe' : '')"
                x-text="o"></div>
        </template>
    </div>
</div>
