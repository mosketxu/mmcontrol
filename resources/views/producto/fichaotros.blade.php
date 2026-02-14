<table width="80%" style="margin-top:10px; " cellspacing="0" cellpadding="2" class="tablacentrada">
    <tr  >
        <td width="25%" style="font-weight:bold; padding-left:3px;background-color: #CCC0D9;"  class="borde1" >Cliente</td>
        <td style="padding-left:3px; background-color: #E5DFEC;"  class="borde1" colspan="2">{{ $producto->cliente->entidad }}</td>
    </tr>
    <tr style="">
        <td style="font-weight:bold; padding-left:3px;background-color: #CCC0D9;"  class="borde1">Cod.</td>
        <td style="padding-left:3px;background-color: #E5DFEC;"  class="borde1" colspan="2">{{ $producto->isbn }}</td>
    </tr>
    <tr style="">
        <td style="font-weight:bold; padding-left:3px;background-color: #CCC0D9;"   class="borde1">Referencia</td>
        <td style="padding-left:3px; background-color: #E5DFEC;"  class="borde1" colspan="2">{{ $producto->referencia }}</td>
    </tr>
    <tr style="margin-top=10px;font-weight: bold; ">
        <td style="font-weight:bold; padding-left:3px;" colspan="3" class="">Datos Caja</td>
    </tr>
    <tr style="">
        <td style="font-weight:bold; padding-left:3px;background-color: #CCC0D9;" class="borde1">Caja</td>
        <td style="padding-left:3px;" class="borde1" colspan="2">{{ $producto->caja->name?? '-' }}</td>
    </tr>
    <tr style="">
        <td style="font-weight:bold; padding-left:3px;background-color: #CCC0D9;"  class="borde1">Medidas (LxAxH)</td>
        <td style=" padding-left:3px;" class="borde1" colspan="2">{{ $producto->medidas }}</td>
    </tr>
    <tr style="">
        <td style="font-weight:bold; padding-left:3px;background-color: #CCC0D9;"  class="borde1">Desarrollo</td>
        <td style=" padding-left:3px;" class="borde1" colspan="2">{{ $producto->desarrollocaja }}</td>
    </tr>
    <tr style="">
        <td style="font-weight:bold; padding-left:3px;background-color: #CCC0D9;"  class="borde1">Material</td>
        <td style=" padding-left:3px;" class="borde1" colspan="2">{{ $producto->material }}</td>
    </tr>
    <tr style="">
        <td style="font-weight:bold; padding-left:3px;background-color: #CCC0D9;"  class="borde1">Gramaje</td>
        <td style=" padding-left:3px;" class="borde1" colspan="2">{{ $producto->gramajecaja }}</td>
    </tr>
    <tr style="">
        <td style="font-weight:bold; padding-left:3px;background-color: #CCC0D9;"  class="borde1">Impresión</td>
        <td style=" padding-left:3px;" class="borde1" colspan="2">{{ $producto->impresion }}</td>
    </tr>
    <tr style="">
        <td style="font-weight:bold; padding-left:3px;background-color: #CCC0D9;"  class="borde1">Acabado</td>
        <td style=" padding-left:3px;" class="borde1" colspan="2">{{ $producto->acabadocaja }}</td>
    </tr>
    <tr style="margin-top=10px;font-weight: bold; ">
        <td style="font-weight:bold; padding-left:3px;" colspan="3" class="">Datos Nido</td>
    </tr>
    <tr style="">
        <td style="font-weight:bold; padding-left:3px;background-color: #CCC0D9;"  class="borde1">Medidas</td>
        <td style=" padding-left:3px;" class="borde1" colspan="2">{{ $producto->medidasnido }}</td>
    </tr>
    <tr style="">
        <td style="font-weight:bold; padding-left:3px;background-color: #CCC0D9;"  class="borde1">Material</td>
        <td style=" padding-left:3px;" class="borde1" colspan="2">{{ $producto->materialnido }}</td>
    </tr>
    <tr style="">
        <td style="font-weight:bold; padding-left:3px;background-color: #CCC0D9;"  class="borde1">Impresión</td>
        <td style=" padding-left:3px;" class="borde1" colspan="2">{{ $producto->impresionnido }}</td>
    </tr>
    <tr style="margin-top=10px;font-weight: bold; ">
        <td style="font-weight:bold; padding-left:3px;" colspan="3" class="">Otros</td>
    </tr>
    <tr style="">
        <td style="font-weight:bold; padding-left:3px;background-color: #CCC0D9;"  class="borde1">Procesos</td>
        <td style="padding-left:3px;" class="borde1" colspan="2">
            <p>{!! nl2br(e($producto->procesospack)) !!}</p>
        </td>
    </tr>
    <tr style="">
        <td style="font-weight:bold; padding-left:3px;background-color: #CCC0D9;"  class="borde1">Manipulación</td>
        <td style="padding-left:3px;" class="borde1" colspan="2">
            <p>{!! nl2br(e($producto->manipulacion)) !!}</p>
        </td>
    </tr>
    <tr style="margin-top=10px;font-weight: bold; ">
        <td style="font-weight:bold; padding-left:3px;" colspan="3" class=""></td>
    </tr>
    <tr style="">
        <td style="font-weight:bold; padding-left:3px;background-color: #CCC0D9;"  class="borde1">Observaciones</td>
        <td style="padding-left:3px;" class="borde1" colspan="2">
            <p>{!! nl2br(e($producto->observaciones)) !!}</p>
        </td>
    </tr>
</table>

