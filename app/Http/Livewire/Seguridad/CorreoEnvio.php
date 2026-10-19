<?php

namespace App\Http\Livewire\Seguridad;

use App\Support\CorreoUsuario;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

// Perfil: contraseña del correo del propio usuario para enviar desde su cuenta y que la copia quede en su Enviados.
class CorreoEnvio extends Component
{
    public $clave = '';
    public $error = '';
    public $ok = '';

    public function guardar()
    {
        $this->error = $this->ok = '';
        $u = Auth::user();
        if (trim($this->clave) === '') { $this->error = 'Escribe la contraseña de tu correo.'; return; }
        $error = CorreoUsuario::probar($u->email, $this->clave);
        if ($error) { $this->error = $error; return; }
        $u->forceFill(['mail_password' => $this->clave, 'mail_rechazado' => false])->save();
        $this->clave = '';
        $this->ok = 'Guardada (encriptada). Los correos saldrán desde tu cuenta y quedarán en tu carpeta de Enviados.';
    }

    public function quitar()
    {
        Auth::user()->forceFill(['mail_password' => null, 'mail_rechazado' => true])->save();
        $this->error = '';
        $this->ok = 'Contraseña eliminada. Los correos saldrán por el correo por defecto.';
    }

    public function render()
    {
        $u = Auth::user();
        return view('livewire.seguridad.correo-envio', [
            'visible' => CorreoUsuario::activo() && CorreoUsuario::cuentaPropia($u),
            'tiene' => (bool) $u->mail_password,
            'porDefecto' => config('mail.from.address'),
        ]);
    }
}
