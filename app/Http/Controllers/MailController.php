<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\TestMail;

class MailController extends Controller
{
    public function sendEmail() {
        $details=[
            'title'=>'Correo de google',
            'body'=>'El cuerpo'
        ];
        Mail::to("alex.arregui@sumaempresa.com")->send(new TestMail($details));
        return "Correo enviado";

    }
}
