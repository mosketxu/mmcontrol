<?php

namespace App\Http\Livewire\Seguridad;

use App\Models\Formato as ModelsFormato;
use Illuminate\Support\Facades\Validator;


use Livewire\Component;

class Formato extends Component
{
    public $titulo='Formatos';
    public $valorcampo1='';
    public $valorcampo2='';
    public $valorcampo3='';
    public $titcampo1='Formato';
    public $titcampo2='Destino';
    public $titcampo3='Descripción';
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
            'valorcampo1'=>'required|unique:formatos,name',
            'valorcampo2'=>'nullable',
            'valorcampo3'=>'nullable',
        ];
    }
    public function messages()
    {
        return [
            'valorcampo1.required' => 'El nombre del formato es necesario,',
            'valorcampo1.unique' => 'El formato ya existe. Elige otro nombre,',
        ];
    }

    public function render()
    {
        $valores=ModelsFormato::query()
            ->search('name',$this->search)
            ->select('id','name as valorcampo1','familia as valorcampo2','descripcion as valorcampo3')
            ->orderBy('name')
            ->get();
        return view('livewire.auxiliarcard',compact('valores'));
    }

    public function changeCampo(ModelsFormato $valor,$campo,$valorcampo)
    {
        Validator::make(['valorcampo'=>$valorcampo],[
            'valorcampo'=>'required|unique:formatos,name',
            ])->validate();
        $p=ModelsFormato::find($valor->id);
        if($campo=='familia') $valorcampo=strtoupper($valorcampo);
        $p->$campo=$valorcampo;
        $p->save();
        $this->dispatchBrowserEvent('notify', 'Formato Actualizado.');
    }

    public function editar($valorId)
    {
        $formato=ModelsFormato::find($valorId);
        return redirect()->route('formatos.edit',$formato);
    }

    public function save()
    {
        $this->validate();

        ModelsFormato::create([
            'name'=>$this->valorcampo1,
            'familia'=>strtoupper($this->valorcampo2),
            'descripcion'=>$this->valorcampo3,
        ]);

        $this->dispatchBrowserEvent('notify', 'Formato añadido con éxito');

        $this->emit('refresh');
        $this->valorcampo1='';
        $this->valorcampo2='';
        $this->valorcampo3='';
    }

    public function delete($valorId)
    {
        $borrar = ModelsFormato::find($valorId);

        if ($borrar) {
            $borrar->delete();
            $this->dispatchBrowserEvent('notify', 'Formato eliminado!');
        }
    }
}
