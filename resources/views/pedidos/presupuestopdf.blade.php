<!doctype html>
    <html lang="es">

    <head>
        <meta charset="UTF-8">
        <title>Presupuesto {{ $presupuesto->id }}</title>
        {{-- <link rel="stylesheet" href="{{ asset('css/app.css')}}"> --}}
        <link rel="stylesheet" href="{{ asset('css/pdf.css')}}">

        {{-- sobreescribo margenes de app.css --}}
        <style>
            @page {margin: 20px 40px 20px 40px;}
        </style>
    </head>
    <body>
        <!-- Define header and footer blocks before your content -->
        <header>
            <table width="100%" style="margin-top:0px; " class="tablacentrada">
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
        <main style=" margin-right: 10px; margin-top:220px">
            <table width="90%" style="margin-top:10px; " cellspacing="0" cellpadding="2" class="tablacentrada">
                <tr  >
                    <td style="padding-left:3px;"  class="" >Demanda de presupuesto núm. {{ $presupuesto->id }} / {{ substr($presupuesto->fechapresupuesto, 0,4) }}</td>
                    <td style="text-align: right;"  class="" >FECHA: {{ $fecha}}</td>
                </tr>
                <tr>
                    <td>sdf</td>
                    <td>{{ $presupuesto->fechapresupuesto }}</td>
                </tr>
            </table>
            @if($presupuesto->comentario)
            <table width="90%" style="margin-top:10px; " cellspacing="0" cellpadding="2" class="tablacentrada">
                <tr  >
                    <td style="padding-left:3px; font-weight:bold;" colspan="2"  class="" >Observaciones:</td>
                </tr>
                <tr>
                    <td style="padding-left:3px;"  class="" >{{ $presupuesto->comentario}}</td>
                </tr>
            </table>
            @endif
            {{-- Datos producto  --}}
            <div class="" style="margin-top:40px; "></div>
            @include('producto.ficha')
        </main>
    </body>
</html>
