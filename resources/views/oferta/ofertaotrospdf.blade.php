<!doctype html>
    <html lang="es">

    <head>
        <meta charset="UTF-8">
        <title>Nº Oferta: {{ $oferta->id }}</title>
        <link rel="stylesheet" href="{{ asset('css/app.css')}}">

        {{--
            Paginación: en vez de precalcular a mano cuántas líneas caben en cada
            página (como se hacía antes), dejamos que dompdf reparta el contenido
            de forma natural:
              - El <footer> es position:fixed, así que se PINTA solo (se repite en
                cada página) pero dompdf NO reserva hueco para él automáticamente:
                comprobado renderizando el PDF, el texto de condiciones llegaba a
                quedar por debajo del borde superior de la imagen del pie (solapado
                con ella) en presupuestos cortos. Por eso el margen inferior de
                @page de aquí abajo está puesto a propósito, del mismo alto que el
                <footer> (125px) — así el flujo normal nunca invade esa franja.
              - Cada bloque (producto, tabla de opciones, firma) lleva
                page-break-inside:avoid para no partirse a la mitad.
              - El espaciado ENTRE bloques repetibles (producto, tabla de opciones)
                se pone como margin-bottom del bloque, no como margin-top: un
                margin-top se arrastra al principio de la página siguiente cuando el
                bloque cae justo tras un salto de página, dejando un hueco de más
                arriba del todo; un margin-bottom no, porque ya se ha consumido en
                la página anterior.
              - El bloque de sello/firma va en el flujo normal del documento
                (nada de position:fixed), así que sólo aparece una vez, justo
                después del último contenido — que por definición es la última
                página.
              - dompdf no repite de forma fiable un <header> con margin-top
                reservado (o se solapa con el contenido, o no aparece) en páginas
                siguientes a la primera, así que el membrete solo se muestra en
                la primera página (patrón habitual en documentos multipágina).
        --}}
        <style>
            {{-- Margen superior solo a partir de la página 2: en la 1ª el membrete ya
            ocupa esa franja (y queda pegado arriba, como estaba pensado); en las
            siguientes no hay nada ahí y el contenido quedaba literalmente pegado al
            borde superior de la hoja. --}}
            @page {margin: 25px 0px 125px 0px;}
            @page :first {margin-top: 0px;}
            .page-break {page-break-after: always;}
            .firma-block {page-break-inside: avoid;}
            .producto-block {page-break-inside: avoid; margin-bottom: 14px;}
            .opciones-chunk {page-break-inside: avoid; margin-bottom: 10px;}
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
        <footer style="position:fixed;left:0px;bottom:-125px;height:125px;width:100%">
            <div class="text-center">
                <img src="{{asset('img/piehierba.png')}}" class="mt-2" width="800px">
            </div>
        </footer>

    <!-- Wrap the content of your PDF inside a main tag -->
        <main style=" margin-right: 10px; margin-top:10px">
            <div class="">
                <div class="py-0 space-y-2" style="min-height: 300px;">
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

                    {{-- Productos: una oferta puede tener varias cajas/productos, cada
                    una con su propia cantidad (oferta_productos). Se repite el bloque
                    de ficha (Datos Caja / Datos Nido / Procesos-Manipulación-Observaciones)
                    para cada uno. --}}
                    @forelse ($oferta->ofertaproductos as $op)
                        @php
                            // "0" es el valor por defecto cuando un campo no se ha rellenado
                            // (igual que la tirada de una linea nueva empieza en '0'): se
                            // trata como "vacio" en todas estas comprobaciones.
                            $relleno = fn($v) => $v !== null && $v !== '' && $v !== '0';
                            $p = $op->producto;
                            $hayCaja = $p && ($relleno($p->caja?->name) || $relleno($p->medidas) || $relleno($p->desarrollocaja) || $relleno($p->material) || $relleno($p->gramajecaja) || $relleno($p->impresion) || $relleno($p->acabadocaja));
                            $hayNido = $p && ($relleno($p->medidasnido) || $relleno($p->materialnido) || $relleno($p->impresionnido));
                            $bloques = [];
                            if($p){
                                if($relleno($p->procesospack)) {$bloques['Procesos'] = nl2br(e($p->procesospack));}
                                if($relleno($p->manipulacion)) {$bloques['Manipulación'] = nl2br(e($p->manipulacion));}
                                if($relleno($p->observaciones)) {$bloques['Observaciones'] = nl2br(e($p->observaciones));}
                            }
                            $countbloques = count($bloques);
                        @endphp
                        <div class="producto-block">
                            <table width="80%" align="center" style="font-size:12px;" cellspacing="0" cellpadding="2">
                                <tr>
                                    <td style="background-color:#EAF1DD; font-weight:bold; padding-left:6px;">
                                        {{ $p->referencia ?? '' }}@if($p && $p->isbn) ({{ $p->isbn }}) @endif
                                        — Cantidad: {{ $op->tirada }}
                                    </td>
                                </tr>
                            </table>

                            @if($p)
                            <table width="80%" align="center" style="margin-top:4px; font-size:12px; color:#1e1b1b;">
                                <tr>
                                    @if($hayCaja && $hayNido)
                                        <td width="50%" valign="top">
                                            @include('oferta.ofertaotrospdftablacaja', ['p' => $p])
                                        </td>
                                        <td width="50%" valign="top">
                                            @include('oferta.ofertaotrospdftablanido', ['p' => $p])
                                        </td>
                                    @elseif($hayCaja)
                                        <td width="100%">
                                            @include('oferta.ofertaotrospdftablacaja', ['p' => $p])
                                        </td>
                                    @elseif($hayNido)
                                        <td width="100%">
                                            @include('oferta.ofertaotrospdftablanido', ['p' => $p])
                                        </td>
                                    @endif
                                </tr>
                            </table>

                            @if($countbloques > 0)
                            <table width="80%" align="center" style="margin-top:4px; font-size:12px;">
                                <tr>
                                    <td colspan="{{ $countbloques }}" style="background-color:#FEFCE8; border-bottom:1px solid #FDE047; padding:3px 4px;"><strong>Otros</strong></td>
                                </tr>
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

                            @if($op->observaciones)
                            <table width="80%" align="center" style="margin-top:4px; font-size:12px;">
                                <tr>
                                    <td><strong>Observaciones línea: </strong>{!! nl2br(e($op->observaciones)) !!}</td>
                                </tr>
                            </table>
                            @endif
                            @endif
                        </div>
                    @empty
                        {{-- Presupuesto sin productos añadidos todavía --}}
                    @endforelse

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
                </div>
            </div>

            {{-- La tabla de Opciones va FUERA del div con min-height: ese min-height
            es solo para acercar la firma al pie en presupuestos cortos, y meter una
            tabla que puede ocupar varias páginas dentro de una caja con altura
            mínima artificial confundía el algoritmo de paginación de dompdf y
            llegaba a perder filas. La tabla, con su <thead> repitiéndose sola, se
            gestiona mejor completamente aparte.

            Además: dompdf tiene un bug real (reproducido de forma aislada, no es
            cosa nuestra) por el que, combinando un <footer> con position:fixed con
            UNA tabla que necesita partirse internamente en más de una página,
            desaparecen filas enteras sin avisar. La única forma fiable de evitarlo
            es que dompdf nunca tenga que partir una tabla por dentro: se trocea la
            lista de precios en bloques pequeños (cada uno con su propia tabla y
            su propia cabecera repetida, page-break-inside:avoid), así cada trozo
            siempre entra entero en una página y dompdf, como mucho, empuja el
            bloque completo a la página siguiente — nunca pierde una fila suelta. --}}
            @foreach($oferta->ofertadetalles->chunk(12) as $bloqueDetalles)
            <div class="opciones-chunk">
                <table width="90%" style="" cellspacing="0" cellpadding="0" class="mx-auto text-sm">
                    <thead>
                        <tr>
                            <td width=57% class="pl-2 font-bold " style="border-style: solid;border-width: .6;border-color: gray" colspan="2">Opciones</td>
                            <td width=15% class="pr-2 font-bold text-right " style="border-style: solid;border-width: .6;border-color: gray">Cantidad</td>
                            <td width=15% class="pr-2 font-bold text-right" style="border-style: solid;border-width: .6;border-color: gray">Precio unitario</td>
                            <td width=15% class="pr-2 font-bold text-right" style="border-style: solid;border-width: .6;border-color: gray">Precio total</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($bloqueDetalles as $odetalle)
                        <tr>
                            <td width=51% class="pl-2" style="border-style: solid;border-width: .6;border-color: gray" colspan="2"><span class="font-bold">{{ $odetalle->titulo }}</span> {{ $odetalle->concepto }}</td>
                            <td width=15% class="pr-2 text-right" style="border-style: solid;border-width: .6;border-color: gray">{{ $odetalle->cantidad }}</td>
                            <td width=15% class="pr-2 text-right" style="border-style: solid;border-width: .6;border-color: gray">{{ $odetalle->importe }}</td>
                            <td width=15% class="pr-2 text-right" style="border-style: solid;border-width: .6;border-color: gray">{{ $odetalle->total }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endforeach

            <div class="firma-block">
                <table width="90%" style="" class="mx-auto">
                    <tr>
                        <td width=50% class="test-right">
                        </td>
                        <td width=50%>
                            <div class="h-24 p-3 border border-blue-900">
                                SELLO Y FIRMA
                            </div>
                        </td>
                    </tr>
                </table>
                <div>
                    <div style="margin-left: 50px;font-size: 0.5rem;">
                        <p class="text-bold">IVA no incluido.</p>
                        <p>Oferta válida durante 30 días.</p>
                        <p>El precio no incluye retoques de archivos.</p>
                        <p>Milimetrica Producciones tiene la potestad de destruir archivos o troquel sin previo aviso, pasados 2 años desde su última fabricación </p>
                        <p>La cantidad suministrada se ajustará al pedido, admitiéndose las siguientes variaciones en +/-25% (pedidos menores de 500 uds.), 20% (pedidos entre 501 y 1.000 uds.), 10% (pedidos entre 1.001 y 15.000 uds.) y 5% (pedidos mayores de 15.000 uds)</p>
                    </div>
                </div>
            </div>
        </main>
    </body>
</html>
