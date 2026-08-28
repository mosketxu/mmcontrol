<?php

namespace App\Http\Livewire\Seguridad;

use App\Http\Livewire\Concerns\CampoEditable;
use App\Models\Responsable;
use Livewire\Component;
use Livewire\WithPagination;

class Responsables extends Component
{
    use WithPagination;
    use CampoEditable;

    public $titulo='Responsables';
    public $valorcampo1='';
    public $valorcampo2='';
    public $valorcampo3=1;
    public $titcampo1='Responsable';
    public $titcampo2='email';
    public $titcampo3='Activo';
    public $campo1='responsable';
    public $campo2='mailresponsable';
    public $campo3='activo';
    public $campo1visible=1;
    public $campo2visible=1;
    public $campo3visible=1;
    public $campo3tipo='bool';
    public $editarvisible=0;
    public $search='';

    protected $listeners = [ 'refresh' => '$refresh'];

    protected function rules(){
        return [
            'valorcampo1'=>'required|unique:responsables,responsable',
            'valorcampo2'=>'nullable|email',
            'valorcampo3'=>'nullable',
        ];
    }

    public function messages(){
        return [
            'valorcampo1.required' => 'El nombre del responsable es necesario',
            'valorcampo1.unique' => 'Ese responsable ya existe. Elige otro nombre.',
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
        $reglas = $campo === 'activo'
            ? ['valorcampo'=>'boolean']
            : ['valorcampo'=>'required'];

        $this->validarInline(['valorcampo'=>$valorcampo], $reglas);

        $p=Responsable::find($valor->id);
        $p->$campo=$valorcampo;
        $p->save();
        $this->dispatch('notify', 'Responsable Actualizado.');
    }

    public function editar($valorId){
        $user= Responsable::find($valorId);
        return redirect()->route('users.edit',$user);
    }

    public function save(){
        $this->validate();

        Responsable::create([
            'responsable'=>$this->valorcampo1,
            'mailresponsable'=>$this->valorcampo2 ?: null,
            'activo'=>$this->valorcampo3 ? 1 : 0,
        ]);

        $this->dispatch('notify', 'Responsable añadido con éxito');

        $this->dispatch('refresh');
        $this->valorcampo1='';
        $this->valorcampo2='';
        $this->valorcampo3=1;
    }

    public function delete($valorId){

        $borrar = Responsable::find($valorId);

        if ($borrar) {
            $borrar->delete();
            $this->dispatch('notify', 'Responsable eliminado!');
        }
    }

}
