<?php

namespace App\Http\Livewire\Seguridad;

use App\Http\Livewire\Concerns\CampoEditable;
use App\Models\User;
use App\Models\UserEmpresa;
use Livewire\Component;
use Livewire\WithPagination;


class Usuarios extends Component
{
    use WithPagination;
    use CampoEditable;

    public $titulo='Usuarios';
    public $valorcampo1='';
    public $valorcampo2='';
    public $valorcampo3='';
    public $titcampo1='Usuario';
    public $titcampo2='email';
    public $titcampo3='password';
    public $campo1='name';
    public $campo2='email';
    public $campo3='password';
    public $campo1visible=1;
    public $campo2visible=1;
    public $campo3visible=0;
    public $editarvisible=1;
    public $search='';

    protected $listeners = [ 'refresh' => '$refresh'];

    protected function rules()
    {
        return [
            'valorcampo1'=>'required|unique:users,name',
            'valorcampo2'=>'email|required',
        ];
    }

    public function messages(){
        return [
            'valorcampo1.required' => 'El nombre del usuario es necesario',
            'valorcampo1.unique' => 'El nombre del usuario ya existe',
            'valorcampo2.required' => 'El mail es necesario.',
            'valorcampo2.email' => 'El mail debe ser válido.',
        ];
    }

    public function render(){
        $valores=User::query()
            ->search('name',$this->search)
            ->orSearch('email',$this->search)
            ->select('id','name as valorcampo1','email as valorcampo2','password as valorcampo3')
            ->orderBy('name')
            ->get();

        return view('livewire.auxiliarcard',compact('valores'));
    }

    public function changeCampo(User $valor,$campo,$valorcampo){
        $this->validarInline(['valorcampo'=>$valorcampo], ['valorcampo'=>'required']);

        if ($campo === 'email') {
            $duplicado=$this->usuarioConEmail($valorcampo, $valor->id);
            if ($duplicado) {
                $this->addError('valorcampo2', $this->mensajeDuplicado($duplicado));
                $this->nonce++; // repinta la fila: el input recupera el correo original
                return;
            }
        }

        $p=User::find($valor->id);
        $p->$campo=$valorcampo;
        $p->save();

        $this->dispatch('notify', 'Usuario Actualizado.');
    }

    public function editar($valorId){
        $user= User::find($valorId);
        return redirect()->route('users.edit',$user);
    }

    public function save(){
        $this->validate();

        $duplicado=$this->usuarioConEmail($this->valorcampo2);
        if ($duplicado) {
            $this->addError('valorcampo2', $this->mensajeDuplicado($duplicado));
            return;
        }

        User::create([
            'name'=>$this->valorcampo1,
            'email'=>$this->valorcampo2,
            'password'=>'',
        ]);

        $this->dispatch('notify', 'Usuario añadido con éxito');

        $this->dispatch('refresh');
        $this->valorcampo1='';
        $this->valorcampo2='';
        $this->valorcampo3='';
    }

    public function delete($valorId){

        $borrar = User::find($valorId);

        if ($borrar) {
            $empresasclienteborrar=UserEmpresa::where('user_id',$borrar->id)->get();
            foreach($empresasclienteborrar as $registro){
                $ids[]=$registro->id;
            }
            // $empresasclienteborrar->delete();
            $borrar->delete();
            $this->dispatch('notify', 'Usuario eliminado!');
        }
    }

    /** Devuelve el usuario que ya tiene ese correo (o null), excluyendo un id. */
    private function usuarioConEmail($email, $exceptoId=null){
        return User::where('email',$email)
            ->when($exceptoId, fn($q)=>$q->where('id','!=',$exceptoId))
            ->first();
    }

    private function mensajeDuplicado(User $duplicado){
        return 'Ese correo ya está en uso por el usuario "'.$duplicado->name.'". Elige otro.';
    }
}
