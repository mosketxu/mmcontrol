<?php

namespace App\Http\Livewire\Producto;

use Livewire\Component;

use App\Models\{Caja, Encuadernacion, Entidad, Formato, Gramaje, Material, Plastificado, Producto, Tinta};
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

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

    protected function rules(){
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
            'producto.descripsolapa'=>Rule::requiredIf($this->producto->solapa==true),
            'producto.guardas'=>'nullable',
            'producto.descripguardas'=>Rule::requiredIf($this->producto->guardas==true),
            'producto.cd'=>'nullable',
            'producto.descripcd'=>Rule::requiredIf($this->producto->cd==true),
            'producto.novedad'=>'nullable',
            'producto.descripnovedad'=>'nullable',
            'producto.caja_id'=>'nullable',
            'producto.udxcaja'=>'nullable|numeric',
            'producto.precioventa'=>'nullable|numeric',
            'producto.observaciones'=>'nullable',
            'producto.material'=>'nullable',
            'producto.medidas'=>'nullable',
            'producto.troquel'=>'nullable',
            'producto.impresion'=>'nullable',
        ];
    }

    public function messages(){
        return [
            'producto.referencia.required' => 'La referencia es necesaria.',
            'producto.referencia.unique' => 'Esta referencia ya existe.',
            'producto.isbn.unique' => 'El ISBN o el Cod./Ref. ya existe.',
            'producto.preciocoste.numeric' => 'El precio de compra debe ser numérico',
            'producto.precioventa.numeric' => 'El precio de venta debe ser numérico',
            'producto.descripsolapa.required' => 'La descripcion de las solapas es necesaria si se ha seleccionado la opción Solapas. ',
            'producto.descripguardas.required' => 'La descripcion de las guardas es necesaria si se ha seleccionado la opción Guardas. ',
            'producto.descripnovedad.required' => 'La descripcion de la novedad es necesaria si se ha seleccionado la opción Novedad. ',
            'producto.descripcd.required' => 'La descripcion del cd es necesaria si se ha seleccionado la opción CD. ',
        ];
    }
    public function mount(Producto $producto,$tipo,$titulo){
        $this->producto=$producto;
        $this->tipo=$tipo;
        $this->titulo=$titulo;
    }

    public function render(){
        if($this->tipo=='1' && $this->producto->id) $this->titulo='Ficha del libro: '. $this->producto->referencia;
        elseif($this->tipo=='2' && $this->producto->id)  $this->titulo='Ficha del producto: '. $this->producto->referencia;

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

        $vista= $this->tipo=='1' ? 'livewire.producto.prodeditorial' : 'livewire.producto.prodotros';

        return view($vista,compact('clientes'));
    }

    public function updatedProductoPreciocoste(){
        if($this->producto->preciocoste=='') $this->producto->preciocoste='0';
        $this->producto->preciocoste=str_replace(',','.',$this->producto->preciocoste);
        $this->validateOnly('producto.preciocoste');
    }

    public function updatedProductoPrecioventa(){
        if($this->producto->precioventa=='') $this->producto->precioventa='0';
        $this->producto->precioventa=str_replace(',','.',$this->producto->precioventa);
        $this->validateOnly('producto.precioventa');
    }

    public function updatedProductoNovedad(){if($this->producto->novedad==false) $this->producto->descripnovedad='';}
    public function updatedProductoGuardas(){if($this->producto->guardas==false) $this->producto->descripguardas='';}
    public function updatedProductoCd(){if($this->producto->cd==false) $this->producto->descripcd='';}
    public function updatedProductoSolapa(){if($this->producto->solapa==false) $this->producto->descripsolapa='';}
    public function updatedProductoDescripnovedad(){if($this->producto->descripnovedad!='') $this->producto->novedad=true;}
    public function updatedProductoDescripguardas(){if($this->producto->descripguardas!='') $this->producto->guardas=true;}
    public function updatedProductodescripcd(){if($this->producto->descripcd!='') $this->producto->cd=true;}
    public function updatedProductoDescripsolapa(){if($this->producto->descripsolapa!='') $this->producto->solapa=true;}
    public function updatedProductoUdxcaja(){if($this->producto->udxcaja=='') $this->producto->udxcaja='0';}

    public function updatedficheropdf(){
        $this->validate(['ficheropdf'=>'file|max:5000']);
    }

    public function save(){
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

        Validator::make([
            'descripsolapa'=>$this->producto->descripsolapa,
            'descripguardas'=>$this->producto->descripguardas,
            'descripcd'=>$this->producto->descripcd,

        ],[
            'descripsolapa' => Rule::requiredIf($this->producto->solapa==true),
            'descripguardas' => Rule::requiredIf($this->producto->guardas==true),
            'descripcd' => Rule::requiredIf($this->producto->cd==true),
        ],[
            'descripsolapa.required' => 'La descripcion de las solapas es necesaria si se ha seleccionado la opción Solapas. ',
            'descripguardas.required' => 'La descripcion de las guardas es necesaria si se ha seleccionado la opción Guardas. ',
            'descripcd.required' => 'La descripcion del cd es necesaria si se ha seleccionado la opción CD. ',
        ])->validate();

        $prod=Producto::updateOrCreate([
            'id'=>$i
            ],
            [
            'isbn'=>$this->producto->isbn,
            'referencia'=>$this->producto->referencia,
            'cliente_id'=>$this->producto->cliente_id,
            'tipo'=>$this->producto->tipo,
            'tirada'=>$this->producto->tirada,
            'formato'=>$this->producto->formato,
            'FSC'=>$this->producto->FSC,
            'materialinterior'=>$this->producto->materialinterior,
            'tintainterior'=>$this->producto->tintainterior,
            'gramajeinterior'=>$this->producto->gramajeinterior,
            'materialcubierta'=>$this->producto->materialcubierta,
            'tintacubierta'=>$this->producto->tintacubierta,
            'gramajecubierta'=>$this->producto->gramajecubierta,
            'paginas'=>$this->producto->paginas,
            'encuadernado'=>$this->producto->encuadernado,
            'plastificado'=>$this->producto->plastificado,
            'solapa'=>$this->producto->solapa,
            'descripsolapa'=>$this->producto->descripsolapa,
            'guardas'=>$this->producto->guardas,
            'descripguardas'=>$this->producto->descripguardas,
            'cd'=>$this->producto->cd,
            'descripcd'=>$this->producto->descripcd,
            'novedad'=>$this->producto->novedad,
            'descripnovedad'=>$this->producto->descripnovedad,
            'caja_id'=>$this->producto->caja_id,
            'udxcaja'=>$this->producto->udxcaja,
            'preciocoste'=>$this->producto->preciocoste,
            'precioventa'=>$this->producto->precioventa,
            'observaciones'=>$this->producto->observaciones,
            ]
        );

        $mensaje=$this->producto->referencia . " creado satisfactoriamente";
        $this->dispatchBrowserEvent('notify', $mensaje);

        return redirect()->route('producto.edit',$prod);
        // $this->emit('refreshproducto');
    }
}
