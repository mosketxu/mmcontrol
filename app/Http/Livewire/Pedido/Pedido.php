<?php

namespace App\Http\Livewire\Pedido;

use App\Models\{Producto,EntidadContacto,Entidad, Oferta, Pedido as ModeloPedido};
use Illuminate\Validation\Rule;
use Livewire\Component;

class Pedido extends Component
{
    public $pedidoid='';
    public $tipo;
    public $ruta;
    public $responsable;
    public $cliente_id;
    public $proveedor_id;
    public $pedidocliente;
    public $oferta_id;
    public $facturadopor_id;
    public $muestra;
    public $pruebacolor;
    public $contacto_id;
    public $producto_id;
    public $fechapedido;
    public $fechaarchivos;
    public $fechaplotter;
    public $fechaentrega;
    public $tiradaprevista=0;
    public $tiradareal=0;
    public $preciocoste=0;
    public $precio=0;
    public $preciototal=0;
    public $parcial=0;
    public $estado=0;
    public $facturado;
    public $uds_caja;
    public $otros;

    // public $destino='0';
    public $filtroisbn;
    public $filtroreferencia;
    public $filtrocliente;
    public $ofertatemp;

    public $titulo='';
    public $contactos;
    public $productos;
    public $ofertas;

    protected function rules(){
        return [
            'pedidoid'=>'required',
            'responsable'=>'required',
            'cliente_id'=>'required',
            'contacto_id'=>'required',
            'proveedor_id'=>'nullable',
            'pedidocliente'=>'nullable',
            'oferta_id'=>'nullable',
            'facturadopor_id'=>'nullable',
            'muestra'=>'nullable',
            'producto_id'=>'required',
            'fechapedido'=>'required|date',
            'fechaarchivos'=>'nullable|date',
            'fechaplotter'=>'nullable|date',
            'fechaentrega'=>'required|date',
            'tiradaprevista'=>'required|numeric',
            'tiradareal'=>'nullable|numeric',
            'preciocoste'=>'nullable|numeric',
            'precio'=>'nullable|numeric',
            'preciototal'=>'nullable|numeric',
            'estado'=>'nullable',
            'facturado'=>'nullable',
            'uds_caja'=>'nullable',
            'otros'=>'nullable',
        ];
    }

    public function messages(){
        return [
            'pedidoid.required'=>'El número de pedido es necesario',
            'producto_id.required'=>'Debes elegir un producto',
            'contacto_id.required'=>'Debes elegir un contacto',
            'responsable.required'=>'El responsable del pedido es necesario',
            'cliente_id.required'=>'El cliente es necesario',
            'proveedor_id.nullable'=>'',
            'fechapedido.date'=>'La fecha del pedido debe ser válida',
            'fechapedido.required'=>'La fecha del pedido es necesaria',
            'fechaarchivos.date'=>'La fecha de los archivos debe ser válida',
            'fechaplotter.date'=>'La fecha del plotter debe ser válida',
            'fechaentrega.date'=>'La fecha de entrega debe ser válida',
            'fechaentrega.required'=>'La fecha de entrega es necesaria',
            'tiradaprevista.required'=>'La tirada prevista es necesaria',
            'tiradaprevista.numeric'=>'El valor de la tirada prevista debe ser numérico',
            'tiradareal.numeric'=>'El valor de la tirada real debe ser numérico',
            'preciocoste.numeric'=>'El valor del precio de compra debe ser numérico',
            'precio.numeric'=>'El valor del precio de venta debe ser numérico',
            'preciototal.numeric'=>'El valor del precio total debe ser numérico',
        ];
    }

    public function mount($pedidoid,$tipo,$ruta){
        $this->titulo='Nuevo Pedido:';
        $this->tipo=$tipo;
        $this->ruta=$ruta;
        $mm=Entidad::where('nif','B63941835')->first();
        $this->facturadopor_id=$mm->id;
        if ($pedidoid!='') {
            $pedido=ModeloPedido::find($pedidoid);
            $this->tipo=$pedido->tipo;
            $this->pedidoid=$pedido->id;
            $this->responsable=$pedido->responsable;
            $this->cliente_id=$pedido->cliente_id;
            $this->pedidocliente=$pedido->pedidocliente;
            $this->oferta_id=$pedido->oferta_id;
            $this->contacto_id=$pedido->contacto_id;
            $this->proveedor_id=$pedido->proveedor_id;
            $this->facturadopor_id=$pedido->facturadopor_id;
            $this->muestra=$pedido->muestra;
            $this->pruebacolor=$pedido->pruebacolor;
            $this->producto_id=$pedido->producto_id;
            $this->fechapedido=$pedido->fechapedido;
            $this->fechaarchivos=$pedido->fechaarchivos;
            $this->fechaplotter=$pedido->fechaplotter;
            $this->fechaentrega=$pedido->fechaentrega;
            $this->tiradaprevista=$pedido->tiradaprevista;
            $this->tiradareal=$pedido->tiradareal;
            $this->preciocoste=$pedido->producto->preciocoste ?? '-';
            $this->precio=$pedido->precio;
            $this->preciototal=$pedido->preciototal;
            $this->estado=$pedido->estado;
            $this->facturado=$pedido->facturado;
            $this->uds_caja=$pedido->uds_caja;
            $this->otros=$pedido->otros;
            $this->titulo='Pedido';
            if($this->cliente_id){
                $this->contactos=EntidadContacto::with('entidadcontacto')->where('entidad_id', $this->cliente_id)->get();
                $this->ofertas=Oferta::where('cliente_id', '=', $this->cliente_id)->orderBy('id')->get();
            }
        }
    }

    public function render(){
        $entidades=Entidad::orderBy('entidad')->get();
        $clientes=$entidades->whereIn('entidadtipo_id',['1','2']);
        $proveedores=$entidades->whereIn('entidadtipo_id',['2','3']);

        $this->productos=Producto::query()
            ->with('cliente')
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
            return view('livewire.pedido.pedido',compact(['entidades','clientes','proveedores']));
        }

    public function updatedClienteId(){
        $this->contactos=EntidadContacto::with('entidadcontacto')->where('entidad_id', $this->cliente_id)->get();
        $this->ofertas=Oferta::where('cliente_id', $this->cliente_id)->get();
        if(!$this->fechapedido) $this->fechapedido=now()->format('Y-m-d');
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

    public function updatedOfertatemp(){
        $this->oferta_id= $this->ofertatemp;
    }

    public function updatedPreciocoste(){
        $this->preciocoste= $this->preciocoste=='' ? $this->preciocoste=0 : $this->preciocoste;
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

    public function numpedido(){
        $anyo= substr($this->fechapedido, 0,4);
        $anyo2= substr($anyo, -2);
        $ped=ModeloPedido::whereYear('fechapedido', $anyo)->max('id') ;
        return !isset($ped) ? ($anyo2 * 100000 +1) :$ped + 1 ;
    }

    public function save(){
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
            'contacto_id'=>$this->contacto_id,
            'pedidocliente'=>$this->pedidocliente,
            'oferta_id'=>$this->oferta_id,
            'proveedor_id'=>$this->proveedor_id == '' ? null : $this->proveedor_id ,
            'producto_id'=>$this->producto_id,
            'muestra'=>$this->muestra,
            'pruebacolor'=>$this->pruebacolor,
            'facturadopor_id'=>$this->facturadopor_id,
            'fechapedido'=>$this->fechapedido,
            'fechaarchivos'=>$this->fechaarchivos,
            'fechaplotter'=>$this->fechaplotter,
            'fechaentrega'=>$this->fechaentrega,
            'tiradaprevista'=>$this->tiradaprevista,
            'tiradareal'=>$this->tiradareal,
            'precio'=>$this->precio,
            'preciototal'=>$this->preciototal,
            'estado'=>$this->estado,
            'facturado'=>$this->facturado == '' ? '0' : $this->facturado,
            'uds_caja'=>$this->uds_caja,
            'otros'=>$this->otros,
        ]);

        $this->titulo='Pedido:';
        $pedido=ModeloPedido::find($ped->id);
        $this->dispatchBrowserEvent('notify', $mensaje);
        if($nuevo) return redirect()->route('pedido.editar',[$pedido,$this->ruta]);
    }

}
