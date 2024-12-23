<?php

namespace App\Http\Livewire\Seguridad;

use App\Models\Laminado;
use Illuminate\Support\Facades\Validator;


use Livewire\Component;

class Stock extends Component
{
    public $titulo='Productos Stock';
    public $valorcampo1='';
    public $valorcampo2='';
    public $valorcampo3='';
    public $titcampo1='Nombre';
    public $titcampo2='Descripción';
    public $titcampo3='';
    public $campo1='name';
    public $campo2='descripcion';
    public $campo3='';
    public $campo1visible=1;
    public $campo2visible=1;
    public $campo3visible=0;
    public $editarvisible=0;
    public $search='';

    protected $listeners = [ 'refresh' => '$refresh'];

    protected function rules()
    {
        return [
            'valorcampo1'=>'required|unique:laminados,name',
            'valorcampo2'=>'nullable',
            'valorcampo3'=>'nullable',
        ];
    }
    public function messages()
    {
        return [
            'valorcampo1.required' => 'El nombre es necesario.',
            'valorcampo1.unique' => 'El nombre ya existe. Elige otro nombre,',
        ];
    }

    public function render()
    {
        $valores=Laminado::query()
            ->search('name',$this->search)
            ->select('id','name as valorcampo1','descripcion as valorcampo2')
            ->orderBy('name')
            ->get();
        return view('livewire.auxiliarcard',compact('valores'));
    }

    public function changeCampo(Laminado $valor,$campo,$valorcampo)
    {
        Validator::make(['valorcampo'=>$valorcampo],[
            'valorcampo'=>'required|unique:laminados,name',
            ])->validate();
        $p=Laminado::find($valor->id);
        // if($campo=='familia') $valorcampo=strtoupper($valorcampo);
        $p->$campo=$valorcampo;
        $p->save();
        $this->dispatchBrowserEvent('notify', 'Producto Stock  Actualizado.');
    }


    public function save()
    {
        $this->validate();

        Laminado::create([
            'name'=>$this->valorcampo1,
            'descripcion'=>$this->valorcampo2,
        ]);

        $this->dispatchBrowserEvent('notify', 'Producto Stock añadido con éxito');

        $this->emit('refresh');
        $this->valorcampo1='';
        $this->valorcampo2='';
        $this->valorcampo3='';
    }

    public function delete($valorId)
    {
        $borrar = Laminado::find($valorId);

        if ($borrar) {
            $borrar->delete();
            $this->dispatchBrowserEvent('notify', 'Producto Stock eliminado!');
        }
    }
}
