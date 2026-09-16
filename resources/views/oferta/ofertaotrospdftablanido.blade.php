@php
    // "0" es el valor por defecto cuando no se ha rellenado (ver comentario
    // en ofertaotrospdftablacaja.blade.php).
    $campos = array_filter([
        'Medidas' => $p->medidasnido,
        'Material' => $p->materialnido,
        'Impresión' => $p->impresionnido,
    ], fn($v) => $v !== null && $v !== '' && $v !== '0');
@endphp
@if(count($campos) > 0)
<table width="100%" cellpadding="2" cellspacing="0" style="page-break-inside: avoid;">
    <tr>
        <td colspan="4"><span style="background-color:#F1F5F9; padding:2px 7px; border-radius:3px;"><strong>Datos Nido</strong></span></td>
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
