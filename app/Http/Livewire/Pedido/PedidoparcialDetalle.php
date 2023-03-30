<?php

namespace App\Http\Livewire\Pedido;

use App\Models\PedidoparcialDetalle as PedidoPedidoparcialDetalle;
use Livewire\Component;

class PedidoparcialDetalle extends Component
{
    public $parcialid;
    public $concepto;
    public $cantidad;
    public $precio_ud;
    public $total;

    protected $listeners = [ 'refresh' => '$refresh'];

    protected function rules()
    {
        return [
            'concepto'=>'required',
            'cantidad'=>'nullable|numeric',
            'precio_ud'=>'nullable|numeric',
            'total'=>'nullable|numeric',
        ];
    }

    public function messages(){
        return [
            'concepto.required'=>'El concepto es necesario',
            'cantidad.numeric'=>'La cantidad debe ser numérica',
        ];
    }

    public function mount($parcialid){
        $this->parcialid=$parcialid;
    }

    public function render(){
        $detalles=PedidoPedidoparcialDetalle::where('parcial_id',$this->parcialid)->get();
        return view('livewire.pedido.pedidoparcial-detalle',compact('detalles'));
    }

    public function updatedCantidad(){
        $this->total=$this->cantidad * $this->precio_ud;
    }
    public function updatedPrecioUd(){
        $this->total=$this->cantidad * $this->precio_ud;
    }

    public function changeCampo(PedidoPedidoparcialDetalle $valor, $campo, $valorcampo){
        $p=PedidoPedidoparcialDetalle::find($valor->id);
        $p->$campo=$valorcampo;
        $p->save();
        $p->total=$p->cantidad*$p->precio_ud;
        $p->save();
        $this->dispatchBrowserEvent('notify', 'Archivo Actualizado.');
    }

    public function save(){
        $this->validate();
        PedidoPedidoparcialDetalle::create([
            'parcial_id'=>$this->parcialid,
            'concepto'=>$this->concepto,
            'cantidad'=>$this->cantidad,
            'precio_ud'=>$this->precio_ud,
            'total'=>$this->precio_ud * $this->cantidad,
        ]);

        $this->dispatchBrowserEvent('notify', 'Línea añadida con éxito');

        $this->concepto='';
        $this->cantidad='0';
        $this->precio_ud='0';
        $this->total='0';
        $this->emit('refresh');

    }

    public function delete($valorId){
        $borrar = PedidoPedidoparcialDetalle::find($valorId);
        if ($borrar) {
            $borrar->delete();
            $this->dispatchBrowserEvent('notify', 'Línea eliminada!');
        }
    }

}
