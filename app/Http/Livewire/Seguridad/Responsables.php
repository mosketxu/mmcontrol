<?php

namespace App\Http\Livewire\Seguridad;

use Livewire\Component;
use Illuminate\Support\Facades\Validator;
use App\Models\Responsable;
use Livewire\WithPagination;

class Responsables extends Component
{
    use WithPagination;

    public $titulo='Responsables';
    public $valorcampo1='';
    public $valorcampo2='';
    public $valorcampo3='';
    public $titcampo1='Responsable';
    public $titcampo2='email';
    public $titcampo3='Activo';
    public $campo1='responsable';
    public $campo2='mailresponsable';
    public $campo3='activo';
    public $campo1visible=1;
    public $campo2visible=1;
    public $campo3visible=1;
    public $editarvisible=0;
    public $search='';


    protected $listeners = [ 'refresh' => '$refresh'];

    protected function rules(){
        return [
            'valorcampo1'=>'required|unique:users,name',
            'valorcampo2'=>'email|required|unique:users,email',
            'valorcampo3'=>'nullable',
        ];
    }

    public function messages(){
        return [
            'valorcampo1.required' => 'El nombre del responsable es necesario',
            'valorcampo1.unique' => 'El nombre del responsable ya existe',
            'valorcampo2.unique' => 'El mail ya existe. Elige otro.',
            'valorcampo2.required' => 'El mail es necesario.',
            'valorcampo2.email' => 'El mail debe ser válido.',
        ];
    }

    public function render(){
        $valores=Responsable::query()
            ->search('responsable',$this->search)
            ->orSearch('mailresponsable',$this->search)
            ->select('id','responsable as valorcampo1','mailresponsable as valorcampo2','activo as valorcampo3')
            ->orderBy('responsable')
            ->get();

        return view('livewire.auxiliarcard',compact('valores'));
    }

    public function changeCampo(Responsable $valor,$campo,$valorcampo){
        Validator::make(['valorcampo'=>$valorcampo],[
            'valorcampo'=>'required',
        ])->validate();

        $p=Responsable::find($valor->id);
        $p->$campo=$valorcampo;
        $p->save();
        $this->dispatchBrowserEvent('notify', 'Responsable Actualizado.');
    }

    public function editar($valorId){
        $user= Responsable::find($valorId);
        return redirect()->route('users.edit',$user);
    }

    public function save(){
        $this->validate();

        Responsable::create([
            'name'=>$this->valorcampo1,
            'email'=>$this->valorcampo2,
            'password'=>'',
        ]);

        $this->dispatchBrowserEvent('notify', 'Responsable añadido con éxito');

        $this->emit('refresh');
        $this->valorcampo1='';
        $this->valorcampo2='';
        $this->valorcampo3='';
    }

    public function delete($valorId){

        $borrar = Responsable::find($valorId);

        if ($borrar) {
            $borrar->delete();
            $this->dispatchBrowserEvent('notify', 'Responsable eliminado!');
        }
    }

}
