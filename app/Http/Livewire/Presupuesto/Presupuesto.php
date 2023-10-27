<?php

namespace App\Http\Livewire\Presupuesto;

use App\Models\{Producto,Entidad, EntidadContacto, Pedido, PedidoProducto,PedidoProceso, Presupuesto as ModelsPresupuesto, PresupuestoProducto, PresupuestoProceso,Caja, Responsable};
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class Presupuesto extends Component
{
    public $presupuestoid='';
    public $cliente_id;
    public $descripcion;
    public $responsable;
    public $contacto_id;
    public $proveedor_id;
    public $tirada='0';
    public $precio_ud=0;
    public $preciototal=0;
    public $facturadopor;
    public $fechapresupuesto;
    public $tipo;
    public $estado=0;
    public $espedido=0;
    public $manipulacion='';
    public $pedido;
    public $caja_id;
    public $uds_caja=0;
    public $transporte;
    public $troquel;
    public $especificacioneslogisticas;
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
    public $escliente='';


    protected $listeners = [ 'refreshpresupuesto'];

    public function refreshpresupuesto(){
        $this->mount($this->presupuestoid,$this->tipo,$this->ruta,$this->titulo);
    // $this->render();
    }


    protected function rules(){
        return [
            // 'presupuestoid'=>'required',
            'cliente_id'=>'required',
            'descripcion'=>Rule::requiredIf($this->tipo!='1'),
            'responsable'=>'nullable',
            'contacto_id'=>'nullable',
            'proveedor_id'=>'nullable',
            'tirada'=>'required',
            'precio_ud'=>'nullable',
            'preciototal'=>'nullable',
            'facturadopor'=>'required',
            'fechapresupuesto'=>'date|required',
            'estado'=>'nullable',
            'tipo'=>'required',
            'espedido'=>'required',
            'manipulacion'=>'nullable',
            'caja_id'=>'nullable',
            'uds_caja'=>'nullable',
            'transporte'=>'nullable',
            'troquel'=>'nullable',
            'especificacioneslogisticas'=>'nullable',
            'otros'=>'nullable',
            'productoeditorialid'=>'required_if:tipo,1'
        ];
    }

    public function messages(){
        return [
            // 'presupuestoid.required'=>'El número de presupuesto es necesario',
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
            $this->descripcion=$presupuesto->descripcion;
            $this->contacto_id=$presupuesto->contacto_id;
            $this->proveedor_id=$presupuesto->proveedor_id;
            $this->facturadopor=$presupuesto->facturadopor;
            $this->fechapresupuesto=$presupuesto->fechapresupuesto;
            $this->tirada=$presupuesto->tirada;
            $this->precio_ud=$presupuesto->precio_ud;
            $this->preciototal=$presupuesto->preciototal;
            $this->estado=$presupuesto->estado;
            $this->tipo=$presupuesto->tipo;
            $this->espedido=$presupuesto->espedido;
            $this->manipulacion=$presupuesto->manipulacion;
            $this->pedido=$presupuesto->pedido;
            $this->caja_id=$presupuesto->caja_id;
            $this->uds_caja=$presupuesto->uds_caja;
            $this->transporte=$presupuesto->transporte;
            $this->troquel=$presupuesto->troquel;
            $this->especificacioneslogisticas=$presupuesto->especificacioneslogisticas;
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
        $clientes=$entidades->whereIn('entidadtipo_id', ['1','2','4']);
        $proveedores=$entidades->whereIn('entidadtipo_id', ['2','3']);
        $cajas=Caja::orderBy('name')->get();
        $cliente=$this->cliente_id;
        $tipo=$this->tipo;

        $pedidos=Pedido::query()
            ->when($cliente!='', function ($query) use($cliente) {
                $query->where('cliente_id', $cliente);})
            ->when($tipo!='', function ($query) use($tipo) {
                $query->where('tipo', $tipo);})
            ->orderBy('id')
            ->get();

        $this->productos=Producto::query()
            ->with('cliente')
            ->when($this->cliente_id!='', function ($query) {
                $query->where('cliente_id', $this->cliente_id);
            })
            ->orderBy('referencia', 'asc')
            ->get();

        $responsables=Responsable::all();

        $vista=$this->tipo=='1' ? 'livewire.presupuesto.presupuestoeditorial' : 'livewire.presupuesto.presupuestootros' ;

        return view($vista, compact(['entidades','clientes','proveedores','responsables','cajas','pedidos']));
    }

    public function updatedClienteId(){
        $this->contactos=EntidadContacto::with('entidadcontacto')->where('entidad_id', $this->cliente_id)->get();
        if (!$this->fechapresupuesto) {
            $this->fechapresupuesto=now()->format('Y-m-d');
        }
        $this->productos=Producto::query()
            ->when($this->cliente_id!='', function ($query) {
                $query->where('cliente_id', $this->cliente_id);
            })
        ->orderBy('referencia', 'asc')
        ->get();

        $resp=Entidad::find($this->cliente_id);
        if($resp->responsable!='') $this->responsable=$resp->responsable;
    }

    public function updatedPedido(){
        $presup=ModelsPresupuesto::find($this->presupuestoid);
        $pold=Pedido::where('presupuesto_id',$presup->id)->first();
        if($pold){
            $pold->presupuesto_id=null;
            $pold->save();
        }

        $pnew=Pedido::find($this->pedido);
        $pnew->presupuesto_id=$this->presupuestoid;
        $pnew->save();
        $presup->pedido=$this->pedido;
        $presup->save();
    }

    public function tiradanum($tirada){
        return is_numeric($tirada) ? $tirada : 0;
    }

    public function updatedProductoeditorialid(){
        if ($this->productoeditorialid=='') {
            $this->precio_ud=0;
        } else {
            $p=Producto::find($this->productoeditorialid);
            $this->precio_ud=$p->precio_ud;
            $this->preciototal=$p->precio_ud * $this->tiradanum($p->tirada);
            $this->caja_id=$p->caja_id;
            $this->uds_caja=$p->udxcaja;
        }
    }

    public function updatedPrecioUd(){
        $this->precio_ud= $this->precio_ud=='' ? $this->precio_ud=0 : $this->precio_ud;
        $this->preciototal= $this->precio_ud * $this->tiradanum($this->tirada);
    }

    public function updatedPreciototal(){
        $this->preciototal= $this->preciototal=='' ? $this->preciototal=0 : $this->preciototal;
    }

    public function updatedTirada(){
        if($this->tirada=='') $this->tirada='0';
        $this->preciototal= $this->precio_ud * $this->tiradanum($this->tirada);
    }

    public function updatedCajaId(){
        if($this->caja_id=='') $this->caja_id=null;
    }

    public function numpresupuesto(){
        $anyo= substr($this->fechapresupuesto, 0, 4);
        $anyo2= substr($anyo, -2);
        $presup=ModelsPresupuesto::inYear($anyo)->max('id') ;
        return !isset($presup) ? ($anyo2 * 100000 +1) : $presup + 1 ;
    }

    public function desbloquear(){
        $this->deshabilitado= $this->deshabilitado=='disabled' ? '' : 'disabled';
    }

    public function save(){
        $this->validate();
        $this->estado=$this->estado=='' ? '0' : $this->estado;
        $this->espedido=$this->espedido=='' ? '0' : $this->espedido;
        if($this->contacto_id =='') $this->contacto_id=null;
        $mensaje="Presupuesto creado satisfactoriamente";
        $i=null;
        $nuevo=null;

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

        if($this->tipo!='1')
            Validator::make(
                ['descripcion'=>$this->descripcion,],
                ['descripcion' => 'required',],
                ['descripcion.required'=>'La descripción es necesaria.'])
                ->validate();

        // Esto lo hago tanto para Editorial como para Packaging
        $presup=ModelsPresupuesto::updateOrCreate(
            [
            'id'=>$i
            ],
            [
            'id'=>$this->presupuestoid,
            'responsable'=>$this->responsable,
            'tipo'=>$this->tipo,
            'cliente_id'=>$this->cliente_id,
            'descripcion'=>$this->descripcion,
            'contacto_id'=>$this->contacto_id,
            'proveedor_id'=>$this->proveedor_id ,
            'tirada'=>$this->tirada,
            'facturadopor'=>$this->facturadopor,
            'fechapresupuesto'=>$this->fechapresupuesto,
            'precio_ud'=>$this->precio_ud,
            'preciototal'=>$this->preciototal,
            'estado'=>$this->estado,
            'tipo'=>$this->tipo,
            'espedido'=>$this->espedido,
            'manipulacion'=>$this->manipulacion,
            'pedido'=>$this->pedido,
            'caja_id'=>$this->caja_id,
            'uds_caja'=>$this->uds_caja,
            'transporte'=>$this->transporte,
            'troquel'=>$this->troquel,
            'especificacioneslogisticas'=>$this->especificacioneslogisticas,
            'otros'=>$this->otros,
        ]
        );

        // Esto solo para editorial ya que debo crear el producto en la lista de los productos del presupuesto
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
                'preciototal'=>$this->tiradanum($this->tirada) * $this->precio_ud,

            ]
            );
        }

        $i=null;
        if ($nuevo) {
            return redirect()->route('presupuesto.editar', [$presup,'e']);
        }
        $this->dispatchBrowserEvent('notify', $mensaje);
    }

    public function pedido(ModelsPresupuesto $presupuesto){
        $pedidoid=null;
        $fechapedido=now()->format('Y-m-d');
        $anyo= substr($fechapedido, 0,4);
        $anyo2= substr($anyo, -2);

        $pedidoid=Pedido::inYear($anyo)->max('id') ;
        $pedidoid= !isset($pedidoid) ? ($anyo2 * 100000 +1) :$pedidoid + 1 ;
        $pedMax=Pedido::max('id');

        $pedidoid=$pedMax>=$pedidoid ? $pedMax+1 : $pedidoid;

$ped=Pedido::create([
            'id'=>$pedidoid,
            'responsable'=>$presupuesto->responsable,
            'tipo'=>$presupuesto->tipo,
            'cliente_id'=>$presupuesto->cliente_id,
            'descripcion'=>$presupuesto->descripcion,
            'contacto_id'=>$presupuesto->contacto_id,
            'presupuesto_id'=>$presupuesto->id,
            'proveedor_id'=>$presupuesto->proveedor_id ,
            'facturadopor'=>$presupuesto->facturadopor,
            'fechapedido'=>$fechapedido,
            'tiradaprevista'=>$this->tiradanum($presupuesto->tirada) ,
            'tiradareal'=>'0',
            'precio'=>$presupuesto->precio_ud ? $presupuesto->precio_ud : '0' ,
            'preciototal'=>$presupuesto->precio_ud * $this->tiradanum($presupuesto->tirada),
            'estado'=>'0',
            'tipo'=>$presupuesto->tipo,
            'facturado'=>'0',
            'caja_id'=>$this->caja_id,
            'uds_caja'=>$presupuesto->uds_caja,
            'transporte'=>$presupuesto->transporte,
            'troquel'=>$presupuesto->troquel,
            'especificacioneslogisticas'=>$presupuesto->especificacioneslogisticas,
            'otros'=>$presupuesto->otros,
        ]);

        $presproductos=PresupuestoProducto::where('presupuesto_id',$presupuesto->id)->get();

        foreach ($presproductos as $presproducto) {
            $pprod=PedidoProducto::create([
                'pedido_id'=>$ped->id,
                'producto_id'=>$presproducto->producto_id,
                'tirada'=>$this->tiradanum($presproducto->tirada),
                'precio_ud'=>$presproducto->precio_ud,
                'preciototal'=> $this->tiradanum($presproducto->tirada) * $this->precio_ud,
                'observaciones'=>$presproducto->observaciones,
                'visible'=>$presproducto->visible,
                'orden'=>$presproducto->orden,
            ]);
        }

        $presprocesos=PresupuestoProceso::where('presupuesto_id',$presupuesto->id)->get();

        foreach ($presprocesos as $presproceso) {
            $pprod=PedidoProceso::create([
                'pedido_id'=>$ped->id,
                'proceso'=>$presproceso->proceso,
                'descripcion'=>$presproceso->descripcion,
                'tirada'=>$presproceso->tirada,
                'precio_ud'=>$presproceso->precio_ud,
                'preciototal'=>$this->tiradanum($presproceso->tirada) * $this->precio_ud,
                'observaciones'=>$presproceso->observaciones,
                'visible'=>$presproceso->visible,
                'orden'=>$presproceso->orden,
            ]);
        }

        $presupuesto->espedido='1';
        $presupuesto->pedido=$ped->id;
        $presupuesto->save();
        return redirect()->route('pedido.editar',[$ped,'i']);
    }
}
