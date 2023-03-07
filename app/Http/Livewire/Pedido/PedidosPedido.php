<?php

namespace App\Http\Livewire\Pedido;

use App\Models\{Pedido,Producto,PedidoProducto};
use Illuminate\Support\Facades\Storage;
use Livewire\Component;


class PedidosPedido extends Component
{

    public $pedidoId;
    public $pedido;
    public $tipo;
    public $estado;
    public $facturado;
    public $producto='';

    public function mount($pedidoId,$tipo){
        $this->tipo=$tipo;
        $this->pedido=Pedido::find($pedidoId);
        $this->estado=$this->pedido->estado;
        $this->facturado=$this->pedido->facturado;
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
            $this->dispatchBrowserEvent('notify', 'pedido borrado. ');
        }
    }

}
