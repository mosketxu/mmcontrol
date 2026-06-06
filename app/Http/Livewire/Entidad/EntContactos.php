<?php

namespace App\Http\Livewire\Entidad;

use App\Models\{Entidad, EntidadContacto};
use Livewire\Component;
use Livewire\WithPagination;

class EntContactos extends Component
{
    use WithPagination;

    public $entidad;
    public $entidadId;
    public $contacto;
    public $nombre;
    public $tfno;
    public $emailgral;
    public $departamento;
    public $comentarios;
    public $search='';
    public $conts;
    public $ruta;

    public function mount($entidad,$ruta){
        $this->entidad=$entidad;
        $this->entidadId=$entidad->id;
        $this->ruta=$ruta;
    }


    public function render(){
        $contactos = EntidadContacto::where('entidad_id',$this->entidad->id)
        ->join('entidades','entidad_contactos.contacto_id','=','entidades.id')
        ->select('entidad_contactos.*', 'entidades.entidad', 'entidades.nif', 'entidades.tfno','entidades.emailgral')
        ->search('entidades.entidad',$this->search)
        ->orderBy('entidades.entidad')
        ->get();

        $excludedContactos = EntidadContacto::where('entidad_id',$this->entidad->id)->pluck('contacto_id');
        $excludedContactos->push($this->entidad->id);
        $entidades=Entidad::whereNotIn('id',$excludedContactos)->orderBy('entidad')->get();

        return view('livewire.entidad.ent-contactos',compact(['contactos','entidades','excludedContactos']));
    }

    public function changeEntidad($contactoId,$campo,$valor){
        $relacion = EntidadContacto::find($contactoId);
        if (!$relacion) {return;}
        $entidad = Entidad::find($relacion->contacto_id);
        if ($entidad) {
            $entidad->update([$campo => $valor]);
            session()->flash('success', 'Contacto modificado con éxito');
            // $this->dispatchBrowserEvent('notify', 'Contacto modificado con éxito');
        }
    }

    public function changeRelacion($contactoId,$campo,$valor){
        $relacion = EntidadContacto::find($contactoId);
        if ($relacion) {
            $relacion->update([$campo => $valor]);
            session()->flash('success', 'Contacto modificado con éxito');
            // $this->dispatchBrowserEvent('notify', 'Contacto modificado con éxito');
        }
    }

    public function savecontacto(){
        $this->validate([
            'nombre' => 'required|string|max:255',
            'emailgral' => 'nullable|email',
            'tfno' => 'nullable|max:50',
            'departamento' => 'nullable|max:255',
            'comentarios' => 'nullable',
        ]);

        $nuevoContacto = Entidad::create([
            'entidad'   => $this->nombre,
            'tfno'      => $this->tfno,
            'emailgral' => $this->emailgral,
            'entidadtipo_id'=>'0',
        ]);
        if($nuevoContacto){
             EntidadContacto::create([
                'entidad_id'=>$this->entidad->id,
                'contacto_id'=>$nuevoContacto->id,
                'departamento'=>$this->departamento,
                'comentarios'=>$this->comentarios,
            ]);
            session()->flash('success', 'Contacto añadido con éxito');
            //  $this->dispatchBrowserEvent('notify', 'Contacto añadido con éxito');
             $this->reset(['nombre', 'tfno', 'emailgral', 'departamento', 'comentarios']);
        }
    }

    public function delete($contactoId)
    {
        $contactoBorrar = EntidadContacto::find($contactoId);
        $e=Entidad::find($contactoBorrar->contacto_id);

        if ($contactoBorrar) {
            $contactoBorrar->delete();
            // $this->dispatchBrowserEvent('notify', 'El contacto '.$e->entidad.' ha sido eliminado!');
        }
    }

}
