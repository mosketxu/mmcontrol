<?php

namespace App\Http\Livewire\Oferta;

use App\Models\{Producto,EntidadContacto,Entidad,Oferta as ModelsOferta};
use Illuminate\Validation\Rule;
use Livewire\Component;

use Illuminate\Support\Facades\Auth;

class Oferta extends Component
{
    public $ofertaid='';
    public $ruta='';
    public $cliente_id='';
    public $contacto_id='';
    public $descripcion='';
    public $fecha='';
    public $producto_id='';
    public $prod;
    public $tipo='';
    public $acabado='';
    public $manipulacion='';
    public $material='';
    public $medidas='';
    public $impresion='';
    public $embalaje='';
    public $entrega='';
    public $transporte='';
    public $troquel='';
    public $observaciones='';
    public $estado='0';
    public $deshabilitado='';

    public $filtroisbn='';
    public $filtroreferencia='';
    public $filtrocliente='';
    public $escliente='';

    public $contactos;
    public $productos;
    public $titulo='';

    protected $queryString=['filtroisbn','filtrorefencia','filtrocliente'];


    protected $listeners = [ 'refreshoferta'];

    public function refreshoferta(){
        $this->mount($this->ofertaid,$this->tipo,$this->ruta,$this->titulo);
    }

    protected function rules(){
        return [
            'ofertaid'=>'nullable',
            'cliente_id'=>'required',
            'contacto_id'=>'nullable',
            'descripcion'=>'required_if:tipo,2',
            'fecha'=>'date|required',
            'producto_id'=>'required_if:tipo,1',
            'acabado'=>'nullable',
            'manipulacion'=>'nullable',
            'material'=>'nullable',
            'medidas'=>'nullable',
            'impresion'=>'nullable',
            'embalaje'=>'nullable',
            'entrega'=>'nullable',
            'transporte'=>'nullable',
            'troquel'=>'nullable',
            'observaciones'=>'nullable',
            'estado'=>'nullable',
        ];
    }

    public function messages(){
        return [
            'cliente_id.required'=>'El cliente es necesario',
            'producto_id.required_if'=>'El producto es necesario',
            'descripcion.required_if'=>'La descripción es necesaria',
            'fecha.required'=>'La fecha es necesaria',
            'fecha.required'=>'La fecha debe ser válida',
        ];
    }

    public function mount($ofertaid,$tipo,$ruta){
        $this->titulo=$tipo=='1' ? 'Nuevo Presupuesto Editorial:' : 'Nueva Presupuesto Packaging/Propios:' ;
        $this->tipo=$tipo;
        $this->ruta=$ruta;
        $this->escliente=Auth::user()->hasRole('Cliente') ? 'disabled' : '';

        if ($ofertaid!='') {
            $oferta=ModelsOferta::find($ofertaid);

            $this->cliente_id=$oferta->cliente_id;
            $this->contacto_id=$oferta->contacto_id;
            $this->descripcion=$oferta->descripcion;
            $this->fecha=$oferta->fecha;
            $this->producto_id=$oferta->producto_id;
            if($oferta->producto_id) $this->prod=Producto::find($oferta->producto_id);
            $this->tipo=$oferta->tipo;
            $this->acabado=$oferta->acabado;
            $this->manipulacion=$oferta->manipulacion;
            $this->material=$oferta->material;
            $this->medidas=$oferta->medidas;
            $this->impresion=$oferta->impresion;
            $this->embalaje=$oferta->embalaje;
            $this->entrega=$oferta->entrega;
            $this->transporte=$oferta->transporte;
            $this->troquel=$oferta->troquel;
            $this->observaciones=$oferta->observaciones;
            $this->estado=$oferta->estado;
            if($this->cliente_id)
                $this->contactos=EntidadContacto::with('entidadcontacto')->where('entidad_id', $this->cliente_id)->get();
        }

    }

    public function render(){
        $entidades=Entidad::orderBy('entidad')->get();
        $clientes=$entidades->whereIn('entidadtipo_id',['1','2']);
        $this->productos=Producto::query()
            // ->with('cliente')
            ->when($this->cliente_id!='', function ($query){
                $query->where('cliente_id', '=',$this->cliente_id);
                })
            ->when($this->filtroreferencia!='', function ($query){
                $query->where('referencia', 'like', '%'.$this->filtroreferencia.'%');
                })
            ->when($this->filtrocliente!='', function ($query){
                $query->where('cliente_id',$this->filtrocliente);
                })
            ->orderBy('referencia','asc')
            ->get();

        $vista=$this->tipo=='1' ? 'livewire.oferta.ofertaeditorial' : 'livewire.oferta.ofertaotros'  ;
        return view($vista,compact(['entidades','clientes']));
        }


        public function updatedClienteId(){
        $this->contactos=EntidadContacto::with('entidadcontacto')->where('entidad_id', $this->cliente_id)->get();
        if(!$this->fecha) $this->fecha=now()->format('Y-m-d');
        $this->productos=Producto::query()
            ->with('cliente')
            ->when($this->cliente_id!='', function ($query){
                $query->where('cliente_id', '=',$this->cliente_id);
                })
            ->when($this->filtroreferencia!='', function ($query){
                $query->where('referencia', 'like', '%'.$this->filtroreferencia.'%');
                })
            ->when($this->filtrocliente!='', function ($query){
                $query->where('cliente_id',$this->filtrocliente);
                })
            ->orderBy('referencia','asc')
            ->get();
    }

    // public function updatedProductoId(){
    //     if ($this->producto_id=='') {
    //         $this->preciocoste=0;
    //     } else {
    //         $this->prod=Producto::find($this->producto_id);
    //         $this->precio=$this->prod->precio;
    //         $this->preciocoste=$this->prod->preciocoste;
    //     }
    // }

    public function numoferta(){
        $anyo= substr($this->fecha, 0,4);
        $anyo2= substr($anyo, -2);
        $ofe=ModelsOferta::inYear($anyo)->max('id') ;
        return !isset($ofe) ? ($anyo2 * 100000 +1) :$ofe + 1 ;
    }

    public function save(){
        if($this->producto_id=='') $this->producto_id=null;
        if($this->contacto_id=='') $this->contacto_id=null;
        $this->validate();
        $mensaje="Oferta creada satisfactoriamente";
        $i="";
        if ($this->ofertaid!='') {
            $i=$this->ofertaid;
            $mensaje="Oferta actualizada satisfactoriamente";
        }else{
            $this->ofertaid=$this->numoferta();
            $i=$this->ofertaid;
        }

        $ofe=ModelsOferta::updateOrCreate([
            'id'=>$i
            ],
            [
            'id'=>$this->ofertaid,
            'cliente_id'=>$this->cliente_id,
            'contacto_id'=>$this->contacto_id,
            'descripcion'=>$this->descripcion,
            'fecha'=>$this->fecha,
            'producto_id'=>$this->producto_id,
            'tipo'=>$this->tipo,
            'acabado'=>$this->acabado,
            'entrega'=>$this->entrega,
            'manipulacion'=>$this->manipulacion,
            'material'=>$this->material,
            'medidas'=>$this->medidas,
            'impresion'=>$this->impresion,
            'embalaje'=>$this->embalaje,
            'entrega'=>$this->entrega,
            'transporte'=>$this->transporte,
            'troquel'=>$this->troquel,
            'observaciones'=>$this->observaciones,
            'estado'=>$this->estado,
        ]);


        $this->dispatchBrowserEvent('notify', $mensaje);
        return redirect()->route('oferta.editar',[$ofe,'i']);
    }
}
