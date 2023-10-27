<?php

namespace App\Http\Livewire\Seguridad;

use App\Models\Entidad;
use App\Models\User;
use App\Models\UserEmpresa;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Laravel\Jetstream\Rules\Role;

use Livewire\Component;

class EmpresasCliente extends Component{

    public $titulo='Empresas';
    public $empresaId;
    public $cliente;
    public $search='';
    public $roles;

    protected $listeners = [ 'refresh' => '$refresh'];

    protected function rules(){
        return [
            'empresaId'=>'required',
        ];
    }

    public function messages(){
        return [
            'empresaId.required' => 'El nombre de la empresa en  necesario',
        ];
    }

    function mount(User $cliente){
        $this->cliente=$cliente;
        $this->roles = $cliente->getRoleNames();

    }

    public function render(){
        // el usuario no es el AUTH sino el elegido en edit
        $empresasasociadas=UserEmpresa::query()
            ->with('entidad')
            ->join('entidades','entidades.id','user_empresas.entidad_id')
            ->where('user_id',$this->cliente->id)
            ->select('user_empresas.id as id','entidad_id','entidades.entidad as entidad')
            ->orderBy('entidades.entidad')
            ->get();

        $empresasdisponibles=Entidad::query()
            ->whereIn('entidadtipo_id',['0','1'])
            ->whereNotIn('id',$empresasasociadas->pluck('entidad_id'))
            ->orderBy('entidad')
            ->get();


        return view('livewire.seguridad.empresas-cliente',compact(['empresasasociadas','empresasdisponibles']));
    }

    public function save(){
        $this->validate();
        UserEmpresa::create(['user_id'=>$this->cliente->id,'entidad_id'=>$this->empresaId,]);
        $this->dispatchBrowserEvent('notify', 'Empresa añadida con éxito');
        $this->emit('refresh');
        $this->empresaId='';
    }

    public function delete($id){
        $borrar = UserEmpresa::find($id);
        if ($borrar) {
            $borrar->delete();
            $this->dispatchBrowserEvent('notify', 'Empresa eliminada!');
        }
    }
}
