<?php

namespace App\Http\Livewire\Pedido;

use App\Models\Pedido;
use App\Models\PedidoParcial;
use App\Models\PedidoparcialDetalle as PedidoPedidoparcialDetalle;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class PedidoparcialDetalle extends Component
{
    public $parcialid;
    public $concepto;
    public $cantidad;
    public $precio_ud;
    public $total;
    public $escliente='';

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
        $this->escliente=Auth::user()->hasRole('Cliente')? 'disabled' : '';
    }

    public function render(){
        $detalles=PedidoPedidoparcialDetalle::where('parcial_id',$this->parcialid)->get();
        $facturado=\App\Models\FacturaDetalle::where('parcial_id',$this->parcialid)->first();
        return view('livewire.pedido.pedidoparcial-detalle',compact('detalles','facturado'));
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

    // Copia al albarán las líneas del pedido (concepto, cantidad y precio); las cantidades se pueden editar después.
    public function cargarDelPedido(){
        $parcial=PedidoParcial::find($this->parcialid);
        if(!$parcial) return;
        if($parcial->facturadetalles()->exists()){
            $this->dispatchBrowserEvent('notifyred', 'El albarán ya está facturado.');
            return;
        }
        $pedido=Pedido::find($parcial->pedido_id);
        if(!$pedido) return;

        $lineas=[];
        foreach($pedido->pedidoproductos()->orderBy('orden')->orderBy('id')->get() as $pp){
            $concepto=optional($pp->producto)->referencia ?: $pedido->descripcion;
            $precio=(float)$pp->precio_ud>0 ? $pp->precio_ud : $pedido->precio;
            $lineas[]=['concepto'=>$concepto,'cantidad'=>$pp->tirada,'precio_ud'=>$precio];
        }
        if(!$lineas){
            $lineas[]=['concepto'=>$pedido->descripcion,'cantidad'=>$parcial->cantidad ?: $pedido->tiradareal,'precio_ud'=>$pedido->precio];
        }
        foreach($lineas as $l){
            PedidoPedidoparcialDetalle::create([
                'parcial_id'=>$parcial->id,
                'concepto'=>$l['concepto'] ?: 'Pedido '.$pedido->id,
                'cantidad'=>$l['cantidad'] ?: 0,
                'precio_ud'=>$l['precio_ud'] ?: 0,
                'total'=>round(($l['cantidad'] ?: 0)*($l['precio_ud'] ?: 0),6),
            ]);
        }
        $this->dispatchBrowserEvent('notify', 'Líneas cargadas del pedido.');
    }

    public function delete($valorId){
        $borrar = PedidoPedidoparcialDetalle::find($valorId);
        if ($borrar) {
            $borrar->delete();
            $this->dispatchBrowserEvent('notify', 'Línea eliminada!');
        }
    }

}
