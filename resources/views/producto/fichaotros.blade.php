            <table width="80%" style="margin-top:10px; " cellspacing="0" cellpadding="2" class="tablacentrada">
                <tr  >
                    <td width=25% style="font-weight:bold; padding-left:3px;background-color: #CCC0D9;"  class="borde1" >Cliente</td>
                    <td style="padding-left:3px; background-color: #E5DFEC;"  class="borde1" colspan="2">{{ $producto->cliente->entidad }}</td>
                </tr>
                <tr style="">
                    <td style="font-weight:bold; padding-left:3px;background-color: #CCC0D9;"  class="borde1">Cod./Ref</td>
                    <td style="padding-left:3px;background-color: #E5DFEC;"  class="borde1" colspan="2">{{ $producto->isbn }}</td>
                </tr>
                <tr style="">
                    <td style="font-weight:bold; padding-left:3px;background-color: #CCC0D9;"  class="borde1">Descripción</td>
                    <td style="padding-left:3px; background-color: #E5DFEC;"  class="borde1" colspan="2">{{ $producto->referencia }}</td>
                </tr>
                <tr style="">
                    <td style="font-weight:bold; padding-left:3px;background-color: #CCC0D9;" class="borde1">Material</td>
                    <td style="padding-left:3px;" class="borde1" colspan="2">{{ $producto->material }}</td>
                </tr>
                <tr style="">
                    <td style="font-weight:bold; padding-left:3px;background-color: #CCC0D9;"  class="borde1">Medidas</td>
                    <td style=" padding-left:3px;" class="borde1" colspan="2">{{ $producto->medidas }}</td>
                </tr>
                <tr style="">
                    <td style="font-weight:bold; padding-left:3px;background-color: #CCC0D9;"  class="borde1">Impresión</td>
                    <td style=" padding-left:3px;" class="borde1" colspan="2">{{ $producto->impresion }}</td>
                </tr>
                <tr style="">
                    <td style="font-weight:bold; padding-left:3px;background-color: #CCC0D9;"  class="borde1">Troquel</td>
                    <td style="padding-left:3px;" class="borde1" colspan="2">{{ $producto->troquel }}</td>
                </tr>
                <tr style="">
                    <td style="font-weight:bold; padding-left:3px;background-color: #CCC0D9;"  class="borde1">Precio Coste</td>
                    <td style="padding-left:3px;" class="borde1" colspan="2">{{ $producto->preciocoste }}</td>
                </tr>
                <tr style="">
                    <td style="font-weight:bold; padding-left:3px;background-color: #CCC0D9;"  class="borde1">Precio Venta</td>
                    <td style="padding-left:3px;" class="borde1" colspan="2">{{ $producto->precioventa }}</td>
                </tr>
                <tr style="">
                    <td style="font-weight:bold; padding-left:3px;background-color: #CCC0D9;"  class="borde1">Otros</td>
                    <td style="padding-left:3px;" class="borde1" colspan="2">{{ $producto->observaciones }}</td>
                </tr>
            </table>
