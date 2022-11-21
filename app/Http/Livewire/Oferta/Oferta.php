<?php

namespace App\Http\Livewire\Oferta;

use App\Models\{Producto,EntidadContacto,Entidad,Oferta as ModelsOferta};
use Illuminate\Validation\Rule;
use Livewire\Component;

class Oferta extends Component
{
    public $ofertaid='';
    public $tipo;
    public $ruta;
    public $cliente_id;
    public $contacto_id;
    public $fecha;
    public $producto_id;
    public $referencia;
    public $formato;
    public $extension;
    public $interiorcomposicion;
    public $interiorimpresion;
    public $cubiertacomposicion;
    public $cubiertaimpresion;
    public $guardascomposicion;
    public $guardasimpresion;
    public $acabado;
    public $manipulacion;
    public $entrega;
    public $observaciones;
    public $estado='0';

    public $filtroisbn;
    public $filtroreferencia;
    public $filtrocliente;

    public $contactos;
    // public $productos;
    public $titulo='';

    protected function rules(){
        return [
            'cliente_id'=>'required',
            'contacto_id'=>'nullable',
            'fecha'=>'date|required',
            'producto_id'=>'nullable',
            'referencia'=>'required',
            'formato'=>'nullable',
            'extension'=>'nullable',
            'interiorcomposicion'=>'nullable',
            'interiorimpresion'=>'nullable',
            'cubiertacomposicion'=>'nullable',
            'cubiertaimpresion'=>'nullable',
            'guardascomposicion'=>'nullable',
            'guardasimpresion'=>'nullable',
            'acabado'=>'nullable',
            'manipulacion'=>'nullable',
            'entrega'=>'nullable',
            'observaciones'=>'nullable',
            'estado'=>'nullable',
        ];
    }

    public function messages()
    {
        return [
            'cliente_id'=>'El cliente es necesario',
            'fecha'=>'La fecha es necesaria',
            'fecha'=>'La fecha debe ser válida',
            'referencia'=>'La referencia es necesaria',
            'referencia'=>'required',
        ];
    }

    public function mount($ofertaid,$tipo,$ruta){
        $this->titulo=$tipo=='1' ? 'Nueva Oferta Editorial:' : 'Nueva Oferta Otros Productos:' ;
        $this->tipo=$tipo;
        $this->ruta=$ruta;

        if ($ofertaid!='') {
            $oferta=ModelsOferta::find($ofertaid);

            $this->cliente_id=$oferta->cliente_id;
            $this->contacto_id=$oferta->contacto_id;
            $this->fecha=$oferta->fecha;
            // $this->producto_id=$oferta->producto_id;
            $this->referencia=$oferta->referencia;
            $this->formato=$oferta->formato;
            $this->extension=$oferta->extension;
            $this->interiorcomposicion=$oferta->interiorcomposicion;
            $this->interiorimpresion=$oferta->interiorimpresion;
            $this->cubiertacomposicion=$oferta->cubiertacomposicion;
            $this->cubiertaimpresion=$oferta->cubiertaimpresion;
            $this->guardascomposicion=$oferta->guardascomposicion;
            $this->guardasimpresion=$oferta->guardasimpresion;
            $this->acabado=$oferta->acabado;
            $this->manipulacion=$oferta->manipulacion;
            $this->entrega=$oferta->entrega;
            $this->observaciones=$oferta->observaciones;
            $this->estado=$oferta->estado;
            if($this->cliente_id)
                $this->contactos=EntidadContacto::with('entidadcontacto')->where('entidad_id', $this->cliente_id)->get();
        }
    }

    public function render(){
        $entidades=Entidad::orderBy('entidad')->get();
        $clientes=$entidades->whereIn('entidadtipo_id',['1','2']);
        // $this->productos=Producto::query()
        //     ->with('cliente')
        //     ->when($this->cliente_id!='', function ($query){
        //         $query->where('cliente_id', '=',$this->cliente_id);
        //         })
        //     ->when($this->filtroreferencia!='', function ($query){
        //         $query->where('referencia', 'like', '%'.$this->filtroreferencia.'%');
        //         })
        //     ->when($this->filtrocliente!='', function ($query){
        //         $query->where('cliente_id',$this->filtrocliente);
        //         })
        //     ->orderBy('referencia','asc')
        //     ->get();
            return view('livewire.oferta.oferta',compact(['entidades','clientes']));
        }

    public function updatedClienteId(){
        $this->contactos=EntidadContacto::with('entidadcontacto')->where('entidad_id', $this->cliente_id)->get();
        if(!$this->fecha) $this->fecha=now()->format('Y-m-d');
    }

    public function updatedProductoId(){
        if ($this->producto_id=='') {
            $this->preciocoste=0;
        } else {
            $p=Producto::find($this->producto_id);
            $this->precio=$p->precio;
            $this->preciocoste=$p->preciocoste;
        }
    }

    public function numoferta(){
        $anyo= substr($this->fecha, 0,4);
        $anyo2= substr($anyo, -2);
        $ped=ModelsOferta::whereYear('fecha', $anyo)->max('id') ;
            return !isset($ped) ? ($anyo2 * 100000 +1) :$ped + 1 ;
        // }
    }

    public function save()
    {
        $mensaje="Oferta creada satisfactoriamente";
        $i="";
        if ($this->ofertaid!='') {
            $i=$this->ofertaid;
            $mensaje="Oferta actualizada satisfactoriamente";
            $nuevo=false;
            $this->validate([
                'ofertaid'=>[
                    'required',
                    Rule::unique('ofertas', 'id')->ignore($this->ofertaid)
                ],],);
        }else{
            $this->ofertaid=$this->numoferta();
            $i=$this->ofertaid;
            $nuevo=true;
        }
        $this->validate();
        // dd($this->contacto_id);
        $ofe=ModelsOferta::updateOrCreate([
            'id'=>$i
            ],
            [
            'id'=>$this->ofertaid,
            'cliente_id'=>$this->cliente_id,
            'contacto_id'=>$this->contacto_id,
            'tipo'=>$this->tipo,
            'fecha'=>$this->fecha,
            'producto_id'=>$this->producto_id,
            'referencia'=>$this->referencia,
            'formato'=>$this->formato,
            'extension'=>$this->extension,
            'interiorcomposicion'=>$this->interiorcomposicion,
            'interiorimpresion'=>$this->interiorimpresion,
            'cubiertacomposicion'=>$this->cubiertacomposicion,
            'cubiertaimpresion'=>$this->cubiertaimpresion,
            'guardascomposicion'=>$this->guardascomposicion,
            'guardasimpresion'=>$this->guardasimpresion,
            'acabado'=>$this->acabado,
            'manipulacion'=>$this->manipulacion,
            'entrega'=>$this->entrega,
            'observaciones'=>$this->observaciones,
            'estado'=>$this->estado,
        ]);

        $oferta=ModelsOferta::find($ofe->id);
        $this->dispatchBrowserEvent('notify', $mensaje);
    }


    }
