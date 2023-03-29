<?php

namespace App\Http\Livewire\Producto;

use App\Models\Producto;
use App\Models\ProductoArchivo as ModelsProductoArchivo;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;

use Livewire\Component;


class ProductoArchivo extends Component
{
    use WithFileUploads;

    public $titulo='Archivos del producto:';
    public $ruta;
    public $productoid;
    public $prod;
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
    public $tipo;

    protected $listeners = [ 'refresh' => '$refresh'];


    protected function rules(){
        return [
            // 'valorcampofecha'=>'required||date',
            // 'valorcampo2'=>'nullable',
            'valorcampo3'=>'nullable',
            'valorcampo4'=>'required',
            'valorcampoimg'=>'required',
        ];
    }

    public function messages(){
        return [
            'valorcampo4.required'=>'El comentario es necesario',
            'valorcampoimg.required'=>'El fichero es necesario',
        ];
    }

    public function mount($productoid,$ruta,$tipo){
        $this->prod=Producto::find($productoid);
        $this->titulo="Archivos del producto: ". $this->prod->referencia;
        $this->tipo=$tipo;
    }

    public function render(){
        $valores=ModelsProductoArchivo::query()
        ->search('comentario', $this->search)
        ->select('id', 'nombrearchivooriginal as valorcampo3','comentario as valorcampo4', 'archivo as valorcampoimg')
        ->where('producto_id',$this->prod->id)
        ->orderBy('comentario')
        ->get();

        return view('livewire.producto.auxiliarproductoscard', compact('valores'));
    }

    public function changeCampo(ModelsProductoArchivo $valor, $campo, $valorcampo){
        $p=ModelsProductoArchivo::find($valor->id);
        $p->$campo=$valorcampo;
        $p->save();
        $this->dispatchBrowserEvent('notify', 'Archivo Actualizado.');
    }

    public function updatedValorcampoimg(){
        $this->validate(['valorcampoimg'=>'file|max:5000']);
    }

    public function save(){
        $this->validate();
        $filename="";
        $extension="";

        $productoarchivo=ModelsProductoArchivo::create([
            'producto_id'=>$this->productoid,
            'comentario'=>$this->valorcampo4,
            'nombrearchivooriginal'=>$this->valorcampoimg->getClientOriginalName(),
            'archivo'=>'',
        ]);

        if($this->campoimgvisible=='1'){
            if ($this->valorcampoimg) {
                $nombre=$this->productoid.'/'.$productoarchivo->id.'.'.$this->valorcampoimg->extension();
                $filename=$this->valorcampoimg->storeAs('/', $nombre, 'fichasproducto');
                $productoarchivo->archivo=$nombre;
                $productoarchivo->save();
            }
        }


        $this->dispatchBrowserEvent('notify', 'Archivo añadido con éxito');

        return redirect()->route('producto.archivos',[$this->productoid,$this->ruta]);
    }

    public function delete($valorId)
    {
        $borrar = ModelsProductoArchivo::find($valorId);

        if ($borrar) {
            $borrar->delete();
            $this->dispatchBrowserEvent('notify', 'Archivo eliminado!');
        }
    }
}
