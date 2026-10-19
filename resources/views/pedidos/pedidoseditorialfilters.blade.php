@php $fx = \App\Support\Facetas::desde($__data); @endphp

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
                    <x-buscador name="search" :valor="$search" faceta="numero" contexto="pedidos" :filtros="$fx" :tipo="$tipo ?? null" placeholder=""/>
                </div>
            </div>
        </div>
        {{-- Nº de albarán: lleva al pedido que lo contiene --}}
        <div class="flex w-1/12 " style="min-width:9rem">
            <div class="w-full">
                <label class="px-1 text-sm text-gray-600" title="Busca el pedido que contiene este albarán">
                    Albarán
                </label>
                                <x-buscador name="filtroalbaran" solo="id" :valor="$filtroalbaran ?? ''" :options="$albaranes ?? []" placeholder="Escribe..."/>
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
                    <x-buscador name="filtroreferencia" :valor="$filtroreferencia" faceta="referencia" contexto="pedidos" :filtros="$fx" :tipo="$tipo ?? null" placeholder=""/>
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
                    <x-buscador name="filtroisbn" :valor="$filtroisbn" faceta="isbn" contexto="pedidos" :filtros="$fx" :tipo="$tipo ?? null" placeholder=""/>
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
                    <x-combo faceta="responsable" contexto="pedidos" :tipo="$tipo ?? null" :filtros="$fx" name="filtroresponsable" :valor="$filtroresponsable" placeholder="Todos"/>
                </div>
            </div>
        </div>

        <div class="flex w-1/12 ">
            <div class="w-full">
                <label class="px-1 text-sm text-gray-600">
                    Cliente
                </label>
                <div class="flex">
                    <x-combo faceta="cliente" contexto="pedidos" :tipo="$tipo ?? null" :filtros="$fx" name="filtrocliente" :valor="$filtrocliente" placeholder="-- Todos --"/>
                </div>
            </div>
        </div>
        <div class="flex w-1/12 ">
            <div class="w-full">
                <label class="px-1 text-sm text-gray-600">
                    Idioma
                </label>
                <div class="flex">
                    <x-combo faceta="idioma" contexto="pedidos" :tipo="$tipo ?? null" :filtros="$fx" name="filtroidioma" :valor="$filtroidioma" placeholder="-- Todos --"/>
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
                    <x-combo faceta="proveedor" contexto="pedidos" :tipo="$tipo ?? null" :filtros="$fx" name="filtroproveedor" :valor="$filtroproveedor" placeholder="-- Todos --"/>
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
                    <x-buscador name="filtroanyo" :valor="$filtroanyo" sugerir="anyos" :tipo="$tipo ?? null" placeholder="Año"/>
                </div>
            </div>
        </div>
        <div class="flex w-1/12">
            <div class="w-full">
                <label class="px-1 text-sm text-gray-600">
                    Mes
                </label>
                <div class="flex">
                    <x-combo name="filtromes" :valor="$filtromes" :options="collect($meses)->map(fn($mes)=>['id'=>$mes->id,'label'=>($mes->mesmayus)])->values()->all()" placeholder="-- Todos --"/>
                </div>
            </div>
        </div>
        <div class="flex w-1/12">
            <div class="w-full">
                <label class="px-1 text-sm text-gray-600">
                    Estado
                </label>
                <div class="flex">

                    <x-combo name="filtroestado" :valor="$filtroestado" :options="[['id'=>'0','label'=>'En curso'],['id'=>'1','label'=>'Acabado'],['id'=>'2','label'=>'Cancelado'],['id'=>'3','label'=>'Todos']]" placeholder="-- selecciona --"/>
                </div>
            </div>
        </div>
        <div class="flex w-1/12">
            <div class="w-full">
                <label class="px-1 text-sm text-gray-600">
                    Laminado
                </label>
                {{-- <div class="flex">
                    <x-combo name="filtrolaminadoplastico" :valor="$filtrolaminadoplastico" :options="[['id'=>'0','label'=>'No'],['id'=>'1','label'=>'Sí']]" placeholder="Todos"/>
                </div> --}}
                <div class="flex">
                    <x-combo name="filtrolaminado" :valor="$filtrolaminado" :options="collect($laminados)->map(fn($laminado)=>['id'=>$laminado->id,'label'=>($laminado->name)])->values()->all()" placeholder="Todos"/>
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
                    <x-combo name="filtrofacturado" :valor="$filtrofacturado" :options="[['id'=>'0','label'=>'No'],['id'=>'1','label'=>'Sí'],['id'=>'2','label'=>'Parcial']]" placeholder="-- selecciona --"/>
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
