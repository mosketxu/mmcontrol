<?php

namespace App\Http\Livewire\Pedido;

use App\Models\{Entidad,Pedido,PedidoFacturacion as ModelsPedidoFacturacion};
use Livewire\Component;

class PedidoFacturacion extends Component
{
    public $titulo='Facturación: ';
    public $ruta;
    public $tipo;
    public $pedidoid;
    public $pedido;
    public $pdfvisible=false;
    public $cliente_id;
    public $fecha;
    public $cantidad='0';
    public $importe='0';
    public $estado='0';
    public $comentario='';
    public $search='';

    protected $listeners = [ 'refresh' => '$refresh'];

    protected function rules()
    {
        return [
            'pedido_id'=>'required',
            'cliente_id'=>'required',
            'fecha'=>'date|required',
            'cantidad'=>'nullable|numeric',
            'importe'=>'nullable|numeric',
            'estado'=>'nullable',
        ];
    }

    public function messages()
    {
        return [
            'pedido_id.required'=>'El campo Pedido es recesario.',
            'cliente_id.required'=>'El campo Cliente_id es recesario.',
            'fecha.required'=>'El campo fecha es recesario.',
            'fecha.date'=>'El campo fecha debe ser de tipo fecha.',
            'cantidad.numeric'=>'El campo Cantidad debe ser numérico',
            'importe.numeric'=>'El campo Importe debe ser numérico',
        ];
    }

    public function mount($pedidoid,$ruta,$tipo)
    {
        $this->pedido=Pedido::find($pedidoid);
        $this->tipo=$tipo;
        $this->ruta=$ruta;
        $this->fecha=now()->format('Y-m-d');
        $this->pedidoid=$pedidoid;
        $this->cliente_id=$this->pedido->cliente_id;
    }

    public function render()
    {
        $facturas=ModelsPedidoFacturacion::query()
        ->search('comentario',$this->search)
        ->orderBy('id')
        ->paginate(10);

        $clientes=Entidad::orderBy('entidad')->whereIn('entidadtipo_id',['1','2'])->get();

        return view('livewire.pedido.facturas',compact('facturas','clientes'));
    }

    public function changeCampo(ModelsPedidoFacturacion $valor,$campo,$valorcampo)
    {
        $p=ModelsPedidoFacturacion::find($valor->id);
        $p->$campo=$valorcampo;
        $p->save();
        $this->dispatchBrowserEvent('notify', 'Facturación Actualizada.');
    }

    public function save()
    {
        $this->validate();
        $f=$this->numfactura();
        // dd($this->pedido_id);
        ModelsPedidoFacturacion::create([
            'id'=>$f,
            'pedido_id'=>$this->pedido_id,
            'cliente_id'=>$this->cliente_id,
            'fecha'=>$this->fecha,
            'cantidad'=>$this->cantidad,
            'importe'=>$this->importe,
            'estado'=>$this->estado,
            'comentario'=>$this->comentario,
        ]);

        $this->dispatchBrowserEvent('notify', 'Facturación añadida con éxito');

            $this->fecha==now()->format('Y-m-d');
            $this->cantidad='0';
            $this->importe='0';
            $this->estado='0';

        $this->emit('refresh');

    }

    public function numfactura(){
        $anyo= substr($this->fecha, 0,4);
        $anyo2= substr($anyo, -2);
        // if (!isset($this->pedidoid)){
            $fac=ModelsPedidoFacturacion::whereYear('fecha', $anyo)->max('id') ;
            return !isset($fac) ? ($anyo2 * 100000 +1) :$fac + 1 ;
        // }
    }

    public function delete($valorId)
    {
        $borrar = ModelsPedidoFacturacion::find($valorId);

        if ($borrar) {
            $borrar->delete();
            $this->dispatchBrowserEvent('notify', 'Facturación eliminada!');
        }
    }
}
