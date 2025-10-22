<!doctype html>
    <html lang="es">

    <head>
        <meta charset="UTF-8">
        <title>Ficha {{ $producto->isbn }}</title>
        <link rel="stylesheet" href="{{ asset('css/pdf.css')}}">

        {{-- sobreescribo margenes de pdf.css --}}
        <style>
            @page {margin: 20px 40px 20px 40px;}
        </style>
    </head>
    <body>
        <!-- Define header and footer blocks before your content -->
        <header>
            <table width="100%" style="margin-top:0px; " class="tablacentrada">
                <tr>
                    <td style="text-align: right;" width="200px">
                        {{-- <img src="{{asset('img/logo.png')}}" width="200px"> --}}
                        <img src="{{asset('img/logo.png')}}" width="150px">
                    </td>
                    <td style="text-align:right;color: #6b7280">
                        C/ del Joncar 19, planta 5 - 08005 Barcelona (España) <br>
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
        <main style="margin-top:200px; margin-right: 10px;">
            {{-- Datos generales  --}}
            @if($tipo=='1')
                @if($tipopdf=='n')
                    @include('producto.fichaeditorial')
                @else
                    @include('producto.fichaeditorialreducida')
                @endif
            @else
                @include('producto.fichaotros')
            @endif
        </main>
    </body>
</html>
