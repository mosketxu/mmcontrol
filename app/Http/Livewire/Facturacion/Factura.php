<?php

namespace App\Http\Livewire\Facturacion;

use App\Models\{Entidad, EntidadContacto, Factura as ModelsFactura,Pedido};
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Factura extends Component
{

    public $facturaid='';
    public $ruta;
    public $cliente_id;
    public $contacto_id;
    public $fecha;
    public $fechavencimiento;
    public $pedidocliente;
    public $importe=0;
    public $iva=0;
    public $total=0;
    public $estado=0;
    public $tipo='1';
    public $observaciones;

    public $mesagge;
    public $bloqueado='0';
    public $deshabilitado='';
    public $escliente='';
    public $filtrocliente;
    public $cliente="";

    public $titulo='';
    public $pedidos;
    public $contactos;
    public $fac;

    protected $listeners = [ 'refreshfactura'];

    public function refreshfactura(){
        $this->mount($this->facturaid);
    // $this->render();
    }

    protected function rules(){
        return [
            // 'facturaid'=>'required',
            'cliente_id'=>'required',
            'contacto_id'=>'nullable',
            'pedidocliente'=>'nullable',
            'fecha'=>'date|required',
            'fechavencimiento'=>'nullable|date',
            'estado'=>'nullable',
            'tipo'=>'nullable',
            'observaciones'=>'nullable',
        ];
    }

    public function messages(){
        return [
            'facturaid.required'=>'El número de factura es necesario.',
            'cliente_id.required'=>'El cliente es necesario.',
            'fecha.required'=>'La fecha es necesaria.',
            'fecha.date'=>'La fecha debe ser válida.',
            'fechavencimiento.date'=>'La fecha de vencimiento debe ser válida.',
        ];
    }

    public function mount($facturaid){
        $this->titulo='Nueva Factura:';
        if ($facturaid!='') {
            $factura=ModelsFactura::find($facturaid);
            $this->fac=$factura;
            $this->facturaid=$factura->id;
            $this->cliente_id=$factura->cliente_id;
            $this->contacto_id=$factura->contacto_id;
            $this->fecha=$factura->fecha;
            $this->fechavencimiento=$factura->fechavencimiento;
            $this->pedidocliente=$factura->pedidocliente;
            $this->importe=number_format($factura->importe,4,',','.');
            $this->iva=number_format($factura->iva,2,',','.');
            $this->total=number_format($factura->total,2,',','.');
            $this->estado=$factura->estado;
            $this->tipo=$factura->tipo;
            $this->observaciones=$factura->observaciones;
            $this->bloqueado=$this->estado!='0' ? '1' : '0';
            $this->deshabilitado=$this->bloqueado=='1' ? 'disabled' : '';

            $pedidossinfacturar=Pedido::select('pedidocliente','facturado')
                ->where('cliente_id',$factura->cliente_id)
                ->where('pedidocliente','<>','')
                ->where('facturado','<>','1')
                ->groupBy('pedidocliente')->get();

            $pedidodeestafactura=Pedido::select('pedidocliente','facturado')
                ->where('pedidocliente',$this->pedidocliente)
                ->where('pedidocliente','<>','')
                ->get();

            $this->pedidos=$pedidossinfacturar->concat($pedidodeestafactura);

            $this->contactos=EntidadContacto::with('entidadcontacto')->where('entidad_id',$factura->cliente_id)->get();
        }
        $this->escliente=Auth::user()->hasRole('Cliente') ? 'disabled' : '';
    }

    public function render(){
        $clientes=Entidad::orderBy('entidad')->whereIn('entidadtipo_id',['1','2'])->get();
        return view('livewire.facturacion.factura',compact(['clientes']));
    }

    public function updatedClienteId(){
        if(!$this->fecha) $this->fecha=now()->format('Y-m-d');
        $this->contactos=EntidadContacto::with('entidadcontacto')->where('entidad_id',$this->cliente_id)->get();
        $this->pedidos=Pedido::select('pedidocliente')->where('cliente_id',$this->cliente_id)->where('estado','<>','1')->where('pedidocliente','<>','')->groupBy('pedidocliente')->get();
    }

    public function updatedContactoId(){if($this->contacto_id=='') $this->contacto_id=null;}

    public function numfactura(){
        $anyo= substr($this->fecha, 0,4);
        $anyo2= substr($anyo, -2);
        // quieren el la facturacion no empieza de 1 cada año sino que siga la numeracion del año anterior. Segun JM en enero 2024
        // $fac=ModelsFactura::inYear($anyo)->max('id') ;
        // return !isset($fac) ? ($anyo2 * 100000 +1961) :$fac + 1 ;

        // lo calculo sin iniciar de 1
        $fac=$anyo2.substr(ModelsFactura::max('id')+1, -5);
        return !isset($fac) ? ($anyo2 * 100000 +1961) :$fac  ;

    }

    public function save(){
        $mensaje="Factura creada satisfactoriamente";
        $i="";
        if($this->fechavencimiento=='') $this->fechavencimiento=null;
        $this->validate();
        if ($this->facturaid!='') {
            $i=$this->facturaid;
            $mensaje="Factura actualizada satisfactoriamente";
            $nuevo=false;
            $this->validate([
                'facturaid'=>[
                    'required',
                    Rule::unique('facturas', 'id')->ignore($this->facturaid)
                ],],);
        }else{
            $this->facturaid=$this->numfactura();
            $i=$this->facturaid;
            $nuevo=true;
        }
        $fac=ModelsFactura::updateOrCreate([
            'id'=>$i
            ],
            [
            'id'=>$this->facturaid,
            'cliente_id'=>$this->cliente_id,
            'contacto_id'=>$this->contacto_id,
            'pedidocliente'=>$this->pedidocliente,
            'fecha'=>$this->fecha,
            'fechavencimiento'=>$this->fechavencimiento,
            'estado'=>$this->estado == '' ? '0' : $this->estado,
            'tipo'=>$this->tipo == '' ? '1' : $this->tipo,
            'observaciones'=>$this->observaciones,
        ]);

        $this->titulo='Factura:';
        $factura=ModelsFactura::find($i);

        $this->dispatchBrowserEvent('notify', $mensaje);
        return redirect()->route('facturacion.edit',$factura->id);
    }
}
