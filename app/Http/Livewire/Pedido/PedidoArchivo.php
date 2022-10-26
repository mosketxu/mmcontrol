<?php

namespace App\Http\Livewire\Pedido;

use App\Models\PedidoArchivo as ModelsPedidoArchivo;
use Livewire\Component;

class PedidoArchivo extends Component
{
    public $titulo='Archivos';
    public $pedidoid;
    public $titcampofecha='';
    public $titcampo2='';
    public $titcampo3='';
    public $titcampo4='Comentario';
    public $titcampoimg='Ficheros';
    public $valorcampofecha='';
    public $valorcampo2='';
    public $valorcampo3='';
    public $valorcampo4='';
    public $valorimg='';
    public $campofecha='';
    public $campo2='';
    public $campo3='';
    public $campo4='comentario';
    public $campoimg='archivo';
    public $campofechavisible=0;
    public $campo2visible=0;
    public $campo3visible=0;
    public $campo4visible=1;
    public $campoimgvisible=1;
    public $editarvisible=0;
    public $search='';

    protected $listeners = [ 'refresh' => '$refresh'];

    protected function rules()
    {
        return [
            // 'valorcampofecha'=>'required||date',
            // 'valorcampo2'=>'nullable',
            // 'valorcampo3'=>'nullable',
            'valorcampo4'=>'required',
            'valorcampoimg'=>'required',
        ];
    }

    public function messages()
    {
        return [
            'valorcampo4.required'=>'El comentario es necesario',
            'valorcampoimg.required'=>'El fichero es necesario',
        ];
    }

public function render()
{
    $valores=ModelsPedidoArchivo::query()
    ->search('comentario', $this->search)
    ->select('id', 'comentario as valorcampo4', 'archivo as valorcampoimg')
    ->orderBy('comentario')
    ->get();

    return view('livewire.auxiliarfechacard', compact('valores'));
}

    public function changeCampo(ModelsPedidoArchivo $valor, $campo, $valorcampo)
    {
        $p=ModelsPedidoArchivo::find($valor->id);
        $p->$campo=$valorcampo;
        $p->save();
        $this->dispatchBrowserEvent('notify', 'Archivo Actualizado.');
    }

    public function save()
    {
        $this->validate();
        ModelsPedidoArchivo::create([
            'pedido_id'=>$this->pedidoid,
            'comentario'=>$this->valorcampo4,
        ]);

        $this->dispatchBrowserEvent('notify', 'Archivo añadido con éxito');

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
        $borrar = ModelsPedidoArchivo::find($valorId);

        if ($borrar) {
            $borrar->delete();
            $this->dispatchBrowserEvent('notify', 'Archivo eliminado!');
        }
    }
}
