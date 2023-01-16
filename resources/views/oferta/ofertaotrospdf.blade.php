<!doctype html>
    <html lang="es">

    <head>
        <meta charset="UTF-8">
        <title>Nº Oferta: {{ $oferta->id }}</title>
        <link rel="stylesheet" href="{{ asset('css/app.css')}}">


        {{-- sobreescribo margenes de app.css --}}
        <style>
            @page {margin: 0px 0px 0px 0px;}
            .page-break {page-break-after: always;}
        </style>

    </head>
    <body>
        <!-- Define header and footer blocks before your content -->
        <header >
            <table width="80%" style="margin-top:0px; " class="mx-auto">
                <tr>
                    <td class="text-center">
                        <img src="{{asset('img/encajabioreducimosok.png')}}" class="mt-2 text-center" width="600px">
                    </td>
                </tr>
            </table>
            <hr style="border-top: 3px solid rgb(112, 173, 71);">
        </header>
        <footer style="position:fixed;left:0px;bottom:0px;height:320px;width:100%">
            <table width="80%" style="" class="mx-auto">
                <tr>
                    <td width=45%>
                        <div class="h-24 p-3 border border-blue-900">
                            SELLO Y FIRMA
                        </div>
                    <td width=55% class="test-right">
                        <div class="text-right">
                            <img src="{{asset('img/sellosostenibilidad.png')}}" class="text-right" width="260px">
                        </div>
                    </td>
                </tr>
            </table>
            <div >
                <div style="margin-left: 50px;font-size: 0.5rem;">
                    <p>Oferta válida durante 30 días.</p>
                    <p>El precio no incluye retoques de archivos.</p>
                    <p>Milimetrica Producciones tiene la potestad de destruir archivos o troquel sin previo aviso, pasados 2 años desde su última fabricación </p>
                    <p>La cantidad suministrada se ajustará al pedido, admitiéndose las siguientes variaciones en +/-25% (pedidos menores de 500 uds.), 20% (pedidos entre 501 y 1.000 uds.), 10% (pedidos entre 1.001 y 15.000 uds.) y 5% (pedidos mayores de 15.000 uds)</p>
                </div>
                <div class="text-center">
                    <img src="{{asset('img/piehierba.png')}}" class="mt-2" width="800px">
                </div>
            </div>
        </footer>

    <!-- Wrap the content of your PDF inside a main tag -->
        <main style=" margin-right: 10px; margin-top:10px">
            <div class="">
                <div class="py-0 space-y-2">
                     <table width=80% class="mx-auto mt-1 text-sm " style="color:rgb(30, 27, 27);">
                        <tr>
                            <td width=70% class="font-bold">Cliente: {{ $oferta->cliente->entidad }}</td>
                            <td width=30% class="font-bold text-right">Presupuesto nº: {{ $oferta->id}}</td>
                        </tr>
                        <tr>
                            <td width=70% class="font-bold">Att: {{ $oferta->contacto->entidad }}</td>
                            <td width=30% class="font-bold text-right">Fecha: {{ $oferta->ffecha}}</td>
                        </tr>
                        <tr>
                            <td colspan="2" style="padding-top:8px">Con la presente y en base a su solicitud, le presento nuestra mejor oferta de:</td>
                        </tr>
                        <tr>
                            <td colspan="2" style="padding-top:8px" class="font-bold">REF: {{ $oferta->descripcion }}</td>
                        </tr>
                    </table>

                    <table width=80% class="mx-auto mt-4 text-sm " style="color:rgb(30, 27, 27);">
                        <tr>
                            <td width=20% class="font-bold" style=""  >Material:</td>
                            <td width=80% >{{ $oferta->material}}</td>
                        </tr>
                        <tr>
                            <td width=20% class="font-bold "  style="padding-top:1px">Medidas:</td>
                            <td width=80% >{{ $oferta->medidas}}</td>
                        </tr>
                        <tr>
                            <td width=20% class="font-bold "  style="padding-top:1px">Impresión:</td>
                            <td width=80% >{{ $oferta->impresion}}</td>
                        </tr>
                        {{-- <tr>
                            <td width=20% class="font-bold "  style="padding-top:1px">Acabados:</td>
                            <td width=80% >{{ $oferta->acabado}}</td>
                        </tr> --}}
                        <tr>
                            <td width=20% class="font-bold "  style="padding-top:1px">Embalaje:</td>
                            <td width=80% >{{ $oferta->embalaje }}</td>
                        </tr>
                        <tr>
                            <td width=20% class="font-bold "  style="padding-top:1px">Transporte:</td>
                            <td width=80% >{{ $oferta->transporte }}</td>
                        </tr>
                    </table>

                    @if($oferta->ofertaproductos->count()>0)
                    <div class="py-0 space-y-2">
                        <table width="80%" style="margin-top:30px; " cellspacing="0" cellpadding="0" class="mx-auto text-sm">
                            <tr>
                                <td width=40% class="pl-2 text-xs font-bold " style="border-style: solid;border-width: .6;border-color: gray" colspan="2">Producto</td>
                                <td width=30% class="pl-2 text-xs font-bold text-left " style="border-style: solid;border-width: .6;border-color: gray">Material</td>
                                <td width=10% class="pr-2 text-xs font-bold text-right" style="border-style: solid;border-width: .6;border-color: gray">Cantidad</td>
                                <td width=10% class="pr-2 text-xs font-bold text-right" style="border-style: solid;border-width: .6;border-color: gray">Importe</td>
                                <td width=10% class="pr-2 text-xs font-bold text-right" style="border-style: solid;border-width: .6;border-color: gray">Total</td>
                            </tr>
                            @foreach($oferta->ofertaproductos as $oproducto)
                            <tr>
                                <td width=30% class="pl-2 text-xs" style="border-style: solid;border-width: .6;border-color: gray" colspan="2">{{ $oproducto->producto->referencia}}</td>
                                <td width=20% class="pl-2 text-xs text-left" style="border-style: solid;border-width: .6;border-color: gray">{{ $oproducto->producto->material }}</td>
                                <td width=10% class="pr-2 text-xs text-right" style="border-style: solid;border-width: .6;border-color: gray">{{ $oproducto->tirada}}</td>
                                <td width=10% class="pr-2 text-xs text-right" style="border-style: solid;border-width: .6;border-color: gray">{{ $oproducto->precio_ud }}</td>
                                <td width=10% class="pr-2 text-xs text-right" style="border-style: solid;border-width: .6;border-color: gray">{{ round($oproducto->precio_ud * $oproducto->precio_ud ,2)}}</td>
                            </tr>
                            @endforeach
                        </table>
                    </div>
                    @endif

                    @if($oferta->ofertaprocesos->count()>0)
                    <div class="py-0 space-y-2 text-xs">
                        <table width="80%" style="margin-top:30px; " cellspacing="0" cellpadding="0" class="mx-auto text-sm">
                            <tr>
                                <td width=20% class="pl-2 text-xs font-bold " style="border-style: solid;border-width: .6;border-color: gray" colspan="2">Proceso</td>
                                <td width=30% class="pl-2 text-xs font-bold text-left " style="border-style: solid;border-width: .6;border-color: gray">Descripcion</td>
                                <td width=10% class="pr-2 text-xs font-bold text-right" style="border-style: solid;border-width: .6;border-color: gray">Cantidad</td>
                                <td width=10% class="pr-2 text-xs font-bold text-right" style="border-style: solid;border-width: .6;border-color: gray">Importe</td>
                                <td width=10% class="pr-2 text-xs font-bold text-right" style="border-style: solid;border-width: .6;border-color: gray">Total</td>
                            </tr>
                            @foreach($oferta->ofertaprocesos as $oproceso)
                            <tr>
                                <td width=20% class="pl-2 text-xs" style="border-style: solid;border-width: .6;border-color: gray" colspan="2">{{ $oproceso->proceso}}</td>
                                <td width=30% class="pl-2 text-xs text-left" style="border-style: solid;border-width: .6;border-color: gray">{{ $oproceso->descripcion }}</td>
                                <td width=10% class="pr-2 text-xs text-right" style="border-style: solid;border-width: .6;border-color: gray">{{ $oproceso->tirada}}</td>
                                <td width=10% class="pr-2 text-xs text-right" style="border-style: solid;border-width: .6;border-color: gray">{{ $oproceso->precio_ud}}</td>
                                <td width=10% class="pr-2 text-xs text-right" style="border-style: solid;border-width: .6;border-color: gray">{{ round($oproceso->precio_ud * $oproceso->tirada,2) }}</td>
                            </tr>
                            @endforeach
                        </table>
                    </div>
                    @endif

                    {{-- resto --}}
                    <div class="py-0 space-y-2 text-xs">
                        <table width="80%" style="margin-top:10px; " class="mx-auto" cellspacing="0" cellpadding="2" >
                            <tr>
                                <td style="padding-left:3px;"  class="" ><span class="font-bold">Transporte: </span>{{ $oferta->transporte}} </td>
                            </tr>
                            <tr>
                                <td style="padding-left:3px;"  class="" > <span class="font-bold">Troquel: </span>{{ $oferta->troquel}}</td>
                            </tr>
                            <tr>
                                <td> <span class="font-bold">Observaciones: </span>{{ $oferta->observaciones}}</td>
                            </tr>
                        </table>
                    </div>

                    {{-- <table width=80% class="mx-auto mt-4 text-sm " style="color:rgb(30, 27, 27);">
                        <tr>
                            <td>Troquel</td>
                            <td>{{ $oferta->troquel }}</td>
                        </tr>
                        <tr>
                            <td colspan="2" class="font-bold" style=""  >Observaciones:</td>
                        </tr>
                        <tr>
                            <td colspan ="2" width=80% >{{ $oferta->observaciones}}</td>
                        </tr>
                    </table> --}}
                </div>
            </div>
        </main>
    </body>
</html>
