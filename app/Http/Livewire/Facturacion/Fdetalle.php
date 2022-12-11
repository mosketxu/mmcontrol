<?php

namespace App\Http\Livewire\Facturacion;

use Livewire\Component;

use App\Models\Entidad;
use App\Models\Factura;
use App\Models\FacturaDetalle as ModelsFacturaDetalle;
use App\Models\Pedido;
use App\Models\Producto;
use Illuminate\Support\Facades\DB;

class Fdetalle extends Component
{
    public $factura;
    public $pedido_id;
    public $cantidad='0';
    public $iva='0.21';
    public $concepto;
    public $importe='0';
    public $orden='0';
    public $visible=true;
    public $observaciones;
    public $bloqueado=false;
    public $deshabilitado='';

    public $fdetalle;
    public $subtotalsiniva=0;
    public $subtotaliva=0;
    public $subtotal=0;

    protected function rules(){
        return [
            'pedido_id'=>'nullable',
            'cantidad'=>'required|numeric',
            'iva'=>'required|numeric',
            'concepto'=>'nullable',
            'importe'=>'required|numeric',
            'orden'=>'nullable',
            'visible'=>'nullable',
            'observaciones'=>'nullable',
            'bloqueado' => 'integer|size:0',
        ];
    }

    public function messages(){
        return [
            'cantidad.required'=>'La cantidad es necesaria.',
            'iva.required'=>'El iva es necesario.',
            'iva.numeric'=>'El iva debe ser numérico.',
            'importe.required'=>'El importe es necesario.',
            'importe.numeric'=>'El importe debe ser numérico.',
            'bloqueado.size'=>'La factura ya se ha enviado. Debe desbloquearla.',
        ];
    }

    public function mount($facturaid,$deshabilitado)
    {
        $this->factura=Factura::find($facturaid);
        $this->bloqueado= $this->factura->estado =='0' ? '0' : '1';
        $this->deshabilitado= $deshabilitado;
    }

    public function render()
    {
        $entidad=Entidad::find($this->factura->cliente_id);
        $pedidostodos=Pedido::where('cliente_id', $this->factura->cliente_id)->where('pedidocliente',$this->factura->pedidocliente)->orderBy('id')->get();
        $pedidos=$pedidostodos->where('facturado','!=','1');
        $fdetalles=ModelsFacturaDetalle::where('factura_id',$this->factura->id)->orderBy('orden')->orderBy('pedido_id')->get();
        return view('livewire.facturacion.fdetalle',compact(['fdetalles','entidad','pedidostodos','pedidos']));
    }

    public function UpdatedPedidoId(){
        $pedido=Pedido::find($this->pedido_id);
        if($pedido) {
            if($pedido->tipo=='1'){
                $prod=$pedido->pedidoproductos->first();
                if($prod){
                    $producto= Producto::find($prod->producto_id);
                    $this->importe=$producto->precioventa;
                    $this->concepto=$producto->referencia;
                    $this->calculos();
                }
            }
        }
    }

    public function calculos(){
        $this->subtotalsiniva=round($this->importe * $this->cantidad ,2);
        $this->subtotaliva=round($this->importe * $this->cantidad * $this->iva ,2);
        $this->subtotal=round($this->importe *$this->cantidad * (1+$this->iva) ,2);
    }

    public function UpdatedCantidad(){ if($this->cantidad=='') $this->cantidad=='0'; $this->calculos(); }
    public function UpdatedIva(){  if($this->iva=='') $this->iva=='0'; $this->calculos();}
    public function UpdatedImporte(){  if($this->importe=='') $this->importe=='0'; $this->calculos(); }

    public function changeValor(ModelsFacturaDetalle $facturadetalle,$campo,$valor)
    {
        $this->validate();
        $facturadetalle->update([$campo=>$valor]);
        $facturadetalle->update([
            'subtotalsiniva'=>round($facturadetalle->importe * $facturadetalle->cantidad ,2),
            'subtotaliva'=>round($facturadetalle->importe * $facturadetalle->cantidad * $facturadetalle->iva ,2),
            'subtotal'=>round($facturadetalle->importe *$facturadetalle->cantidad * (1+$facturadetalle->iva) ,2),
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
        if($this->pedido_id=='') $this->pedido_id=null;
        // dd()

        $this->validate();
        $fdetalle=ModelsFacturaDetalle::create([
            'factura_id'=>$this->factura->id,
            'pedido_id'=>$this->pedido_id,
            'concepto'=>$this->concepto,
            'cantidad'=>$this->cantidad,
            'iva'=>$this->iva,
            'importe'=>$this->importe,
            'subtotalsiniva'=>round($this->importe * $this->cantidad ,2),
            'subtotaliva'=>round($this->importe * $this->cantidad * $this->iva,2),
            'subtotal'=>round($this->importe * $this->cantidad * (1+$this->iva),2),
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
        $this->concepto='';
        $this->importe='0';
        $this->orden='0';
        $this->visible=true;
        $this->observaciones='';

        $this->dispatchBrowserEvent('notify', 'Guardado con éxito.');
    }

    public function delete($valorId)
    {
        $this->validate();

        $borrar = ModelsFacturaDetalle::find($valorId);

        if ($borrar) {
            $borrar->delete();
            $this->dispatchBrowserEvent('notify', 'Línea eliminada!');
        }
    }

}
