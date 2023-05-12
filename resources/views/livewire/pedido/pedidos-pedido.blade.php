<div class="flex hover:bg-gray-200 hover:cursor-pointer">
    <div class="flex items-center w-6/12 space-x-2 text-sm text-gray-500 border-t-0 cursor-pointer border-y " wire:loading.class.delay="opacity-50" onclick="location.href = '{{ route('pedido.editar',[$pedido,'i']) }}'">
        <div class="flex-col w-2/12 text-left md:w-1/12">
            <div class="pl-1">
                <div class="text-base font-bold">
                    {{ $pedido->id }}
                </div>
                @if($pedido->presupuesto_id)
                    <div class="">
                        <a class="text-blue-700 underline" href="{{ route('presupuesto.editar',[$pedido->presupuesto_id,'i']) }}"  title="Pedido">{{ $pedido->presupuesto_id }}</a>
                    </div>
                @endif
            </div>
        </div>
        <div class="flex-col w-3/12 pl-2 text-left md:w-2/12">{{ $pedido->cliente->entidad }}</div>
        @if($pedido->tipo=='1')
        {{-- <div class="">{{ $pedido }}</div> --}}
            <div class="flex-col w-6/12 text-left">{{ $pedido->isbn }} - {{ $pedido->ref }}</div>
        @else
            <div class="flex-col w-4/12 text-left md:w-6/12">{{ $pedido->descripcion }}</div>
        @endif
        <div class="flex w-2/12 mx-auto text-center bg-gray-50">
            <div class="w-6/12">{{ $pedido->tiradaprevista }}</div>
            <div class="w-1/12">/</div>
            <div class="w-5/12">{{ $pedido->tiradareal }}</div>
        </div>
    </div>
    <div class="flex items-center w-3/12 space-x-2 text-sm text-gray-500 border-t-0 cursor-pointer border-y " wire:loading.class.delay="opacity-50" >
        <div class="flex-none w-4/12 md:flex md:w-full">
            <div class="w-4/12">
                <div class="flex font-bold">
                    Arch:
                    @if($pedido->ctrarchivos=='1')<x-icon.validate class="w-4"/>@endif
                </div>
                <div class=" {{ $pedido->ctrlarchivoscolor[0] }}" wire:click="cambiaEstadocontrolfecha('ctrarchivos')">
                    {{ $pedido->farchivos }}
                </div>
            </div>
            <div class="w-4/12">
                <div class="flex font-bold">
                    Plot:
                    @if($pedido->ctrplotter=='1')<x-icon.validate class="w-4"/>@endif
                </div>
                <div class="{{ $pedido->ctrlplottercolor[0] }}"  wire:click="cambiaEstadocontrolfecha('ctrplotter')">
                    {{ $pedido->fplotter }}
                </div>
            </div>
            <div class="w-4/12">
                <div class="flex font-bold">
                    Entr:
                    @if($pedido->ctrentrega=='1')<x-icon.validate class="w-4"/>@endif
                </div>
                <div class="{{ $pedido->ctrlentregacolor[0] }}"  wire:click="cambiaEstadocontrolfecha('ctrentrega')">
                    {{ $pedido->fentrega }}
                </div>
            </div>
        </div>
    </div>
    <div class="flex items-center w-3/12 space-x-2 text-sm text-gray-500 border-t-0 cursor-pointer border-y " wire:loading.class.delay="opacity-50" ">
        <div class="flex-none w-3/12 lg:flex ">
            <div class="w-6/12 pl-2" >
                @if($estado=='0')
                    <x-icon.thumbs-up-a class="" title="En curso" wire:click="cambiaEstado()"/>
                @elseif($estado=='2')
                    <x-icon.thumbs-down-a class="w-5 " title="Cancelado" wire:click="cambiaEstado()"/>
                @elseif($estado=='1')
                    <x-icon.flag-checkered-a class="w-5 text-black hover:text-gray-700 " title="Finalizado" wire:click="cambiaEstado()"/>
                @endif
            </div>
            <div class="w-6/12 pl-2">
                @if($pedido->facturado=='1')
                    <x-icon.thumbs-up-a class="w-5 text-green-500 hover:text-green-700 "  title="Sí" wire:click="cambiaFac({{ $pedido->id}})"/>
                @elseif($pedido->facturado=='0')
                    <x-icon.thumbs-down-a class="w-5 text-red-500 hover:text-red-700 " title="No" wire:click="cambiaFac({{ $pedido->id}})"/>
                @elseif($pedido->facturado=='2')
                    <x-icon.p-a class="w-4 text-black hover:text-gray-700 " title="Parcial" wire:click="cambiaFac({{ $pedido->id}})"/>
                @endif
            </div>
        </div>
        <div class="w-9/12 space-x-1 text-center lg:space-x-2">
            <x-icon.truck-a class="w-5 {{ $pedido->parcialescolor[0] }} hover:{{ $pedido->parcialescolor[1] }} " onclick="location.href = '{{route('pedido.parciales',[$pedido->id,'i'])}}'" title="Albaranes"/>
            <x-icon.building-circle-arrow-right-a class="w-5 {{ $pedido->distribucionescolor[0] }} hover:{{ $pedido->distribucionescolor[1] }} " onclick="location.href = '{{route('pedido.distribuciones',[$pedido->id,'i'])}}'" title="Distribuciones"/>
            <x-icon.clip-a class="w-5 {{ $pedido->archivoscolor[0] }} hover:{{ $pedido->archivoscolor[1] }} " onclick="location.href = '{{route('pedido.archivos',[$pedido->id,'i'])}}'" title="Archivo"/>
            <x-icon.triangleexclamation-a class="w-6 mb-1 {{ $pedido->incidenciascolor[0] }} hover:{{ $pedido->incidenciascolor[1] }} " onclick="location.href = '{{route('pedido.incidencias',[$pedido,'i'])}}'" title="Incidencias"/>
            <x-icon.sandwatch-a class="w-4 {{ $pedido->retrasoscolor[0] }} hover:{{ $pedido->retrasoscolor[1] }} " onclick="location.href = '{{route('pedido.retrasos',[$pedido,'i'])}}'" title="Retrasos"/>
            @if($pedido->facturado!='0')
                <x-icon.euro-a class="w-6 {{ $pedido->facturadocolor[0] }} hover:{{ $pedido->facturadocolor[1] }} " wire:click="generarfactura" title="Facturación"/>
            @else
                <x-icon.euro-a class="w-6 {{ $pedido->facturadocolor[0] }} hover:{{ $pedido->facturadocolor[1] }} " title="Facturación"
                    wire:click.prevent="generarfactura" onclick="confirm('¿Quieres generar un factura con este pedido?') || event.stopImmediatePropagation()"/>
            @endif
            <x-icon.pdf-a class="text-red-500 hover:text-red-700" href="{{route('pedido.entrada',[$pedido,$tipo,'i'])}}" target="_blank"/>
            <x-icon.delete-a class="w-7" wire:click.prevent="delete({{ $pedido->id }})" onclick="confirm('¿Estás seguro?') || event.stopImmediatePropagation()" />
        </div>
    </div>
</div>

