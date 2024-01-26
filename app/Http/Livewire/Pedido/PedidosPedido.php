<?php

namespace App\Http\Livewire\Pedido;

use App\Models\{Factura, FacturaDetalle, Pedido,Producto,PedidoProducto};
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;


class PedidosPedido extends Component
{

    public $pedidoId;
    public $pedido;
    public $tipo;
    public $estado;
    public $ctrarchivos;
    public $ctrplotter;
    public $ctrentrega;
    public $facturado;
    public $producto='';
    public $escliente='';

    protected $listeners = [ 'refreshpedidospedido' => '$refresh'];

    public function mount($pedido,$tipo){
        $this->tipo=$tipo;
        $this->pedido=$pedido;
        $this->estado=$this->pedido->estado;
        $this->facturado=$this->pedido->facturado;
        $this->ctrarchivos=$this->pedido->ctrarchivos;
        $this->ctrplotter=$this->pedido->ctrplotter;
        $this->ctrentrega=$this->pedido->ctrentrega;

        $this->escliente=Auth::user()->hasRole('Cliente') ? 'disabled' : '';

    }

    public function render(){
        return view('livewire.pedido.pedidos-pedido');
    }

    public function cambiaEstado(){
        if($this->estado!='2')
            $this->estado=$this->estado+1;
        else
            $this->estado='0';

        $this->pedido->estado=$this->estado;
        $this->pedido->save();

    }

    public function cambiaEstadocontrolfecha($ctrl){
        $this->$ctrl=$this->$ctrl =='1' ? '0' : '1';
        // dd($this->pedido);
        $this->pedido->$ctrl=$this->$ctrl;

        $this->pedido->save();
        $this->pedido=Pedido::query()
        ->join('entidades','pedidos.cliente_id','=','entidades.id')
        ->leftjoin('pedido_productos','pedido_productos.pedido_id','=','pedidos.id')
        ->leftjoin('productos','pedido_productos.producto_id','=','productos.id')
        ->select('pedidos.*','entidades.entidad as cli', 'productos.isbn as isbn','productos.referencia as ref')
        ->find($this->pedido->id);

        // $this->emit('refreshpedidospedido');
    }

    public function generarfactura(){
        $existe=FacturaDetalle::where('pedido_id',$this->pedido->id)->first();
        // si existe voy a la primera factura donde esté ese pedido
        if($existe){
            $factura=Factura::find($existe->factura_id);
            return redirect()->route('facturacion.edit',$factura);
        }

        // si no existe creo la factura con los datos de este pedido
        $anyo= substr(now(), 0,4);
        $anyo2= substr($anyo, -2);
        $fac=Factura::inYear($anyo)->max('id') ;
        $numfra= !isset($fac) ? ($anyo2 * 100000 +1961) :$fac + 1 ;

        $factura=Factura::create([
            'id'=>$numfra,
            'cliente_id'=>$this->pedido->cliente_id,
            'contacto_id'=>$this->pedido->contacto_id,
            'fecha'=>now(),
            'importe'=>$this->pedido->preciototal ,
            'iva'=>round($this->pedido->preciototal * 0.21,4),
            'total'=>round($this->pedido->preciototal *1.21,4),
            'pedidocliente'=>$this->pedido->pedidocliente,
            'tipo'=>$this->pedido->tipo,
        ]);

        // añadir en el detalle el pedido
        if($this->pedido->tipo=='1')
            $concepto=$this->pedido->pedidoproductos->first()->producto->referencia;
        else
            $concepto=$this->pedido->descripcion;

        FacturaDetalle::create([
            'factura_id'=>$numfra,
            'pedido_id'=>$this->pedido->id,
            'importe'=>$this->pedido->precio,
            'cantidad'=>$this->pedido->tiradareal,
            'iva'=>'0.21',
            'subtotalsiniva'=>round($this->pedido->precio * $this->pedido->tiradareal ,4),
            'subtotaliva'=>round($this->pedido->precio * $this->pedido->tiradareal * 0.21,4),
            'subtotal'=>round($this->pedido->precio * $this->pedido->tiradareal * 1.21,4),
            'concepto'=>$concepto,
            'orden'=>'0',
            'visible'=>'1',
        ]);

        //actualizar pedido a facturado
        $this->pedido->facturado='1';
        $this->pedido->save();
        return redirect()->route('facturacion.edit',$numfra);
    }

    public function cambiaFac(){
        if($this->facturado!='2')
            $this->facturado=$this->facturado+1;
        else
            $this->facturado='0';

        $this->pedido->facturado=$this->facturado;
        $this->pedido->save();
    }

    public function delete($pedidoId){
        $existe=Storage::disk('archivospedido')->exists($pedidoId);
        if ($existe) Storage::disk('archivospedido')->deleteDirectory($pedidoId);

        $pedido = Pedido::find($pedidoId);
        if ($pedido) {
            $pedido->delete();
            $this->emit('refreshpedidospedido');
            $this->dispatchBrowserEvent('notify', 'pedido borrado. ');

        }

    }

}
