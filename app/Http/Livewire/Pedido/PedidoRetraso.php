<?php

namespace App\Http\Livewire\Pedido;

use App\Models\{Pedido, PedidoRetraso as ModelsPedidoRetraso};
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class PedidoRetraso extends Component
{
    public $titulo='Retrasos: ';
    public $ruta;
    public $tipo;
    public $pedidoid;
    public $pedido;
    public $pdfvisible=false;

    public $routepdf='';

    public $campofecha='fecha';
    public $titcampofecha='Fecha';
    public $valorcampofecha='';
    public $longcampofecha='w-1/12';
    public $campofechavisible=1;
    public $campofechadisabled='';

    public $campo2='cantidad';
    public $titcampo2='Cantidad';
    public $valorcampo2='0';
    public $longcampo2='w-1/12';
    public $textcampo2='text-right';
    public $desplazcampo2='pr-2';
    public $tipocampo2='number';
    public $campo2visible=1;
    public $campo2disabled='';
    public $campo2selectname='';

    public $campo3='importe';
    public $titcampo3='Importe';
    public $valorcampo3='0';
    public $longcampo3='w-1/12';
    public $textcampo3='text-right';
    public $desplazcampo3='pr-2';
    public $tipocampo3='number';
    public $campo3visible=1;
    public $campo3disabled='';
    public $campo3selectname='';

    public $campo4='comentario';
    public $titcampo4='Comentario';
    public $valorcampo4='';
    public $longcampo4='w-7/12';
    public $textcampo4='text-left';
    public $desplazcampo4='pl-6';
    public $tipocampo4='text';
    public $campo4visible=1;
    public $campo4disabled='';

    public $campo5='';
    public $titcampo5='';
    public $valorcampo5='';
    public $longcampo5='';
    public $textcampo5='';
    public $desplazcampo5='';
    public $tipocampo5='';
    public $campo5visible=0;
    public $campo5disabled='';

    public $campo6='';
    public $titcampo6='';
    public $valorcampo6='';
    public $longcampo6='';
    public $textcampo6='';
    public $desplazcampo6='';
    public $tipocampo6='';
    public $campo6visible=0;
    public $campo6disabled='';

    public $campoimg='';
    public $titcampoimg='';
    public $valorcampoimg='';
    public $longcampoimg="";
    public $campoimgvisible=0;
    public $campoimgdisabled='';

    public $editarvisible=1;
    public $search='';
    public $escliente='';

    protected $queryString=['search'];


    protected $listeners = [ 'refresh' => '$refresh'];

    protected function rules(){
        return [
            'valorcampofecha'=>'required||date',
            'valorcampo2'=>'nullable',
            'valorcampo3'=>'nullable',
            'valorcampo4'=>'nullable',
            // 'valorcampoimg'=>'nullable',
        ];
    }

    public function messages(){
        return [
            'fecha.required'=>'La fecha es necesaria',
        ];
    }

    public function mount($pedidoid,$ruta,$tipo){
        $this->valorcampofecha=now()->format('Y-m-d');
        $this->pedido=Pedido::find($pedidoid);
        $this->tipo=$tipo;
        $this->ruta=$ruta;
        $this->escliente=Auth::user()->hasRole('Cliente')? 'disabled' : '';
    }

    public function render(){
        $valores=ModelsPedidoRetraso::query()
        ->where('pedido_id',$this->pedido->id)
        ->search('comentario',$this->search)
        ->select('id','fecha as valorcampofecha','cantidad as valorcampo2','importe as valorcampo3','comentario as valorcampo4')
        ->orderBy('fecha')
        ->get();

        return view('livewire.pedido.auxiliarpedidoscard',compact('valores'));
    }

    public function changeCampo(ModelsPedidoRetraso $valor,$campo,$valorcampo)
    {
        $p=ModelsPedidoRetraso::find($valor->id);
        $p->$campo=$valorcampo;
        $p->save();
        $this->dispatchBrowserEvent('notify', 'Retraso Actualizado.');
    }

    public function save()
    {
        $this->valorcampo2=$this->valorcampo2=='' ? '0' : $this->valorcampo2;
        $this->valorcampo3=$this->valorcampo3=='' ? '0' : $this->valorcampo3;
        $this->validate();
        ModelsPedidoRetraso::create([
            'pedido_id'=>$this->pedidoid,
            'fecha'=>$this->valorcampofecha,
            'cantidad'=>$this->valorcampo2,
            'importe'=>$this->valorcampo3,
            'comentario'=>$this->valorcampo4,
        ]);

        $pedido=Pedido::find($this->pedidoid);
        $pedido->hayRetrasos=$pedido->hayRetrasos+1;
        $pedido->save();


        $this->dispatchBrowserEvent('notify', 'Retraso añadido con éxito');

        $this->valorcampofecha=$this->valorcampofecha=now()->format('Y-m-d');
        $this->valorcampo2='0';
        $this->valorcampo3='0';
        $this->valorcampo4='';
        $this->valorcampoimg='';
        $this->campofechavisible=1;
        $this->campo2visible=1;
        $this->campo3visible=1;
        $this->campo4visible=1;
        $this->campoimgvisible=0;
        $this->emit('refresh');

    }

    public function delete($valorId)
    {
        $borrar = ModelsPedidoRetraso::find($valorId);

        if ($borrar) {
            $borrar->delete();
            $pedido=Pedido::find($this->pedidoid);
            $pedido->hayRetrasos=$pedido->hayRetrasos-1;
            $pedido->save();

            $this->dispatchBrowserEvent('notify', 'Retraso eliminado!');
        }
    }
}
