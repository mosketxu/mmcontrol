<?php

namespace App\Http\Livewire\Seguridad;

use App\Models\Encuadernacion as ModelsEncuadernacion;
use Illuminate\Support\Facades\Validator;

use Livewire\Component;


class Encuadernacion extends Component
{
    public $titulo='Encuadernación';
    public $valorcampo1='';
    public $valorcampo2='';
    public $valorcampo3='';
    public $titcampo1='Encuadernación';
    public $titcampo2='Destino';
    public $titcampo3='Descripcion';
    public $campo1='name';
    public $campo2='familia';
    public $campo3='descripcion';
    public $campo1visible=1;
    public $campo2visible=0;
    public $campo3visible=1;
    public $editarvisible=0;
    public $search='';

    protected $listeners = [ 'refresh' => '$refresh'];

    protected function rules()
    {
        return [
            'valorcampo1'=>'required|unique:encuadernaciones,name',
            'valorcampo2'=>'nullable',
            'valorcampo3'=>'nullable',
        ];
    }
    public function messages()
    {
        return [
            'valorcampo1.required' => 'El nombre de la Encuadernacion es necesaria,',
            'valorcampo1.unique' => 'La Encuadernacion ya existe. Elige otro nombre,',
        ];
    }

    public function render()
    {
        $valores=ModelsEncuadernacion::query()
            ->search('name',$this->search)
            ->select('id','name as valorcampo1','familia as valorcampo2','descripcion as valorcampo3')
            ->orderBy('name')
            ->get();
        return view('livewire.auxiliarcard',compact('valores'));
    }

    public function changeCampo(ModelsEncuadernacion $valor,$campo,$valorcampo)
    {
        Validator::make(['valorcampo'=>$valorcampo],[
            'valorcampo'=>'required|unique:encuadernaciones,name',
            ])->validate();
        $p=ModelsEncuadernacion::find($valor->id);
        if($campo=='familia') $valorcampo=strtoupper($valorcampo);
        $p->$campo=$valorcampo;
        $p->save();
        $this->dispatchBrowserEvent('notify', 'Encuadernacion Actualizada.');
    }


    public function save()
    {
        $this->validate();

        ModelsEncuadernacion::create([
            'name'=>$this->valorcampo1,
            'familia'=>strtoupper($this->valorcampo2),
            'descripcion'=>$this->valorcampo3,
        ]);

        $this->dispatchBrowserEvent('notify', 'Encuadernacion añadida con éxito');

        $this->emit('refresh');
        $this->valorcampo1='';
        $this->valorcampo2='';
        $this->valorcampo3='';
    }

    public function delete($valorId)
    {
        $borrar = ModelsEncuadernacion::find($valorId);

        if ($borrar) {
            $borrar->delete();
            $this->dispatchBrowserEvent('notify', 'Encuadernacion eliminada!');
        }
    }
}
