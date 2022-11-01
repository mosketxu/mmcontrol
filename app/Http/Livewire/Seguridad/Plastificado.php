<?php

namespace App\Http\Livewire\Seguridad;

use App\Models\Plastificado as ModelsPlastificado;
use Illuminate\Support\Facades\Validator;


use Livewire\Component;

class Plastificado extends Component
{
    public $titulo='Plastificados';
    public $valorcampo1='';
    public $valorcampo2='';
    public $valorcampo3='';
    public $titcampo1='Plastificado';
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
            'valorcampo1'=>'required|unique:plastificados,name',
            'valorcampo2'=>'nullable',
            'valorcampo3'=>'nullable',
        ];
    }
    public function messages()
    {
        return [
            'valorcampo1.required' => 'El nombre del plastificado es necesario,',
            'valorcampo1.unique' => 'El plastificado ya existe. Elige otro nombre,',
        ];
    }

    public function render()
    {
        $valores=ModelsPlastificado::query()
            ->search('name',$this->search)
            ->select('id','name as valorcampo1','familia as valorcampo2','descripcion as valorcampo3')
            ->orderBy('name')
            ->get();
        return view('livewire.auxiliarcard',compact('valores'));
    }

    public function changeCampo(ModelsPlastificado $valor,$campo,$valorcampo)
    {
        Validator::make(['valorcampo'=>$valorcampo],[
            'valorcampo'=>'required|unique:plastificados,name',
            ])->validate();
        $p=ModelsPlastificado::find($valor->id);
        if($campo=='familia') $valorcampo=strtoupper($valorcampo);
        $p->$campo=$valorcampo;
        $p->save();
        $this->dispatchBrowserEvent('notify', 'Plastificado Actualizado.');
    }

    public function save()
    {
        $this->validate();

        ModelsPlastificado::create([
            'name'=>$this->valorcampo1,
            'familia'=>strtoupper($this->valorcampo2),
            'descripcion'=>$this->valorcampo3,
        ]);

        $this->dispatchBrowserEvent('notify', 'Plastificado añadido con éxito');

        $this->emit('refresh');
        $this->valorcampo1='';
        $this->valorcampo2='';
        $this->valorcampo3='';
    }

    public function delete($valorId)
    {
        $borrar = ModelsPlastificado::find($valorId);

        if ($borrar) {
            $borrar->delete();
            $this->dispatchBrowserEvent('notify', 'Plastificado eliminado!');
        }
    }
}
