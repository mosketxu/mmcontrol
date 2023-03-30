<?php

namespace App\Http\Livewire\Facturacion;

use App\Models\FacturaDetalle;
use App\Models\Pedido;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class Fdetalles extends Component
{
    public $fdetalle_id;
    public $factura_id='';
    public $pedido_id='';
    public $concepto='';
    public $cantidad='0';
    public $importe='0';
    public $subtotalsiniva='0';
    public $subtotaliva='0';
    public $subtotal='0';
    public $iva='0.21';
    public $orden='0';
    public $visible='0';
    public $observaciones='';

    public $factura;
    public $deshabilitado='';

    protected function rules(){
        return [
            'fdetalle_id'=>'required',
            'factura_id'=>'required',
            'pedido_id'=>'nullable',
            'concepto'=>'nullable',
            'cantidad'=>'numeric|required',
            'importe'=>'numeric|required',
            'iva'=>'numeric|required',
            'subtotalsiniva'=>'numeric|required',
            'subtotaliva'=>'numeric|required',
            'subtotal'=>'numeric|required',
            'orden'=>'required',
            'visible'=>'required',
            'observaciones'=>'nullable',
        ];
    }

    public function mount($factura,$fdetalle,$deshabilitado){
        $this->factura=$factura;
        $this->fdetalle_id=$fdetalle->id;
        $this->factura_id=$fdetalle->factura_id;
        $this->pedido_id=$fdetalle->pedido_id;
        $this->concepto=$fdetalle->concepto;
        $this->cantidad=$fdetalle->cantidad;
        $this->importe=$fdetalle->importe;
        $this->iva=$fdetalle->iva;
        $this->subtotalsiniva=$fdetalle->subtotalsiniva;
        $this->subtotaliva=$fdetalle->subtotaliva;
        $this->subtotal=$fdetalle->subtotal;
        $this->orden=$fdetalle->orden;
        $this->visible=$fdetalle->visible;
        $this->observaciones=$fdetalle->observaciones;
        $this->deshabilitado=$deshabilitado;
    }

    public function render(){
        $pedidos=Pedido::where('cliente_id',$this->factura->cliente_id)->where('facturado','<>','1')->select('id')->get();
        return view('livewire.facturacion.fdetalles',compact('pedidos'));
    }

    public function UpdatedPedidoId(){
        $pedido=Pedido::find($this->pedido_id);
        if($pedido) {
            if($pedido->tipo=='1'){
                $producto=$pedido->pedidoproductos->first()->producto;
                $this->importe=$producto->precioventa;
                $this->concepto=$producto->referencia;
                $this->calculos();
                $this->save();
            }
        }
    }

    public function calculos(){
        $this->subtotalsiniva=round($this->importe * $this->cantidad ,2);
        $this->subtotaliva=round($this->importe * $this->cantidad * $this->iva ,2);
        $this->subtotal=round($this->importe *$this->cantidad * (1+$this->iva) ,2);
    }

    public function UpdatedCantidad(){if($this->cantidad=='') $this->cantidad=='0'; $this->calculos(); $this->save();}
    public function UpdatedIva(){  if($this->iva=='') $this->iva=='0'; $this->calculos(); $this->save();}
    public function UpdatedImporte(){  if($this->importe=='') $this->importe=='0'; $this->calculos();  $this->save();}
    public function UpdatedOrden(){  $this->save(); }
    public function UpdatedConcepto(){  $this->save(); }
    public function UpdatedObservaciones(){  $this->save(); }
    public function UpdatedVisible(){  $this->save(); }



    public function save(){
        $this->validate();
        $fd=FacturaDetalle::find($this->fdetalle_id)->update([
            'factura_id'=>$this->factura_id,
            'pedido_id'=>$this->pedido_id,
            'concepto'=>$this->concepto,
            'cantidad'=>$this->cantidad,
            'importe'=>$this->importe,
            'iva'=>$this->iva,
            'subtotalsiniva'=>$this->subtotalsiniva,
            'subtotaliva'=>$this->subtotaliva,
            'subtotal'=>$this->subtotal,
            'orden'=>$this->orden,
            'visible'=>$this->visible,
            'observaciones'=>$this->observaciones
        ]);


        $totales = FacturaDetalle::where('factura_id',$this->factura->id)
            ->select('factura_id',
                DB::raw('SUM(subtotalsiniva) as subtotalsiniva'),
                DB::raw('SUM(subtotaliva) as subtotaliva'),
                DB::raw('SUM(subtotal) as subtotal'))
            ->groupBy("factura_id")
            ->first();

        $this->factura->update([
                'importe'=>$totales->subtotalsiniva,
                'iva'=>$totales->subtotaliva,
                'total'=>$totales->subtotal]
        );

        $mensaje="Actualizado con éxito";
        $this->emit('refreshfactura');
        $this->dispatchBrowserEvent('notify', $mensaje);
    }

    public function delete($valorId){
        $borrar = FacturaDetalle::find($valorId);
        if ($borrar) {
            $borrar->delete();
            $this->emit('refreshfactura');
            $this->dispatchBrowserEvent('notify', 'Línea eliminada!');
        }

    }
}
