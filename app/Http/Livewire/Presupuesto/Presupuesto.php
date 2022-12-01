<?php

namespace App\Http\Livewire\Presupuesto;


use App\Models\{Producto,Entidad, EntidadContacto, Pedido, PedidoProducto, Presupuesto as ModelsPresupuesto, PresupuestoProducto};
use Illuminate\Validation\Rule;
use Livewire\Component;

class Presupuesto extends Component
{
    public $presupuestoid='';
    public $tipo;
    public $cliente_id;
    public $responsable;
    public $contacto_id;
    public $proveedor_id;
    public $tirada=0;
    public $precio_ud=0;
    public $preciototal=0;
    public $facturadopor;
    public $fechapresupuesto;
    public $estado=0;
    public $espedido=0;
    public $pedido;
    public $uds_caja=0;
    public $otros;

    public $productoeditorialid;
    public $presupuestoproductoid;
    public $titulo;
    public $ruta;
    public $deshabilitado='';

    public $filtroisbn;
    public $filtroreferencia;
    public $filtrocliente;
    public $filtroproveedor;

    public $contactos;
    public $productos;

    protected function rules(){
        return [
            'presupuestoid'=>'required',
            'cliente_id'=>'required',
            'responsable'=>'nullable',
            'contacto_id'=>'nullable',
            'proveedor_id'=>'required',
            'tirada'=>'required',
            'precio_ud'=>'nullable',
            'preciototal'=>'nullable',
            'facturadopor'=>'required',
            'fechapresupuesto'=>'date|required',
            'estado'=>'required',
            'espedido'=>'required',
            'uds_caja'=>'nullable',
            'otros'=>'nullable',
            'productoeditorialid'=>'required_if:tipo,1'
        ];
    }

    public function messages(){
        return [
            'presupuestoid.required'=>'El número de presupuesto es necesario',
            'cliente_id.required'=>'El cliente es necesario',
            'proveedor_id.required'=>'El proveedor es necesario',
            'tirada.required'=>'La tirada es necesaria',
            'facturadopor.required'=>'Definir quien facturará es necesario',
            'fechapresupuesto.required'=>'La fecha del presupuesto es necesaria',
            'fechapresupuesto.date'=>'La fecha debe ser válida',
            'estado.required'=>'El estado es necesario',
            'espedido.required'=>'Definir si es pedido es necesario',
            'productoeditorialid.required'=>'El producto editorial es necesario',
        ];
    }

    public function mount($presupuestoid, $tipo, $ruta, $titulo){
        $this->titulo=$titulo;
        $this->tipo=$tipo;
        $this->ruta=$ruta;

        if ($presupuestoid!='') {
            $presupuesto=ModelsPresupuesto::find($presupuestoid);
            $this->tipo=$presupuesto->tipo;
            $this->presupuestoid=$presupuesto->id;
            $this->responsable=$presupuesto->responsable;
            $this->cliente_id=$presupuesto->cliente_id;
            $this->contacto_id=$presupuesto->contacto_id;
            $this->proveedor_id=$presupuesto->proveedor_id;
            $this->facturadopor=$presupuesto->facturadopor;
            $this->fechapresupuesto=$presupuesto->fechapresupuesto;
            $this->tirada=$presupuesto->tirada;
            $this->precio_ud=$presupuesto->precio_ud;
            $this->preciototal=$presupuesto->preciototal;
            $this->estado=$presupuesto->estado;
            $this->espedido=$presupuesto->espedido;
            $this->pedido=$presupuesto->pedido;
            $this->uds_caja=$presupuesto->uds_caja;
            $this->otros=$presupuesto->otros;
            if ($this->cliente_id) {
                $this->contactos=EntidadContacto::with('entidadcontacto')->where('entidad_id', $this->cliente_id)->get();
            }
            if ($tipo=='1') {
                $this->productoeditorialid=$presupuesto->presupuestoproductos->first()->producto->id;
                $this->presupuestoproductoid=$presupuesto->presupuestoproductos->first()->id;
            }
            $this->deshabilitado=$this->espedido=='1' ? 'disabled' : '';
        }
    }

    public function render(){
        $entidades=Entidad::orderBy('entidad')->get();
        $clientes=$entidades->whereIn('entidadtipo_id', ['1','2']);
        $proveedores=$entidades->whereIn('entidadtipo_id', ['2','3']);

        $this->productos=Producto::query()
            ->with('cliente')
            // ->when($this->filtroisbn!='', function ($query){
            //     $query->where('isbn', 'like', '%'.$this->filtroisbn.'%');
            //     })
            // ->when($this->filtroreferencia!='', function ($query){
            //     $query->where('referencia', 'like', '%'.$this->filtroreferencia.'%');
            //     })
            // ->when($this->filtrocliente!='', function ($query){
            //     $query->where('cliente_id',$this->filtrocliente);
            //     })
            ->when($this->cliente_id!='', function ($query) {
                $query->where('cliente_id', $this->cliente_id);
            })
            ->orderBy('referencia', 'asc')
            ->get();

        $vista=$this->tipo=='1' ? 'livewire.presupuesto.presupuestoeditorial' : 'livewire.presupuesto.presupuestootros' ;

        return view($vista, compact(['entidades','clientes','proveedores']));
    }

    public function updatedClienteId(){
        $this->contactos=EntidadContacto::with('entidadcontacto')->where('entidad_id', $this->cliente_id)->get();
        if (!$this->fechapresupuesto) {
            $this->fechapresupuesto=now()->format('Y-m-d');
        }
        $this->productos=Producto::query()
               // ->when($this->filtroisbn!='', function ($query){
            //     $query->where('isbn', 'like', '%'.$this->filtroisbn.'%');
            //     })
            // ->when($this->filtroreferencia!='', function ($query){
            //     $query->where('referencia', 'like', '%'.$this->filtroreferencia.'%');
            //     })
            // ->when($this->filtrocliente!='', function ($query){
            //     $query->where('cliente_id',$this->filtrocliente);
            //     })
            ->when($this->cliente_id!='', function ($query) {
                $query->where('cliente_id', $this->cliente_id);
            })
        ->orderBy('referencia', 'asc')
        ->get();
    }

    public function updatedProductoeditorialid(){
        if ($this->productoeditorialid=='') {
            $this->precio_ud=0;
        } else {
            $p=Producto::find($this->productoeditorialid);
            $this->precio_ud=$p->precio_ud;
            $this->preciototal=$p->precio_ud * $p->tirada;
        }
    }

    public function updatedPrecioUd(){
        $this->precio_ud= $this->precio_ud=='' ? $this->precio_ud=0 : $this->precio_ud;
        $this->preciototal= $this->precio_ud * $this->tirada;
    }

    public function updatedPreciototal(){
        $this->preciototal= $this->preciototal=='' ? $this->preciototal=0 : $this->preciototal;
    }

    public function updatedTirada(){
        $this->tirada= $this->tirada=='' ? $this->tirada=0 : $this->tirada;
        $this->preciototal= $this->preciototal=='' ? $this->preciototal=0 : $this->preciototal;
    }

    public function numpresupuesto(){
        $anyo= substr($this->fechapresupuesto, 0, 4);
        $anyo2= substr($anyo, -2);
        $presup=ModelsPresupuesto::whereYear('fechapresupuesto', $anyo)->max('id') ;
        return !isset($presup) ? ($anyo2 * 100000 +1) : $presup + 1 ;
    }

    public function desbloquear()
    {
        $this->deshabilitado= $this->deshabilitado=='disabled' ? '' : 'disabled';
    }
    public function save(){
        $this->estado=$this->estado=='' ? '0' : $this->estado;
        $this->espedido=$this->espedido=='' ? '0' : $this->espedido;
        $mensaje="Presupuesto creado satisfactoriamente";
        $i="";
        if ($this->presupuestoid!='') {
            $i=$this->presupuestoid;
            $mensaje="Presupuesto actualizado satisfactoriamente";
            $nuevo=false;
            $this->validate([
                'presupuestoid'=>[
                    'required',
                    Rule::unique('presupuestos', 'id')->ignore($this->presupuestoid)
                ],], );
        } else {
            $this->presupuestoid=$this->numpresupuesto();
            $i=$this->presupuestoid;
            $nuevo=true;
        }
        $this->validate();
        $presup=ModelsPresupuesto::updateOrCreate(
            [
            'id'=>$i
            ],
            [
            'id'=>$this->presupuestoid,
            'responsable'=>$this->responsable,
            'tipo'=>$this->tipo,
            'cliente_id'=>$this->cliente_id,
            'contacto_id'=>$this->contacto_id,
            'proveedor_id'=>$this->proveedor_id ,
            'tirada'=>$this->tirada,
            'facturadopor'=>$this->facturadopor,
            'fechapresupuesto'=>$this->fechapresupuesto,
            'tirada'=>$this->tirada,
            'precio_ud'=>$this->precio_ud,
            'preciototal'=>$this->preciototal,
            'estado'=>$this->estado,
            'espedido'=>$this->espedido,
            'pedido'=>$this->pedido,
            'uds_caja'=>$this->uds_caja,
            'otros'=>$this->otros,
        ]
        );

        if ($this->tipo=='1') {
            $presupprod=PresupuestoProducto::updateOrCreate(
                [
                'id'=>$this->presupuestoproductoid
                ],
                [
                'presupuesto_id'=>$presup->id,
                'producto_id'=>$this->productoeditorialid,
                'tirada'=>$this->tirada,
                'precio_ud'=>$this->precio_ud,
                'preciototal'=>$this->tirada * $this->precio_ud,

            ]
            );
        }

        $this->dispatchBrowserEvent('notify', $mensaje);
        if ($nuevo) {
            return redirect()->route('presupuesto.editar', [$presup,'e']);
        }
    }

    public function pedido(ModelsPresupuesto $presupuesto){
        $fechapedido=now()->format('Y-m-d');
        $anyo= substr($fechapedido, 0,4);
        $anyo2= substr($anyo, -2);
        $pedidoid=Pedido::whereYear('fechapedido', $anyo)->max('id') ;
        $pedidoid= !isset($pedidoid) ? ($anyo2 * 100000 +1) :$pedidoid + 1 ;

        $ped=Pedido::create([
            'id'=>$pedidoid,
            'responsable'=>$presupuesto->responsable,
            'tipo'=>$presupuesto->tipo,
            'cliente_id'=>$presupuesto->cliente_id,
            'contacto_id'=>$presupuesto->contacto_id,
            'presupuesto_id'=>$presupuesto->id,
            'proveedor_id'=>$presupuesto->proveedor_id ,
            'facturadopor'=>$presupuesto->facturadopor,
            'fechapedido'=>$fechapedido,
            'tiradaprevista'=>$presupuesto->tirada,
            'tiradareal'=>'0',
            'precio'=>$presupuesto->precio_ud ? $presupuesto->precio_ud : '0' ,
            'preciototal'=>$presupuesto->precio_ud * $presupuesto->tirada,
            'estado'=>'0',
            'facturado'=>'0',
            'uds_caja'=>$presupuesto->uds_caja,
            'otros'=>$presupuesto->otros,
        ]);

        $presproductos=PresupuestoProducto::where('presupuesto_id',$presupuesto->id)->get();

        foreach ($presproductos as $presproducto) {
            $pprod=PedidoProducto::create([
                'pedido_id'=>$ped->id,
                'producto_id'=>$presproducto->producto_id,
                'tiradaprevista'=>$presproducto->tirada,
                'precio'=>$presproducto->precio_ud,
                'preciototal'=>$presproducto->tirada * $this->precio_ud,
            ]);
        }

        $presupuesto->espedido='1';
        $presupuesto->pedido=$ped->id;
        $presupuesto->save();
        return redirect()->route('pedido.editar',[$ped,'i']);
    }
}
