<?php

namespace App\Support;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use RuntimeException;
use Symfony\Component\Mailer\SentMessage;
use Symfony\Component\Mailer\Transport\AbstractTransport;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\MessageConverter;

/**
 * Transporte de correo por Microsoft Graph (igual que Appmos): MAIL_MAILER=graph.
 * Envía desde GRAPH_SENDER con la app de Graph de Suma (credenciales GRAPH_* en el .env).
 * Lo usan el «¿Olvidaste tu contraseña?», los avisos y todo lo que va por el mailer por defecto.
 * Los albaranes y facturas siguen saliendo con la cuenta de cada usuario (CorreoUsuario).
 */
class GraphTransport extends AbstractTransport
{
    public function __construct(private array $cfg)
    {
        parent::__construct();
    }

    private function token(): string
    {
        return Cache::remember('graph_token_mmcontrol', 3000, function () {
            $r = Http::asForm()->timeout(30)->post('https://login.microsoftonline.com/' . $this->cfg['tenant_id'] . '/oauth2/v2.0/token', [
                'client_id' => $this->cfg['client_id'],
                'client_secret' => $this->cfg['client_secret'],
                'scope' => 'https://graph.microsoft.com/.default',
                'grant_type' => 'client_credentials',
            ]);
            if (!$r->successful() || !$r->json('access_token')) {
                throw new RuntimeException('Graph: no se ha podido obtener el token: ' . mb_substr($r->body(), 0, 200));
            }
            return $r->json('access_token');
        });
    }

    private static function dirs(array $lista): array
    {
        return array_map(fn (Address $a) => ['emailAddress' => array_filter(['address' => $a->getAddress(), 'name' => $a->getName()])], $lista);
    }

    protected function doSend(SentMessage $message): void
    {
        $email = MessageConverter::toEmail($message->getOriginalMessage());
        $html = $email->getHtmlBody();
        $msg = [
            'subject' => (string) $email->getSubject(),
            'body' => $html !== null
                ? ['contentType' => 'HTML', 'content' => is_resource($html) ? stream_get_contents($html) : (string) $html]
                : ['contentType' => 'Text', 'content' => (string) (is_resource($t = $email->getTextBody()) ? stream_get_contents($t) : $t)],
            'toRecipients' => self::dirs($email->getTo()),
        ];
        if ($email->getCc()) $msg['ccRecipients'] = self::dirs($email->getCc());
        if ($email->getBcc()) $msg['bccRecipients'] = self::dirs($email->getBcc());
        if ($email->getReplyTo()) $msg['replyTo'] = self::dirs($email->getReplyTo());
        foreach ($email->getAttachments() as $adj) {
            $msg['attachments'][] = [
                '@odata.type' => '#microsoft.graph.fileAttachment',
                'name' => $adj->getFilename() ?: 'adjunto',
                'contentType' => $adj->getMediaType() . '/' . $adj->getMediaSubtype(),
                'contentBytes' => base64_encode($adj->getBody()),
            ];
        }
        $r = Http::withToken($this->token())->timeout(60)
            ->post('https://graph.microsoft.com/v1.0/users/' . rawurlencode($this->cfg['sender']) . '/sendMail', ['message' => $msg, 'saveToSentItems' => true]);
        if (!$r->successful()) {
            throw new RuntimeException('Graph: no se ha podido enviar (' . $r->status() . '): ' . mb_substr($r->body(), 0, 300));
        }
    }

    public function __toString(): string
    {
        return 'graph';
    }
}
