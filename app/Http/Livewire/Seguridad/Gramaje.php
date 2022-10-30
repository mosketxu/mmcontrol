<?php

namespace App\Http\Livewire\Seguridad;

use App\Models\Gramaje as ModelsGramaje;
use Illuminate\Support\Facades\Validator;


use Livewire\Component;

class Gramaje extends Component
{
    public $titulo='Gramajes';
    public $valorcampo1='';
    public $valorcampo2='';
    public $valorcampo3='';
    public $titcampo1='Destino';
    public $titcampo2='Gramaje';
    public $titcampo3='Descripción';
    public $pp='name';
    public $campo1='familia';
    public $campo2='name';
    public $campo3='descripcion';
    public $campo1visible=1;
    public $campo2visible=1;
    public $campo3visible=1;
    public $editarvisible=0;
    public $search='';

    protected $listeners = [ 'refresh' => '$refresh'];

    protected function rules()
    {
        return [
            'valorcampo2'=>'required|unique:gramajes,name',
            'valorcampo3'=>'nullable',
        ];
    }
    public function messages()
    {
        return [
            'valorcampo2.required' => 'El nombre del Gramaje es necesario,',
            'valorcampo2.unique' => 'El Gramaje ya existe. Elige otro nombre,',
        ];
    }

    public function render()
    {
        $valores=ModelsGramaje::query()
            ->search('name',$this->search)
            ->select('id','familia as valorcampo1','name as valorcampo2','descripcion as valorcampo3')
            ->orderBy('name')
            ->get();
        return view('livewire.auxiliarcard',compact('valores'));
    }

    public function changeCampo(ModelsGramaje $valor,$campo,$valorcampo)
    {
        Validator::make(['valorcampo'=>$valorcampo],[
            'valorcampo'=>'required|unique:gramajes,name',
            ])->validate();
        $p=ModelsGramaje::find($valor->id);
        if($campo=='familia') $valorcampo=strtoupper($valorcampo);
        $p->$campo=$valorcampo;
        $p->save();
        $this->dispatchBrowserEvent('notify', 'Gramaje Actualizado.');
    }


    public function save()
    {
        $this->validate();

        ModelsGramaje::create([
            'name'=>$this->valorcampo2,
            'familia'=>strtoupper($this->valorcampo3),
        ]);

        $this->dispatchBrowserEvent('notify', 'Gramaje añadido con éxito');

        $this->emit('refresh');
        $this->valorcampo2='';
        $this->valorcampo3='';
    }

    public function delete($valorId)
    {
        $borrar = ModelsGramaje::find($valorId);

        if ($borrar) {
            $borrar->delete();
            $this->dispatchBrowserEvent('notify', 'Gramaje eliminado!');
        }
    }
}
