<!doctype html>
    <html lang="es">

    <head>
        <meta charset="UTF-8">
        <title>Factura {{ $pedido->id }}</title>
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
                <div class="py-0 space-y-2">
                    <table width="80%" style="margin-top:10px; " cellspacing="0" cellpadding="0" class="mx-auto ">
                        <tr>
                            <td>Pedido: {{ $pedido->id }} </td>
                            <td class="text-right">Fecha: {{ $pedido->fpedido4 }}</td>
                        </tr>
                    </table>

                    <table width="80%" style="margin-top:20px; " cellspacing="0" cellpadding="2" class="mx-auto ">
                        <tr class="">
                            <td style="font-weight:bold; padding-left:3px;background-color: #C2D69B; border-style: solid; border-width: .6; border-color: gray"   >Cliente</td>
                            <td style="padding-left:10px; background-color: #EAF1DD;border-style: solid; border-width: .6; border-color: gray" colspan="2">{{ $pedido->cliente->entidad }}</td>
                        </tr>
                        <tr style="">
                            <td style="font-weight:bold; padding-left:3px;background-color: #C2D69B;border-style: solid; border-width: .6; border-color: gray">Título</td>
                            <td style="padding-left:10px; background-color: #EAF1DD;border-style: solid; border-width: .6; border-color: gray" colspan="2">{{ $pedido->producto->referencia }}</td>
                        </tr>
                        <tr style="">
                            <td style="font-weight:bold; padding-left:3px;background-color: #C2D69B;border-style: solid; border-width: .6; border-color: gray">ISBN/Referencia</td>
                            <td style="padding-left:10px;background-color: #EAF1DD;border-style: solid; border-width: .6; border-color: gray" colspan="2">{{ $pedido->producto->isbn }}</td>
                        </tr>
                        <tr style="">
                            <td style="font-weight:bold; padding-left:3px;background-color: #C2D69B;border-style: solid; border-width: .6; border-color: gray">Tirada</td>
                            <td style="padding-left:10px;background-color: white;border-style: solid; border-width: .6; border-color: gray" colspan="2">{{ $pedido->tiradaprevista }}</td>
                        </tr>
                        <tr style="">
                            <td style="font-weight:bold; padding-left:3px;background-color: #C2D69B;border-style: solid; border-width: .6; border-color: gray">Fecha de archivos</td>
                            <td style="padding-left:10px;background-color: white;border-style: solid; border-width: .6; border-color: gray" colspan="2">{{ $pedido->farchivos4 }}</td>
                        </tr>
                        <tr style="">
                            <td style="font-weight:bold; padding-left:3px;background-color: #C2D69B;border-style: solid; border-width: .6; border-color: gray">Fecha de entrega</td>
                            <td style="padding-left:10px;background-color: white;border-style: solid; border-width: .6; border-color: gray" colspan="2">{{ $pedido->fentrega4 }}</td>
                        </tr>
                        <tr style="">
                            <td style="font-weight:bold; padding-left:3px;background-color: #C2D69B;border-style: solid; border-width: .6; border-color: gray">Parciales</td>
                            <td style="padding-left:10px;background-color: white;border-style: solid; border-width: .6; border-color: gray" colspan="2">
                                @if($pedido->parciales->count()>0)
                                    @foreach ($pedido->parciales as $parcial )
                                        <div style=" border-bottom:solid ;  border-bottom-width: .6; border-color: gray">
                                            <div style="display: flex; ">
                                                <div style="display: flex">
                                                    {{ $parcial->fecha }} - {{ $parcial->cantidad }} Uds
                                                </div>
                                            </div>
                                            @if($parcial->comentario!='')
                                            <div class="">
                                                {{ $parcial->comentario }}

                                            </div>
                                            @endif
                                        </div>
                                    @endforeach
                                @endif
                            </td>
                        </tr>
                        @foreach ($pedido->distribuciones as $distribucion )
                        <tr>
                            <td style="font-weight:bold; padding-left:3px;background-color: #C2D69B;border-style: solid; border-width: .6; border-color: gray">Distribucion {{ $loop->index +1 }}</td>
                            <td style="padding-left:10px;background-color: white;border-style: solid; border-width: .6; border-color: gray" colspan="2"><textarea name="" id="" cols="30" rows="8" class="p-0 m-0 border-none" style="text-align: left;">{{ $distribucion->comentario }}</textarea></td>
                        </tr>
                        @endforeach
                        <tr style="">
                            <td style="font-weight:bold; padding-left:3px;background-color: #C2D69B;border-style: solid; border-width: .6; border-color: gray">Packing list</td>
                            <td style="padding-left:10px;background-color: white;border-style: solid; border-width: .6; border-color: gray" colspan="2">definir</td>
                        </tr>
                        {{-- @if($pedido->archivos->count()>0)
                        <tr>
                            <td style="font-weight:bold; padding-left:3px;background-color: #C2D69B;border-style: solid; border-width: .6; border-color: gray">Archivos</td>
                            <td style="padding-left:10px;background-color: white;border-style: solid; border-width: .6; border-color: gray" colspan="2">
                                @foreach ($pedido->archivos as $archivo )
                                    <p>Fecha: {{ $archivo->nombrearchivooriginal }} / &nbsp; {{ $archivo->comentario }} </p>
                                @endforeachif
                            </td>
                        </tr>
                        @endforeach --}}
                        <tr style="">
                            <td style="font-weight:bold; padding-left:3px;background-color: #C2D69B;border-style: solid; border-width: .6; border-color: gray">Otros</td>
                            <td style="padding-left:10px;background-color: white;border-style: solid; border-width: .6; border-color: gray" colspan="2">{{ $pedido->otros }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </main>
    </body>
</html>
