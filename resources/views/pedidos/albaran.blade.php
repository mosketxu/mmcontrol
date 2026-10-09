<div class="">
    <div class="py-0 space-y-2">
        <table width="90%" style="margin-top:10px; " cellspacing="0" cellpadding="2" class="mx-auto ">
            <tr>
                <td class="">ALBARÁN NÚM.: {{ $parcial->id }}</td>
                <td class="text-right"> Fecha: {{ date("d/m/Y", strtotime($parcial->fecha)) }}</td>
            </tr>
        </table>
        <div class="p-5 m-5 text-sm border ">
            <table>
                <tr>
                    <td>
                        <p>CLIENTE: {{ $entidad->entidad }}</p>
                        <p>DOMICILIO: {{ $entidad->direccion }}</p>
                        <p>POBLACIÓN: {{ $entidad->localidad }} ({{$entidad->cp  }})</p>
                        <p>TEL./: {{ $entidad->telefono }}</p>
                        <p>PERSONA DE CONTACTO: {{ $pedido->contacto->entidad }}</p>
                    </td>
                </tr>
            </table>
            @php
                $valorado = $valorado ?? true;
                $packaging = $pedido->tipo == 2 && isset($pedidoproductos) && $pedidoproductos->count();
            @endphp
            @if($packaging)
                {{-- Packaging: primero el pedido (lo contratado) y debajo el albarán (esta entrega), cada uno con su subtotal --}}
                <table width=100% class="mt-10">
                    <tr><td colspan="4" class="font-bold">PEDIDO {{ $pedido->id }}</td></tr>
                    <tr class="border-b-2">
                        <td width=52% class="font-bold">Concepto</td>
                        <td width=16% class="font-bold text-right">Cantidad</td>
                        @if($valorado)
                        <td width=16% class="font-bold text-right">€/Ud</td>
                        <td width=16% class="font-bold text-right">Total</td>
                        @endif
                    </tr>
                    @php $subpedido=0; @endphp
                    @foreach ($pedidoproductos as $pp)
                        @php
                            $totpp = (float)$pp->preciototal > 0 ? (float)$pp->preciototal : round($pp->tirada*$pp->precio_ud,2);
                            $subpedido += $totpp;
                        @endphp
                        <tr>
                            <td>{{ optional($pp->producto)->referencia ?: $pedido->descripcion }}</td>
                            <td class="text-right">{{ $pp->tirada }}</td>
                            @if($valorado)
                            <td class="text-right">{{ number_format(round($pp->precio_ud,2),2) }}</td>
                            <td class="text-right">{{ number_format(round($totpp,2),2) }}</td>
                            @endif
                        </tr>
                    @endforeach
                    <tr class="border-t-2">
                        <td class="italic font-bold">Subtotal pedido</td>
                        <td class="italic font-bold text-right">{{ $pedidoproductos->sum('tirada') }}</td>
                        @if($valorado)
                        <td></td>
                        <td class="italic font-bold text-right">{{ number_format(round($subpedido,2),2) }}</td>
                        @endif
                    </tr>
                </table>
                <table width=100% class="mt-10">
                    <tr><td colspan="4" class="font-bold">ALBARÁN {{ $parcial->id }} (esta entrega)</td></tr>
                    <tr class="border-b-2">
                        <td width=52% class="font-bold">Concepto</td>
                        <td width=16% class="font-bold text-right">Cantidad</td>
                        @if($valorado)
                        <td width=16% class="font-bold text-right">€/Ud</td>
                        <td width=16% class="font-bold text-right">Total</td>
                        @endif
                    </tr>
                    @foreach ($detalles as $detalle)
                        <tr>
                            <td>{{ $detalle->concepto }}</td>
                            <td class="text-right">{{ $detalle->cantidad }}</td>
                            @if($valorado)
                            <td class="text-right">{{ number_format(round($detalle->precio_ud,2),2) }}</td>
                            <td class="text-right">{{ number_format(round($detalle->total,2),2) }}</td>
                            @endif
                        </tr>
                    @endforeach
                    <tr class="border-t-2">
                        <td class="italic font-bold">Subtotal albarán</td>
                        <td class="italic font-bold text-right">{{ $detalles->sum('cantidad') }}</td>
                        @if($valorado)
                        <td></td>
                        <td class="italic font-bold text-right">{{ number_format(round($detalles->sum('total'),2),2) }}</td>
                        @endif
                    </tr>
                </table>
            @else
            <table width=100% class="mt-20">
                <tr class="border-b-2">
                    <td width=52% class="font-bold " >Concepto</td>
                    <td  width=16% class="font-bold text-right" >Cantidad</td>
                    @if($valorado)
                    <td  width=16% class="font-bold text-right" >€/Ud</td>
                    <td  width=16% class="font-bold text-right" >Total</td>
                    @endif
                </tr>
                @foreach ($detalles as $detalle)
                <tr>
                    <td>{{ $detalle->concepto }}</td>
                    <td class="text-right">{{ $detalle->cantidad }}</td>
                    @if($valorado)
                    <td class="text-right"> {{ number_format(round($detalle->precio_ud,2),2) }}</td>
                    <td class="text-right">{{ number_format(round($detalle->total,2),2) }}</td>
                    @endif
                </tr>
                @endforeach
                @if($valorado)
                <tr class="border-t-2">
                    <td> </td>
                    <td class="text-right"></td>
                    <td class="italic font-bold text-right"> Total</td>
                    <td class="italic font-bold text-right">{{ number_format(round($detalles->sum('total'),2),2) }}</td>
                </tr>
                @endif
            </table>
            @endif
            <div class="{{ $packaging ? 'mt-10' : 'mt-24' }}">
                <div class="w-24 ml-2 font-bold">Enviar a: {{ $parcial->destino }} </div>
                <div class="ml-2">Att.: {{ $parcial->atencion }}</div>
                <div class="ml-2">Dirección: {{ $parcial->direccion }}</div>
                <div class="ml-2">Localidad: {{ $parcial->localidad }} ({{ $parcial->cp }}) </div>
                <div class="ml-2">Horario: {{ $parcial->horario }}</div>
                <div class="ml-2">Tfno.: {{ $parcial->tfno }}</div>
                <div class="ml-2">Observaciones:<textarea rows="1" class="mt-0 text-sm border-0">{{ $parcial->observaciones }}</textarea></div>
            </div>
        </div>
        </div>


        <table width="90%" style="margin-top:10px; " cellspacing="0" cellpadding="2" class="mx-auto ">
            <tr>
                <td class=""></td>
                <td class="text-right"> HE RECIBIDO CONFORME  (fecha y Firma)</td>
            </tr>
        </table>
    </div>
</div>
