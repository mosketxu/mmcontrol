<?php

namespace App\Http\Livewire\Pedido;

use App\Models\{Pedido, PedidoProceso as ModelsPedidoProceso};
use Illuminate\Support\Facades\Auth;
use Livewire\Component;


class PedidoProceso extends Component
{
    public $pedido;
    public $pedido_id;
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
            'pedido_id'=>'required',
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
            'pedido_id'=>'El pedido es necesario.',
            'proceso'=>'El proceso es necesario.',
            'tirada'=>'La cantidad es necesario.',
        ];
    }

    public function mount($pedidoid,$deshabilitado){
        $this->pedido=Pedido::find($pedidoid);
        $this->pedido_id=$pedidoid;
        $this->deshabilitado= $deshabilitado;
        $this->escliente=Auth::user()->hasRole('Cliente') ? 'disabled' : '';
    }

    public function render(){
        $pedprocesos=ModelsPedidoProceso::where('pedido_id',$this->pedido_id)->get();
        return view('livewire.pedido.pedido-procesootros',compact('pedprocesos'));
    }

    public function UpdatedTirada(){ if($this->tirada=='') $this->tirada=='0'; $this->preciototal=$this->precio_ud * $this->tirada; }
    public function UpdatedPrecioUd(){ if($this->precio_ud=='') $this->precio_ud=='0'; $this->preciototal=$this->precio_ud * $this->tirada; }

    public function save(){
        if(!$this->tirada) $this->tirada=0;
        if(!$this->precio_ud) $this->precio_ud=0;
        if(!$this->preciototal) $this->preciototal=0;

        $this->validate();
        $pproc=ModelsPedidoProceso::create([
            'pedido_id'=>$this->pedido_id,
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

        $borrar = ModelsPedidoProceso::find($valorId);

        if ($borrar) {
            $borrar->delete();
            $this->dispatchBrowserEvent('notify', 'Línea eliminada!');
        }
    }

}
