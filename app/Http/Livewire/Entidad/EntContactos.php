<?php

namespace App\Http\Livewire\Entidad;

use App\Models\{Entidad, EntidadContacto, User};
use Livewire\Component;

class EntContactos extends Component
{
    public function mount($entidadId)
    {
        $this->entidad=Entidad::findOrFail($entidadId);
    }
    public function render()
    {
        $users=User::get();
        $contactos=EntidadContacto::where('entidad_id',$this->entidad->id)->paginate(15);
        return view('livewire.entidad.ent-contactos',compact(['contactos']));
    }

    public function delete($entidadcontactoId)
    {
        $entidadcontacto = EntidadContacto::find($entidadcontactoId);
        if ($entidadcontacto) {
            $entidadcontacto->delete();
            $this->dispatchBrowserEvent('notify', 'El contacto ha sido eliminado!');
        }
    }
}
