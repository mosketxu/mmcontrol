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
    public $titcampo1='Destino';
    public $titcampo2='Plastificado';
    public $titcampo3='Descripcion';
    public $campo1='familia';
    public $campo2='name';
    public $campo3='descripcion';
    public $campo1visible=0;
    public $campo2visible=1;
    public $campo3visible=1;
    public $editarvisible=0;
    public $search='';

    protected $listeners = [ 'refresh' => '$refresh'];

    protected function rules()
    {
        return [
            'valorcampo2'=>'required|unique:plastificados,name',
            'valorcampo3'=>'nullable',
        ];
    }
    public function messages()
    {
        return [
            'valorcampo2.required' => 'El nombre del plastificado es necesario,',
            'valorcampo2.unique' => 'El plastificado ya existe. Elige otro nombre,',
        ];
    }

    public function render()
    {
        $valores=ModelsPlastificado::query()
            ->search('name',$this->search)
            ->select('id','familia as valorcampo1','name as valorcampo2','descripcion as valorcampo3')
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
            'name'=>$this->valorcampo2,
            'familia'=>strtoupper($this->valorcampo3),
        ]);

        $this->dispatchBrowserEvent('notify', 'Plastificado añadido con éxito');

        $this->emit('refresh');
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
