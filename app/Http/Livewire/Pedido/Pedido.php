<?php

namespace App\Http\Livewire\Pedido;

use App\Models\{Producto,EntidadContacto,Entidad, Oferta, Pedido as ModeloPedido,Caja, Factura, FacturaDetalle, Laminado, PedidoProducto, Responsable};
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Pedido extends Component
{
    public $pedidoid='';
    public $ruta;
    public $responsable;
    public $cliente_id;
    public $descripcion;
    public $proveedor_id;
    public $pedidocliente;
    public $oferta_id;
    public $facturadopor;
    public $muestra;
    public $pruebacolor;
    public $laminadoplastico;
    public $laminado_id='1';
    public $consumo=0;
    public $unidad_consumo;
    public $contacto_id;
    // public $producto_id;
    public $fechapedido;
    public $fechaarchivos;
    public $fechamaqueta;
    public $fechaplotter;
    public $fechaentrega;
    public $ctrarchivos;
    public $ctrmaqueta;
    public $ctrplotter;
    public $ctrentrega;
    public $tiradaprevista=0;
    public $tiradareal=0;
    public $precio=0;
    public $preciototal=0;
    public $parcial=0;
    public $estado=0;
    public $tipo;
    public $facturado;
    public $caja_id;
    public $uds_caja;
    public $transporte;
    public $otros;

    // public $destino='0';
    public $filtroisbn;
    public $filtroreferencia;
    public $filtrocliente;



    public $titulo='';
    public $productoeditorialid;
    public $pedidoproductoid;
    public $contactos;
    public $productos;
    public $facturas;
    public $ofertas;
    public $deshabilitado;
    public $escliente;

    protected $queryString=['filtrocliente','filtroreferencia','filtroisbn'];

    protected $listeners = [ 'refreshpedido'];

    public function refreshpedido(){
        $this->mount($this->pedidoid,$this->tipo,$this->ruta,$this->titulo);
    }

    protected function rules(){
        return [
            'pedidoid'=>'required',
            'responsable'=>'nullable',
            'cliente_id'=>'required',
            'descripcion'=>'nullable',
            'contacto_id'=>'nullable',
            'proveedor_id'=>'nullable',
            'pedidocliente'=>'nullable',
            'oferta_id'=>'nullable',
            'facturadopor'=>'required',
            'muestra'=>'nullable',
            'fechapedido'=>'required|date',
            'fechaarchivos'=>'nullable|date',
            'fechamaqueta'=>'nullable|date',
            'fechaplotter'=>'nullable|date',
            'fechaentrega'=>'nullable|date',
            'ctrarchivos'=>'nullable',
            'ctrmaqueta'=>'nullable',
            'ctrplotter'=>'nullable',
            'ctrentrega'=>'nullable',
            'tiradaprevista'=>'required|numeric',
            'tiradareal'=>'nullable|numeric',
            'precio'=>'nullable|numeric',
            'preciototal'=>'nullable|numeric',
            'estado'=>'nullable',
            'tipo'=>'nullable',
            'facturado'=>'nullable',
            'caja_id'=>'nullable',
            'uds_caja'=>'nullable',
            'transporte'=>'nullable',
            'otros'=>'nullable',
            'productoeditorialid'=>'required_if:tipo,1'
        ];
    }

    public function messages(){
        return [
            'pedidoid.required'=>'El número de pedido es necesario',
            'responsable.required'=>'El responsable del pedido es necesario',
            'cliente_id.required'=>'El cliente es necesario',
            'facturadopor.required'=>'Debe estar definido quién facturará el pedido',
            'proveedor_id.nullable'=>'',
            'fechapedido.date'=>'La fecha del pedido debe ser válida',
            'fechapedido.required'=>'La fecha del pedido es necesaria',
            'fechaarchivos.date'=>'La fecha de los archivos debe ser válida',
            'fechamaqueta.date'=>'La fecha de la maqueta debe ser válida',
            'fechaplotter.date'=>'La fecha del plotter debe ser válida',
            'fechaentrega.date'=>'La fecha de entrega debe ser válida',
            'fechaentrega.required'=>'La fecha de entrega es necesaria',
            'tiradaprevista.required'=>'La tirada prevista es necesaria',
            'tiradaprevista.numeric'=>'El valor de la tirada prevista debe ser numérico',
            'tiradareal.numeric'=>'El valor de la tirada real debe ser numérico',
            'precio.numeric'=>'El valor del precio de venta debe ser numérico',
            'preciototal.numeric'=>'El valor del precio total debe ser numérico',
            'productoeditorialid.required_if'=>'El Producto es necesario',
        ];
    }

    public function mount($pedidoid,$tipo,$ruta,$titulo){
        $this->titulo=$titulo;
        $this->tipo=$tipo;
        $this->ruta=$ruta;
        if ($pedidoid!='') {
            $pedido=ModeloPedido::find($pedidoid);
            $this->tipo=$pedido->tipo;
            $this->pedidoid=$pedido->id;
            $this->responsable=$pedido->responsable;
            $this->cliente_id=$pedido->cliente_id;
            $this->descripcion=$pedido->descripcion;
            $this->pedidocliente=$pedido->pedidocliente;
            $this->oferta_id=$pedido->oferta_id;
            $this->contacto_id=$pedido->contacto_id;
            $this->proveedor_id=$pedido->proveedor_id;
            $this->facturadopor=$pedido->facturadopor;
            $this->muestra=$pedido->muestra;
            $this->pruebacolor=$pedido->pruebacolor;
            $this->laminadoplastico=$pedido->laminadoplastico;
            $this->laminado_id=$pedido->laminado_id;
            $this->consumo=$pedido->consumo;
            $this->unidad_consumo=$pedido->unidad_consumo;
            $this->fechapedido=$pedido->fechapedido;
            $this->fechaarchivos=$pedido->fechaarchivos;
            $this->fechamaqueta=$pedido->fechamaqueta;
            $this->fechaplotter=$pedido->fechaplotter;
            $this->fechaentrega=$pedido->fechaentrega;
            $this->ctrarchivos=$pedido->ctrarchivos;
            $this->ctrmaqueta=$pedido->ctrmaqueta;
            $this->ctrplotter=$pedido->ctrplotter;
            $this->ctrentrega=$pedido->ctrentrega;
            $this->tiradaprevista=$pedido->tiradaprevista;
            $this->tiradareal=$pedido->tiradareal;
            $this->precio=$pedido->precio;
            $this->preciototal=$pedido->preciototal;
            $this->estado=$pedido->estado;
            $this->facturado=$pedido->facturado;
            $this->caja_id=$pedido->caja_id;
            $this->uds_caja=$pedido->uds_caja;
            $this->transporte=$pedido->transporte;
            $this->otros=$pedido->otros;
            $this->titulo=$this->tipo=='1'?'Pedido Editorial':'Pedido Packaging/Propios';
            $this->facturas=FacturaDetalle::where('pedido_id',$pedido->id)->get();
            // dd($pedido->id);
            // dd($this->facturas);
            if($this->cliente_id){
                $this->contactos=EntidadContacto::with('entidadcontacto')->where('entidad_id', $this->cliente_id)->get();
                $this->ofertas=Oferta::where('cliente_id', '=', $this->cliente_id)->orderBy('id')->get();
            }
            if ($tipo=='1') {
                $this->productoeditorialid=$pedido->pedidoproductos->first()->producto->id;
                $this->pedidoproductoid=$pedido->pedidoproductos->first()->id;
            }
        }
        $this->facturas=FacturaDetalle::where('pedido_id',$this->pedidoid)->get();
        $this->escliente=Auth::user()->hasRole('Cliente')? 'disabled' : '';
    }

    public function render(){
        $entidades=Entidad::orderBy('entidad')->get();
        $clientes=$entidades->whereIn('entidadtipo_id',['1','2']);
        $proveedores=$entidades->whereIn('entidadtipo_id',['2','3']);
        $laminados=Laminado::get();
        $cajas=Caja::orderBy('name')->get();

        $this->productos=Producto::query()
            ->with('cliente')
            ->when($this->cliente_id!='', function ($query){
                $query->where('cliente_id',$this->cliente_id);
                })
            ->when($this->filtroisbn!='', function ($query){
                $query->where('isbn', 'like', '%'.$this->filtroisbn.'%');
                })
            ->when($this->filtroreferencia!='', function ($query){
                $query->where('referencia', 'like', '%'.$this->filtroreferencia.'%');
                })
            ->when($this->filtrocliente!='', function ($query){
                $query->where('cliente_id',$this->filtrocliente);
                })
            ->orderBy('referencia','asc')
            ->get();

            $responsables=Responsable::all();

        $vista=$this->tipo=='1' ? 'livewire.pedido.pedidoeditorial' : 'livewire.pedido.pedidootros';
        return view($vista,compact(['entidades','clientes','proveedores','responsables','cajas','laminados']));
    }

    public function updatedClienteId(){
        $this->contactos=EntidadContacto::with('entidadcontacto')->where('entidad_id', $this->cliente_id)->get();
        $this->ofertas=Oferta::where('cliente_id', $this->cliente_id)->get();
        if(!$this->fechapedido) $this->fechapedido=now()->format('Y-m-d');
        $resp=Entidad::find($this->cliente_id);
        if($resp->responsable!='') $this->responsable=$resp->responsable;

    }

    public function updatedProductoeditorialid(){
        if ($this->productoeditorialid=='') {
            // dd($this->productoeditorialid);
            $this->precio=0;
        } else {
            $p=Producto::find($this->productoeditorialid);
            $this->precio=$p->precioventa;
            $this->caja_id=$p->caja_id;
            $this->uds_caja=$p->udxcaja;
            $this->preciototal=$this->precio * $this->tiradareal;
        }
    }

    public function updatedPrecio(){
        $this->precio= $this->precio=='' ? $this->precio=0 : $this->precio;
        $this->preciototal=$this->precio*$this->tiradareal;
    }

    public function updatedTiradaprevista(){
        $this->tiradaprevista= $this->tiradaprevista=='' ? $this->tiradaprevista=0 : $this->tiradaprevista;
    }

    public function updatedTiradareal(){
        $this->tiradareal= $this->tiradareal=='' ? $this->tiradareal=0 : $this->tiradareal;
        $this->preciototal=$this->precio*$this->tiradareal;
    }

    public function updatedCajaId(){
        if($this->caja_id=='') $this->caja_id=null;
    }

    public function numpedido(){
        $anyo= substr($this->fechapedido, 0,4);
        $anyo2= substr($anyo, -2);
        $ped=ModeloPedido::inYear($anyo)->max('id') ;
        $ped=!isset($ped) ? ($anyo2 * 100000 +1) :$ped + 1 ;
        $pedMax=ModeloPedido::max('id');
        $ped=$pedMax>$ped ? $pedMax+1 : $ped;
        return $ped;
    }

    public function save(){
        if($this->fechaarchivos=='')$this->fechaarchivos=null;
        if($this->fechamaqueta=='')$this->fechamaqueta=null;
        if($this->fechaentrega =='') $this->fechaentrega=null;
        if($this->fechaplotter =='') $this->fechaplotter=null;
        if($this->ctrarchivos=='')$this->ctrarchivos='0';
        if($this->ctrmaqueta=='')$this->ctrmaqueta='0';
        if($this->ctrentrega =='') $this->ctrentrega='0';
        if($this->ctrplotter =='') $this->ctrplotter='0';
        if($this->contacto_id =='') $this->contacto_id=null;

        if($this->precio=='') $this->precio='0';
        if($this->consumo=='') $this->consumo='0';
        $mensaje="Pedido creado satisfactoriamente";
        $i="";
        if ($this->pedidoid!='') {
            $i=$this->pedidoid;
            $mensaje="Pedido actualizado satisfactoriamente";
            $nuevo=false;
            $this->validate([
                'pedidoid'=>[
                    'required',
                    Rule::unique('pedidos', 'id')->ignore($this->pedidoid)
                ],],);
        }else{
            $this->pedidoid=$this->numpedido();
            $i=$this->pedidoid;
            $nuevo=true;
        }

        $this->validate();
        $ped=ModeloPedido::updateOrCreate([
            'id'=>$i
            ],
            [
            'id'=>$this->pedidoid,
            'responsable'=>$this->responsable,
            'tipo'=>$this->tipo,
            'cliente_id'=>$this->cliente_id,
            'descripcion'=>$this->descripcion,
            'contacto_id'=>$this->contacto_id,
            'pedidocliente'=>$this->pedidocliente,
            'oferta_id'=>$this->oferta_id,
            'proveedor_id'=>$this->proveedor_id == '' ? null : $this->proveedor_id ,
            // 'producto_id'=>$this->producto_id,
            'muestra'=>$this->muestra,
            'pruebacolor'=>$this->pruebacolor,
            'laminadoplastico'=>$this->laminadoplastico,
            'laminado_id'=>$this->laminado_id,
            'consumo'=>$this->consumo,
            'unidad_consumo'=>$this->unidad_consumo,
            'facturadopor'=>$this->facturadopor,
            'fechapedido'=>$this->fechapedido,
            'fechaarchivos'=>$this->fechaarchivos,
            'fechamaqueta'=>$this->fechamaqueta,
            'fechaplotter'=>$this->fechaplotter,
            'fechaentrega'=>$this->fechaentrega,
            'ctrarchivos'=>$this->ctrarchivos,
            'ctrmaqueta'=>$this->ctrmaqueta,
            'ctrplotter'=>$this->ctrplotter,
            'ctrentrega'=>$this->ctrentrega,
            'tiradaprevista'=>$this->tiradaprevista,
            'tiradareal'=>$this->tiradareal,
            'precio'=>$this->precio,
            'preciototal'=>$this->preciototal,
            'estado'=>$this->estado,
            'tipo'=>$this->tipo,
            'facturado'=>$this->facturado == '' ? '0' : $this->facturado,
            'caja_id'=>$this->caja_id,
            'uds_caja'=>$this->uds_caja,
            'transporte'=>$this->transporte,
            'otros'=>$this->otros,
        ]);
        // dd($this->productoeditorialid .'-'. $ped->id);
        if ($this->tipo=='1') {
            $pprod=PedidoProducto::where('pedido_id',$ped->id)->first();    // miro si ya hay un producto. Si lo hay modifico o actualizo la linea
            if($pprod) $i=$pprod->id;                                       // si no lo creo. Si habia uno el producto es otro lo modifico. No añado
            $pedidopprod=PedidoProducto::updateOrCreate(
                [
                'id'=>$i
                ],
                [
                'pedido_id'=>$ped->id,
                'producto_id'=>$this->productoeditorialid,
                'tirada'=>$this->tiradaprevista,
                'precio_ud'=>$this->precio,
                'preciototal'=>$this->preciototal,
            ]
            );
        }

        // $this->titulo= $this->tipo='1' ? 'Pedido Editorial:': 'Pedido Packaging/Propios:';
        $pedido=ModeloPedido::find($ped->id);
        $this->dispatchBrowserEvent('notify', $mensaje);
        // if($nuevo) return redirect()->route('pedido.editar',[$pedido,$this->ruta,$this->titulo]);
        return redirect()->route('pedido.editar',[$pedido,$this->ruta,$this->titulo]);
    }

}
