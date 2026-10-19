<?php

namespace App\Support;

use App\Models\User;
use Illuminate\Support\Facades\Mail;

/**
 * Envío de correo con la cuenta del propio usuario y copia en su carpeta de Enviados (IMAP).
 *  - Con contraseña guardada (encriptada) y buzón del dominio configurado: sale desde su cuenta y la copia va a SU Enviados.
 *  - Si no (no la ha dado o dijo «ahora no»): sale por el correo por defecto (MAIL_* del .env) y la copia va al Enviados de ese buzón.
 * Configuración en config/mail.php → 'usuario'. Apagado si no hay smtp_host/imap_host.
 */
class CorreoUsuario
{
    public static function activo(): bool
    {
        return (bool) (config('mail.usuario.smtp_host') && config('mail.usuario.imap_host'));
    }

    /** El email del usuario es un buzón del dominio configurado (único caso en que puede usar su propia cuenta). */
    public static function cuentaPropia(User $u): bool
    {
        $dom = strtolower((string) config('mail.usuario.dominio'));
        return $dom !== '' && str_ends_with(strtolower((string) $u->email), '@' . $dom);
    }

    public static function usaCuentaPropia(User $u): bool
    {
        return self::activo() && self::cuentaPropia($u) && $u->mail_password;
    }

    /** Hay que pedirle la contraseña (primera vez que envía): puede darla o decir «ahora no». */
    public static function debePreguntar(User $u): bool
    {
        return self::activo() && self::cuentaPropia($u) && !$u->mail_password && !$u->mail_rechazado;
    }

    public static function desde(User $u): string
    {
        return self::usaCuentaPropia($u) ? $u->email : (string) config('mail.from.address');
    }

    /** Comprueba usuario y contraseña contra el servidor de correo. null = correcto; si no, el motivo. */
    public static function probar(string $email, string $clave): ?string
    {
        try {
            $imap = new ImapMinimo(config('mail.usuario.imap_host'), (int) config('mail.usuario.imap_port'));
            $imap->login($email, $clave);
            $imap->cerrar();
            return null;
        } catch (\Throwable $e) {
            return $e->getMessage();
        }
    }

    /**
     * Envía y guarda la copia en Enviados. Devuelve ['desde'=>email, 'copia'=>bool, 'aviso'=>string|null].
     * Si el envío falla lanza la excepción; si solo falla la copia, el correo ya ha salido y se avisa en 'aviso'.
     */
    public static function enviar(User $u, array $emails, $mailable): array
    {
        $propia = self::usaCuentaPropia($u);
        if ($propia) {
            $cfg = config('mail.usuario');
            $mailer = Mail::build([
                'transport' => 'smtp', 'host' => $cfg['smtp_host'], 'port' => $cfg['smtp_port'], 'encryption' => $cfg['encryption'],
                'username' => $u->email, 'password' => $u->mail_password, 'timeout' => 30, 'verify_peer' => false,
            ]);
            if (config('mail.always_to')) $mailer->alwaysTo(config('mail.always_to')); // las pruebas nunca salen a terceros
            $mailable->desde = ['email' => $u->email, 'name' => $u->name];
            $user = $u->email;
            $clave = $u->mail_password;
        } else {
            $mailer = Mail::mailer();
            $user = config('mail.mailers.smtp.username');
            $clave = config('mail.mailers.smtp.password');
        }

        $sent = $mailer->to($emails)->send($mailable);
        $res = ['desde' => $propia ? $u->email : (string) config('mail.from.address'), 'copia' => false, 'aviso' => null];

        if (config('mail.usuario.imap_host') && $user && $clave && $sent) {
            try {
                $imap = new ImapMinimo(config('mail.usuario.imap_host'), (int) config('mail.usuario.imap_port'));
                $imap->login($user, $clave);
                $imap->guardarEnEnviados($sent->toString(), config('mail.usuario.carpeta_enviados'));
                $imap->cerrar();
                $res['copia'] = true;
            } catch (\Throwable $e) {
                $res['aviso'] = 'El correo salió, pero no se pudo guardar la copia en Enviados: ' . $e->getMessage();
                report($e);
            }
        }
        return $res;
    }
}
