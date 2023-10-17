<?php

namespace App\Http\Livewire\Oferta;

use App\Models\OfertaProceso;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class OfertaProcesos extends Component
{
    public $oferta_id;
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

    protected function rules(){
        return [
            'oferta_id'=>'required',
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
            'oferta_id'=>'El oferta es necesario.',
            'proceso'=>'El proceso es necesario.',
            'tirada'=>'La cantidad es necesario.',

        ];
    }

    public function mount($pproceso,$deshabilitado){

        $this->pproceso=$pproceso;
        $this->pprocesoid=$pproceso->id;
        $this->oferta_id=$pproceso->oferta_id;
        $this->descripcion=$pproceso->descripcion;
        $this->proceso=$pproceso->proceso;
        $this->tirada=$pproceso->tirada;
        $this->precio_ud=$pproceso->precio_ud;
        $this->preciototal=$pproceso->preciototal;
        $this->orden=$pproceso->orden;
        $this->visible=$pproceso->visible;
        $this->deshabilitado=$deshabilitado;
        if(Auth::user()->hasRole('Cliente')) $this->deshabilitado='disabled';
    }

    public function render(){

        return view('livewire.oferta.oferta-procesosotros');
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
        $pproc=OfertaProceso::updateOrCreate([
            'id'=>$this->pprocesoid
            ],
            [
            'oferta_id'=>$this->oferta_id,
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

    public function delete($valorId){
        $borrar = OfertaProceso::find($valorId);

        if ($borrar) {
            $borrar->delete();
            $this->dispatchBrowserEvent('notify', 'Línea eliminada!');
        }

        $this->emit('refreshoferta');
    }

}

