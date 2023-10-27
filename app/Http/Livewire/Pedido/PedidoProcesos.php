<?php

namespace App\Http\Livewire\Pedido;

use App\Models\PedidoProceso;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;


class PedidoProcesos extends Component
{
    public $pedido_id;
    public $pprocesoid;
    public $pproceso;
    public $proceso;
    public $tirada;
    public $precio_ud;
    public $preciototal;
    public $orden;
    public $visible;
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

    public function mount($pproceso,$deshabilitado){

        $this->pproceso=$pproceso;
        $this->pprocesoid=$pproceso->id;
        $this->pedido_id=$pproceso->pedido_id;
        $this->descripcion=$pproceso->descripcion;
        $this->proceso=$pproceso->proceso;
        $this->tirada=$pproceso->tirada;
        $this->precio_ud=$pproceso->precio_ud;
        $this->preciototal=$pproceso->preciototal;
        $this->orden=$pproceso->orden;
        $this->visible=$pproceso->visible;
        $this->escliente=Auth::user()->hasRole('Cliente') ? 'disabled' : '';
    }

    public function render(){

        return view('livewire.pedido.pedido-procesosotros');
    }

    public function UpdatedOrden(){  $this->save(); }
    public function Updateddescripcion(){  $this->save(); }
    public function UpdatedVisible(){  $this->save(); }

    public function UpdatedTirada(){ if($this->tirada=='') $this->tirada=='0'; $this->preciototal=$this->precio_ud * $this->tirada;  }
    public function UpdatedPrecioUd(){ if($this->precio_ud=='') $this->precio_ud=='0'; $this->preciototal=$this->precio_ud * $this->tirada; ; }

    public function save(){
        if(!$this->tirada) $this->tirada=0;
        if(!$this->precio_ud) $this->precio_ud=0;
        if(!$this->preciototal) $this->preciototal=0;

        $this->validate();
        $pproc=PedidoProceso::updateOrCreate([
            'id'=>$this->pprocesoid
            ],
            [
            'pedido_id'=>$this->pedido_id,
            'proceso'=>$this->proceso,
            'descripcion'=>$this->descripcion,
            'tirada'=>$this->tirada,
            'precio_ud'=>$this->precio_ud,
            'preciototal'=>$this->preciototal,
            'visible'=>$this->visible,
            'orden'=>$this->orden,
        ]);
        $this->dispatchBrowserEvent('notify', 'Guardado con éxito.');

        $this->emit('refresh');
    }

    public function delete($valorId)
    {
        $this->validate();

        $borrar = PedidoProceso::find($valorId);

        if ($borrar) {
            $borrar->delete();
            $this->dispatchBrowserEvent('notify', 'Línea eliminada!');
        }

        $this->emit('refreshpedido');
    }

}

