<?php

namespace App\Http\Livewire\Pedido;

use App\Models\{Producto,EntidadContacto,Entidad,User,Pedido as ModelsPedido};
use Livewire\Component;

class Pedido extends Component
{
    public $pedido;
    public $responsable_id;
    public $cliente_id;
    public $proveedor_id;
    public $producto_id;
    public $fechapedido;
    public $fechaarchivos;
    public $fechaplotter;
    public $fechaentrega;
    public $tiradaprevista;
    public $tiradareal;
    public $precio;
    public $preciototal;
    public $parcial;
    public $estado;
    public $facturado;
    public $cd_dvd;
    public $distribucion;
    public $cajas;
    public $incidencias;
    public $retardos;
    public $otros;
    public $fichapedido;
    public $mesagge;
    public $contactos;

    public $showPDFModal=false;

    protected function rules(){
        return [
            'pedido'=>'required',
            'responsable_id'=>'required',
            'cliente_id'=>'required',
            'proveedor_id'=>'nullable',
            'fechapedido'=>'required|date',
            'fechaarchivos'=>'nullable|date',
            'fechaplotter'=>'nullable|date',
            'fechaentrega'=>'required|date',
            'tiradaprevista'=>'required|numeric',
            'tiradareal'=>'nullable|numeric',
            'precio'=>'nullable|numeric',
            'preciototal'=>'nullable|numeric',
            'estado'=>'nullable',
            'facturado'=>'nullable',
            'cd_dvd'=>'nullable',
            'distribucion'=>'nullable',
            'cajas'=>'nullable',
            'incidencias'=>'nullable',
            'retardos'=>'nullable',
            'otros'=>'nullable',
            'fichapedido'=>'nullable',
        ];
    }

    public function messages()
    {
        return [
            'pedido.required'=>'El número de pedido es necesario',
            'responsable_id.required'=>'El responsable del pedido es necesario',
            'cliente_id.required'=>'El cliente es necesario',
            'proveedor_id.nullable'=>'',
            'fechapedido.date'=>'La fecha del pedido debe ser válida',
            'fechapedido.requiered'=>'La fecha del pedido es necesaria',
            'fechaarchivos.date'=>'La fecha de los archivos debe ser válida',
            'fechaplotter.date'=>'La fecha del plotter debe ser válida',
            'fechaentrega.date'=>'La fecha de entrega debe ser válida',
            'fechaentrega.requiered'=>'La fecha de entrega es necesaria',
            'tiradaprevista.required'=>'La tirada prevista es necesaria',
            'tiradaprevista.numeric'=>'El valor de la tirada prevista debe ser numérico',
            'tiradareal.numeric'=>'El valor de la tirada real debe ser numérico',
            'precio.numeric'=>'El valor del precio real debe ser numérico',
            'preciototal.numeric'=>'El valor del precio total real debe ser numérico',
        ];
    }

    public function mount(Pedido $pedido)
    {
        $this->pedido=$pedido->pedido;
        $this->responsable_id=$pedido->responsable_id;
        $this->cliente_id=$pedido->cliente_id;
        $this->proveedor_id=$pedido->proveedor_id;
        $this->fechapedido=$pedido->fechapedido;
        $this->fechaarchivos=$pedido->fechaarchivos;
        $this->fechaplotter=$pedido->fechaplotter;
        $this->fechaentrega=$pedido->fechaentrega;
        $this->tiradaprevista=$pedido->tiradaprevista;
        $this->tiradareal=$pedido->tiradareal;
        $this->precio=$pedido->precio;
        $this->preciototal=$pedido->preciototal;
        $this->estado=$pedido->estado;
        $this->facturado=$pedido->facturado;
        $this->cd_dvd=$pedido->cd_dvd;
        $this->distribucion=$pedido->distribucion;
        $this->cajas=$pedido->cajas;
        $this->incidencias=$pedido->incidencias;
        $this->retardos=$pedido->retardos;
        $this->otros=$pedido->otros;
        $this->fichapedido=$pedido->fichapedido;
    }

    public function render()
    {
        // $this->contactos=EntidadContacto::where('entidad_id',$pedido->cliente_id)->orderBy('contacto')->get();
        $entidades=Entidad::orderBy('entidad')->get();
        $clientes=$entidades->whereIn('entidadtipo_id',['2','3']);
        $proveedores=$entidades->whereIn('entidadtipo_id',['1','2']);
        $responsables=User::role('Milimetrica')->orderBy('name')->get();
        $productos=Producto::select('id','isbn','referencia');
        return view('livewire.pedido.pedido',compact(['productos','clientes','proveedores','responsables']));
    }

    public function openPDFModal(){
        $this->showPDFModal = true;
    }

    public function imprimir(){
        $this->openPDFModal();
    }

    public function save()
    {
        $this->validate();

        $mensaje="Pedido actualizado satisfactoriamente";

        $presup=Pedido::findOrFail($this->Pedido->id)
            ->update([
                'pedido'=>$this->pedido,
                'responsable_id'=>$this->responsable_id,
                'cliente_id'=>$this->cliente_id,
                'proveedor_id'=>$this->proveedor_id,
                'fechapedido'=>$this->fechapedido,
                'fechaarchivos'=>$this->fechaarchivos,
                'fechaplotter'=>$this->fechaplotter,
                'fechaentrega'=>$this->fechaentrega,
                'tiradaprevista'=>$this->tiradaprevista,
                'tiradareal'=>$this->tiradareal,
                'precio'=>$this->precio,
                'preciototal'=>$this->preciototal,
                'estado'=>$this->estado,
                'facturado'=>$this->facturado,
                'cd_dvd'=>$this->cd_dvd,
                'distribucion'=>$this->distribucion,
                'cajas'=>$this->cajas,
                'incidencias'=>$this->incidencias,
                'retardos'=>$this->retardos,
                'otros'=>$this->otros,
        ]);

        $pedido=Pedido::find($this->pedido->id);

        // $presup->recalculo();

        $this->dispatchBrowserEvent('notify', $mensaje);

        // return redirect()->route('presupuesto.edit',$presup);
    }
}
