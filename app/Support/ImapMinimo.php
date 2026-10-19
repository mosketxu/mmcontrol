<?php

namespace App\Support;

/** Cliente IMAP mínimo (sin extensión php-imap): login, localizar la carpeta de Enviados y APPEND. */
class ImapMinimo
{
    private $f;
    private int $n = 0;

    public function __construct(string $host, int $puerto = 993)
    {
        $ctx = stream_context_create(['ssl' => ['verify_peer' => false, 'verify_peer_name' => false]]);
        $this->f = @stream_socket_client("ssl://$host:$puerto", $errno, $err, 15, STREAM_CLIENT_CONNECT, $ctx);
        if (!$this->f) throw new \RuntimeException("No se pudo conectar con el servidor de correo ($host:$puerto): $err");
        stream_set_timeout($this->f, 20);
        fgets($this->f); // saludo
    }

    private function cmd(string $c, ?callable $literal = null): array
    {
        $tag = 'A' . (++$this->n);
        fwrite($this->f, "$tag $c\r\n");
        $lineas = [];
        while (($l = fgets($this->f)) !== false) {
            if ($literal && str_starts_with($l, '+')) { $literal(); $literal = null; continue; }
            if (str_starts_with($l, "$tag ")) {
                if (!preg_match("/^$tag OK/i", $l)) throw new \RuntimeException(trim(substr($l, strlen($tag) + 1)));
                return $lineas;
            }
            $lineas[] = rtrim($l);
        }
        throw new \RuntimeException('El servidor de correo no respondió.');
    }

    private static function q(string $s): string
    {
        return '"' . addcslashes($s, "\\\"") . '"';
    }

    public function login(string $user, string $clave): void
    {
        try {
            $this->cmd('LOGIN ' . self::q($user) . ' ' . self::q($clave));
        } catch (\RuntimeException $e) {
            throw new \RuntimeException('Usuario o contraseña de correo incorrectos.');
        }
    }

    public function carpetaEnviados(?string $forzada = null): string
    {
        if ($forzada) return $forzada;
        $lineas = $this->cmd('LIST "" "*"');
        $nombres = [];
        foreach ($lineas as $l) {
            if (preg_match('/^\* LIST \(([^)]*)\) (?:"[^"]*"|NIL) (?:"([^"]*)"|(\S+))/', $l, $m)) {
                $nombre = $m[2] !== '' ? $m[2] : $m[3];
                if (stripos($m[1], '\\Sent') !== false) return $nombre;
                $nombres[] = $nombre;
            }
        }
        foreach (['Sent', 'INBOX.Sent', 'Enviados', 'INBOX.Enviados', 'Sent Items', 'Elementos enviados', 'Sent Messages'] as $c) {
            if (in_array($c, $nombres, true)) return $c;
        }
        $this->cmd('CREATE "Sent"');
        return 'Sent';
    }

    public function guardarEnEnviados(string $mime, ?string $carpeta = null): void
    {
        $carpeta = $this->carpetaEnviados($carpeta);
        $mime = preg_replace('/\r?\n/', "\r\n", $mime);
        $this->cmd('APPEND ' . self::q($carpeta) . ' (\\Seen) {' . strlen($mime) . '}', function () use ($mime) {
            fwrite($this->f, $mime . "\r\n");
        });
    }

    public function cerrar(): void
    {
        try { fwrite($this->f, 'A' . (++$this->n) . " LOGOUT\r\n"); fclose($this->f); } catch (\Throwable $e) {}
    }
}
