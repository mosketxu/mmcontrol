<?php

namespace App\Http\Livewire\Pedido;

use App\Http\Controllers\PedidoController;
use App\Mail\AlbaranMail;
use App\Models\AlbaranEnvio;
use App\Models\Entidad;
use App\Models\EntidadContacto;
use App\Models\Pedido;
use App\Models\PedidoParcial;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use Livewire\WithFileUploads;

// Envío por email del albarán a los contactos del proveedor del pedido.
class PedidoParcialEmail extends Component
{
    use WithFileUploads;

    public $pedidoid;
    public $parcialid;
    public $ruta;

    public $destinatarios = [];   // [['nombre'=>, 'email'=>, 'activo'=>bool]]
    public $nuevoNombre = '';
    public $nuevoEmail = '';
    public $asunto = '';
    public $mensaje = '';
    public $valorado = '0';       // al proveedor, por defecto sin precios
    public $adjuntos = [];        // ficheros subidos desde el ordenador
    public $confirmando = false;  // segundo paso: resumen antes del envío real
    public $enviadoOk = false;

    public function mount($pedidoid, $parcialid, $ruta)
    {
        $this->pedidoid = $pedidoid;
        $this->parcialid = $parcialid;
        $this->ruta = $ruta;

        $pedido = Pedido::find($pedidoid);
        $parcial = PedidoParcial::find($parcialid);

        if ($pedido && $pedido->proveedor_id) {
            $prov = Entidad::find($pedido->proveedor_id);
            if ($prov && $prov->emailgral) {
                $this->destinatarios[] = ['nombre' => $prov->entidad . ' (general)', 'email' => $prov->emailgral, 'activo' => true];
            }
            $contactos = EntidadContacto::with('entidadcontacto')->where('entidad_id', $pedido->proveedor_id)->get();
            foreach ($contactos as $c) {
                $e = $c->entidadcontacto;
                if (!$e) continue;
                $mail = $e->emailgral ?: ($e->emailadm ?: $e->emailaux);
                if ($mail && !collect($this->destinatarios)->contains('email', $mail)) {
                    $this->destinatarios[] = ['nombre' => $e->entidad . ($c->departamento ? ' · ' . $c->departamento : ''), 'email' => $mail, 'activo' => true];
                }
            }
        }

        $cfg = config('albaran_email');
        $r = $this->marcadores($pedido, $parcial);
        $this->asunto = strtr($cfg['asunto'], $r);
        $this->mensaje = strtr($cfg['cuerpo'], $r);
    }

    protected function marcadores($pedido, $parcial): array
    {
        $destino = trim(implode("\n", array_filter([
            $parcial->destino ?? '',
            $parcial->atencion ? 'Att.: ' . $parcial->atencion : '',
            $parcial->direccion ?? '',
            trim(($parcial->localidad ?? '') . ($parcial->cp ? ' (' . $parcial->cp . ')' : '')),
            $parcial->horario ? 'Horario: ' . $parcial->horario : '',
            $parcial->tfno ? 'Tfno.: ' . $parcial->tfno : '',
        ])));
        $pp = $pedido?->pedidoproductos()->with('producto')->first();
        return [
            '{albaran}' => $parcial->id ?? '',
            '{pedido}' => $pedido->id ?? '',
            '{cliente}' => optional($pedido?->cliente)->entidad ?? '',
            '{destino}' => $destino,
            '{fecha}' => $parcial->ffecha ?? '',
            '{referencia}' => optional(optional($pp)->producto)->referencia ?: ($pedido->descripcion ?? ''),
        ];
    }

    public function render()
    {
        $envios = AlbaranEnvio::where('parcial_id', $this->parcialid)->latest('enviado_at')->get();
        $pedido = Pedido::find($this->pedidoid);
        $proveedor = $pedido && $pedido->proveedor_id ? Entidad::find($pedido->proveedor_id) : null;
        return view('livewire.pedido.pedido-parcial-email', compact('envios', 'proveedor'));
    }

    public function anadir()
    {
        $this->validate(['nuevoEmail' => 'required|email'], ['nuevoEmail.required' => 'Escribe un email.', 'nuevoEmail.email' => 'El email no es válido.']);
        if (collect($this->destinatarios)->contains('email', $this->nuevoEmail)) {
            $this->addError('nuevoEmail', 'Ese email ya está en la lista.');
            return;
        }
        $this->destinatarios[] = ['nombre' => $this->nuevoNombre ?: $this->nuevoEmail, 'email' => $this->nuevoEmail, 'activo' => true];
        $this->nuevoNombre = $this->nuevoEmail = '';
        $this->confirmando = false;
    }

    public function quitar($i)
    {
        unset($this->destinatarios[$i]);
        $this->destinatarios = array_values($this->destinatarios);
        $this->confirmando = false;
    }

    public function quitarAdjunto($i)
    {
        unset($this->adjuntos[$i]);
        $this->adjuntos = array_values($this->adjuntos);
    }

    protected function emailsActivos(): array
    {
        return collect($this->destinatarios)->where('activo', true)->pluck('email')->unique()->values()->all();
    }

    // Paso 1: valida y enseña el resumen.
    public function preparar()
    {
        $this->resetErrorBag();
        if (!$this->emailsActivos()) {
            $this->addError('destinatarios', 'Marca o añade al menos un destinatario.');
            return;
        }
        $this->validate([
            'asunto' => 'required|max:200',
            'mensaje' => 'required',
            'adjuntos.*' => 'file|max:10240',
        ], ['asunto.required' => 'El asunto es necesario.', 'mensaje.required' => 'El mensaje es necesario.', 'adjuntos.*.max' => 'Cada adjunto puede pesar hasta 10 MB.']);
        $this->confirmando = true;
    }

    public function cancelar()
    {
        $this->confirmando = false;
    }

    // Paso 2: envío real (solo si se ha pasado por el resumen).
    public function enviar()
    {
        if (!$this->confirmando) return;
        $emails = $this->emailsActivos();
        if (!$emails) { $this->confirmando = false; return; }

        $pdf = app(PedidoController::class)->albaranPdf($this->parcialid, (bool) $this->valorado)->output();
        $nombrePdf = 'albaran-' . $this->parcialid . ($this->valorado ? '' : '-sin-valorar') . '.pdf';

        $extras = [];
        foreach ($this->adjuntos as $f) {
            $extras[] = ['path' => $f->getRealPath(), 'name' => $f->getClientOriginalName(), 'mime' => $f->getMimeType()];
        }

        Mail::to($emails)->send(new AlbaranMail($this->asunto, $this->mensaje, $pdf, $nombrePdf, $extras));

        AlbaranEnvio::create([
            'parcial_id' => $this->parcialid,
            'user_id' => Auth::id(),
            'destinatarios' => $this->destinatarios ? collect($this->destinatarios)->where('activo', true)->values()->all() : [],
            'asunto' => $this->asunto,
            'mensaje' => $this->mensaje,
            'adjuntos' => array_merge([$nombrePdf], collect($extras)->pluck('name')->all()),
            'valorado' => (bool) $this->valorado,
            'enviado_at' => now(),
        ]);

        $this->confirmando = false;
        $this->adjuntos = [];
        $this->dispatchBrowserEvent('notify', 'Albarán enviado a ' . count($emails) . ' destinatario(s).');
    }
}
