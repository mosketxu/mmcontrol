<!doctype html>
    <html lang="es">

    <head>
        <meta charset="UTF-8">
        <title>Pedido {{ $pedido->id }}</title>
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
                    <td style="text-align: right; font-size:0.8rem" width=50%>
                        <p>C/ Zamora 46-48,  Ático 5ª • 08005 Barcelona (España)</p>
                        <p><a href="www.milimetrica.es">www.milimetrica.es</a></p>
                        <p>Milimétrica Producciones, S.L. - NIF: B-63941835</p>
                    </td>
                </tr>
            </table>
        </header>
        <footer>
        </footer>

    <!-- Wrap the content of your PDF inside a main tag -->
        <main style=" margin-right: 10px; margin-top:20px">
            <div class="">
                <div class="py-0 space-y-2 text-sm">
                    <table width="80%" style="margin-top:10px; " cellspacing="0" cellpadding="0" class="mx-auto ">
                        <tr>
                            <td>Pedido: {{ $pedido->id }} </td>
                            <td class="text-right">Fecha: {{ $pedido->fpedido4 }}</td>
                        </tr>
                    </table>

                    <table width="80%" style="margin-top:20px; " cellspacing="0" cellpadding="2" class="mx-auto ">
                        <tr class="">
                            <td width=25% style="font-weight:bold; padding-left:3px;background-color: #C2D69B; border-style: solid; border-width: .6; border-color: gray"   >Cliente</td>
                            <td width=75% style="padding-left:10px; background-color: #EAF1DD;border-style: solid; border-width: .6; border-color: gray" colspan="2">
                                {{ $pedido->facturadopor=='1' ? 'Milimetrica' : $pedido->cliente->entidad }}
                            </td>
                        </tr>
                        <tr style="">
                            <td style="font-weight:bold; padding-left:3px;background-color: #C2D69B;border-style: solid; border-width: .6; border-color: gray">Descripción</td>
                            <td style="padding-left:10px; background-color: #EAF1DD;border-style: solid; border-width: .6; border-color: gray" colspan="2">
                                <p>{!! nl2br(e($pedido->descripcion)) !!}</p>
                            </td>
                        </tr>
                        <tr style="">
                            <td style="font-weight:bold; padding-left:3px;background-color: #C2D69B;border-style: solid; border-width: .6; border-color: gray">Tirada</td>
                            <td style="padding-left:10px; background-color: #EAF1DD;border-style: solid; border-width: .6; border-color: gray" colspan="2">{{ $pedido->tiradaprevista }}</td>
                        </tr>
                        <tr style="">
                        </tr>
                        <tr style="">
                            <td style="font-weight:bold; padding-left:3px;background-color: #C2D69B;border-style: solid; border-width: .6; border-color: gray">Fecha archivos</td>
                            <td style="padding-left:10px;background-color: white;border-style: solid; border-width: .6; border-color: gray" colspan="2">{{ $pedido->farchivos4 }}</td>
                        </tr>
                        <tr style="">
                            <td style="font-weight:bold; padding-left:3px;background-color: #C2D69B;border-style: solid; border-width: .6; border-color: gray">Fecha de entrega</td>
                            <td style="padding-left:10px;background-color: white;border-style: solid; border-width: .6; border-color: gray" colspan="2">{{ $pedido->fentrega4 }}</td>
                        </tr>
                        @foreach ($pedido->distribuciones as $distribucion )
                        <tr>
                            <td  width=25% style="font-weight:bold; padding-left:3px;background-color: #C2D69B;border-style: solid; border-width: .6; border-color: gray">Distribucion {{ $loop->index +1 }}</td>
                            <td  width=75% style="padding-left:10px;background-color: white;border-style: solid; border-width: .6; border-color: gray" colspan="2">
                                Cantidad: {{ $distribucion->cantidad }}
                                <p>{!! nl2br(e($distribucion->comentario)) !!}</p>
                            </td>
                        </tr>
                        @endforeach
                        <tr style="">
                            <td  width=25% style="font-weight:bold; padding-left:3px;background-color: #C2D69B;border-style: solid; border-width: .6; border-color: gray">Otros</td>
                            <td  width=75% style="padding-left:10px;background-color: white;border-style: solid; border-width: .6; border-color: gray" colspan="2">
                                <p>{!! nl2br(e($pedido->otros)) !!}</p>
                            </td>
                        </tr>
                    </table>
                    {{-- Productos --}}
                    @if($productos->count()>0)
                    {{-- @foreach ($productos as $producto)
                    <tr>
                        <td class="text-center">{{ $producto->isbn}}</td>
                        <td>{{ $producto->referencia }}</td>
                        <td>{{ $producto->material}}</td>
                        <td>{{ $producto->medidas }}</td>
                        <td>{{ $producto->troquel }}</td>
                        <td>{{ $producto->impresion }}</td>
                        <td style="text-align: right;" class="pr-2">{{ $producto->tirada}} </td>
                    </tr>

                    @endforeach --}}

                    <div class="mx-20 mt-8 border ">
                        <table  width="100%" style="" cellspacing="0" cellpadding="2" class="mx-auto text-xs" >
                            <tr >
                                <td class="pl-2 bg-blue-300" style="background-color: #e0f3bc; font-weight:bold;" colspan="7"  >Productos:</td>
                            </tr>
                            <tr>
                                <td class="pl-1 font-bold">Cod./Ref.</td>
                                <td class="font-bold">Descripción</td>
                                <td class="font-bold">Material</td>
                                <td class="font-bold">Medidas</td>
                                {{-- <td class="font-bold">Troquel</td>
                                <td class="font-bold">Impresión</td> --}}
                                <td class="pr-2 font-bold text-right">Cantidad</td>
                            </tr>

                            @foreach ($productos as $producto)

                            <tr>
                                <td class="text-center">{{ $producto->isbn}}</td>
                                <td>{{ $producto->referencia }}</td>
                                <td>{{ $producto->material}}</td>
                                <td>{{ $producto->medidas }}</td>
                                {{-- <td>{{ $producto->troquel }}</td>
                                <td>{{ $producto->impresion }}</td> --}}
                                <td style="text-align: right;" class="pr-2">{{ $producto->tirada}} </td>
                            </tr>
                            @endforeach
                        </table>
                    </div>
                    @endif
                    {{-- Procesos --}}
                    {{-- @if($pedido->pedidoprocesos->count()>0)
                    <div class="mx-20 mt-8 border">
                        <table width="100%" style="" cellspacing="0" cellpadding="2" class="mx-auto text-xs">
                            <tr >
                                <td class="pl-2 bg-blue-300" style="background-color: #bcd0f3; font-weight:bold;" colspan="3"  >Procesos:</td>
                            </tr>
                            <tr>
                                <td class="pl-2 font-bold">Proceso</td>
                                <td class="font-bold">Descripción</td>
                                <td class="pr-2 font-bold text-right" >Cantidad</td>
                            </tr>
                            @foreach ($pedido->pedidoprocesos as $pproceso)
                            <tr>
                                <td class="pl-2" >{{ $pproceso->proceso}}</td>
                                <td>{{ $pproceso->descripcion}}</td>
                                <td class="pr-2" style="text-align: right;">{{ $pproceso->tirada}}</td>
                            </tr>
                            @endforeach
                        </table>
                    </div>
                    @endif --}}
                    <table width="80%" style="margin-top:20px; " cellspacing="0" cellpadding="2" class="mx-auto ">
                        @foreach ($pedido->subpedidos as $subpedido )
                        <tr>
                            <td  width=25% style="font-weight:bold; padding-left:3px;background-color: #C2D69B;border-style: solid; border-width: .6; border-color: gray">Subpedido {{ $loop->index +1 }}: </td>
                            {{-- <td  width=25% style="font-weight:bold; padding-left:3px;background-color: #C2D69B;border-style: solid; border-width: .6; border-color: gray">Referencia </td> --}}
                            <td  width=75% style="padding-left:10px;background-color: white;border-style: solid; border-width: .6; border-color: gray" colspan="2">
                                <div class="">Referencia: {{$subpedido->referencia}}</div>
                                <div class="">Uds: {{$subpedido->unidades}}</div>
                                <div class="">Otros: {{$subpedido->otros}}</div>
                                <div class="">F.Archivos: {{$subpedido->fecha_archivos}}</div>
                                <div class="">F.Plotters: {{$subpedido->fecha_plotters}}</div>
                                <div class="">F.Entrega: {{$subpedido->fecha_entrega}}</div>
                            </td>
                        </tr>
                        @endforeach
                    </table>
                    <table width="80%" style="margin-top:20px; " cellspacing="0" cellpadding="2" class="mx-auto ">
                        @foreach ($pedido->tareas as $tarea )
                        <tr>
                            <td  width=25% style="font-weight:bold; padding-left:3px;background-color: #C2D69B;border-style: solid; border-width: .6; border-color: gray">Tarea {{ $loop->index +1 }}: </td>
                            {{-- <td  width=25% style="font-weight:bold; padding-left:3px;background-color: #C2D69B;border-style: solid; border-width: .6; border-color: gray">Referencia </td> --}}
                            <td  width=75% style="padding-left:10px;background-color: white;border-style: solid; border-width: .6; border-color: gray" colspan="2">
                                <div class="">Tarea: {{$tarea->referencia}}</div>
                                <div class="">Uds: {{$tarea->unidades}}</div>
                                <div class="">Otros: {{$tarea->otros}}</div>
                                <div class="">F.Inicio: {{$tarea->fecha_inicio}}</div>
                                <div class="">F.Fin: {{$tarea->fecha_fin}}</div>
                                <div class="">Asignado a: {{$tarea->asignado_a}}</div>
                                <div class="">Estado: {{$tarea->estadotext}}</div>
                            </td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </main>
    </body>
</html>
