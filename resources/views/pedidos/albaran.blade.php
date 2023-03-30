<div class="">
    <div class="py-0 space-y-2">
        <table width="90%" style="margin-top:10px; " cellspacing="0" cellpadding="2" class="mx-auto ">
            <tr>
                <td class="">ALBARÁN NÚM.: {{ $parcial->id }}</td>
                <td class="text-right"> Fecha: {{ date("d/m/Y", strtotime($parcial->fecha)) }}</td>
            </tr>
        </table>
        <div class="border m-5 p-5 text-sm ">
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
            <table width=100% class="mt-20">
                <tr class="border-b-2">
                    <td width=52% class="font-bold " >Concepto</td>
                    <td  width=16% class="font-bold text-right" >Cantidad</td>
                    <td  width=16% class="font-bold text-right" >€/Ud</td>
                    <td  width=16% class="font-bold text-right" >Total</td>
                </tr>
                @foreach ($detalles as $detalle)
                <tr>
                    <td>{{ $detalle->concepto }}</td>
                    <td class="text-right">{{ $detalle->cantidad }}</td>
                    <td class="text-right"> {{ number_format(round($detalle->precio_ud,2),2) }}</td>
                    <td class="text-right">{{ number_format(round($detalle->total,2),2) }}</td>
                </tr>
                @endforeach
                <tr class="border-t-2">
                    <td> </td>
                    <td class="text-right"></td>
                    <td class="text-right font-bold italic"> Total</td>
                    <td class="text-right font-bold italic">{{ number_format(round($detalle->sum('total'),2),2) }}</td>

                </tr>
            </table>
            <div class="mt-24">
                <div class="ml-2 w-24 font-bold">Enviar a: {{ $parcial->destino }} </div>
                <div class="ml-2">Att.: {{ $parcial->atencion }}</div>
                <div class="ml-2">Dirección: {{ $parcial->direccion }}</div>
                <div class="ml-2">Localidad: {{ $parcial->localidad }} ({{ $parcial->cp }}) </div>
                <div class="ml-2">Horario: {{ $parcial->horario }}</div>
                <div class="ml-2">Tfno.: {{ $parcial->tfno }}</div>
                <div class="ml-2">Observaciones:<textarea rows="1" class="border-0 text-sm mt-0">{{ $parcial->observaciones }}</textarea></div>
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
