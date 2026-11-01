<?php

namespace App\Listeners;

use Illuminate\Mail\Events\MessageSending;
use Symfony\Component\Mime\Address;

/**
 * Solo en la réplica de pruebas (si MAIL_ALWAYS_TO está definido): ningún correo sale a terceros.
 *  - Correos del negocio (albaranes, presupuestos…; cabecera X-MM-Tipo: negocio) → MAIL_ALWAYS_TO (Mireia).
 *  - Correos de cuenta (¿Olvidaste tu contraseña?): a quien lo pide si existe como usuario en la BD
 *    (sea cliente o de Milimétrica); si no → MAIL_TECNICO_TO.
 *  - Todo lo demás (pruebas, avisos o fallos de la aplicación) → MAIL_TECNICO_TO (Alex).
 * En producción MAIL_ALWAYS_TO no está definido y este listener no toca nada.
 */
class RedirigirCorreoPruebas
{
    public function handle(MessageSending $event): void
    {
        $negocio = config('mail.always_to');
        if (!$negocio) return;
        $tecnico = config('mail.tecnico_to') ?: $negocio;

        $m = $event->message;
        $h = $m->getHeaders();
        $tipo = $h->has('X-MM-Tipo') ? $h->get('X-MM-Tipo')->getBodyAsString() : null;
        $h->remove('X-MM-Tipo');

        if ($tipo === 'negocio') {
            $destino = [$negocio];
        } elseif (!empty($event->data['__laravel_notification']) && str_contains($event->data['__laravel_notification'], 'ResetPassword')) {
            $todos = array_merge($m->getTo(), $m->getCc(), $m->getBcc());
            $esUsuario = fn (Address $a) => \App\Models\User::where('email', $a->getAddress())->exists();
            $destino = ($todos && count(array_filter($todos, $esUsuario)) === count($todos)) ? null : [$tecnico];
        } else {
            $destino = [$tecnico];
        }

        if ($destino === null) return; // se queda como está (usuario de la aplicación)
        $original = implode(', ', array_map(fn (Address $a) => $a->getAddress(), $m->getTo()));
        $m->to(...$destino);
        if ($m->getCc()) $m->cc();
        if ($m->getBcc()) $m->bcc();
        $h->remove('Cc');
        $h->remove('Bcc');
        if ($original) $h->addTextHeader('X-MM-Para-Original', $original);
    }
}
