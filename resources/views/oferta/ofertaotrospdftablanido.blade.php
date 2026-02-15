@php $p = $oferta->ofertaproducto; @endphp

<table width="100%" cellpadding="2" cellspacing="0" style="page-break-inside: avoid;">
    <tr>
        <td colspan="2"><strong>Datos Nido</strong></td>
    </tr>

    @if($p->medidasnido!='')
    <tr>
        <td width="30%"><strong>Medidas:</strong></td>
        <td>{{ $p->medidasnido }}</td>
    </tr>
    @endif

    @if($p->materialnido!='')
    <tr>
        <td><strong>Material:</strong></td>
        <td>{{ $p->materialnido }}</td>
    </tr>
    @endif

    @if($p->impresionnido!='')
    <tr>
        <td><strong>Impresión:</strong></td>
        <td>{{ $p->impresionnido }}</td>
    </tr>
    @endif
</table>
