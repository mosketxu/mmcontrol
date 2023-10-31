<?php

namespace App\Http\Livewire\Presupuesto;

use App\Models\Presupuesto;
use App\Models\PresupuestoProceso as ModelsPresupuestoProceso;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class PresupuestoProceso extends Component
{
    public $presupuesto;
    public $presupuesto_id;
    public $proceso;
    public $orden='0';
    public $visible='1';
    public $tirada='0';
    public $precio_ud='0';
    public $preciototal='0';
    public $descripcion='';
    public $bloqueado=false;
    public $deshabilitado='';
    public $escliente='';

    protected function rules(){
        return [
            'presupuesto_id'=>'required',
            'proceso'=>'required',
            'tirada'=>'required',
            'precio_ud'=>'nullable',
            'preciototal'=>'nullable',
            'descripcion'=>'nullable',
            'visible'=>'nullable',
            'orden'=>'nullable',
        ];
    }

    public function messages(){
        return [
            'presupuesto_id'=>'El presupuesto es necesario.',
            'proceso'=>'El proceso es necesario.',
            'tirada'=>'La cantidad es necesario.',
        ];
    }

    public function mount($presupuestoid,$escliente){
        $this->presupuesto=Presupuesto::find($presupuestoid);
        $this->presupuesto_id=$presupuestoid;
        $this->deshabilitado= $escliente;
        $this->escliente= $escliente;
        $this->escliente=Auth::user()->hasRole('Cliente') ? 'disabled' : '';
    }

    public function render(){
        $presupprocesos=ModelsPresupuestoProceso::where('presupuesto_id',$this->presupuesto_id)->get();
        return view('livewire.presupuesto.presupuesto-procesootros',compact('presupprocesos'));
    }

    public function UpdatedTirada(){ if($this->tirada=='') $this->tirada=='0'; $this->preciototal=$this->precio_ud * $this->tirada; }
    public function UpdatedPrecioUd(){ if($this->precio_ud=='') $this->precio_ud=='0'; $this->preciototal=$this->precio_ud * $this->tirada; }

    public function save(){
        if(!$this->tirada) $this->tirada=0;
        if(!$this->precio_ud) $this->precio_ud=0;
        if(!$this->preciototal) $this->preciototal=0;

        $this->validate();
        $pproc=ModelsPresupuestoProceso::create([
            'presupuesto_id'=>$this->presupuesto_id,
            'proceso'=>$this->proceso,
            'tirada'=>$this->tirada,
            'precio_ud'=>$this->precio_ud,
            'preciototal'=>$this->preciototal,
            'descripcion'=>$this->descripcion,
            'visible'=>$this->visible,
            'orden'=>$this->orden,
        ]);

        $this->proceso='';
        $this->tirada='0';
        $this->precio_ud='0';
        $this->preciototal='0';
        $this->descripcion='';
        $this->visible='1';
        $this->orden='0';

        $this->dispatchBrowserEvent('notify', 'Guardado con éxito.');
    }

    public function delete($valorId)
    {
        $this->validate();

        $borrar = ModelsPresupuestoProceso::find($valorId);

        if ($borrar) {
            $borrar->delete();
            $this->dispatchBrowserEvent('notify', 'Línea eliminada!');
        }
    }

}
