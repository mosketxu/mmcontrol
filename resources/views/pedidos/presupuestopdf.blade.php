<!doctype html>
    <html lang="es">

    <head>
        <meta charset="UTF-8">
        <title>Presupuesto {{ $presupuesto->id }}</title>
        <link rel="stylesheet" href="{{ asset('css/app.css')}}">

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
                        <img src="{{asset('img/logo.png')}}" width="250px">
                    </td>
                </tr>
                <tr style="margin-top:50px;">
                    <td class="text-xs " style="text-align:right;color: #6b7280">
                        <br>
                        <br>
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
        <main style=" margin-right: 10px; margin-top:20px">
            <h1>datos presupuesto</h1>
            {{-- Datos producto  --}}
            @include('producto.ficha')
        </main>
    </body>
</html>
