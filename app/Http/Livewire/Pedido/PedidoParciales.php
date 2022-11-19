<?php

namespace App\Http\Livewire\Pedido;

use App\Models\{Pedido,PedidoParcial as ModelsPedidoParcial};
use Livewire\Component;

class PedidoParciales extends Component
{
    public $titulo='Albaranes: ';
    public $tipo;
    public $ruta;
    public $pedidoid;
    public $pedido;
    public $pdfvisible=true;

    public $routepdf='pedido.parcial';
    public $routepdfvbles='pedido.parcial';

    public $campofecha='fecha';
    public $titcampofecha='Fecha';
    public $valorcampofecha='';
    public $longcampofecha='w-1/12';
    public $campofechavisible=1;
    public $campofechadisabled='';

    public $campo2='id';
    public $titcampo2='Nº Albaran';
    public $valorcampo2='';
    public $longcampo2='w-1/12';
    public $textcampo2='text-right';
    public $desplazcampo2='';
    public $tipocampo2='number';
    public $campo2visible=1;
    public $campo2disabled='disabled';
    public $campo2selectname='';

    public $campo3='cantidad';
    public $titcampo3='Cantidad';
    public $valorcampo3='0';
    public $longcampo3='w-1/12';
    public $textcampo3='text-right';
    public $desplazcampo3='';
    public $tipocampo3='number';
    public $campo3visible=1;
    public $campo3disabled='';
    public $campo3selectname='';

    public $campo4='importe';
    public $titcampo4='Importe';
    public $valorcampo4='0';
    public $longcampo4='w-1/12';
    public $textcampo4='text-right';
    public $desplazcampo4='';
    public $tipocampo4='number';
    public $campo4visible=1;
    public $campo4disabled='';
    public $campo4selectname='';

    public $campo5='comentario';
    public $titcampo5='Comentario';
    public $valorcampo5='';
    public $longcampo5='w-7/12';
    public $textcampo5='text-left';
    public $desplazcampo5='';
    public $tipocampo5='text';
    public $campo5visible=1;
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

    protected $listeners = [ 'refresh' => '$refresh'];

    protected function rules()
    {
        return [
            'valorcampofecha'=>'required||date',
            'valorcampo2'=>'nullable',
            'valorcampo3'=>'nullable',
            'valorcampo4'=>'nullable',
            // 'valorcampoimg'=>'nullable',
        ];
    }

    public function messages()
    {
        return [
            'fecha.required'=>'La fecha es necesaria',
        ];
    }

    public function mount($pedidoid,$ruta,$tipo)
    {
        $this->valorcampofecha=now()->format('Y-m-d');
        $this->pedido=Pedido::find($pedidoid);
        $this->tipo=$tipo;
        $this->ruta=$ruta;
        $this->pedidoid=$pedidoid;
    }

    public function render()
    {
        $valores=ModelsPedidoParcial::query()
        ->search('comentario',$this->search)
        ->select('id','id as valorcampo2','fecha as valorcampofecha','cantidad as valorcampo3','importe as valorcampo4','comentario as valorcampo5')
        ->orderBy('fecha')
        ->paginate(10);


        return view('livewire.pedido.auxiliarpedidoscard',compact('valores'));
    }

    public function changeCampo(ModelsPedidoParcial $valor,$campo,$valorcampo)
    {
        $p=ModelsPedidoParcial::find($valor->id);
        $p->$campo=$valorcampo;
        $p->save();
        $this->dispatchBrowserEvent('notify', 'Parcial Actualizado.');
    }

    public function editar($parcialid)
    {
        return redirect()->route('pedido.parcial',[$this->pedidoid,$this->ruta,$parcialid]);
    }

    public function save()
    {
        $this->valorcampo2=$this->valorcampo2=='' ? '0' : $this->valorcampo2;
        $this->valorcampo3=$this->valorcampo3=='' ? '0' : $this->valorcampo3;
        $this->validate();
        $p=ModelsPedidoParcial::create([
            'pedido_id'=>$this->pedidoid,
            'fecha'=>$this->valorcampofecha,
            'cantidad'=>$this->valorcampo2,
            'importe'=>$this->valorcampo3,
            'comentario'=>$this->valorcampo4,
        ]);

        $this->dispatchBrowserEvent('notify', 'Parcial añadido con éxito');

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
        // $this->emit('refresh');

        $this->ruta='e';

        return redirect()->route('pedido.parcial',[$this->pedidoid,$this->ruta,$p->id]);

    }

    public function delete($valorId)
    {
        $borrar = ModelsPedidoParcial::find($valorId);

        if ($borrar) {
            $borrar->delete();
            $this->dispatchBrowserEvent('notify', 'Parcial eliminado!');
        }
    }
}
