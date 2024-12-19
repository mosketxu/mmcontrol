<?php

namespace App\Http\Livewire\Pedido;

use App\Models\Pedido;
use App\Models\PedidoSubpedido as ModelsPedidoSubpedido;
use Illuminate\Support\Facades\Auth;


use Livewire\Component;

class PedidoSubpedido extends Component{

    public $ruta;
    public $tipo;
    public $pedido;

    public $referencia='';
    public $pedidoid='';
    public $unidades='';
    public $otros='';
    public $fecha_archivos='';
    public $fecha_plotters='';
    public $fecha_entrega='';

    public $editarvisible=0;
    public $search='';
    public $escliente='';

    protected $queryString=['search'];


    protected $listeners = [ 'refresh' => '$refresh'];

    protected function rules()
    {
        return [
            'referencia'=>'required',
            'pedidoid'=>'required',
            'unidades'=>'required',
            'otros'=>'nullable',
            'fecha_archivos'=>'nullable',
            'fecha_plotters'=>'nullable',
            'fecha_entrega'=>'nullable',
        ];
    }

    public function messages()
    {
        return [
            'referencia.required'=>'La referencia/ISBN es necesaria.',
            'unidades.required'=>'Las unidades son necesarias',
        ];
    }

    public function mount($pedidoid,$ruta,$tipo)
    {
        $this->pedido=Pedido::find($pedidoid);
        $this->pedidoid=$pedidoid;
        $this->tipo=$tipo;
        $this->ruta=$ruta;
        $this->escliente=Auth::user()->hasRole('Cliente')? 'disabled' : '';
    }

    public function render()
    {
        $subpedidos=ModelsPedidoSubpedido::query()
        ->search('referencia', $this->search)
        ->where('pedido_id',$this->pedido->id)
        ->orderBy('referencia')
        ->get();


        return view('livewire.pedido.pedido-subpedido', compact('subpedidos'));
    }

    public function changeCampo(ModelsPedidoSubpedido $valor, $campo, $valorcampo)
    {
        $p=ModelsPedidoSubpedido::find($valor->id);
        $p->$campo=$valorcampo;
        $p->save();
        $this->dispatchBrowserEvent('notify', 'Subpedido Actualizado.');
    }

    public function save()
    {
        $this->validate();

        $pedidoarchivo=ModelsPedidoSubpedido::create([
            'pedido_id'=>$this->pedidoid,
            'referencia'=>$this->referencia,
            'unidades'=> $this->unidades,
            'otros'=> $this->otros,
            'fecha_archivos'=> $this->fecha_archivos,
            'fecha_plotters'=> $this->fecha_plotters,
            'fecha_entrega'=> $this->fecha_entrega
        ]);

        $this->dispatchBrowserEvent('notify', 'Subpedido añadido con éxito');

        return redirect()->route('pedido.subpedidos',[$this->pedidoid,$this->ruta]);
    }

    public function delete($valorId)
    {
        $borrar = ModelsPedidoSubpedido::find($valorId);

        if ($borrar) {
            $borrar->delete();
            $pedido=ModelsPedidoSubpedido::find($borrar->pedido_id);
            $pedido->save();
            $this->dispatchBrowserEvent('notify', 'Subpedido eliminado!');
        }
    }
}
