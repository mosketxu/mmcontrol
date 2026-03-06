<!doctype html>
    <html lang="es">

    <head>
        <meta charset="UTF-8">
        <title>Presupuesto {{ $presupuesto->id }}</title>
        <link rel="stylesheet" href="{{ asset('css/pdf.css')}}">
        <style>
            @page {margin: 20px 40px 20px 40px;}
        </style>
    </head>
    <body>
        <!-- Define header and footer blocks before your content -->
        <header>
        </header>
        <footer>
            <div>
                <div>
                </div>
            </div>
        </footer>

    <!-- Wrap the content of your PDF inside a main tag -->
        <main style=" margin-right: 10px; margin-top:0px">
            <table width="100%" style="margin-top:0px; " class="tablacentrada">
                <tr>
                    <td style="text-align: left; background-color: white" >
                        {{-- <img src="{{asset('img/milimetrica.png')}}" width="200px"> --}}
                        <img src="{{ public_path('img/milimetrica.png') }}" width="200">
                    </td>
                    <td class="text-xs " style="text-align:right;color: #6b7280">
                        C/ del Joncar 19, planta 5 - 08005 Barcelona (España) <br>
                        <a href="http://www.milimetrica.es" class="colorazul">www.milimetrica.es</a> <br>
                        milimétrica producciones, s.l. – N.I.F. B-63.941.835
                    </td>
                </tr>
            </table>
            <table width="90%" style="margin-top:10px; " cellspacing="0" cellpadding="2" class="tablacentrada">
                <tr>
                    <td style="padding-left:3px;"  class="" >Demanda de presupuesto núm. <span style="font-weight:bold;">{{ $presupuesto->id }} </span></td>
                    <td style="text-align: right;"  class="" >Fecha: <span style="font-weight:bold;">{{ $presupuesto->fpresupuesto4}}</span></td>
                </tr>
                <tr>
                    <td>Solicitado por: <span style="font-weight:bold;">
                        {{ $presupuesto->facturadopor=='1' ? $presupuesto->responsable : $presupuesto->cliente->entidad ?? '' }}
                    </span></td>
                </tr>
                <tr>
                    <td>Proveedor: <span style="font-weight:bold;">{{ $presupuesto->proveedor->entidad ?? ''}} </span></td>
                </tr>
            </table>

            {{-- <div class="" style="margin-top:40px; "> --}}
                <table width="90%" style="margin-top:10px; " cellspacing="0" cellpadding="2" class="tablacentrada">
                    <tr  >
                        <td style="font-weight:bold; padding-left:3px;background-color: #CCC0D9;"  class="borde1" >Cliente </td>
                        <td style="padding-left:3px; background-color: #E5DFEC;"  class="borde1" colspan="2">
                            {{ $presupuesto->facturadopor=='1' ? 'Milimetrica' : $presupuesto->cliente->entidad ?? '' }}
                        </td>
                    </tr>
                    @if($producto && ($producto->isbn || $producto->referencia))
                        <tr style="">
                            <td style="font-weight:bold; padding-left:3px;background-color: #CCC0D9;"  class="borde1">Cód.Producto</td>
                            <td style="padding-left:3px;background-color: #E5DFEC;"  class="borde1" colspan="2">{{ $producto->isbn }}</td>
                        </tr>
                        <tr style="">
                            <td style="font-weight:bold; padding-left:3px;background-color: #CCC0D9;"  class="borde1">Ref.Producto</td>
                            <td style="padding-left:3px;background-color: #E5DFEC;"  class="borde1" colspan="2">{{ $producto->referencia }}</td>
                        </tr>
                    @endif
                    <tr style="">
                        <td style="font-weight:bold; padding-left:3px;background-color: #CCC0D9;"  class="borde1">Descripcion</td>
                        <td style="padding-left:3px; background-color: #E5DFEC;"  class="borde1" colspan="2">{{ $presupuesto->descripcion }}</td>
                    </tr>
                    <tr style="">
                        <td style="font-weight:bold; padding-left:3px;background-color: #CCC0D9;" class="borde1">Tirada</td>
                        <td style="padding-left:3px;" class="borde1" colspan="2">{{ $presupuesto->tirada }}</td>
                    </tr>
                    <tr style="">
                        <td style="font-weight:bold; padding-left:3px;background-color: #CCC0D9;"  class="borde1">Modelo Caja</td>
                        <td style="padding-left:3px;" class="borde1" colspan="2">{{ $presupuesto->caja->name ?? ''}}</td>
                    </tr>
                    <tr style="">
                        <td style="font-weight:bold; padding-left:3px;background-color: #CCC0D9;"  class="borde1">Etiqueta</td>
                        <td style="padding-left:3px;" class="borde1" colspan="2">{{ $presupuesto->etiqueta}}</td>
                    </tr>
                    @if($presupuesto->uds_caja>0)
                    <tr style="">
                        <td style="font-weight:bold; padding-left:3px;background-color: #CCC0D9;"  class="borde1">Uds x Caja</td>
                        <td style="padding-left:3px;" class="borde1" colspan="2">{{ $presupuesto->uds_caja }}</td>
                    </tr>
                    @endif
                    <tr style="">
                        <td style="font-weight:bold; padding-left:3px;background-color: #CCC0D9;"  class="borde1">Manipulación</td>
                        <td style="padding-left:3px;" class="borde1" colspan="2">
                            {{-- <p>{!! nl2br(e($presupuesto->manipulacion)) !!}</p> --}}
                            {!! nl2br(e($presupuesto->manipulacion)) !!}
                        </td>
                    </tr>
                    <tr style="">
                        <td style="font-weight:bold; padding-left:3px;background-color: #CCC0D9;"  class="borde1">Distribución</td>
                        <td style="padding-left:3px;" class="borde1" colspan="2">
                            {{-- <p>{!! nl2br(e($presupuesto->transporte)) !!}</p> --}}
                            {!! nl2br(e($presupuesto->transporte)) !!}
                        </td>
                    </tr>
                    <tr style="">
                        <td style="font-weight:bold; padding-left:3px;background-color: #CCC0D9;"  class="borde1">Espec. logísticas</td>
                        <td style="padding-left:3px;" class="borde1" colspan="2">
                            {{-- <p>{!! nl2br(e($presupuesto->especificacioneslogisticas)) !!}</p> --}}
                            {!! nl2br(e($presupuesto->especificacioneslogisticas)) !!}
                        </td>
                    </tr>
                    <tr style="">
                        <td style="font-weight:bold; padding-left:3px;background-color: #CCC0D9;"  class="borde1">Otros</td>
                        <td style="padding-left:3px;" class="borde1" colspan="2">
                            {{-- <p>{!! nl2br(e($presupuesto->otros)) !!}</p> --}}
                            {!! nl2br(e($presupuesto->otros)) !!}
                        </td>
                    </tr>
                </table>

                {{-- @if($producto->isbn || $producto->referencia ) --}}
                @if(!empty($producto) && ($producto->isbn || $producto->referencia))
                <table width="90%" style="margin-top:10px; " cellspacing="0" cellpadding="2" class="tablacentrada">
                    <tr  >
                        <td style="font-weight:bold; padding-left:3px;background-color: #CCC0D9;text-decoration:underline" colspan="3"  class="borde1" >Detalle del producto</td>
                    </tr>
                    @if($producto->caja_id || $producto->medidas || $producto->desarrollocaja || $producto->material || $producto->gramajecaja || $producto->impresion || $producto->acabadocaja)
                        <tr style="margin-top=10px;font-weight: bold; ">
                            <td style="font-weight:bold; padding-left:3px;" colspan="3" class="">Datos Caja</td>
                        </tr>
                        @if($producto->caja_id )
                            <tr style="">
                                <td style="font-weight:bold; padding-left:3px;background-color: #CCC0D9;" class="borde1">Caja</td>
                                <td style="padding-left:3px;" class="borde1" colspan="2">{{ $producto->caja->name?? '-' }}</td>
                        </tr>
                        @endif
                        @if($producto->medidas )
                            <tr style="">
                                <td style="font-weight:bold; padding-left:3px;background-color: #CCC0D9;"  class="borde1">Medidas (LxAxH)</td>
                                <td style=" padding-left:3px;" class="borde1" colspan="2">{{ $producto->medidas }}</td>
                            </tr>
                        @endif
                        @if( $producto->desarrollocaja)
                            <tr style="">
                                <td style="font-weight:bold; padding-left:3px;background-color: #CCC0D9;"  class="borde1">Desarrollo</td>
                                <td style=" padding-left:3px;" class="borde1" colspan="2">{{ $producto->desarrollocaja }}</td>
                            </tr>
                        @endif
                        @if( $producto->material)
                            <tr style="">
                                <td style="font-weight:bold; padding-left:3px;background-color: #CCC0D9;"  class="borde1">Material</td>
                                <td style=" padding-left:3px;" class="borde1" colspan="2">{{ $producto->material }}</td>
                            </tr>
                        @endif
                        @if( $producto->gramajecaja)
                            <tr style="">
                                <td style="font-weight:bold; padding-left:3px;background-color: #CCC0D9;"  class="borde1">Gramaje</td>
                                <td style=" padding-left:3px;" class="borde1" colspan="2">{{ $producto->gramajecaja }}</td>
                            </tr>
                        @endif
                        @if( $producto->impresion)
                            <tr style="">
                                <td style="font-weight:bold; padding-left:3px;background-color: #CCC0D9;"  class="borde1">Impresión</td>
                                <td style=" padding-left:3px;" class="borde1" colspan="2">{{ $producto->impresion }}</td>
                            </tr>
                        @endif
                        @if( $producto->acabadocaja)
                            <tr style="">
                                <td style="font-weight:bold; padding-left:3px;background-color: #CCC0D9;"  class="borde1">Acabado</td>
                                <td style=" padding-left:3px;" class="borde1" colspan="2">{{ $producto->acabadocaja }}</td>
                            </tr>
                        @endif
                    @endif
                    @if($producto->medidasnido || $producto->materialnido || $producto->impresionnido )
                        <tr style="margin-top=10px;font-weight: bold; ">
                            <td style="font-weight:bold; padding-left:3px;" colspan="3" class="">Datos Nido</td>
                        </tr>
                        @if($producto->medidasnido)
                        <tr style="">
                            <td style="font-weight:bold; padding-left:3px;background-color: #CCC0D9;"  class="borde1">Medidas</td>
                            <td style=" padding-left:3px;" class="borde1" colspan="2">{{ $producto->medidasnido }}</td>
                        </tr>
                        @endif
                        @if($producto->materialnido)
                            <tr style="">
                                <td style="font-weight:bold; padding-left:3px;background-color: #CCC0D9;"  class="borde1">Material</td>
                                <td style=" padding-left:3px;" class="borde1" colspan="2">{{ $producto->materialnido }}</td>
                            </tr>
                        @endif
                        @if($producto->impresionnido)
                            <tr style="">
                                <td style="font-weight:bold; padding-left:3px;background-color: #CCC0D9;"  class="borde1">Impresión</td>
                                <td style=" padding-left:3px;" class="borde1" colspan="2">{{ $producto->impresionnido }}</td>
                            </tr>
                        @endif
                    @endif
                    @if($producto->procesospack || $producto->manipulacion  )
                        <tr style="margin-top=10px;font-weight: bold; ">
                            <td style="font-weight:bold; padding-left:3px;" colspan="3" class="">Otros</td>
                        </tr>
                        @if($producto->procesospack )
                            <tr style="">
                                <td style="font-weight:bold; padding-left:3px;background-color: #CCC0D9;"  class="borde1">Procesos</td>
                                <td style="padding-left:3px;" class="borde1" colspan="2">
                                    {{-- <p>{!! nl2br(e($producto->procesospack)) !!}</p> --}}
                                    {!! nl2br(e($producto->procesospack)) !!}
                                </td>
                            </tr>
                        @endif
                        @if($producto->manipulacion )
                            <tr style="">
                                <td style="font-weight:bold; padding-left:3px;background-color: #CCC0D9;"  class="borde1">Manipulación</td>
                                <td style="padding-left:3px;" class="borde1" colspan="2">
                                    <p>{!! nl2br(e($producto->manipulacion)) !!}</p>
                                    {!! nl2br(e($producto->manipulacion)) !!}
                                </td>
                            </tr>
                        @endif
                    @endif
                    @if($producto->observaciones)
                        <tr style="margin-top=10px;font-weight: bold; ">
                            <td style="font-weight:bold; padding-left:3px;" colspan="3" class=""></td>
                        </tr>
                        <tr style="">
                            <td style="font-weight:bold; padding-left:3px;background-color: #CCC0D9;"  class="borde1">Observaciones</td>
                            <td style="padding-left:3px;" class="borde1" colspan="2">
                                {{-- <p>{!! nl2br(e($producto->observaciones)) !!}</p> --}}
                                {!! nl2br(e($producto->observaciones)) !!}
                            </td>
                        </tr>
                    @endif
                </table>
                @endif
            {{-- </div> --}}
        </main>
    </body>
</html>
