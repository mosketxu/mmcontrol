<!doctype html>
    <html lang="es">

    <head>
        <meta charset="UTF-8">
        <title>Presupuesto {{ $presupuesto->id }}</title>
        <link rel="stylesheet" href="{{ asset('css/app.css')}}">
        {{-- <link rel="stylesheet" href="{{ asset('css/pdf.css')}}"> --}}

        {{-- sobreescribo margenes de app.css --}}
        <style>
            @page {margin: 20px 40px 20px 40px;}
        </style>
    </head>
    <body>
        <!-- Define header and footer blocks before your content -->
        <header>
            <table width="100%" style="margin-top:0px; ">
                <tr>
                    <td style="text-align: left;" width="250px">
                        <img src="{{asset('img/milimetrica.png')}}" width="250px">
                    </td>
                </tr>
                <tr style="">
                    <td class="text-xs " style="text-align:right;color: #6b7280">
                        C/ ZAMORA 46-48 ÁTICO 5ª - 08005 Barcelona (España) <br>
                        <a href="http://www.milimetrica.es" class="colorazul">www.milimetrica.es</a> <br>
                        milimétrica producciones, s.l. – N.I.F. B-63.941.835
                    </td>
                </tr>
            </table>
        </header>
        <footer>
            <div>
                <div>
                </div>
            </div>
        </footer>

    <!-- Wrap the content of your PDF inside a main tag -->
        <main style=" margin-right: 10px; margin-top:50px" class="text-sm">
            <table width="90%" style="margin-top:10px; " class="mx-auto" cellspacing="0" cellpadding="2" >
                <tr  >
                    <td style="padding-left:3px;"  class="" >Demanda de presupuesto núm.: <span class="font-bold">{{ $presupuesto->id }} </span></td>
                    <td style="text-align: right;"  class="" >Fecha: <span class="font-bold">{{ $presupuesto->fpresupuesto4}}</span></td>
                </tr>
                <tr>
                    <td style="padding-left:3px;"  class="" >Cliente: <span class="font-bold"> {{ $presupuesto->facturadopor=='1' ? 'Milimétrica' : $presupuesto->cliente->entidad}} </span></td>
                    <td style="text-align: center;"  class="" ></td>
                </tr>
                <tr>
                    <td>Solicitado por: <span style="font-weight:bold;">{{ $presupuesto->contacto->entidad}} </span></td>
                </tr>
                <tr>
                    <td>Proveedor: <span style="font-weight:bold;">{{ $presupuesto->proveedor->entidad}} </span></td>
                </tr>
                <tr>
                    <td style="padding-left:3px;"  class="" >Descripción: <span class="font-bold">{{ $presupuesto->descripcion}} </span></td>
                </tr>
            </table>


            {{-- Productos --}}
            @if($presupuesto->presupuestoproductos->count()>0)
                <table width="90%" style="margin-top:40px; " cellspacing="0" cellpadding="2" class="mx-auto" >
                    <tr>
                        <td style="padding-left:3px; font-weight:bold;background-color:rgb(215, 212, 212);" colspan="7"  class="" >Productos:</td>
                    </tr>
                    <tr>
                        <td class="font-bold">Cod./Ref.</td>
                        <td class="font-bold">Descripción</td>
                        <td class="font-bold text-right pr-2">Cantidad</td>
                        <td class="font-bold">Material</td>
                        <td class="font-bold">Medidas</td>
                        <td class="font-bold">Troquel</td>
                        <td class="font-bold">Impresión</td>
                    </tr>
                    @foreach ($presupuesto->presupuestoproductos as $pproducto)
                    <tr>
                        <td>{{ $pproducto->producto->isbn }}</td>
                        <td>{{ $pproducto->producto->referencia }}</td>
                        <td style="text-align: right;" class="pr-2">{{ $pproducto->tirada}} </td>
                        <td>{{ $pproducto->producto->material}}</td>
                        <td>{{ $pproducto->producto->medidas }}</td>
                        <td>{{ $pproducto->producto->troquel }}</td>
                        <td>{{ $pproducto->producto->impresion }}</td>
                    </tr>

                    @endforeach
                </table>
            @endif
            {{-- Procesos --}}
            @if($presupuesto->presupuestoprocesos->count()>0)
            <table width="90%" style="margin-top:40px; " cellspacing="0" cellpadding="2" class="mx-auto">
                <tr  >
                    <td style="padding-left:3px; font-weight:bold;background-color:rgb(215, 212, 212);" colspan="3"  class="" >Procesos:</td>
                </tr>
                <tr>
                    <td class="font-bold">Proceso</td>
                    <td class="font-bold">Descripción</td>
                    <td class="font-bold text-right" >Cantidad</td>
                </tr>
                @foreach ($presupuesto->presupuestoprocesos as $pproceso)
                <tr>
                    <td>{{ $pproceso->proceso}}</td>
                    <td>{{ $pproceso->descripcion}}</td>
                    <td style="text-align: right;">{{ $pproceso->tirada}}</td>
                </tr>
                @endforeach
            </table>
            @endif

        {{-- resto --}}
            <table width="90%" style="margin-top:10px; " class="mx-auto" cellspacing="0" cellpadding="2" >
                <tr>
                    <td style="padding-left:3px; font-weight:bold;background-color:rgb(215, 212, 212);" colspan="7"  class="" >Otros:</td>
                </tr>

                <tr>
                    <td style="padding-left:3px;"  class="" >Transporte: <span class="font-bold">{{ $presupuesto->transporte}} </span></td>
                </tr>
                <tr>
                    <td>Observaciones: <span class="font-bold">{{ $presupuesto->otros}} </span></td>
                </tr>
            </table>

        </main>
    </body>
</html>
