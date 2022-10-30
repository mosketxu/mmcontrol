<?php

namespace App\Http\Livewire\Producto;

use Livewire\Component;

use App\Models\{Caja, Encuadernacion, Entidad, Formato, Gramaje, Material, Plastificado, Producto, Tinta};
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;
use Illuminate\Validation\Rule;

class Prod extends Component
{
    use WithFileUploads;

    public $producto;
    public $formatos;
    public $listaformatos;
    public $gramajesinterior;
    public $tintasinterior;
    public $materialesinterior;
    public $gramajescubierta;
    public $tintascubierta;
    public $materialescubierta;
    public $plastificados;
    public $encuadernados;
    public $ficheropdf;
    public $tipo;
    public $titulo;
    public $formatoselected;
    public $gramajeinteriorselected;
    public $materialinteriorselected;
    public $tintainteriorselected;
    public $gramajecubiertaselected;
    public $materialcubiertaselected;
    public $tintacubiertaselected;
    public $encuadernadoselected;
    public $cajaselected;
    public $plastificadoselected;


    protected function rules()
    {
        return [
            'producto.id'=>'nullable',
            'producto.tipo'=>'required',
            'producto.cliente_id'=>'nullable',
            'producto.isbn'=>'nullable||unique:productos,isbn',
            'producto.referencia'=>'required||unique:productos,referencia',
            'producto.preciocoste'=>'nullable|numeric',
            'producto.precioventa'=>'nullable|numeric',
            'producto.tirada'=>'nullable|numeric',
            'producto.formato'=>'nullable',
            'producto.FSC'=>'nullable',
            'producto.materialinterior'=>'nullable',
            'producto.tintainterior'=>'nullable',
            'producto.gramajeinterior'=>'nullable',
            'producto.materialcubierta'=>'nullable',
            'producto.tintacubierta'=>'nullable',
            'producto.gramajecubierta'=>'nullable',
            'producto.paginas'=>'nullable',
            'producto.plastificado'=>'nullable',
            'producto.encuadernado'=>'nullable',
            'producto.solapa'=>'nullable',
            'producto.descripsolapa'=>'nullable',
            'producto.guardas'=>'nullable',
            'producto.descripguardas'=>'nullable',
            'producto.cd'=>'nullable',
            'producto.descripcd'=>'nullable',
            'producto.novedad'=>'nullable',
            'producto.descripnovedad'=>'nullable',
            'producto.caja'=>'nullable',
            'producto.udxcaja'=>'nullable|numeric',
            'producto.especiflogistica'=>'nullable',
            'producto.precioventa'=>'nullable|numeric',
            'producto.observaciones'=>'nullable',
                ];
    }

    public function messages()
    {
        return [
            'producto.referencia.required' => 'La referencia es necesaria.',
            'producto.referencia.unique' => 'Esta referencia ya existe.',
            'producto.isbn.unique' => 'El ISBN ya existe.',
            'producto.preciocoste.numeric' => 'El precio de compra debe ser numérico',
            'producto.precioventa.numeric' => 'El precio de venta debe ser numérico',
        ];
    }
    public function mount(Producto $producto)
    {
        $this->producto=$producto;
    }

    public function render()
    {
        if($this->tipo==1){
            $this->titulo='Nuevo producto editorial';
            if($this->producto->id) $this->titulo='Ficha del libro:'. $this->producto->referencia;
        }elseif($this->tipo==2){
            $this->titulo='Nuevo producto';
            if($this->producto->id) $this->titulo='Ficha del producto:'. $this->producto->referencia;
        }
        $this->formatos=Formato::orderBy('name')->get();
        $gramajes=Gramaje::orderBy('name')->get();
        $this->gramajesinterior=$gramajes->whereIn('familia',['','INT']);
        $this->gramajescubierta=$gramajes->whereIn('familia',['','CUB']);
        $materiales=Material::orderBy('name')->get();
        $this->materialesinterior=$materiales->whereIn('familia',['','INT']);
        $this->materialescubierta=$materiales->whereIn('familia',['','CUB']);
        $tintas=Tinta::orderBy('name')->get();
        $this->tintasinterior=$tintas->whereIn('familia',['','INT']);
        $this->tintascubierta=$tintas->whereIn('familia',['','CUB']);
        $this->plastificados=Plastificado::orderBy('name')->get();
        $this->encuadernaciones=Encuadernacion::orderBy('name')->get();
        $this->cajas=Caja::orderBy('name')->get();
        $entidades=Entidad::orderBy('entidad')->get();
        $clientes=$entidades->whereIn('entidadtipo_id',['1','2']);

        return view('livewire.producto.prod',compact('clientes'));
    }

    public function updatedProductoPreciocompra()
    {
        $this->producto->preciocoste=str_replace(',','.',$this->producto->preciocoste);
        $this->validateOnly('producto.preciocoste');
    }

    public function updatedProductoPrecioventa()
    {
        $this->producto->precioventa=str_replace(',','.',$this->producto->precioventa);
        $this->validateOnly('producto.precioventa');
    }

    public function updatedficheropdf()
    {
        $this->validate(['ficheropdf'=>'file|max:5000']);
    }

    public function presentaPDF(Producto $producto){
        $existe=Storage::disk('fichasproducto')->exists($producto->fichaproducto);
        if ($existe)
            return Storage::disk('fichasproducto')->download($producto->fichaproducto);
    }

    public function save()
    {

        if($this->producto->cliente_id=='') $this->producto->cliente_id=null;
        if($this->tipo) $this->producto->tipo=$this->tipo;
        if($this->producto->id){
            $i=$this->producto->id;
            $this->validate([
                'producto.referencia'=>[
                    'required',
                    Rule::unique('productos','referencia')->ignore($this->producto->id)
                    ],
                'producto.isbn'=>[
                    'required',
                    Rule::unique('productos','isbn')->ignore($this->producto->id)
                    ],

                ],
            );
            $mensaje=$this->producto->referencia . " actualizado satisfactoriamente";
        }else{
            $this->validate();
            $i=$this->producto->id;
            $message=$this->producto->referencia . " creado satisfactoriamente";
        }

        // $filename=$this->ficheropdf->store('/','fichasproducto');
        // $filename=$this->ficheropdf->storeAs('/','pp.pdf','fichasproducto');
        $filename="";
        if ($this->ficheropdf) {
            $nombre=$this->producto->id.'.'.$this->ficheropdf->extension();
            $filename=$this->ficheropdf->storeAs('/', $nombre, 'fichasproducto');
        }

        // dd($this->producto);
        $prod=Producto::updateOrCreate([
            'id'=>$i
            ],
            [
            'isbn'=>$this->producto->isbn,
            'referencia'=>$this->producto->referencia,
            'cliente_id'=>$this->producto->cliente_id,
            'tipo'=>$this->producto->tipo,
            'tirada'=>$this->producto->tirada,
            'formato'=>$this->formatoselected,
            'FSC'=>$this->producto->FSC,
            'materialinterior'=>$this->materialinteriorselected,
            'tintainterior'=>$this->tintainteriorselected,
            'gramajeinterior'=>$this->gramajeinteriorselected,
            'materialcubierta'=>$this->materialcubiertaselected,
            'tintacubierta'=>$this->tintacubiertaselected,
            'gramajecubierta'=>$this->gramajecubiertaselected,
            'paginas'=>$this->producto->paginas,
            'plastificado'=>$this->plastificadoselected,
            'plastificado'=>$this->plastificadoselected,
            'solapa'=>$this->producto->solapa,
            'descripsolapa'=>$this->producto->descripsolapa,
            'guardas'=>$this->producto->guardas,
            'descripguardas'=>$this->producto->descripguardas,
            'cd'=>$this->producto->cd,
            'descripcd'=>$this->producto->descripcd,
            'novedad'=>$this->producto->novedad,
            'descripnovedad'=>$this->producto->descripnovedad,
            'caja'=>$this->cajaselected,
            'udxcaja'=>$this->producto->udxcaja,
            'especiflogistica'=>$this->producto->especiflogistica,
            'observaciones'=>$this->producto->especiflogistica,
            'preciocoste'=>$this->producto->preciocoste,
            'precioventa'=>$this->producto->precioventa,
            'observaciones'=>$this->producto->observaciones,
            ]
        );
        if($this->ficheropdf){
            $prod->fichaproducto=$filename;
            $prod->save();
        }

        if(!$this->producto->id){
            $this->producto->id=$prod->id;
            $mensaje=$this->producto->referencia . " creado satisfactoriamente";
        }
        $this->dispatchBrowserEvent('notify', $mensaje);
    }
}
