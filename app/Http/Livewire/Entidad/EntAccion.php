<?php

namespace App\Http\Livewire\Entidad;

use App\Models\EntidadAccion;
use App\Models\EntidadContacto;
use Livewire\Component;

class EntAccion extends Component
{
    public $ent;
    public $ruta;
    public $titulo;
    public $search = '';
    public $contacto_id = '';
    public $nombre = '';
    public $accion = '';
    public $descripcion = '';
    public $fechaaccion = '';
    public $proximaaccion = '';

    protected $listeners = ['refresh' => '$refresh'];

    protected function rules()
    {
        return [
            'contacto_id' => 'nullable',
            'nombre' => 'nullable',
            'accion' => 'nullable',
            'descripcion' => 'nullable',
            'fechaaccion' => 'required|date',
            'proximaaccion' => 'nullable',
        ];
    }

    public function messages()
    {
        return [
            'fechaaccion.required' => 'La fecha de accion es necesaria',
            'fechaaccion.date' => 'La fecha de accion no es valida',
        ];
    }

    public function mount($entidad, $ruta)
    {
        $this->ent = $entidad;
        $this->ruta = $ruta;
        $this->titulo = 'Acciones de '.$this->ent->entidad;
        $this->fechaaccion = now()->format('Y-m-d');
    }

    public function render()
    {
        $acciones = EntidadAccion::query()
            ->with('contacto.entidadcontacto')
            ->where('entidad_id', $this->ent->id)
            ->when($this->search != '', function ($query) {
                $query->where(function ($query) {
                    $query->where('nombre', 'like', '%'.$this->search.'%')
                        ->orWhere('accion', 'like', '%'.$this->search.'%')
                        ->orWhere('descripcion', 'like', '%'.$this->search.'%')
                        ->orWhere('proximaaccion', 'like', '%'.$this->search.'%');
                });
            })
            ->orderByDesc('fechaaccion')
            ->get();

        $contactos = EntidadContacto::with('entidadcontacto')
            ->where('entidad_id', $this->ent->id)
            ->get();

        return view('livewire.entidad.ent-accion', compact('acciones', 'contactos'));
    }

    public function changeCampo($accionId, $campo, $valor)
    {
        $accion = EntidadAccion::find($accionId);

        if (! $accion) {
            return;
        }

        $accion->$campo = $valor === '' ? null : $valor;
        $accion->save();

        $this->dispatchBrowserEvent('notify', 'Accion actualizada.');
    }

    public function save()
    {
        $this->validate();

        EntidadAccion::create([
            'entidad_id' => $this->ent->id,
            'contacto_id' => $this->contacto_id ?: null,
            'nombre' => $this->nombre,
            'accion' => $this->accion,
            'descripcion' => $this->descripcion,
            'fechaaccion' => $this->fechaaccion,
            'proximaaccion' => $this->proximaaccion,
        ]);

        $this->contacto_id = '';
        $this->nombre = '';
        $this->accion = '';
        $this->descripcion = '';
        $this->fechaaccion = now()->format('Y-m-d');
        $this->proximaaccion = '';

        $this->dispatchBrowserEvent('notify', 'Accion anadida con exito');
    }

    public function delete($accionId)
    {
        $accion = EntidadAccion::find($accionId);

        if ($accion) {
            $accion->delete();
            $this->dispatchBrowserEvent('notify', 'Accion eliminada!');
        }
    }
}
