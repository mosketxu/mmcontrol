<?php

namespace App\Http\Livewire\Entidad;

use App\Models\{Entidad, EntidadContacto, EntidadTipo,  MetodoPago,Pais,Provincia, User};
// use Illuminate\Support\Carbon;
use Livewire\Component;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;



class Ent extends Component
{
    public $entidad;
    public $entidadtipo;
    public $fechacli;
    public $contactoId;
    public $departamento;
    public $comentario;

    protected function rules(){
        return [
            'entidad.id'=>'nullable',
            'entidad.entidad'=>'required',
            'entidad.entidadtipo_id'=>'required',
            'entidad.responsable'=>'nullable',
            'entidad.nif'=>'nullable|max:12',
            'entidad.direccion'=>'nullable',
            'entidad.cp'=>'nullable|max:10',
            'entidad.localidad'=>'nullable',
            'entidad.provincia_id'=>'nullable',
            'entidad.pais_id'=>'nullable',
            'entidad.tfno'=>'nullable',
            'entidad.emailgral'=>'nullable',
            'entidad.emailadm'=>'nullable',
            'entidad.emailaux'=>'nullable',
            'entidad.web'=>'nullable',
            'entidad.banco1'=>'nullable',
            'entidad.banco2'=>'nullable',
            'entidad.iban1'=>'nullable',
            'entidad.iban2'=>'nullable',
            'entidad.metodopago_id'=>'nullable',
            'entidad.diavencimiento'=>'numeric|nullable',
            'entidad.vencimientofechafactura'=>'numeric|nullable',
            'entidad.credito'=>'nullable',
            'entidad.importecredito'=>'numeric|nullable',
            'entidad.empresacredito'=>'nullable',
            'entidad.vigenciacredito'=>'nullable',
            'entidad.observaciones'=>'nullable',
        ];
    }

    public function messages(){
        return [
            'entidad.entidad.required' => 'El nombre de la entidad es necesario',
            'entidad.entidadtipo_id.required' => 'El tipo es necesario',
            'entidad.nif.max' => 'El Nif debe ser inferior a 12 caracteres',
            'entidad.cuentactblepro.numeric' => 'La cuenta contable del proveedor debe ser numérica',
            'entidad.cuentactblecli.numeric' => 'La cuenta contable del cliente debe ser numérica',
            'entidad.cp.max' => 'El código postal debe ser inferior a 8 caracteres',
            'entidad.diafactura.diavencimiento' => 'El dia de vencimiento debe ser numérico',
        ];
    }

    public function mount(Entidad $entidad, Entidad $contacto,$entidadtipoId){
        $this->entidad=$entidad;
        $this->contacto=$contacto;

        $this->fechacli=$this->entidad->fechacliente;
        $this->entidad->entidadtipo_id=$entidadtipoId;
        $this->entidadtipo=EntidadTipo::find($entidadtipoId);
    }

    public function render(){
        if (!$this->entidad->estado) $this->entidad->estado=0;
        $entidad=$this->entidad;
        $contacto=$this->contacto;
        $this->contactoId=$contacto->id;

        $metodopagos=MetodoPago::all();
        $provincias=Provincia::all();
        $paises=Pais::all();
        return view('livewire.entidad.ent',compact('metodopagos','provincias','paises'));
    }

    public function save(){
        $this->validate();
        if($this->entidad->id){
            $i=$this->entidad->id;
            $this->validate([
                'entidad.entidad'=>[
                    'required',
                    Rule::unique('entidades','entidad')->ignore($this->entidad->id)],
                'entidad.nif'=>[
                    'nullable',
                    'max:12',
                    Rule::unique('entidades','nif')->ignore($this->entidad->id)],
                ]
            );
            $mensaje="Proveedor actualizado satisfactoriamente";
        }else{
            $this->validate([
                'entidad.entidad'=>'required|unique:entidades,entidad',
                'entidad.nif'=>'nullable|max:12|unique:entidades,nif',
                'entidad.cuentactblepro'=>'nullable|numeric|unique:entidades,cuentactblepro',
                'entidad.cuentactblecli'=>'nullable|numeric|unique:entidades,cuentactblecli',
                ]
            );
            $i=$this->entidad->id;
            $mensaje="Proveedor creado satisfactoriamente";
        }

        $ent=Entidad::updateOrCreate([
            'id'=>$i
            ],
            [
            'entidad'=>$this->entidad->entidad,
            'entidadtipo_id'=>$this->entidad->entidadtipo_id,
            'responsable'=>$this->entidad->responsable,
            'nif'=>$this->entidad->nif,
            'direccion'=>$this->entidad->direccion,
            'cp'=>$this->entidad->cp,
            'localidad'=>$this->entidad->localidad,
            'provincia_id'=>$this->entidad->provincia_id,
            'pais_id'=>$this->entidad->pais_id,
            'tfno'=>$this->entidad->tfno,
            'emailgral'=>$this->entidad->emailgral,
            'emailadm'=>$this->entidad->emailadm,
            'emailaux'=>$this->entidad->emailaux,
            'web'=>$this->entidad->web,
            'banco1'=>$this->entidad->banco1,
            'banco2'=>$this->entidad->banco2,
            'iban1'=>$this->entidad->iban1,
            'iban2'=>$this->entidad->iban2,
            'metodopago_id'=>$this->entidad->metodopago_id,
            'diavencimiento'=>$this->entidad->diavencimiento,
            'vencimientofechafactura'=>$this->entidad->vencimientofechafactura,
            'credito'=>$this->entidad->credito,
            'empresacredito'=>$this->entidad->empresacredito,
            'importecredito'=>$this->entidad->importecredito,
            'vigenciacredito'=>$this->entidad->vigenciacredito,
            'observaciones'=>$this->entidad->observaciones,
            ]
        );
        if(!$this->entidad->id){
            $this->entidad->id=$ent->id;
        }

        if($this->contactoId){
            EntidadContacto::create([
                 'contacto_id'=>$this->entidad->id,
                 'entidad_id'=>$this->contactoId,
                 'departamento'=>$this->departamento,
                 'comentarios'=>$this->comentario,
            ]);
            $this->dispatchBrowserEvent('notify', 'Contacto añadido con éxito');
        }

        $this->emitSelf('notify-saved');
        $this->dispatchBrowserEvent('notify', $mensaje);
    }
}
