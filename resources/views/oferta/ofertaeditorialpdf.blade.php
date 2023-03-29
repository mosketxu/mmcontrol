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
            <table width="90%" style="margin-top:0px; " class="mx-auto">
                <tr>
                    <td style="text-align: left"  width=50%>
                        <img src="{{asset('img/milimetricatexto.png')}}" class="mt-2" width="250px">
                    </td>
                    <td style="text-align: right; padding-right:40px" width=50%>
                        <br>
                        <br>
                        <p>Nº Oferta: {{ $oferta->id }}</p>
                        <p>Fecha: {{ $oferta->ffecha }}</p>
                    </td>
                </tr>
            </table>
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
                <div class="mt-10 mb-5 text-center " style="font-size: 0.7rem">
                     C/ Zamora 46-48,  Ático 5ª • 08005 Barcelona • 93 624 38 33
                </div>
                <hr style="border-top: 3px solid rgb(49, 72, 172);">

                <hr class="mt-2" style="border-bottom: 40px solid rgb(49, 72, 172);">
            </div>
        </footer>

    <!-- Wrap the content of your PDF inside a main tag -->
        <main style=" margin-right: 10px; margin-top:10px">
            <div class="">
                <div class="py-0 space-y-2">
                     <table width=90% class="mx-auto mt-1 text-sm " style="color:rgb(30, 27, 27);">
                        <tr><td colspan="2" class="font-bold">Cliente: {{ $oferta->cliente->entidad }}</td></tr>
                        <tr><td colspan="2" class="font-bold"><br>Att: {{ $oferta->contacto->entidad }}</td></tr>
                        <tr><td colspan="2"><br>Con la presente y en base a su solicitud, le presento nuestra mejor oferta de:</td></tr>
                        <tr><td colspan="2">{{ $oferta->descripcion }}</td></tr>
                     </table>

                     <table width=90% class="mx-auto mt-1 text-sm " style="color:rgb(30, 27, 27);">
                        <tr>
                            {{ $oferta->ofertaproducto }}
                            <td width=20% class="font-bold" style="padding-top:8px"  >Ref:</td>
                            <td width=80%  class="font-bold"  style="padding-top:8px"  style="padding-top:8px">{{ $oferta->ofertaproducto->referencia }}</td>
                        </tr>
                        @if($oferta->ofertaproducto->formato!='')
                        <tr>
                            <td width=20% class="font-bold" style="padding-top:8px"  >Formato:</td>
                            <td width=80%  class=""  style="padding-top:8px"  style="padding-top:8px">{{ $oferta->ofertaproducto->formato }}</td>
                        </tr>
                        @endif
                        @if($oferta->ofertaproducto->paginas!='0')
                        <tr>
                            <td width=20% class="font-bold "  style="padding-top:8px">Extensión:</td>
                            <td width=80% class=""  style="padding-top:8px" >{{ $oferta->ofertaproducto->paginas }}</td>
                        </tr>
                        @endif
                        @if($oferta->ofertaproducto->materialinterior!='')
                        <tr>
                            <td width=20% class="font-bold "  style="padding-top:8px">Interior:</td>
                            <td width=80% class="" style="" >
                                <div class="" style="padding-top:8px">
                                    <div class="">
                                        <span class="font-bold"> Composición: </span> {{ $oferta->ofertaproducto->materialinterior }} - {{ $oferta->ofertaproducto->gramajeinterior }} gr
                                    </div>
                                    <div class="">
                                        <span class="font-bold">Impresión:</span> {{ $oferta->ofertaproducto->tintainterior }}
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endif
                        @if($oferta->ofertaproducto->materialcubierta!='')
                        <tr>
                            <td width=20% class="font-bold "  style="padding-top:8px">Cubierta:</td>
                            <td width=80% class="" style="" >
                                <div class="" style="padding-top:8px">
                                    <div class="">
                                        <span class="font-bold"> Composición: </span> {{ $oferta->ofertaproducto->materialcubierta }} - {{ $oferta->ofertaproducto->gramajecubierta }} gr
                                    </div>
                                    <div class="">
                                        <span class="font-bold">Impresión:</span> {{ $oferta->ofertaproducto->tintacubierta }}
                                    </div>
                                    <div class="">
                                        <span class="font-bold">Plastificado:</span> {{ $oferta->ofertaproducto->plastificado }}
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endif
                        @if($oferta->ofertaproducto->encuadernado!='')
                        <tr>
                            <td width=20% class="font-bold "  style="padding-top:8px">Encuadernado:</td>
                            <td width=80% class=""  style="padding-top:8px" >{{ $oferta->ofertaproducto->encuadernado }}</td>
                        </tr>
                        @endif
                        @if($oferta->ofertaproducto->descripsolapa!='')
                        <tr>
                            <td width=20% class="font-bold "  style="padding-top:8px">Solapas:</td>
                            <td width=80% class="" style="padding-top:8px" >
                                {{ $oferta->ofertaproducto->descripsolapa }}
                            </td>
                        </tr>
                        @endif
                        <tr>
                        @if($oferta->ofertaproducto->descripguardas!='')
                        <tr>
                            <td width=20% class="font-bold "  style="padding-top:8px">Guardas:</td>
                            <td width=80% class="" style="padding-top:8px" >
                                {{ $oferta->ofertaproducto->descripguardas }}
                            </td>
                        </tr>
                        @endif
                        @if($oferta->ofertaproducto->manipulacion!='')
                        <tr>
                            <td width=20% class="font-bold "  style="padding-top:8px">Manipulación:</td>
                            <td width=80% class=""  style="padding-top:8px" >{{ $oferta->manipulacion }}</td>
                        </tr>
                        @endif
                        @if($oferta->ofertaproducto->observaciones!='')
                        <tr style="">
                            <td width=20% class="font-bold "  style="margin-top: 0px">Observaciones:</td>
                            <td width=80% class=""  style="padding-top:8px" >
                                <p>{!! nl2br(e($oferta->ofertaproducto->observaciones)) !!}</p>
                            </td>
                        </tr>
                        @endif
                        <tr>
                            <td width=20% class="font-bold "  style="padding-top:8px">Entrega:</td>
                            <td width=80% class=""  style="padding-top:8px" >{{ $oferta->entrega }}</td>
                        </tr>
                    </table>

                    <div class="py-0 space-y-2">
                        <table width="90%" style="margin-top:30px; " cellspacing="0" cellpadding="0" class="mx-auto text-sm">
                            <tr>
                                <td width=51% class="pl-2 font-bold " style="border-style: solid;border-width: .6;border-color: gray" colspan="2">Opciones</td>
                                <td width=17% class="pr-2 font-bold text-right " style="border-style: solid;border-width: .6;border-color: gray">Cantidad</td>
                                <td width=17% class="pr-2 font-bold text-right" style="border-style: solid;border-width: .6;border-color: gray">Precio unitario</td>
                                <td width=17% class="pr-2 font-bold text-right" style="border-style: solid;border-width: .6;border-color: gray">Precio total</td>
                            </tr>
                            @foreach($oferta->ofertadetalles as $odetalle)
                            <tr>
                                <td width=51% class="pl-2" style="border-style: solid;border-width: .6;border-color: gray" colspan="2"><span class="font-bold">{{ $odetalle->titulo }}</span> {{ $odetalle->concepto }}</td>
                                <td width=17% class="pr-2 text-right" style="border-style: solid;border-width: .6;border-color: gray">{{ $odetalle->cantidad }}</td>
                                <td width=17% class="pr-2 text-right" style="border-style: solid;border-width: .6;border-color: gray">{{ $odetalle->importe }}</td>
                                <td width=17% class="pr-2 text-right" style="border-style: solid;border-width: .6;border-color: gray">{{ $odetalle->total }}</td>
                            </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </body>
</html>
