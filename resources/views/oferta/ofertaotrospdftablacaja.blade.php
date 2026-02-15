<table width="100%" cellpadding="2" cellspacing="0" style="page-break-inside: avoid;">
    <tr>
        <td colspan="2"><strong>Datos Caja</strong></td>
    </tr>

    @if($p->caja->name!='')
    <tr>
        <td width="30%"><strong>Caja:</strong></td>
        <td>{{ $p->caja->name }}</td>
    </tr>
    @endif

    @if($p->medidas!='')
    <tr>
        <td><strong>Medidas caja:</strong></td>
        <td>{{ $p->medidas }}</td>
    </tr>
    @endif

    @if($p->desarrollocaja!='')
    <tr>
        <td><strong>Desarrollo caja:</strong></td>
        <td>{{ $p->desarrollocaja }}</td>
    </tr>
    @endif

    @if($p->material!='')
    <tr>
        <td><strong>Material:</strong></td>
        <td>{{ $p->material }}</td>
    </tr>
    @endif

    @if($p->gramajecaja!='')
    <tr>
        <td><strong>Gramaje:</strong></td>
        <td>{{ $p->gramajecaja }}</td>
    </tr>
    @endif

    @if($p->impresion!='')
    <tr>
        <td><strong>Impresión:</strong></td>
        <td>{{ $p->impresion }}</td>
    </tr>
    @endif

    @if($p->acabadocaja!='')
    <tr>
        <td><strong>Acabado:</strong></td>
        <td>{{ $p->acabadocaja }}</td>
    </tr>
    @endif
</table>
