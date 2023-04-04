<!doctype html>
    <html lang="es">

    <head>
        <meta charset="UTF-8">
        <title>Factura {{ $factura->id }}</title>
        <link rel="stylesheet" href="{{ asset('css/app.css')}}">


{{--

    falta poner manual:
        solicitado por
        nuestro presuesto
    --}}

        {{-- sobreescribo margenes de app.css --}}
        <style>
            @page {margin: 20px 0px 0px 0px;}
            .page-break {page-break-after: always;}
        </style>

    </head>
    <body>
        <!-- Define header and footer blocks before your content -->
        <header >
            <table width="90%" style="margin-top:0px; " class="mx-auto">
                <tr>
                    <td style="text-align: left"  width=50%>
                        <img src="{{asset('img/milimetricatexto.png')}}" class="mt-10" width="250px">
                    </td>
                    <td style="text-align: right;" width=50%>
                        <img src="{{asset('img/imageneseco.png')}}" width="250px">
                    </td>
                </tr>
            </table>
            <br>
            <hr style="border-top: 3px solid rgb(49, 72, 172);">
        </header>
        <footer style="position:fixed;left:0px;bottom:0px;height:130px;width:100%">
            <div>
                <div class="mt-10 mb-5 text-center " style="font-size: 0.7rem">
                    Milimétrica Producciones, S.L. • NIF: B-63941835 • C/ Zamora 46-48,  Ático 5ª • 08005 Barcelona • 93 624 38 33
                </div>
                <hr style="border-top: 3px solid rgb(49, 72, 172);">

                <hr class="mt-2" style="border-bottom: 40px solid rgb(49, 72, 172);">
            </div>
        </footer>

    <!-- Wrap the content of your PDF inside a main tag -->
        <main style=" margin-right: 10px; margin-top:20px">
            <div class="">
                <div class="py-0 space-y-2 text-sm">
                    <table width="90%" style="margin-top:10px; " cellspacing="0" cellpadding="0" class="mx-auto ">
                        <tr>
                            <td width=50%>
                                <p>{{ $factura->cliente->entidad }}</p>
                                <p>{{ $factura->cliente->direccion}}</p>
                                <p>{{ $factura->cliente->cp}} {{ $factura->cliente->localidad}} </p>
                                <p>{{ $factura->cliente->nif}} </p>
                            </td>
                            <td width=50%>
                                <p>Fra Num: {{ $factura->id }}</p>
                                <p>Fecha: {{ $factura->ffactura4 }}</p>
                                <p>Su pedido:  {{ $factura->pedidocliente }} </p>
                                <p>Solicitado por: {{ $factura->contacto->entidad ?? ''}}</p>
                            </td>
                        </tr>
                    </table>

                    <table width=90% class="mx-auto mt-20 text-sm " style="color:rgb(30, 27, 27);">
                        <tr>
                            <td class="font-bold " >Oferta</td>
                            <td class="font-bold " >Concepto</td>
                            <td class="font-bold text-right" >Cantidad</td>
                            <td class="font-bold text-right" >Importe</td>
                            <td class="font-bold text-right" >Subtotal</td>
                            <td class="font-bold text-right" >%Iva</td>
                            <td class="font-bold text-right" >Iva</td>
                            <td class="font-bold text-right" >Total</td>
                        </tr>
                        @foreach ($factura->facturadetalles as $detalle)
                        <tr>
                            <td>{{ $detalle->pedido->oferta_id ?? '' }} </td>
                            <td>{{ $detalle->concepto }}</td>
                            <td class="text-right">{{ number_format($detalle->cantidad,0,',','.') }}</td>
                            <td class="text-right">{{ number_format($detalle->importe,2,',','.') }}</td>
                            <td class="text-right">{{ number_format($detalle->subtotalsiniva,2,',','.') }}</td>
                            <td class="text-right">{{ number_format($detalle->iva*100,0) }} %</td>
                            <td class="text-right">{{ number_format($detalle->subtotaliva,2,',','.') }}</td>
                            <td class="text-right">{{ number_format($detalle->subtotal,2,',','.') }}</td>
                        </tr>
                        @if($loop->index>1 && $loop->index%20==0)
                            <tr class="page-break"></tr>
                            <tr>
                                <td class="font-bold " >Oferta</td>
                                <td class="font-bold " >Concepto</td>
                                <td class="font-bold text-right " >Cantidad</td>
                                <td class="font-bold text-right" >Importe</td>
                                <td class="font-bold text-right" >Subtotal</td>
                                <td class="font-bold text-right" >%Iva</td>
                                <td class="font-bold text-right" >Iva</td>
                                <td class="font-bold text-right" >Total</td>
                            </tr>
                        @endif
                        @endforeach
                    </table>
                    <div style="position:fixed;left:0px;bottom:0px;height:250px;width:100%">
                        <table width="90%" style="margin-top:10px; " cellspacing="0" cellpadding="0" class="mx-auto text-sm">
                            <tr class="border-b-2" >
                                <td class="font-bold text-right">IMPORTE</td>
                                <td class="font-bold text-right">%IVA</td>
                                <td class="font-bold text-right">IMPORTE IVA</td>
                                <td class="font-bold text-right">TOTAL FACTURA</td>
                            </tr>
                            @foreach ($totales as $total)
                            <tr >
                                <td class="text-right">{{ number_format($total->subtotalsiniva,2,',','.') }}</td>
                                <td class="text-right">% {{ number_format($total->iva*100,0)  }} </td>
                                <td class="text-right">{{ number_format($total->subtotaliva,2,',','.') }}</td>
                                <td class="text-right">{{ number_format($total->subtotal,2,',','.') }}</td>
                            </tr>
                            @endforeach
                            @if($totales->count()>1)
                            <tr>
                                <td class="font-bold text-right">{{ number_format($factura->importe,2,',','.') }}</td>
                                <td></td >
                                <td class="font-bold text-right">{{ number_format($factura->iva,2,',','.') }}</td>
                                <td class="font-bold text-right">{{ number_format($factura->total,2,',','.') }}</td>
                            </tr>
                            @endif
                        </table>

                        <table width="100%" style="margin-top:10px; " cellspacing="0" cellpadding="0" class="mx-auto text-sm">
                            <tr>
                                <td width="30%" class="text-xs italic text-right"  >Vto: {{ $factura->ffacturavto }}</td>
                                <td width="10%" class="text-xs italic text-right"  ></td>
                                @if($factura->cliente->iban2!='')
                                <td width="60%" class="text-xs italic text-left"  >TRANSFERENCIA A: IBAN {{ $factura->cliente->iban2 }}</td>
                                @else
                                <td width="60%" class="text-xs italic text-left"  >TRANSFERENCIA A: IBAN ES11 2013 3221  3102 1024 3770</td>
                                @endif
                            </tr>
                        </table>
                    </div>

                    {{-- <table width=90% class="mx-auto mt-20 text-sm " style="color:rgb(30, 27, 27);">
                        <tr>
                            <td class="" >Nuestro presupuesto: ¿cómo ponemos el dato, sobre todo si hay más de un pedido?</td>
                        </tr>
                    </table> --}}
                </div>
            </div>
        </main>
    </body>
</html>
