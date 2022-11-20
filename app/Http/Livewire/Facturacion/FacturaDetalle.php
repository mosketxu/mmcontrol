<?php

namespace App\Http\Livewire\Facturacion;

use App\Http\Livewire\Facturacion\FacturaDetalle as FacturacionFacturaDetalle;
use Livewire\Component;

use App\Models\Entidad;
use App\Models\Factura;
use App\Models\FacturaDetalle as ModelsFacturaDetalle;
use App\Models\Pedido;
use Illuminate\Support\Facades\DB;

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
    public $bloqueado=false;

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
            'bloqueado' => 'integer|size:0',
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
            'bloqueado.size'=>'La factura ya se ha enviado. Debe desbloquearla.',
        ];
    }

    public function mount($facturaid)
    {
        $this->factura=Factura::find($facturaid);
        $this->bloqueado= $this->factura->estado =='0' ? '0' : '1';
    }

    public function render()
    {

        $entidad=Entidad::find($this->factura->cliente_id);
        $pedidostodos=Pedido::where('cliente_id', $this->factura->cliente_id)->orderBy('id')->get();
        $pedidos=$pedidostodos->where('facturado','!=','1');
        $fdetalles=ModelsFacturaDetalle::where('factura_id',$this->factura->id)->orderBy('orden')->orderBy('pedido_id')->get();
        return view('livewire.facturacion.factura-detalle',compact(['fdetalles','entidad','pedidostodos','pedidos']));
    }


    public function changeValor(ModelsFacturaDetalle $facturadetalle,$campo,$valor)
    {
        $this->pedido_id=$facturadetalle->pedido_id;
        $this->validate();
        $this->pedido_id='';
        $facturadetalle->update([$campo=>$valor]);
        $facturadetalle->update([
            'subtotalsiniva'=>round($facturadetalle->importe * $facturadetalle->cantidad / $facturadetalle->unidad,2),
            'subtotaliva'=>round($facturadetalle->importe * $facturadetalle->cantidad * $facturadetalle->iva / $facturadetalle->unidad,2),
            'subtotal'=>round($facturadetalle->importe *$facturadetalle->cantidad * (1+$facturadetalle->iva) / $facturadetalle->unidad,2),
            ]);

        $totales = ModelsFacturaDetalle::where('factura_id',$this->factura->id)
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

        $this->emitUp('refreshfactura');

        $this->dispatchBrowserEvent('notify', 'Actualizado con éxito.');
    }

    public function changeVisible(ModelsFacturaDetalle $facturadetalle,$visible)
    {
        $facturadetalle->visible=$facturadetalle->visible=='1'? '0' : '1';
        $facturadetalle->update(['visible'=>$facturadetalle->visible]);
        $this->dispatchBrowserEvent('notify', 'Visible Actualizado.');
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
            'subtotalsiniva'=>round($this->importe * $this->cantidad / $this->unidad,2),
            'subtotaliva'=>round($this->importe * $this->cantidad / $this->unidad* $this->iva,2),
            'subtotal'=>round($this->importe * $this->cantidad / $this->unidad* (1+$this->iva),2),
            'orden'=>$this->orden,
            'visible'=>$this->visible,
            'observaciones'=>$this->observaciones,
            'cantidad'=>$this->cantidad,
        ]);

        $totales = ModelsFacturaDetalle::where('factura_id',$this->factura->id)
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

        $this->pedido_id=$valorId;
        $this->validate();
        $this->pedido_id='';

        $borrar = ModelsFacturaDetalle::find($valorId);

        if ($borrar) {
            $borrar->delete();
            $this->dispatchBrowserEvent('notify', 'Línea eliminada!');
        }
    }

}
