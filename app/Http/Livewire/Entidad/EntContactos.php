<?php

namespace App\Http\Livewire\Entidad;

use App\Models\{Entidad, EntidadContacto};
use Livewire\Component;
use Livewire\WithPagination;

class EntContactos extends Component
{
    use WithPagination;

    public $entidad;
    public $contacto;
    public $departamento;
    public $comentario;
    public $search='';
    public $conts;
    public $ruta='entidad.contacto';

    public function render()
    {

        $ent=$this->entidad;
        $contactos = EntidadContacto::where('entidad_id',$this->entidad->id)
        ->join('entidades','entidad_contactos.contacto_id','=','entidades.id')
        ->select('entidad_contactos.*', 'entidades.entidad', 'entidades.nif', 'entidades.tfno','entidades.emailgral')
        ->search('entidades.entidad',$this->search)
        ->orderBy('entidades.entidad')
        ->get();

        // dd($contactos);
        $excludedContactos = EntidadContacto::where('entidad_id',$this->entidad->id)->pluck('contacto_id');
        $excludedContactos->push($this->entidad->id);
        $entidades=Entidad::whereNotIn('id',$excludedContactos)->orderBy('entidad')->get();

        return view('livewire.entidad.ent-contactos',compact(['ent','contactos','entidades','excludedContactos']));

    }

    public function savecontacto()
    {
        if($this->contacto){
            EntidadContacto::create([
                'entidad_id'=>$this->entidad->id,
                'contacto_id'=>$this->contacto,
                'departamento'=>$this->departamento,
                'comentarios'=>$this->comentario,
                // ''
            ]);
            $this->dispatchBrowserEvent('notify', 'Contacto añadido con éxito');

            $this->reset('contacto');
            $this->reset('departamento');
            $this->reset('comentario');
        }
    }

    public function delete($contactoId)
    {
        $contactoBorrar = EntidadContacto::find($contactoId);
        $e=Entidad::find($contactoBorrar->contacto_id);

        if ($contactoBorrar) {
            $contactoBorrar->delete();
            $this->dispatchBrowserEvent('notify', 'El contacto '.$e->entidad.' ha sido eliminado!');
        }
    }

}
