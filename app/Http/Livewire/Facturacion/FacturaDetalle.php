<?php

namespace App\Http\Livewire\Facturacion;

use App\Http\Livewire\Facturacion\FacturaDetalle as FacturacionFacturaDetalle;
use Livewire\Component;

use App\Models\Entidad;
use App\Models\Factura;
use App\Models\FacturaDetalle as ModelsFacturaDetalle;
use App\Models\Pedido;


class FacturaDetalle extends Component
{
    public $factura;
    public $pedido_id;
    public $cantidad='0';
    public $unidad='1';
    public $iva='0.21';
    public $concepto;
    public $importe='0';
    public $orden='0';
    public $visible=true;
    public $observaciones;

    public $fdetalle;

    protected function rules()
    {
        return [
            'pedido_id'=>'required',
            'cantidad'=>'required|numeric',
            'unidad'=>'required|numeric',
            'iva'=>'required|numeric',
            'concepto'=>'nullable',
            'importe'=>'required|numeric',
            'orden'=>'nullable',
            'visible'=>'nullable',
            'observaciones'=>'nullable',
        ];
    }

    public function messages()
    {
        return [
            'pedido_id.required'=>'El pedido es necesario.',
            'cantidad.required'=>'La cantidad es necesaria.',
            'unidad.required'=>'Las unidades son necesarias.',
            'iva.required'=>'El iva es necesario.',
            'iva.numeric'=>'El iva debe ser numérico.',
            'importe.required'=>'El importe es necesario.',
            'importe.numeric'=>'El importe debe ser numérico.',
        ];
    }

    public function mount($facturaid)
    {
        $this->factura=Factura::find($facturaid);
    }

    public function render()
    {
        $entidad=Entidad::find($this->factura->cliente_id);
        $pedidos=Pedido::where('cliente_id', $this->factura->cliente_id)->where('facturado','!=','1')->orderBy('id')->get();
        $fdetalles=ModelsFacturaDetalle::where('factura_id',$this->factura->id)->get();
        return view('livewire.facturacion.factura-detalle',compact(['fdetalles','entidad','pedidos']));
    }

    // public function updatedFdetalleCantidad()
    // {
    //     $this->calculoImporte($this->fdetalle);
    // }

    // public function updatedFdetalleImporte()
    // {
    //     $this->calculoImporte($this->fdetalle);
    // }

    // public function updatedFdetalleIva()
    // {
    //     $this->calculoImporte($this->fdetalle);
    // }

    // public function updatedFdetalleUnidad()
    // {
    //     $this->calculoImporte($this->fdetalle);
    // }


    public function calculoImporte()
    {

        $this->importe=$this->cantidad*$this->preciounidad/$this->unidad;
        $this->subtotaliva=$this->importe*$this->iva;
        $this->subtota=$this->importe+$this->iva;
    }

    public function changeValor(ModelsFacturaDetalle $facturadetalle,$campo,$valor)
    {
        $facturadetalle->update([$campo=>$valor]);
        $this->dispatchBrowserEvent('notify', 'Actualizado con éxito.');
    }

    public function save(){

        if(!$this->cantidad) $this->cantidad=0;
        if(!$this->iva) $this->iva=0;
        if(!$this->unidad) $this->unidad=1;

        $this->validate();

        $fdetalle=ModelsFacturaDetalle::create([
            'factura_id'=>$this->factura->id,
            'pedido_id'=>$this->pedido_id,
            'concepto'=>$this->concepto,
            'cantidad'=>$this->cantidad,
            'unidad'=>$this->unidad,
            'iva'=>$this->iva,
            'importe'=>$this->importe,
            'subtotalsiniva'=>$this->importe * $this->cantidad / $this->unidad,
            'subtotaliva'=>$this->importe * $this->cantidad / $this->unidad* $this->iva,
            'subtotal'=>$this->importe * $this->cantidad / $this->unidad* (1+$this->iva),
            'orden'=>$this->orden,
            'visible'=>$this->visible,
            'observaciones'=>$this->observaciones,
            'cantidad'=>$this->cantidad,
        ]);

        $this->factura->importe = ModelsFacturaDetalle::where('factura_id',$this->factura->id)->sum('importe');
        $this->factura->iva = ModelsFacturaDetalle::where('factura_id',$this->factura->id)->sum('subtotaliva');
        $this->factura->total = ModelsFacturaDetalle::where('factura_id',$this->factura->id)->sum('subtotal');



        $this->pedido_id='';
        $this->cantidad='0';
        $this->unidad='1';
        $this->concepto='';
        $this->importe='0';
        $this->orden='0';
        $this->visible=true;
        $this->observaciones='';

        $this->dispatchBrowserEvent('notify', 'Guardado con éxito.');
    }

    public function delete($valorId)
    {
        $borrar = ModelsFacturaDetalle::find($valorId);

        if ($borrar) {
            $borrar->delete();
            $this->dispatchBrowserEvent('notify', 'Línea eliminada!');
        }
    }

}
