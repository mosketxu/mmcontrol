<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $asunto }}</title>
</head>
{{-- Maqueta sencilla en línea (los clientes de correo no cargan CSS externo). Firma y pie: los de Milimétrica; el nombre es el del usuario que envía.
     Las imágenes van incrustadas en el correo (cid), así se ven aunque el cliente bloquee imágenes remotas. --}}
<body style="margin:0;padding:0;background:#ffffff;font-family:Arial,Helvetica,sans-serif;color:#1f2937">
    <div style="max-width:640px;padding:16px 20px;font-size:14px;line-height:1.5">
        <div>{!! nl2br(e($cuerpo)) !!}</div>

        {{-- Firma --}}
        <div style="margin-top:24px;font-size:13px;line-height:1.45">
            @if($firma !== '')<div style="font-weight:bold;font-size:14px">{{ $firma }}</div>@endif
            <div>Milimétrica Producciones S.L.</div>
            <div>C/ del Joncar 19, 5-1 Barcelona 08005</div>
            <div>T. 936 243 833</div>
            <div style="color:#6b7280">Outsourcing Printing Services &nbsp;/&nbsp; World Packaging</div>
            <div style="margin-top:10px"><img src="{{ $message->embed(public_path('img/mail/logo-milimetrica.png')) }}" alt="milimétrica" width="200" style="display:block;border:0"></div>
            <div style="margin-top:8px">
                <a href="http://www.encajabio.com/" style="text-decoration:none;color:#15803d;font-size:12px;font-weight:bold">
                    <img src="{{ $message->embed(public_path('img/mail/encajabio.png')) }}" alt="Encajabio · Packaging Circular Economy" width="110" style="display:block;border:0;margin-bottom:4px">
                    BIENVENID@ AL MUNDO DE LA IMPRESIÓN ECOLÓGICA Y SOSTENIBLE
                </a>
            </div>
        </div>

        {{-- Pie legal --}}
        <div style="margin-top:20px;padding-top:10px;border-top:1px solid #d1d5db;font-size:10px;line-height:1.35;color:#6b7280">
            <p style="margin:0 0 6px"><b>Aviso sobre confidencialidad:</b> Este mensaje se dirige exclusivamente a su destinatario. Puede contener información confidencial sometida a secreto profesional. Si no es usted el destinatario debe saber que la información contenida en este mensaje es reservada y su utilización o divulgación con cualquier fin está prohibida. Si ha recibido este documento por error, le rogamos que nos lo comunique y proceda a su destrucción.</p>
            <p style="margin:0 0 6px">MILIMETRICA PRODUCCIONES, S.L. con CIF B-63941835 responsable del tratamiento informa, de conformidad con lo establecido en el REGLAMENTO (UE) 2016/679, que su correo electrónico, así como otros datos de carácter personal son tratados con la finalidad de mantener un canal de comunicación electrónica con usted y poder atender cualquier información, duda, petición o consulta que precise por esta misma vía.</p>
            <p style="margin:0 0 6px">Podrá ejercer sus derechos de acceso, rectificación, limitación de tratamiento, supresión, portabilidad y oposición al tratamiento de sus datos de carácter personal, así como revocar los consentimientos que en su caso haya prestado u obtener más información, dirigiendo su petición a <a href="mailto:jmb@milimetrica.es" style="color:#6b7280">jmb@milimetrica.es</a></p>
            <p style="margin:0 0 6px"><b>Confidentiality Notice:</b> This message is intended exclusively for its recipient. It may contain confidential information subject to professional secrecy. If you are not the recipient, you should know that the information contained in this message is reserved and its use or disclosure for any purpose is prohibited. If you have received this document by mistake, we ask you to notify us and proceed with its destruction.</p>
            <p style="margin:0 0 6px">MILIMETRICA PRODUCCIONES, S.L. with CIF B-63941835, responsible for the treatment, informs, in accordance with the provisions of REGULATION (EU) 2016/679, that your email, as well as other personal data, are processed with the purpose of maintaining an electronic communication channel with you and being able to attend to any information, doubt, request or query that you need through this same channel.</p>
            <p style="margin:0">You may exercise your rights of access, rectification, limitation of treatment, deletion, portability and opposition to the processing of your personal data, as well as revoke the consents that you have given or obtain more information, directing your request to <a href="mailto:jmb@milimetrica.es" style="color:#6b7280">jmb@milimetrica.es</a></p>
        </div>
    </div>
</body>
</html>
