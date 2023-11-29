<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MilimetricaMail extends Mailable
{
    use Queueable, SerializesModels;
    public $details;
    public $presupuesto;
    public $emailmilimetrica;
    public $emailexterno;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($presupuesto,$details)
    {
        $this->details=$details;
        $this->presupuesto=$presupuesto;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // dd($this->details['emailexterno']);

        // dd($this->details['emailexterno']);

        // return $this->from($this->details['emailexterno'], config('mail.from.name', 'Externo'))
        return $this->to($this->details['emailmilimetrica'])
            ->subject($this->details['subject'])
            ->view('emails.milimetricamail');

    }
}
