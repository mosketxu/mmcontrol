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
    ) {}

    public function build()
    {
        $m = $this->subject($this->asunto)
            ->view('emails.albaran')
            ->attachData($this->pdfData, $this->pdfNombre, ['mime' => 'application/pdf']);
        foreach ($this->extras as $e) {
            $m->attach($e['path'], ['as' => $e['name'], 'mime' => $e['mime'] ?? null]);
        }
        return $m;
    }
}
