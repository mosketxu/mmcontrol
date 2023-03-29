<?php

namespace App\Http\Livewire\Entidad;

use App\Models\Entidad;
use App\Models\EntidadDestino;

use Livewire\Component;

class EntDestino extends Component
{

    public $titulo;
    public $ruta;
    public $tipo;
    public $ent;
    public $pedidoid;
    public $titcampofecha='';
    public $titcampo1='Destino';
    public $titcampo2='Att.';
    public $titcampo3='Dirección';
    public $titcampo4='Población';
    public $titcampo5='CP';
    public $titcampo6='Horario';
    public $titcampo7='Tfno';
    public $titcampo8='Observaciones';
    public $titcampoimg='';
    public $valorcampofecha='';
    public $valorcampo1='';
    public $valorcampo2='';
    public $valorcampo3='';
    public $valorcampo4='';
    public $valorcampo5='';
    public $valorcampo6='';
    public $valorcampo7='';
    public $valorcampo8='';
    public $valorcampoimg;
    public $campofecha='';
    public $campo1='destino';
    public $campo2='atencion';
    public $campo3='direccion';
    public $campo4='localidad';
    public $campo5='cp';
    public $campo6='horario';
    public $campo7='tfno';
    public $campo8='observaciones';
    public $campoimg='archivo';
    public $campofechavisible=0;
    public $campo1visible=1;
    public $campo2visible=1;
    public $campo3visible=1;
    public $campo4visible=1;
    public $campo5visible=1;
    public $campo6visible=1;
    public $campo7visible=1;
    public $campo8visible=1;
    public $campoimgvisible=0;
    public $campofechadisabled='';
    public $campo1disabled='';
    public $campo2disabled='';
    public $campo3disabled='';
    public $campo4disabled='';
    public $campo5disabled='';
    public $campo6disabled='';
    public $campo7disabled='';
    public $campo8disabled='';
    public $campoimgdisabled='';
    public $editarvisible=0;
    public $search='';

    protected $listeners = [ 'refresh' => '$refresh'];

    protected function rules()
    {
        return [
            // 'valorcampofecha'=>'required||date',
            'valorcampo1'=>'required',
            'valorcampo2'=>'nullable',
            'valorcampo3'=>'nullable',
            'valorcampo4'=>'nullable',
            'valorcampo5'=>'nullable',
            'valorcampo6'=>'nullable',
            'valorcampo7'=>'nullable',
            'valorcampo8'=>'nullable',
        ];
    }

    public function messages()
    {
        return [
            'valorcampo1.required'=>'El destino es necesario',
        ];
    }

    public function mount($entidad,$ruta)
    {
        $this->ent=$entidad;
        $this->ruta=$ruta;
        $this->titulo='Destinos de '.$this->ent->entidad;
    }

    public function render()
    {
        $valores=EntidadDestino::query()
        ->search('destino', $this->search)
        ->select('id', 'destino as valorcampo1','atencion as valorcampo2','direccion as valorcampo3','localidad as valorcampo4','cp as valorcampo5','horario as valorcampo6','tfno as valorcampo7','observaciones as valorcampo8')
        ->where('entidad_id',$this->ent->id)
        ->orderBy('destino')
        ->get();

        return view('livewire.entidad.auxiliarentidadescard', compact('valores'));
    }

    public function changeCampo(EntidadDestino $valor, $campo, $valorcampo)
    {
        $p=EntidadDestino::find($valor->id);
        $p->$campo=$valorcampo;
        $p->save();
        $this->dispatchBrowserEvent('notify', 'Destino Actualizado.');
    }


    public function save()
    {
        $this->validate();
        $filename="";
        $extension="";

        $pedidodestino=EntidadDestino::create([
            'entidad_id'=>$this->ent->id,
            'destino'=>$this->valorcampo1,
            'atencion'=>$this->valorcampo2,
            'direccion'=>$this->valorcampo3,
            'localidad'=>$this->valorcampo4,
            'cp'=>$this->valorcampo5,
            'horario'=>$this->valorcampo6,
            'tfno'=>$this->valorcampo7,
            'observaciones'=>$this->valorcampo8,
        ]);

            $this->valorcampo1='';
            $this->valorcampo2='';
            $this->valorcampo3='';
            $this->valorcampo4='';
            $this->valorcampo5='';
            $this->valorcampo6='';
            $this->valorcampo7='';
            $this->valorcampo8='';

        $this->dispatchBrowserEvent('notify', 'Destino añadido con éxito');

    }

    public function delete($valorId)
    {
        $borrar = EntidadDestino::find($valorId);

        if ($borrar) {
            $borrar->delete();
            $this->dispatchBrowserEvent('notify', 'Destino eliminado!');
        }
    }
}
