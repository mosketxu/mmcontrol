<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class AlbaranMail extends Mailable
{
    public function __construct(
        public string $asunto,
        public string $cuerpo,
        public string $pdfData,
        public string $pdfNombre,
        public array $extras = [], // [['path'=>..., 'name'=>..., 'mime'=>...]]
        public string $firma = '', // nombre de quien envía (usuario conectado), para la firma
        public array $desde = [],  // ['email'=>, 'name'=>] si se envía desde la cuenta del usuario
    ) {}


    /** Correo del negocio: en la réplica va a MAIL_ALWAYS_TO (App\Listeners\RedirigirCorreoPruebas). */
    private function marcarNegocio(): void
    {
        $this->withSymfonyMessage(fn ($m) => $m->getHeaders()->addTextHeader('X-MM-Tipo', 'negocio'));
    }

    public function build()
    {
        $this->marcarNegocio();
        if ($this->desde) $this->from($this->desde['email'], $this->desde['name'] ?? null);
        $m = $this->subject($this->asunto)
            ->view('emails.albaran')
            ->attachData($this->pdfData, $this->pdfNombre, ['mime' => 'application/pdf']);
        foreach ($this->extras as $e) {
            $m->attach($e['path'], ['as' => $e['name'], 'mime' => $e['mime'] ?? null]);
        }
        return $m;
    }
}
