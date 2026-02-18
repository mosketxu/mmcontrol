
@if(!Auth::user()->hasRole('Cliente'))
    <form method="GET" action="{{ route('pedido.tipo',[$tipo,'i']) }}">
{{-- @else
    <form method="GET" action="{{ route('cliente.pedido.tipo',[$tipo,'i']) }}"> --}}
@endif
{{-- <form method="GET" action="{{ route('seguridad') }}"> --}}
    <div class="flex space-x-2 ">
        {{-- Compra --}}
        <div class="flex w-1/12 ">
            <div class="w-full">
                <label class="px-1 text-sm text-gray-600">
                    Nº
                </label>
                <div class="flex">
                    <input type="search" name="search" value="{{ old('search',$search) }}" class="w-full py-1 text-sm border border-blue-100 rounded-lg" onchange="this.form.submit()" autofocus/>
                </div>
            </div>
        </div>
        <div class="flex w-2/12 ">
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
        </div>
    </div>
</form>
