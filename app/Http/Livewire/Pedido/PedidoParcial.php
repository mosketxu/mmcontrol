<?php

namespace App\Http\Livewire\Pedido;

use App\Models\Entidad;
use App\Models\EntidadDestino;
use App\Models\Pedido;
use App\Models\PedidoParcial as ModelsPedidoParcial;

use Livewire\Component;

class PedidoParcial extends Component
{
    public $pedido;
    public $destinocalculado;
    public $parcial;
    public $ruta;
    public $tipo;
    public $pedidoparcial;

    protected function rules()
    {
        return [
            'parcial.fecha'=>'date|required',
            'parcial.cantidad'=>'nullable|numeric',
            'parcial.importe'=>'nullable|numeric',
            'parcial.comentario'=>'nullable',
            'parcial.destino'=>'required',
            'parcial.atencion'=>'nullable',
            'parcial.direccion'=>'nullable',
            'parcial.localidad'=>'nullable',
            'parcial.cp'=>'nullable',
            'parcial.horario'=>'nullable',
            'parcial.tfno'=>'nullable',
            'parcial.observaciones'=>'nullable',
        ];
    }

    public function messages()
    {
        return [
            'parcial.fecha.required'=>'La Fecha es necesaria',
            'parcial.fecha.date'=>'La Fecha debe ser válida',
            'parcial.cantidad.numeric'=>'La Cantidad deber ser numérica',
            'parcial.importe.numeric'=>'El Importe deber ser numérico',
            'parcial.destino.required'=>'El destino es necesario',
        ];
    }
    public function mount($pedidoid,$ruta,$tipo,$parcialid)
    {

        $this->pedido=Pedido::find($pedidoid);
        $this->parcial=ModelsPedidoParcial::find($parcialid);
        $ruta=$this->ruta;
        $tipo=$this->tipo;
        $this->pedidoparcial=ModelsPedidoParcial::find($parcialid);

    }

    public function render()
    {
        $entidad=Entidad::find($this->pedido->cliente_id);
        $destinos=EntidadDestino::where('entidad_id',$this->pedido->cliente_id)->get();
        return view('livewire.pedido.pedido-parcial',compact('entidad','destinos'));
    }

    public function updatedDestinocalculado(){
        $d=EntidadDestino::find($this->destinocalculado);
        if ($d) {
            $this->parcial->destino=$d->destino;
            $this->parcial->atencion=$d->atencion;
            $this->parcial->direccion=$d->direccion;
            $this->parcial->localidad=$d->localidad;
            $this->parcial->cp=$d->cp;
            $this->parcial->horario=$d->horario;
            $this->parcial->tfno=$d->tfno;
            $this->parcial->observaciones=$d->observaciones;
        } else {
            $this->parcial->destino='';
            $this->parcial->atencion='';
            $this->parcial->direccion='';
            $this->parcial->localidad='';
            $this->parcial->cp='';
            $this->parcial->horario='';
            $this->parcial->tfno='';
            $this->parcial->observaciones='';
        }
    }

    public function save(){
        $parc = ModelsPedidoParcial::find($this->parcial->id);

        $parc->destino=$this->parcial->destino;
        $parc->atencion=$this->parcial->atencion;
        $parc->direccion=$this->parcial->direccion;
        $parc->localidad=$this->parcial->localidad;
        $parc->cp=$this->parcial->cp;
        $parc->horario=$this->parcial->horario;
        $parc->tfno=$this->parcial->tfno;
        $parc->observaciones=$this->parcial->observaciones;


        $parc->save();

        $this->dispatchBrowserEvent('notify', 'Guardado con éxito.');
    }
}
