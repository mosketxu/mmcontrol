<?php

namespace App\Http\Livewire\Pedido;

use App\Models\{Pedido,PedidoArchivo as ModelsPedidoArchivo};
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;

use Livewire\Component;

class PedidoArchivo extends Component
{
    use WithFileUploads;

    public $titulo='Archivo: ';
    public $ruta;
    public $tipo;
    public $pedidoid;
    public $pedido;
    public $pdfvisible ;

    public $routepdf='';

    public $campofecha='';
    public $titcampofecha='';
    public $valorcampofecha='';
    public $longcampofecha='w-1/12';
    public $campofechavisible=0;
    public $campofechadisabled='';

    public $campo2='';
    public $titcampo2='';
    public $valorcampo2='';
    public $longcampo2='';
    public $textcampo2='';
    public $desplazcampo2='';
    public $tipocampo2='';
    public $campo2visible=0;
    public $campo2disabled='';
    public $campo2selectname='';

    public $campo3='nombrearchivooriginal'; //ojo que aunque no se vea se usa
    public $titcampo3='';
    public $valorcampo3='';
    public $longcampo3='';
    public $textcampo3='';
    public $desplazcampo3='';
    public $tipocampo3='';
    public $campo3visible=0;
    public $campo3disabled='';
    public $campo3selectname='';

    public $campo4='comentario';
    public $longcampo4='w-7/12';
    public $titcampo4='Comentario';
    public $valorcampo4='';
    public $textcampo4='text-left';
    public $desplazcampo4='pl-2';
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

    public $campoimg='archivo';
    public $titcampoimg='Fichero';
    public $valorcampoimg='';
    public $longcampoimg="w-2/12";
    public $campoimgvisible=1;
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
        $this->pedido=Pedido::find($pedidoid);
        $this->tipo=$tipo;
        $this->ruta=$ruta;
        $this->titulo="Archivos del pedido: ";
    }

    public function render()
    {
        $valores=ModelsPedidoArchivo::query()
        ->search('comentario', $this->search)
        ->select('id', 'nombrearchivooriginal as valorcampo3','comentario as valorcampo4', 'archivo as valorcampoimg')
        ->where('pedido_id',$this->pedido->id)
        ->orderBy('comentario')
        ->get();

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

    // public function presentaAdjunto($pedidoarchivoid){
    //     $parchivo=ModelsPedidoArchivo::find($pedidoarchivoid);
    //     $existe=Storage::disk('archivospedido')->exists($parchivo->archivo);
    //     if ($existe)
    //         return Storage::disk('archivospedido')->download($parchivo->archivo);
    //     else{
    //         $this->dispatchBrowserEvent('notifyred', 'Ha habido un problema con el fichero');
    //     }
    // }

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

        $pedido=Pedido::find($this->pedidoid);
        $pedido->hayArchivos=$pedido->hayArchivos+1;
        $pedido->save();


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
            $pedido=Pedido::find($borrar->pedido_id);
            $pedido->hayArchivos=$pedido->hayArchivos-1;
            $pedido->save();
            $this->dispatchBrowserEvent('notify', 'Archivo eliminado!');
        }
    }
}
