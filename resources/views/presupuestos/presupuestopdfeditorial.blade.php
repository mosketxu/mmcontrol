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
                    <td style="padding-left:3px;"  class="" >Demanda de presupuesto núm. {{ $presupuesto->id }} </td>
                    <td style="text-align: right;"  class="" >Fecha: {{ $presupuesto->fpresupuesto4}}</td>
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
            <div class="" style="margin-top:40px; ">
                <table width="80%" style="margin-top:10px; " cellspacing="0" cellpadding="2" class="tablacentrada">
                    <tr  >
                        <td style="font-weight:bold; padding-left:3px;background-color: #CCC0D9;"  class="borde1" >Cliente</td>
                        <td style="padding-left:3px; background-color: #E5DFEC;"  class="borde1" colspan="2">
                            {{ $producto->facturadopor!='1' ? 'Milimetrica' : $producto->cliente->entidad }}
                        </td>
                    </tr>
                    <tr style="">
                        <td style="font-weight:bold; padding-left:3px;background-color: #CCC0D9;"  class="borde1">Título</td>
                        <td style="padding-left:3px; background-color: #E5DFEC;"  class="borde1" colspan="2">{{ $producto->referencia }}</td>
                    </tr>
                    <tr style="">
                        <td style="font-weight:bold; padding-left:3px;background-color: #CCC0D9;"  class="borde1">ISBN/Referencia</td>
                        <td style="padding-left:3px;background-color: #E5DFEC;"  class="borde1" colspan="2">{{ $producto->isbn }}</td>
                    </tr>
                    <tr style="">
                        <td style="font-weight:bold; padding-left:3px;background-color: #CCC0D9;" class="borde1">Tirada</td>
                        <td style="padding-left:3px;" class="borde1" colspan="2">{{ $presupuesto->tirada }}</td>
                    </tr>
                    <tr style="">
                        <td style="font-weight:bold; padding-left:3px;background-color: #CCC0D9;" class="borde1">Formato</td>
                        <td style="padding-left:3px;" class="borde1" colspan="2">{{ $producto->formato }}</td>
                    </tr>
                    <tr style="">
                        <td style="font-weight:bold; padding-left:3px;background-color: #CCC0D9;"  class="borde1">Páginas</td>
                        <td style=" padding-left:3px;" class="borde1" colspan="2">{{ $producto->paginas }}</td>
                    </tr>
                    <tr style="">
                        <td style="font-weight:bold; padding-left:3px;background-color: #CCC0D9;"  class="borde1">FSC</td>
                        <td style=" padding-left:3px;" class="borde1" colspan="2">
                            <input type="checkbox" name="FSC" value="{{ $producto->FSC }}" {{ $producto->FSC=='1' ? 'checked' : ''  }} id="FSC">
                        </td>
                    </tr>
                    <tr style="">
                        <td width=30% style="padding-left:3px; background-color: #CCC0D9;"  class="bordeleft1"></td>
                        <td width=20% style="font-weight:bold; padding-left:3px; "  class="borde1" >Material</td>
                        <td width=60% style="padding-left:3px; " class="borde1"> {{ $producto->materialinterior }}</td>
                    </tr>
                    <tr style="">
                        <td width=30% style="font-weight:bold; padding-left:3px;background-color: #CCC0D9;"  class="bordeleft1">Interior</td>
                        <td width=20% style="font-weight:bold; padding-left:3px;"  class="borde1" >Gramaje</td>
                        <td width=60% style="padding-left:3px;"  class="borde1">{{ $producto->gramajeinterior }}</td>
                    </tr>
                    <tr style="">
                        <td width=30% style="padding-left:3px;background-color: #CCC0D9;"  class="bordeleft1 bordebottom1"></td>
                        <td width=20% style="font-weight:bold; padding-left:3px;"  class="borde1" >Tinta</td>
                        <td width=60% style="padding-left:3px;" class="borde1"> {{ $producto->tintainterior }}</td>
                    </tr>
                    <tr style="">
                        <td width=30% style="padding-left:3px;background-color: #CCC0D9;"  class="bordeleft1"></td>
                        <td width=20% style="font-weight:bold; padding-left:3px;"  class="borde1" >Material</td>
                        <td width=60% style="padding-left:3px;" class="borde1" >{{ $producto->materialcubierta }}</td>
                    </tr>
                    <tr style="">
                        <td width=30% style="font-weight:bold; padding-left:3px;background-color: #CCC0D9;"  class="bordeleft1">Cubierta</td>
                        <td width=20% style="font-weight:bold; padding-left:3px;"  class="borde1" >Gramaje</td>
                        <td width=60% style="padding-left:3px;" class="borde1" >{{ $producto->gramajecubierta }}</td>
                    </tr>
                    <tr style="">
                        <td width=30% style="padding-left:3px;background-color: #CCC0D9;"  class="bordeleft1"></td>
                        <td width=20% style="font-weight:bold; padding-left:3px;"  class="borde1" >Tinta</td>
                        <td width=60% style="padding-left:3px;" class="borde1">{{ $producto->tintacubierta }}</td>
                    </tr>
                    <tr style="">
                        <td style="font-weight:bold; padding-left:3px;background-color: #CCC0D9;"  class="borde1">Encuadernación</td>
                        <td style="padding-left:3px;" class="borde1" colspan="2">{{ $producto->encuadernado }}</td>
                    </tr>
                    <tr style="">
                        <td style="font-weight:bold; padding-left:3px;background-color: #CCC0D9;"  class="borde1">Solapas</td>
                        <td style="padding-left:3px;" class="borde1" colspan="2">
                            <input type="checkbox" name="solapa" value="{{ $producto->solapa }}" {{ $producto->solapa=='1' ? 'checked' : ''  }} id="solapa">
                            {{ $producto->descripsolapa }}
                        </td>
                    </tr>
                    <tr style="">
                        <td style="font-weight:bold; padding-left:3px;background-color: #CCC0D9;"  class="borde1">Guardas</td>
                        <td style="padding-left:3px;" class="borde1" colspan="2">
                            <input type="checkbox" name="guardas" value="{{ $producto->guardas }}" {{ $producto->guardas=='1' ? 'checked' : ''  }} id="guardas">
                            {{ $producto->descripguardas }}
                        </td>
                    </tr>
                    <tr style="">
                        <td style="font-weight:bold; padding-left:3px;background-color: #CCC0D9;"  class="borde1">Novedad</td>
                        <td style="padding-left:3px;" class="borde1" colspan="2">
                            <input type="checkbox" name="novedad" value="{{ $producto->novedad }}" {{ $producto->novedad=='1' ? 'checked' : ''  }} id="novedad">
                            {{ $producto->descripnovedad }}
                        </td>
                    </tr>
                    <tr style="">
                        <td style="font-weight:bold; padding-left:3px;background-color: #CCC0D9;"  class="borde1">CD/DVD</td>
                        <td style="padding-left:3px;" class="borde1" colspan="2">
                            <input type="checkbox" name="cd" value="{{ $producto->cd }}" {{ $producto->cd=='1' ? 'checked' : ''  }} id="cd">
                            {{ $producto->descripcd }}
                        </td>
                    </tr>
                    <tr style="">
                        <td style="font-weight:bold; padding-left:3px;background-color: #CCC0D9;"  class="borde1">Modelo Caja</td>
                        <td style="padding-left:3px;" class="borde1" colspan="2">{{ $presupuesto->caja->name ?? ''}}</td>
                    </tr>
                    <tr style="">
                        <td style="font-weight:bold; padding-left:3px;background-color: #CCC0D9;"  class="borde1">Especificaciones logísticas</td>
                        <td style="padding-left:3px;" class="borde1" colspan="2">{{ $producto->especiflogistica }}</td>
                    </tr>
                    <tr style="">
                        <td style="font-weight:bold; padding-left:3px;background-color: #CCC0D9;"  class="borde1">Otros</td>
                        <td style="padding-left:3px;" class="borde1" colspan="2">{{ $producto->observaciones }}</td>
                    </tr>
                </table>
                {{-- @include('producto.ficha') --}}
            </div>
        </main>
    </body>
</html>
