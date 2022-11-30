<?php

namespace App\Http\Livewire\Pedido;

use App\Models\{Entidad, Pedido, PedidoPresupuesto as ModelsPedidoPresupuesto, Producto};

use Illuminate\Support\Facades\DB;

use Livewire\Component;

class PedidoPresupuesto extends Component
{
    public $titulo='Presupuestos: ';
    public $ruta;
    public $tipo;
    public $pedidoid;
    public $pedido;

    public $pdfvisible=true;
    public $routepdf='pedido.presupuesto';

    public $campofecha='fecha';
    public $titcampofecha='Fecha';
    public $valorcampofecha='';
    public $longcampofecha='w-1/12';
    public $campofechavisible=1;
    public $campofechadisabled='';

    public $campo2='producto_id';
    public $titcampo2='Producto';
    public $valorcampo2='';
    public $longcampo2='w-3/12';
    public $textcampo2='text-left';
    public $desplazcampo2='pl-10';
    public $tipocampo2='text';
    public $campo2visible=1;
    public $campo2disabled='disabled';
    public $campo2selectname='';

    public $campo3='proveedor_id';
    public $titcampo3='Proveedor';
    public $valorcampo3='';
    public $longcampo3='w-2/12';
    public $textcampo3='text-left';
    public $desplazcampo3='pl-16';
    public $tipocampo3='combo';
    public $campo3visible=1;
    public $campo3disabled='';
    public $campo3selectname='entidad';

    public $campo4='cantidad';
    public $longcampo4='w-2/12';
    public $titcampo4='Cantidad';
    public $valorcampo4='0';
    public $textcampo4='text-right';
    public $desplazcampo4='';
    public $tipocampo4='number';
    public $campo4visible=1;
    public $campo4disabled='';

    public $campo5='importe';
    public $titcampo5='Importe';
    public $valorcampo5='0';
    public $longcampo5='w-2/12';
    public $textcampo5='text-right';
    public $desplazcampo5='';
    public $tipocampo5='number';
    public $campo5visible=1;
    public $campo5disabled='';

    public $campo6='comentario';
    public $titcampo6='Comentario';
    public $valorcampo6='';
    public $longcampo6='w-4/12';
    public $textcampo6='text-left';
    public $desplazcampo6='pl-24';
    public $tipocampo6='text';
    public $campo6visible=1;
    public $campo6disabled='';

    public $campoimg='';
    public $titcampoimg='';
    public $valorcampoimg='';
    public $longcampoimg="w-2/12";
    public $campoimgvisible=0;
    public $campoimgdisabled='';


    public $editarvisible=0;
    public $search='';

    protected $listeners = [ 'refresh' => '$refresh'];

    protected function rules()
    {
        return [
            'valorcampofecha'=>'required||date',
            'valorcampo2'=>'nullable',
            'valorcampo3'=>'required',
            'valorcampo4'=>'numeric|required',
            'valorcampo5'=>'nullable',
            'valorcampo6'=>'nullable',
        ];
    }

    public function messages()
    {
        return [
            'valorcampofecha.required'=>'La fecha es necesaria',
            'valorcampo3.required'=>'El proveedor es necesario',
            'valorcampo4.required'=>'La cantidad es necesaria',
            'valorcampo4.numeric'=>'La cantidad debe ser númerica',
        ];
    }

    public function mount($pedidoid,$ruta,$tipo)
    {
        $this->valorcampofecha=now()->format('Y-m-d');
        $this->pedido=Pedido::find($pedidoid);
        $this->tipo=$tipo;
        $this->ruta=$ruta;
    }

    public function render()
    {

        $valores=ModelsPedidoPresupuesto::query()
        ->join('pedidos','pedido_presupuestos.pedido_id','=','pedidos.id')
        ->search('comentario',$this->search)
        ->select('pedido_presupuestos.id','fecha as valorcampofecha','productos.referencia as valorcampo2','pedido_presupuestos.proveedor_id as valorcampo3','cantidad as valorcampo4','importe as valorcampo5','comentario as valorcampo6')
        ->orderBy('fecha')
        ->paginate(10);


        $seleccionables3=Entidad::whereIn('entidadtipo_id',['2','3'])->orderBy('entidad')->get();

        return view('livewire.pedido.auxiliarpedidoscard',compact('valores','seleccionables3'));
    }

    public function changeCampo(ModelsPedidoPresupuesto $valor,$campo,$valorcampo)
    {
        $p=ModelsPedidoPresupuesto::find($valor->id);
        $p->$campo=$valorcampo;
        $p->save();
        $this->dispatchBrowserEvent('notify', 'Presupuesto Actualizado.');
    }

    public function save()
    {
        $this->valorcampo4=$this->valorcampo4=='' ? '0' : $this->valorcampo4;
        $this->valorcampo5=$this->valorcampo5=='' ? '0' : $this->valorcampo5;
        $this->validate();

        ModelsPedidoPresupuesto::create([
            'pedido_id'=>$this->pedidoid,
            'fecha'=>$this->valorcampofecha,
            'proveedor_id'=>$this->valorcampo3,
            'cantidad'=>$this->valorcampo4,
            'importe'=>$this->valorcampo5,
            'comentario'=>$this->valorcampo6,
        ]);

        $this->dispatchBrowserEvent('notify', 'Presupuesto añadido con éxito');

        $this->valorcampofecha=$this->valorcampofecha=now()->format('Y-m-d');
        $this->valorcampo2='';
        $this->valorcampo3='0';
        $this->valorcampo4='';
        $this->valorcampoimg='';
        $this->campofechavisible=1;
        $this->campo2visible=1;
        $this->campo3visible=1;
        $this->campo4visible=1;
        $this->campo5visible=1;
        $this->campo6visible=1;
        $this->campoimgvisible=0;
        $this->emit('refresh');

    }

    public function delete($valorId)
    {
        $borrar = ModelsPedidoPresupuesto::find($valorId);

        if ($borrar) {
            $borrar->delete();
            $this->dispatchBrowserEvent('notify', 'Presupuesto eliminado!');
        }
    }

}
