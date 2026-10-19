
@if(!Auth::user()->hasRole('Cliente'))
    <form method="GET" action="{{ route('pedido.tipo',[$tipo,'i']) }}">
@else
    <form method="GET" action="{{ route('cliente.pedido.tipo',[$tipo,'i']) }}">
@endif
{{-- <form method="GET" action="{{ route('seguridad') }}"> --}}
    <div class="flex justify-between space-x-2 ">
        {{-- Pedido --}}
        <div class="flex w-1/12 ">
            <div class="w-full">
                <label class="px-1 text-sm text-gray-600">
                    Pedido
                </label>
                <div class="flex">
                    <input type="search" name="search" value="{{ old('search',$search) }}" class="w-full py-1 text-sm border border-blue-100 rounded-lg" onchange="this.form.submit()" autofocus/>
                </div>
            </div>
        </div>
        {{-- Nº de albarán: lleva al pedido que lo contiene --}}
        <div class="flex w-1/12 " style="min-width:9rem">
            <div class="w-full">
                <label class="px-1 text-sm text-gray-600" title="Busca el pedido que contiene este albarán">
                    Albarán
                </label>
                <div class="flex" style="position:relative"
                    x-data="{ q: @js($filtroalbaran ?? ''), open: false, hi: 0, st: {},
                        calc() { const r = this.$refs.inp.getBoundingClientRect(); const h = window.innerHeight; const below = h - r.bottom - 8, above = r.top - 8; const up = below < 200 && above > below; const mh = Math.max(120, Math.min(260, up ? above : below)); this.st = { position: 'fixed', zIndex: 80, left: r.left + 'px', minWidth: 'max(' + r.width + 'px, 34rem)', maxHeight: mh + 'px', width: 'max-content', maxWidth: (window.innerWidth - r.left - 8) + 'px', top: up ? 'auto' : (r.bottom + 2) + 'px', bottom: up ? (h - r.top + 2) + 'px' : 'auto' } }, options: @js($albaranes ?? []),
                        norm(t){ return (t||'').toString().normalize('NFD').replace(/[\u0300-\u036f]/g,'').toLowerCase() },
                        get filtered(){ const t=this.norm(this.q).split(/\s+/).filter(Boolean); return this.options.filter(o=>{const n=this.norm(o.label); return t.every(w=>n.includes(w))}).slice(0,100) },
                        ir(v){ this.q=v; this.open=false; this.$nextTick(()=>{ this.$refs.val.value=v; this.$refs.val.form.submit() }) } }"
                    @click.outside="open=false">
                    <input type="hidden" name="filtroalbaran" x-ref="val" value="{{ old('filtroalbaran',$filtroalbaran ?? '') }}"/>
                    <input type="text" x-ref="inp" autocomplete="off" placeholder="Escribe..." x-model="q"
                        @focus="calc(); open=true; $el.select()" @input="calc(); open=true; hi=0"
                        @keydown.arrow-down.prevent="hi=Math.min(hi+1,filtered.length-1)" @keydown.arrow-up.prevent="hi=Math.max(hi-1,0)"
                        @keydown.enter.prevent="ir(open && filtered[hi] ? filtered[hi].id : q.trim())"
                        @keydown.escape="open=false"
                        class="w-full py-1 text-sm border border-blue-100 rounded-lg"/>
                    <div x-show="open" x-cloak :style="st" @scroll.window="open && calc()" @resize.window="open && calc()" style="min-width:34rem;white-space:nowrap;overflow:auto;background:#fff;border:1px solid #d1d5db;border-radius:6px;box-shadow:0 4px 12px rgba(0,0,0,.15);font-size:13px">
                        <div @mousedown.prevent="ir('')" style="padding:4px 8px;color:#9ca3af;cursor:pointer">-- Todos --</div>
                        <template x-for="(o,i) in filtered" :key="o.id">
                            <div @mousedown.prevent="ir(o.id)" @mouseenter="hi=i" :style="'padding:4px 8px;cursor:pointer;color:#374151;'+(i===hi?'background:#dbeafe':'')" x-text="o.label"></div>
                        </template>
                        <div x-show="!filtered.length" style="padding:4px 8px;color:#9ca3af">Sin resultados</div>
                    </div>
                </div>
            </div>
        </div>
        {{-- Referencia --}}
        <div class="flex w-2/12 ">
            <div class="w-full">
                <label class="px-1 text-sm text-gray-600">
                    @if($tipo==1)
                        Título
                    @else
                        Descripción
                    @endif
                </label>
                <div class="flex">
                    <input type="search" name="filtroreferencia"  value="{{ old('filtroreferencia',$filtroreferencia) }}" class="w-full py-1 text-sm border border-blue-100 rounded-lg" onchange="this.form.submit()"/>
                </div>
            </div>
        </div>
        {{-- ISBN --}}
        @if($tipo==1)
        <div class="flex w-1/12 ">
            <div class="w-full">
                <label class="px-1 text-sm text-gray-600">
                    ISBN
                </label>
                <div class="flex">
                    <input type="search" name="filtroisbn" value="{{ old('filtroisbn',$filtroisbn) }}" class="w-full py-1 text-sm border border-blue-100 rounded-lg" onchange="this.form.submit()"/>
                </div>
            </div>
        </div>
        @endif
        <div class="flex w-1/12 ">
            <div class="w-full">
                <label class="px-1 text-sm text-gray-600">
                    Rpble.
                </label>
                <div class="flex">
                    <select name="filtroresponsable" class="w-full py-1 text-sm text-gray-600 bg-white border-blue-300 rounded-md shadow-sm appearance-none hover:border-gray-400 focus:outline-none" onchange="this.form.submit()">
                        <option value="0">Todos</option>
                        @foreach ($responsables as $responsable)
                        <option value="{{ $responsable->responsable }}" {{ $responsable->responsable == $filtroresponsable ? 'selected' : ''  }}>{{ $responsable->responsable }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="flex w-1/12 ">
            <div class="w-full">
                <label class="px-1 text-sm text-gray-600">
                    Cliente
                </label>
                <div class="flex">
                    <select name="filtrocliente" class="w-full py-1 text-sm text-gray-600 bg-white border-blue-300 rounded-md shadow-sm appearance-none hover:border-gray-400 focus:outline-none" onchange="this.form.submit()">
                        <option value="">-- Todos --</option>
                        @foreach ($clientes as $cliente)
                        <option value="{{ $cliente->id }}" {{ $cliente->id == $filtrocliente ? 'selected' : ''  }}>{{ $cliente->entidad }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="flex w-1/12 ">
            <div class="w-full">
                <label class="px-1 text-sm text-gray-600">
                    Idioma
                </label>
                <div class="flex">
                    <select name="filtroidioma" class="w-full py-1 text-sm text-gray-600 bg-white border-blue-300 rounded-md shadow-sm appearance-none hover:border-gray-400 focus:outline-none" onchange="this.form.submit()">
                        <option value="">-- Todos --</option>
                        @foreach ($idiomas as $idioma)
                        <option value="{{ $idioma->id }}" {{ $idioma->id == $filtroidioma ? 'selected' : '' }}>{{ $idioma->nombre }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        @if(!Auth::user()->hasRole('Cliente'))
        <div class="flex w-1/12 ">
            <div class="w-full">
                <label class="px-1 text-sm text-gray-600">
                    Proveedor
                </label>
                <div class="flex">
                    <select name="filtroproveedor" class="w-full py-1 text-sm text-gray-600 bg-white border-blue-300 rounded-md shadow-sm appearance-none hover:border-gray-400 focus:outline-none" onchange="this.form.submit()">
                        <option value="">-- Todos --</option>
                        @foreach ($proveedores as $proveedor)
                        <option value="{{ $proveedor->id }}" {{ $proveedor->id == $filtroproveedor ? 'selected' : ''  }}>{{ $proveedor->entidad }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        @endif
        <div class="flex w-1/12">
            <div class="w-full">
                <label class="px-1 text-sm text-gray-600">
                    Año
                </label>
                <div class="flex">
                    <input type="search" name="filtroanyo" value="{{ old('filtroanyo',$filtroanyo) }}"
                        class="w-full py-1 text-sm text-gray-600 placeholder-gray-300 bg-white border-blue-300 rounded-md shadow-sm appearance-none hover:border-gray-400 focus:outline-none" onchange="this.form.submit()"
                        placeholder="Año" />
                </div>
            </div>
        </div>
        <div class="flex w-1/12">
            <div class="w-full">
                <label class="px-1 text-sm text-gray-600">
                    Mes
                </label>
                <div class="flex">
                    <select name="filtromes"
                        class="w-full py-1 text-sm text-gray-600 bg-white border-blue-300 rounded-md shadow-sm appearance-none hover:border-gray-400 focus:outline-none" onchange="this.form.submit()">
                        <option value="">-- Todos --</option>
                        @foreach ($meses as $mes )
                        <option value={{ $mes->id}} {{ $mes->id == $filtromes ? 'selected' : ''  }}>{{ $mes->mesmayus }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="flex w-1/12">
            <div class="w-full">
                <label class="px-1 text-sm text-gray-600">
                    Estado
                </label>
                <div class="flex">

                    <select name="filtroestado"
                        class="w-full py-1 text-sm text-gray-600 bg-white border-blue-300 rounded-md shadow-sm appearance-none hover:border-gray-400 focus:outline-none" onchange="this.form.submit()">
                        <option value="">-- selecciona --</option>
                        <option value="0" {{ $filtroestado=='0'? 'selected' : ''  }}>En curso</option>
                        <option value="1" {{ $filtroestado=='1'? 'selected' : ''  }}>Acabado</option>
                        <option value="2" {{ $filtroestado=='2'? 'selected' : ''  }}>Cancelado</option>
                        <option value="3" {{ $filtroestado=='3'? 'selected' : ''  }}>Todos</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="flex w-1/12">
            <div class="w-full">
                <label class="px-1 text-sm text-gray-600">
                    Laminado
                </label>
                {{-- <div class="flex">
                    <select name="filtrolaminadoplastico"
                        class="w-full py-1 text-sm text-gray-600 bg-white border-blue-300 rounded-md shadow-sm appearance-none hover:border-gray-400 focus:outline-none" onchange="this.form.submit()">
                        <option value="">-- selecciona --</option>
                        <option value="" {{ $filtrolaminadoplastico==''? 'selected' : ''  }}>Todos</option>
                        <option value="0" {{ $filtrolaminadoplastico=='0'? 'selected' : ''  }}>No</option>
                        <option value="1" {{ $filtrolaminadoplastico=='1'? 'selected' : ''  }}>Sí</option>
                    </select>
                </div> --}}
                <div class="flex">
                    <select name="filtrolaminado"
                        class="w-full py-1 text-sm text-gray-600 bg-white border-blue-300 rounded-md shadow-sm appearance-none hover:border-gray-400 focus:outline-none" onchange="this.form.submit()">
                        <option value="">Todos</option>
                        @foreach ($laminados as $laminado )
                            <option value="{{ $laminado->id }}" {{ $laminado->id == $filtrolaminado ? 'selected' : ''  }}>{{ $laminado->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        @if(!Auth::user()->hasRole('Cliente'))
        <div class="flex w-1/12">
            <div class="w-full">
                <label class="px-1 text-sm text-gray-600">
                    Facturado
                </label>
                <div class="flex">
                    <select name="filtrofacturado"
                        class="w-full py-1 text-sm text-gray-600 bg-white border-blue-300 rounded-md shadow-sm appearance-none hover:border-gray-400 focus:outline-none" onchange="this.form.submit()">
                        <option value="">-- selecciona --</option>
                        <option value="0" {{ $filtrofacturado=='0'? 'selected' : ''  }}>No</option>
                        <option value="1" {{ $filtrofacturado=='1'? 'selected' : ''  }}>Sí</option>
                        <option value="2" {{ $filtrofacturado=='2'? 'selected' : ''  }}>Parcial</option>
                    </select>
                </div>
            </div>
        </div>
        @endif
        <div class="w-1/12 text-center">
            <x-icon.xls-a href="{{ route('pedido.export',[
                $tipo,
                $search=='' ? '@' : $search ,
                $filtroreferencia=='' ? '@' : $filtroreferencia,
                $filtroisbn=='' ? '@' : $filtroisbn,
                $filtroresponsable=='' ? '@' : $filtroresponsable,
                $filtrocliente=='' ? '@' : $filtrocliente,
                $filtroproveedor=='' ? '@' : $filtroproveedor,
                // $filtrolaminadoplastico=='' ? '@' : $filtrolaminadoplastico,
                $filtrolaminado=='' ? '@' : $filtrolaminado,
                $filtroanyo=='' ? '@' : $filtroanyo,
                $filtromes=='' ? '@' : $filtromes,
                $filtroestado=='' ? '@' : $filtroestado,
                $filtrofacturado=='' ? '@' : $filtrofacturado,
                ]) }}"
                class="mt-3 mr-1 text-green-400 w-7" title="Exportar pedidos"/>
        </div>
    </div>
</form>
