<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $asunto }}</title>
</head>
{{-- PENDIENTE: adaptar la estética a la del correo que facilite Mireia. Mientras, maqueta sencilla en línea (los clientes de correo no cargan CSS externo). --}}
<body style="margin:0;padding:0;background:#f3f4f6;font-family:Arial,Helvetica,sans-serif;color:#1f2937">
    <table width="100%" cellpadding="0" cellspacing="0" style="background:#f3f4f6;padding:20px 0">
        <tr><td align="center">
            <table width="600" cellpadding="0" cellspacing="0" style="background:#ffffff;border-radius:6px;overflow:hidden">
                <tr><td style="padding:20px 28px;border-bottom:3px solid #2563eb">
                    <img src="{{ asset('img/milimetricatexto.png') }}" alt="milimétrica" width="180">
                </td></tr>
                <tr><td style="padding:24px 28px;font-size:14px;line-height:1.5">
                    {!! nl2br(e($cuerpo)) !!}
                </td></tr>
                <tr><td style="padding:14px 28px;background:#f9fafb;font-size:11px;color:#6b7280">
                    Milimétrica Producciones, S.L. · C/ del Joncar 19, planta 5 · 08005 Barcelona · www.milimetrica.es
                </td></tr>
            </table>
        </td></tr>
    </table>
</body>
</html>
