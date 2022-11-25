<!doctype html>
    <html lang="es">

    <head>
        <meta charset="UTF-8">
        <title>Nº Oferta: {{ $oferta->id }}</title>
        <link rel="stylesheet" href="{{ asset('css/app.css')}}">


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
                        <p>Nº Oferta: {{ $oferta->id }}</p>
                        <p>Fecha: {{ $oferta->fecha }}</p>
                    </td>
                </tr>
            </table>
            <br>
            <hr style="border-top: 3px solid rgb(49, 72, 172);">
        </header>
        <footer style="position:fixed;left:0px;bottom:0px;height:270px;width:100%">
            <table width="90%" style="" class="mx-auto">
                <tr>
                    <td width=50%></td>
                    <td width=50% style="border: solid; border-width:0.6px">SELLO Y FIRMA <br> <br> <br> <br></td>
                </tr>
            </table>
            <div >
                <div style="margin-left: 50px;font-size: 0.5rem;">
                    <p>Oferta válida durante 30 días.</p>
                    <p>El precio no incluye retoques de archivos.</p>
                    <p>Milimetrica Producciones tiene la potestad de destruir archivos o troquel sin previo aviso, pasados 2 años desde su última fabricación </p>
                    <p>La cantidad suministrada se ajustará al pedido, admitiéndose las siguientes variaciones en +/-25% (pedidos menores de 500 uds.), 20% (pedidos entre 501 y 1.000 uds.), 10% (pedidos entre 1.001 y 15.000 uds.) y 5% (pedidos mayores de 15.000 uds)</p>
                </div>
                <div class="text-center  mt-10 mb-5 " style="font-size: 0.7rem">
                     C/ Zamora 46-48,  Ático 5ª • 08005 Barcelona • 93 624 38 33
                </div>
                <hr style="border-top: 3px solid rgb(49, 72, 172);">

                <hr class="mt-2" style="border-bottom: 40px solid rgb(49, 72, 172);">
            </div>
        </footer>

    <!-- Wrap the content of your PDF inside a main tag -->
        <main style=" margin-right: 10px; margin-top:20px">
            <div class="">
                <div class="py-0 space-y-2">
                     <table width=90% class="mt-20 mx-auto text-sm " style="color:rgb(30, 27, 27);">
                        <tr><td colspan="2">Cliente: {{ $oferta->cliente->entidad }}</td></tr>
                        <tr><td colspan="2">Att: {{ $oferta->contacto->entidad }}</td></tr>
                        <tr><td colspan="2">Con la presente y en base a su solicitud, le presento nuestra mejor oferta de:</td></tr>
                        <tr><td colspan="2">REF: {{ $oferta->referencia }}</td></tr>
                        <tr>
                            <td class="font-bold " >Formato:</td>
                            <td class="" >{{ $oferta->formato }}:</td>
                        </tr>
                        <tr>
                            <td class="font-bold " >Extensión:</td>
                            <td class="" >{{ $oferta->extension }}:</td>
                        </tr>
                        <tr>
                            <td class="font-bold " >Interior:</td>
                            <td class="" >
                                Composición: {{ $oferta->interiorcomposicion }}:
                                Impresión: {{ $oferta->interiorimpresion }}:
                            </td>
                        </tr>
                        <tr>
                            <td class="font-bold " >Cubierta:</td>
                            <td class="" >
                                Composición: {{ $oferta->cubiertacomposicion }}:
                                Impresión: {{ $oferta->cubiertaimpresion }}:
                            </td>
                        </tr>
                        <tr>
                            <td class="font-bold " >Guardas:</td>
                            <td class="" >
                                Composición: {{ $oferta->guardascomposicion }}:
                                Impresión: {{ $oferta->guardasimpresion }}:
                            </td>
                        </tr>
                        <tr>
                            <td class="font-bold " >Acabado:</td>
                            <td class="" >{{ $oferta->acabado }}:</td>
                        </tr>
                        <tr>
                            <td class="font-bold " >Manipulación:</td>
                            <td class="" >{{ $oferta->manipulacion }}:</td>
                        </tr>
                        <tr>
                            <td class="font-bold " >Entrega:</td>
                            <td class="" >{{ $oferta->entrega }}:</td>
                        </tr>
                    </table>

                    <div class="py-0 space-y-2">
                        <table width="90%" style="margin-top:10px; " cellspacing="0" cellpadding="0" class="mx-auto text-sm">
                            @foreach($oferta->ofertadetalles as $odetalle)
                            <tr>
                                <td class="font-bold">{{ $odetalle->titulo }}: {{ $odetalle->concepto }}</td>
                            </tr>
                            <tr>
                                <td class="font-bold text-left">Cantidad</td>
                                <td class="font-bold text-center">Precio unitario</td>
                                <td class="font-bold text-right">Precio total</td>
                            </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </body>
</html>
