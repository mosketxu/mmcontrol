<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Nº Oferta: {{ $oferta->id }}</title>
    <link rel="stylesheet" href="{{ asset('css/app.css')}}">

    <style>
        @page {
            margin: 0px 0 30px 0;
        }

        header {
            position: fixed;
            top: 0px;
            left: 0;
            right: 0;
            height: 120px;
            /* text-align: center; */
            /* line-height: 30px; */
            /* background-color: #2c18a0; */
        }

        footer {
            position: fixed;
            bottom: -50px;
            left: 0;
            right: 0;
            /* height: 60px; */
            text-align: left;
            /* background-color: #8a2328; */
            /* line-height: 30px; */
        }

        body {
            margin: 120px 0px 100px 0px;
            padding: 0;
            /* background-color: #22bb55; */

        }

        .content {
            margin-top: 20px;
            margin-bottom: 0px;
            margin-right: 0px;
            margin-left: 0px;
        }

        .page-break {
            page-break-after: always;
        }

        tr.page-break {
        page-break-before: always;
        }

        .last-page-footer {
            display: none;
        }

        .content:last-child + .last-page-footer {
            display: block;
            position: fixed;
            bottom: -50px;
            left: 0;
            right: 0;
            height: 50px;
            text-align: center;
            /* background-color: #f5f5f5; */
        }

        .piepedido {
            position: fixed;
            bottom: 80px;
            left: 0;
            right: 0;
            /* height: 60px; */
            text-align: left;
            /* background-color: #8a2328; */
            /* line-height: 30px; */
        }
    </style>
</head>
<body>
    <header>
        <table width="90%" style="margin-top:0px; " class="mx-auto">
            <tr>
                <td style="text-align: left"  width=50%>
                    {{-- <img src="{{asset('img/milimetricatexto.png')}}" class="mt-2" width="250px"> --}}
                    <img src="{{asset('img/milimetricatexto.png')}}" class="" width="130px">
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

    <footer>
        <div class="">
            <div class="mt-10 mb-5 text-center " style="font-size: 0.7rem">
                C/ del Joncar 19, planta 5 • 08005 Barcelona • 93 624 38 33
            </div>
            <hr style="border-top: 3px solid rgb(49, 72, 172);">

            <hr class="mt-2" style="border-bottom: 40px solid rgb(49, 72, 172);">
        </div>

    </footer>

    <div class="content">
        <div class="py-0 space-y-2">
            <table width=90% class="mx-auto mt-1 text-sm " style="color:rgb(30, 27, 27);">
                <tr><td colspan="2" class="font-bold">Cliente: {{ $oferta->cliente->entidad }}</td></tr>
                <tr><td colspan="2" class="font-bold"><br>Att: {{ $oferta->contacto->entidad }}</td></tr>
                <tr><td colspan="2"><br>Con la presente y en base a su solicitud, le presento nuestra mejor oferta de:</td></tr>
                <tr><td colspan="2">{{ $oferta->descripcion }}</td></tr>
            </table>

            <table width=90% class="mx-auto mt-1 text-sm " style="color:rgb(30, 27, 27);">
                <tr>
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
                @if($oferta->ofertaproducto->plastificado!='')
                <tr>
                    <td width=20% class="font-bold "  style="padding-top:8px">Laminado:</td>
                    <td width=80% class=""  style="padding-top:8px" >{{ $oferta->ofertaproducto->plastificado }}</td>
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
                @if($oferta->ofertaproducto->tipoimpresion!='')
                <tr>
                    <td width=20% class="font-bold "  style="padding-top:8px">Tipo Impresión:</td>
                    <td width=80% class=""  style="padding-top:8px" >{{ $oferta->ofertaproducto->tipoimpresion }}</td>
                </tr>
                @endif
                @if($oferta->ofertaproducto->FSC!='')
                <tr style="padding-top:8px">
                    <td width=20% class="font-bold "  style="margin-top: 0px;padding-top:8px;">FSC:</td>
                    <td width=80% class=""  style="padding-top:8px" >
                        <p>Sí</p>
                    </td>
                </tr>
                @endif
                @if($oferta->ofertaproducto->observaciones!='')
                <tr style="padding-top:8px">
                    <td width=20% class="font-bold "  style="margin-top: 0px;padding-top:8px;">Observaciones:</td>
                    <td width=80% class=""  style="padding-top:8px" >
                        <p>{!! nl2br(e($oferta->ofertaproducto->observaciones)) !!}</p>
                    </td>
                </tr>
                @endif
                @if($oferta->manipulacion!='')
                <tr style="">
                    <td width=20% class="font-bold "  style="margin-top: 0px;padding-top:8px">Manipulación:</td>
                    <td width=80% class=""  style="padding-top:8px" >
                        <p>{!! nl2br(e($oferta->manipulacion)) !!}</p>
                    </td>
                </tr>
                @endif
                @if($oferta->observaciones!='')
                <tr style="">
                    <td width=20% class="font-bold "  style="margin-top: 0px;;padding-top:8px">Otros:</td>
                    <td width=80% class=""  style="padding-top:8px" >
                        <p>{!! nl2br(e($oferta->observaciones)) !!}</p>
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
                        <td width=57% class="pl-2 font-bold " style="border-style: solid;border-width: .6;border-color: gray" colspan="2">Opciones</td>
                        <td width=15% class="pr-2 font-bold text-right " style="border-style: solid;border-width: .6;border-color: gray">Cantidad</td>
                        <td width=15% class="pr-2 font-bold text-right" style="border-style: solid;border-width: .6;border-color: gray">Precio unitario</td>
                        <td width=15% class="pr-2 font-bold text-right" style="border-style: solid;border-width: .6;border-color: gray">Precio total</td>
                    </tr>

                    {{-- @foreach($oferta->ofertadetalles as $index=>$odetalle)
                    @if (($index + 1) % 10 == 0) <!-- Detecta múltiplos de 10 -->
                        <tr class="page-break">
                            <td width=51% class="pl-2" style="border-style: solid;border-width: .6;border-color: gray" colspan="2"><span class="font-bold">{{ $odetalle->titulo }}</span> {{ $odetalle->concepto }}</td>
                            <td width=15% class="pr-2 text-right" style="border-style: solid;border-width: .6;border-color: gray">{{ $odetalle->cantidad }}</td>
                            <td width=15% class="pr-2 text-right" style="border-style: solid;border-width: .6;border-color: gray">{{ $odetalle->importe }}</td>
                            <td width=15% class="pr-2 text-right" style="border-style: solid;border-width: .6;border-color: gray">{{ $odetalle->total }}</td>
                        </tr>
                        <tr style="margin-top: 20px">
                            <td width=57% class="pl-2 font-bold " style="border-style: solid;border-width: .6;border-color: gray" colspan="2">Opciones</td>
                            <td width=15% class="pr-2 font-bold text-right " style="border-style: solid;border-width: .6;border-color: gray">Cantidad</td>
                            <td width=15% class="pr-2 font-bold text-right" style="border-style: solid;border-width: .6;border-color: gray">Precio unitario</td>
                            <td width=15% class="pr-2 font-bold text-right" style="border-style: solid;border-width: .6;border-color: gray">Precio total</td>
                        </tr>
                    @else
                        <tr>
                            <td width=51% class="pl-2" style="border-style: solid;border-width: .6;border-color: gray" colspan="2"><span class="font-bold">{{ $odetalle->titulo }}</span> {{ $odetalle->concepto }}</td>
                            <td width=15% class="pr-2 text-right" style="border-style: solid;border-width: .6;border-color: gray">{{ $odetalle->cantidad }}</td>
                            <td width=15% class="pr-2 text-right" style="border-style: solid;border-width: .6;border-color: gray">{{ $odetalle->importe }}</td>
                            <td width=15% class="pr-2 text-right" style="border-style: solid;border-width: .6;border-color: gray">{{ $odetalle->total }}</td>
                        </tr>
                    @endif
                    @endforeach --}}

                    @foreach($oferta->ofertadetalles as $index=>$odetalle)
                    @if ($index == $salto && $primera==1)
                        @php
                            $primera=0;
                            $cont=0;
                        @endphp
                        <tr class="page-break">
                        </table>
                        <table width="90%" style="margin-top:30px; " cellspacing="0" cellpadding="0" class="mx-auto text-sm">
                        <tr>
                            <td width=57% class="pl-2 font-bold " style="border-style: solid;border-width: .6;border-color: gray" colspan="2">Opciones</td>
                            <td width=15% class="pr-2 font-bold text-right " style="border-style: solid;border-width: .6;border-color: gray">Cantidad</td>
                            <td width=15% class="pr-2 font-bold text-right" style="border-style: solid;border-width: .6;border-color: gray">Precio unitario</td>
                            <td width=15% class="pr-2 font-bold text-right" style="border-style: solid;border-width: .6;border-color: gray">Precio total</td>
                        </tr>
                    @elseif($cont > $controlsaltopag2)
                        @php
                            $cont=0;
                        @endphp
                        <tr class="page-break">
                        </table>
                        <table width="90%" style="margin-top:30px; " cellspacing="0" cellpadding="0" class="mx-auto text-sm">
                            <tr>
                                <td width=57% class="pl-2 font-bold " style="border-style: solid;border-width: .6;border-color: gray" colspan="2">Opciones</td>
                                <td width=15% class="pr-2 font-bold text-right " style="border-style: solid;border-width: .6;border-color: gray">Cantidad</td>
                                <td width=15% class="pr-2 font-bold text-right" style="border-style: solid;border-width: .6;border-color: gray">Precio unitario</td>
                                <td width=15% class="pr-2 font-bold text-right" style="border-style: solid;border-width: .6;border-color: gray">Precio total</td>
                            </tr>
                    @endif
                        @php
                            $cont++;
                        @endphp
                        <tr>
                            <td width=51% class="pl-2" style="border-style: solid;border-width: .6;border-color: gray" colspan="2"><span class="font-bold">{{ $odetalle->titulo }}</span> {{ $odetalle->concepto }}</td>
                            <td width=15% class="pr-2 text-right" style="border-style: solid;border-width: .6;border-color: gray">{{ $odetalle->cantidad }}</td>
                            <td width=15% class="pr-2 text-right" style="border-style: solid;border-width: .6;border-color: gray">{{ $odetalle->importe }}</td>
                            <td width=15% class="pr-2 text-right" style="border-style: solid;border-width: .6;border-color: gray">{{ $odetalle->total }}</td>
                        </tr>
                    <!-- Detecta múltiplos de 10 -->
                        {{--
                        <tr class="page-break">
                            <td width=51% class="pl-2" style="border-style: solid;border-width: .6;border-color: gray" colspan="2"><span class="font-bold">{{ $odetalle->titulo }}</span> {{ $odetalle->concepto }}</td>
                            <td width=15% class="pr-2 text-right" style="border-style: solid;border-width: .6;border-color: gray">{{ $odetalle->cantidad }}</td>
                            <td width=15% class="pr-2 text-right" style="border-style: solid;border-width: .6;border-color: gray">{{ $odetalle->importe }}</td>
                            <td width=15% class="pr-2 text-right" style="border-style: solid;border-width: .6;border-color: gray">{{ $odetalle->total }}</td>
                        </tr>
                        <tr style="margin-top: 20px">
                            <td width=57% class="pl-2 font-bold " style="border-style: solid;border-width: .6;border-color: gray" colspan="2">Opciones</td>
                            <td width=15% class="pr-2 font-bold text-right " style="border-style: solid;border-width: .6;border-color: gray">Cantidad</td>
                            <td width=15% class="pr-2 font-bold text-right" style="border-style: solid;border-width: .6;border-color: gray">Precio unitario</td>
                            <td width=15% class="pr-2 font-bold text-right" style="border-style: solid;border-width: .6;border-color: gray">Precio total</td>
                        </tr>
                    @else --}}
                        {{-- <tr>
                            <td width=51% class="pl-2" style="border-style: solid;border-width: .6;border-color: gray" colspan="2"><span class="font-bold">{{$index}}-{{$primera}} {{ $odetalle->titulo }}</span> {{ $odetalle->concepto }}</td>
                            <td width=15% class="pr-2 text-right" style="border-style: solid;border-width: .6;border-color: gray">{{ $odetalle->cantidad }}</td>
                            <td width=15% class="pr-2 text-right" style="border-style: solid;border-width: .6;border-color: gray">{{ $odetalle->importe }}</td>
                            <td width=15% class="pr-2 text-right" style="border-style: solid;border-width: .6;border-color: gray">{{ $odetalle->total }}</td>
                        </tr> --}}
                    {{-- @endif --}}
                    @endforeach
                </table>
            </div>

            <div class="piepedido">
                <table width="90%" style="fixed" class="mx-auto">
                    <tr>
                        <td width=50%></td>
                        <td width=50% style="border: solid; border-width:0.6px">SELLO Y FIRMA <br> <br> <br> <br></td>
                    </tr>
                </table>
                <div style="margin-left: 50px;font-size: 0.5rem;">
                    <p class="text-bold">IVA no incluido.</p>
                    <p>Oferta válida durante 30 días.</p>
                    <p>El precio no incluye retoques de archivos.</p>
                    <p>Milimetrica Producciones tiene la potestad de destruir archivos o troquel sin previo aviso, pasados 2 años desde su última fabricación </p>
                    <p>La cantidad suministrada se ajustará al pedido, admitiéndose las siguientes variaciones en +/-25% (pedidos menores de 500 uds.), 20% (pedidos entre 501 y 1.000 uds.), 10% (pedidos entre 1.001 y 15.000 uds.) y 5% (pedidos mayores de 15.000 uds)</p>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
