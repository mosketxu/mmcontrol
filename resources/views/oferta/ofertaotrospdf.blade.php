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
            tr.page-break {page-break-before: always;}
            .elemento-final {
                position: fixed;
                bottom: 120px; /* 100px por encima del final del PDF */
                left: 0;
                width: 100%;
                /* text-align: center; */
            }
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
        @php
            $pag=0;
        @endphp
        <footer style="position:fixed;left:0px;bottom:0px;height:125px;width:100%">
            <div class="text-center">
                <img src="{{asset('img/piehierba.png')}}" class="mt-2" width="800px">
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

                    <table width="80%" align="center" style="margin-top:10px; font-size:12px; color:#1e1b1b;">
                        <tr>
                            @if($hayCaja && $hayNido)
                                <td width="50%" valign="top">
                                    @include('oferta.ofertaotrospdftablacaja')
                                </td>
                                <td width="50%" valign="top">
                                    @include('oferta.ofertaotrospdftablanido')
                                </td>
                            @elseif($hayCaja)
                                <td width="100%">
                                    @include('oferta.ofertaotrospdftablacaja')
                                </td>
                            @elseif($hayNido)
                                <td width="100%">
                                    @include('oferta.ofertaotrospdftablanido')
                                </td>
                            @endif
                        </tr>
                    </table>

                    @if($countbloques > 0)
                    <table width="80%" align="center" style="margin-top:10px; font-size:12px;">
                        <tr>
                            @foreach($bloques as $titulo => $contenido)
                                <td width="{{ 100 / $countbloques }}%" valign="top" style="padding-right:10px;">
                                    <strong>{{ $titulo }}</strong><br>
                                    {!! $contenido !!}
                                </td>
                            @endforeach
                        </tr>
                    </table>
                    @endif

                    <table width="80%" style="margin-top:10px; font-size:12px" class="mx-auto" cellspacing="0" cellpadding="2" >
                        @if($oferta->observaciones!='' || $oferta->manipulacion!='' || $oferta->entrega!='')
                        <tr>
                            @if($oferta->manipulacion!='')
                            <td> <span class="font-bold">Manipulación Gral.: </span>
                                <p>{!! nl2br(e($oferta->manipulacion)) !!}</p>
                            </td>
                            @endif
                            @if($oferta->entrega!='')
                            <td> <span class="font-bold">Entrega: </span>
                                <p>{!! nl2br(e($oferta->entrega)) !!}</p>
                            </td>
                            @endif
                            @if($oferta->observaciones!='')
                            <td> <span class="font-bold">Observaciones: </span>
                                <p>{!! nl2br(e($oferta->observaciones)) !!}</p>
                            </td>
                            @endif
                        </tr>
                        @endif
                    </table>

                    {{-- Escandallo --}}
                    <table width="90%" style="margin-top:10px; " cellspacing="0" cellpadding="0" class="mx-auto text-sm">
                    <tr>
                        <td width=57% class="pl-2 font-bold " style="border-style: solid;border-width: .6;border-color: gray" colspan="2">Opciones</td>
                        <td width=15% class="pr-2 font-bold text-right " style="border-style: solid;border-width: .6;border-color: gray">Cantidad</td>
                        <td width=15% class="pr-2 font-bold text-right" style="border-style: solid;border-width: .6;border-color: gray">Precio unitario</td>
                        <td width=15% class="pr-2 font-bold text-right" style="border-style: solid;border-width: .6;border-color: gray">Precio total</td>
                    </tr>

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
                    @endforeach
                </table>


            </div>




                </div>
            </div>
            {{-- @if($pag===1) --}}
            <div class="elemento-final">
                <table width="90%" style="" class="mx-auto">
                    <tr>
                        <td width=50% class="test-right">
                            {{-- <div class="text-right">
                                <img src="{{asset('img/SelloSostenibilidad.png')}}" class="text-right" width="260px">
                            </div> --}}
                        </td>
                        <td width=50%>
                            <div class="h-24 p-3 border border-blue-900">
                                SELLO Y FIRMA
                            </div>
                        </td>
                    </tr>
                </table>
                <div >
                    <div style="margin-left: 50px;font-size: 0.5rem;">
                        <p class="text-bold">IVA no incluido.</p>
                        <p>Oferta válida durante 30 días.</p>
                        <p>El precio no incluye retoques de archivos.</p>
                        <p>Milimetrica Producciones tiene la potestad de destruir archivos o troquel sin previo aviso, pasados 2 años desde su última fabricación </p>
                        <p>La cantidad suministrada se ajustará al pedido, admitiéndose las siguientes variaciones en +/-25% (pedidos menores de 500 uds.), 20% (pedidos entre 501 y 1.000 uds.), 10% (pedidos entre 1.001 y 15.000 uds.) y 5% (pedidos mayores de 15.000 uds)</p>
                    </div>
                    {{-- <div class="text-center">
                        <img src="{{asset('img/piehierba.png')}}" class="mt-2" width="800px">
                    </div> --}}
                </div>
            </div>
        {{-- @endif --}}
        </main>
    </body>
</html>
