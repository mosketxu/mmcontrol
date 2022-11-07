<?php

namespace App\Http\Livewire\Pedido;

use App\Models\{Pedido, PedidoDistribucion as ModelsPedidoDistribucion};



use Livewire\Component;

class PedidoDistribucion extends Component
{
    public $titulo='Distribuciones del pedido: ';
    public $ruta;
    public $tipo;
    public $pedidoid;
    public $titcampofecha='Fecha';
    public $titcampo2='Cantidad';
    public $titcampo3='Importe';
    public $titcampo4='Comentario';
    public $titcampoimg='';
    public $valorcampofecha='';
    public $valorcampo2='0';
    public $valorcampo3='0';
    public $valorcampo4='';
    public $valorcampoimg='';
    public $campofecha='fecha';
    public $campo2='cantidad';
    public $campo3='importe';
    public $campo4='comentario';
    public $campoimg='';
    public $campofechavisible=1;
    public $campo2visible=1;
    public $campo3visible=1;
    public $campo4visible=1;
    public $campoimgvisible=0;
    public $campofechadisabled='';
    public $campo2disabled='';
    public $campo3disabled='disabled';
    public $campo4disabled='';
    public $campoimgdisabled='';
    public $editarvisible=0;
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
        $this->ped=Pedido::find($pedidoid);
        $this->tipo=$tipo;
        $this->ruta=$ruta;
    }

    public function render()
    {
        $valores=ModelsPedidoDistribucion::query()
        ->search('comentario',$this->search)
        ->select('id','fecha as valorcampofecha','cantidad as valorcampo2','importe as valorcampo3','comentario as valorcampo4')
        ->orderBy('fecha')
        ->paginate(10);

        return view('livewire.pedido.auxiliarpedidoscard',compact('valores'));
    }

    public function changeCampo(ModelsPedidoDistribucion $valor,$campo,$valorcampo)
    {
        $p=ModelsPedidoDistribucion::find($valor->id);
        $p->$campo=$valorcampo;
        $p->save();
        $this->dispatchBrowserEvent('notify', 'Distribución Actualizada.');
    }

    public function save()
    {
        $this->valorcampo2=$this->valorcampo2=='' ? '0' : $this->valorcampo2;
        $this->valorcampo3=$this->valorcampo3=='' ? '0' : $this->valorcampo3;
        $this->validate();
        ModelsPedidoDistribucion::create([
            'pedido_id'=>$this->pedidoid,
            'fecha'=>$this->valorcampofecha,
            'cantidad'=>$this->valorcampo2,
            'importe'=>$this->valorcampo3,
            'comentario'=>$this->valorcampo4,
        ]);

        $this->dispatchBrowserEvent('notify', 'Distribución añadida con éxito');

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
        $borrar = ModelsPedidoDistribucion::find($valorId);

        if ($borrar) {
            $borrar->delete();
            $this->dispatchBrowserEvent('notify', 'Distribución eliminada!');
        }
    }
}
