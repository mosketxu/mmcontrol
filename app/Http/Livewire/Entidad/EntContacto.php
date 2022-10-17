<?php

namespace App\Http\Livewire\Entidad;

use App\Models\{Entidad,EntidadContacto};
use Livewire\Component;


class EntContacto extends Component
{
    public $entidad;
    public $entidadId;
    public $contacto;
    public $nombre;
    public $telefono;
    public $movil;
    public $cargo;
    public $email;

    protected function rules(){
        return[
            'nombre'=>'required',
            'telefono'=>'nullable',
            'movil'=>'nullable',
            'cargo'=>'nullable',
            'email'=>'nullable|email',
        ];
    }

    public function messages()
    {
        return [
            'nombre.required'=>'El nombre del contacto es necesario',
            'email.email'=>'El email debe tener un formato apropiado',
        ];
    }
    public function mount(Entidad $entidad, EntidadContacto $contacto)
    {
        $this->entidad=$entidad;
        $this->entidadId=$this->entidad->id;
        if($contacto){
            $this->contacto=$contacto;
            $this->contactoId=$contacto->id;
            $this->nombre=$contacto->contacto;
            $this->telefono=$contacto->telefono;
            $this->movil=$contacto->movil;
            $this->cargo=$contacto->cargo;
            $this->email=$contacto->email;
        }
    }
    public function render()
    {
        return view('livewire.entidad.ent-contacto');
    }

    public function save()
    {
        $this->validate();
        $i='';
        if($this->contacto->id)
            $i=$this->contacto->id;

        $con=EntidadContacto::updateOrCreate([
            'id'=>$i
            ],
            [
            'contacto'=>$this->nombre,
            'entidad_id'=>$this->entidadId,
            'telefono'=>$this->telefono,
            'movil'=>$this->movil,
            'telefono'=>$this->telefono,
            'email'=>$this->email,
            'cargo'=>$this->cargo,
            ]
        );
        if($i)
            $men= "Contacto Actualizado";
        else
            $men= "Contacto Creado";

        $this->dispatchBrowserEvent('notify', $men);
    }
}
