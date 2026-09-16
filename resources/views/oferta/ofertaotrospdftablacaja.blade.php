@php
    // "0" es el valor por defecto de estos campos cuando no se han rellenado
    // (igual que la cantidad de una linea nueva empieza en '0'), asi que se
    // trata como "vacio" y no se muestra su etiqueta.
    $campos = array_filter([
        'Caja' => $p->caja?->name,
        'Medidas caja' => $p->medidas,
        'Desarrollo caja' => $p->desarrollocaja,
        'Material' => $p->material,
        'Gramaje' => $p->gramajecaja,
        'Impresión' => $p->impresion,
        'Acabado' => $p->acabadocaja,
    ], fn($v) => $v !== null && $v !== '' && $v !== '0');
@endphp
@if(count($campos) > 0)
<table width="100%" cellpadding="2" cellspacing="0" style="page-break-inside: avoid;">
    <tr>
        <td colspan="4" style="background-color:#EFF6FF; border-bottom:1px solid #93C5FD; padding:3px 4px;"><strong>Datos Caja</strong></td>
    </tr>
    @foreach(array_chunk($campos, 2, true) as $par)
    <tr>
        @foreach($par as $etiqueta => $valor)
        <td width="20%" valign="top"><strong>{{ $etiqueta }}:</strong></td>
        <td width="30%" valign="top">{{ $valor }}</td>
        @endforeach
        @if(count($par) == 1)
        <td width="20%"></td>
        <td width="30%"></td>
        @endif
    </tr>
    @endforeach
</table>
@endif
