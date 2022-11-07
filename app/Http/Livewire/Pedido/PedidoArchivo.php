<?php

namespace App\Http\Livewire\Pedido;

use App\Models\{Pedido,PedidoArchivo as ModelsPedidoArchivo};
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;

use Livewire\Component;

class PedidoArchivo extends Component
{
    use WithFileUploads;

    public $titulo='Archivos del pedido: ';
    public $ruta;
    public $tipo;
    public $pedidoid;
    public $titcampofecha='';
    public $titcampo2='';
    public $titcampo3='';
    public $titcampo4='Comentario';
    public $titcampoimg='Fichero';
    public $valorcampofecha='';
    public $valorcampo2='';
    public $valorcampo3='';
    public $valorcampo4='';
    public $valorcampoimg;
    public $campofecha='';
    public $campo2='';
    public $campo3='nombrearchivooriginal';
    public $campo4='comentario';
    public $campoimg='archivo';
    public $campofechavisible=0;
    public $campo2visible=0;
    public $campo3visible=0;
    public $campo4visible=1;
    public $campoimgvisible=1;
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
            // 'valorcampofecha'=>'required||date',
            // 'valorcampo2'=>'nullable',
            'valorcampo3'=>'nullable',
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

    public function mount($pedidoid,$ruta,$tipo)
    {
        $this->ped=Pedido::find($pedidoid);
        $this->tipo=$tipo;
        $this->ruta=$ruta;
        $this->titulo="Archivos del pedido: ";
    }

    public function render()
    {
        $valores=ModelsPedidoArchivo::query()
        ->search('comentario', $this->search)
        ->select('id', 'nombrearchivooriginal as valorcampo3','comentario as valorcampo4', 'archivo as valorcampoimg')
        ->where('pedido_id',$this->ped->id)
        ->orderBy('comentario')
        ->paginate(10);

        return view('livewire.pedido.auxiliarpedidoscard', compact('valores'));
    }

    public function changeCampo(ModelsPedidoArchivo $valor, $campo, $valorcampo)
    {
        $p=ModelsPedidoArchivo::find($valor->id);
        $p->$campo=$valorcampo;
        $p->save();
        $this->dispatchBrowserEvent('notify', 'Archivo Actualizado.');
    }

    public function updatedValorcampoimg()
    {
        $this->validate(['valorcampoimg'=>'file|max:5000']);
    }

    public function presentaAdjunto($pedidoarchivoid){
        $parchivo=ModelsPedidoArchivo::find($pedidoarchivoid);
        $existe=Storage::disk('archivospedido')->exists($parchivo->archivo);
        // dd($this->pedidoid.'/'.$pedidoarchivoid->id);
        if ($existe)
            return Storage::disk('archivospedido')->download($parchivo->archivo);
        else{
            $this->dispatchBrowserEvent('notifyred', 'Ha habido un problema con el fichero');
        }
    }

    public function save()
    {
        $this->validate();
        $filename="";
        $extension="";

        $pedidoarchivo=ModelsPedidoArchivo::create([
            'pedido_id'=>$this->pedidoid,
            'comentario'=>$this->valorcampo4,
            'nombrearchivooriginal'=>$this->valorcampoimg->getClientOriginalName(),
            'archivo'=>'',
        ]);

        if($this->campoimgvisible=='1'){
            if ($this->valorcampoimg) {
                $nombre=$this->pedidoid.'/'.$pedidoarchivo->id.'.'.$this->valorcampoimg->extension();
                $filename=$this->valorcampoimg->storeAs('/', $nombre, 'archivospedido');
                $pedidoarchivo->archivo=$nombre;
                $pedidoarchivo->save();
            }
        }


        $this->dispatchBrowserEvent('notify', 'Archivo añadido con éxito');

        return redirect()->route('pedido.archivos',[$this->pedidoid,$this->ruta]);
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
