
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
        {{-- Referencia --}}
        <div class="flex w-2/12 ">
            <div class="w-full">
                <label class="px-1 text-sm text-gray-600">
                    Título
                </label>
                <div class="flex">
                    <input type="search" name="filtroreferencia"  value="{{ old('filtroreferencia',$filtroreferencia) }}" class="w-full py-1 text-sm border border-blue-100 rounded-lg" onchange="this.form.submit()"/>
                </div>
            </div>
        </div>
        {{-- ISBN --}}
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
                    Natureflex
                </label>
                <div class="flex">
                    <select name="filtrolaminadoplastico"
                        class="w-full py-1 text-sm text-gray-600 bg-white border-blue-300 rounded-md shadow-sm appearance-none hover:border-gray-400 focus:outline-none" onchange="this.form.submit()">
                        <option value="">-- selecciona --</option>
                        <option value="" {{ $filtrolaminadoplastico==''? 'selected' : ''  }}>Todos</option>
                        <option value="0" {{ $filtrolaminadoplastico=='0'? 'selected' : ''  }}>No</option>
                        <option value="1" {{ $filtrolaminadoplastico=='1'? 'selected' : ''  }}>Sí</option>
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
        <div class="w-1/12 text-center">
            <x-icon.xls-a href="{{ route('pedido.export',[
                $tipo,
                $search=='' ? '@' : $search ,
                $filtroreferencia=='' ? '@' : $filtroreferencia,
                $filtroisbn=='' ? '@' : $filtroisbn,
                $filtroresponsable=='' ? '@' : $filtroresponsable,
                $filtrocliente=='' ? '@' : $filtrocliente,
                $filtroproveedor=='' ? '@' : $filtroproveedor,
                $filtrolaminadoplastico=='' ? '@' : $filtrolaminadoplastico,
                $filtroanyo=='' ? '@' : $filtroanyo,
                $filtromes=='' ? '@' : $filtromes,
                $filtroestado=='' ? '@' : $filtroestado,
                $filtrofacturado=='' ? '@' : $filtrofacturado,
                ]) }}"
                class="mt-3 mr-1 text-green-400 w-7" title="Exportar pedidos"/>
        </div>
        @endif
    </div>
</form>
