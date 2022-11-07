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
                <tr>
                    <td width=70% class="font-bold " >Concepto</td>
                    <td  width=30% class="font-bold text-right" >Cantidad</td>
                </tr>
                @foreach ($detalles as $detalle)
                <tr>
                    <td>{{ $detalle->concepto }}</td>
                    <td class="text-right">{{ $detalle->cantidad }}</td>
                </tr>
                @endforeach
            </table>
            <div class="mt-24">
                <div class="ml-2 w-24 font-bold">Enviar a: {{ $parcial->destino }} </div>
                <div class="ml-2">Att.: {{ $parcial->atencion }}</div>
                <div class="ml-2">Dirección: {{ $parcial->direccion }}</div>
                <div class="ml-2">Localidad: {{ $parcial->localidad }} ({{ $parcial->cp }}) </div>
                <div class="ml-2">Horario: {{ $parcial->horario }}</div>
                <div class="ml-2">Tfno.: {{ $parcial->tfno }}</div>
                <div class="ml-2">Observaciones: {{ $parcial->observaciones }}</div>
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
