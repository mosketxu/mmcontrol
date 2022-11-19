<?php

namespace App\Http\Livewire\Facturacion;

use App\Models\{Entidad,Factura as ModelsFactura,Pedido};
use Illuminate\Validation\Rule;
use Livewire\Component;

class Factura extends Component
{

    public $facturaid='';
    public $ruta;
    public $cliente_id;
    public $fecha;
    public $importe=0;
    public $iva=0;
    public $total=0;
    public $estado=0;
    public $observaciones;

    public $mesagge;
    public $filtrocliente;

    public $titulo='';
    // public $pedidos;

    protected $listeners = [ 'refreshfactura'];

    public function refreshfactura()
    {
        // dd($this->facturaid);
        $this->mount($this->facturaid);
    // $this->render();
    }

    protected function rules(){
        return [
            'facturaid'=>'required',
            'cliente_id'=>'required',
            'fecha'=>'date|required',
            'importe'=>'numeric|nullable',
            'estado'=>'nullable',
            'observaciones'=>'nullable',
        ];
    }

    public function messages()
    {
    return [
        'facturaid.required'=>'El número de factura es necesario.',
        'cliente_id.required'=>'El cliente es necesario.',
        'fecha.required'=>'la fecha es necesaria.',
        'fecha.date'=>'la fecha debe ser válida.',
        'importe.numeric'=>'El importe ha de ser numérico',
        ];
    }

    public function mount($facturaid){
        $this->titulo='Nueva Factura:';

        if ($facturaid!='') {
            $factura=ModelsFactura::find($facturaid);
            $this->facturaid=$factura->id;
            $this->cliente_id=$factura->cliente_id;
            $this->fecha=$factura->fecha;
            $this->importe=$factura->importe;
            $this->iva=$factura->iva;
            $this->total=$factura->total;
            $this->estado=$factura->estado;
            $this->observaciones=$factura->observaciones;
        }
    }

    public function render(){
        $clientes=Entidad::orderBy('entidad')->whereIn('entidadtipo_id',['1','2'])->get();

        return view('livewire.facturacion.factura',compact(['clientes']));
    }

    public function updatedClienteId(){
        if(!$this->fecha) $this->fecha=now()->format('Y-m-d');
    }

    public function numfactura(){
        $anyo= substr($this->fecha, 0,4);
        $anyo2= substr($anyo, -2);
        $fac=ModelsFactura::whereYear('fecha', $anyo)->max('id') ;
        return !isset($fac) ? ($anyo2 * 100000 +1) :$fac + 1 ;
    }

    public function save()
    {
        $mensaje="Factura creada satisfactoriamente";
        $i="";
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
        $this->validate();
        $fac=ModelsFactura::updateOrCreate([
            'id'=>$i
            ],
            [
            'id'=>$this->facturaid,
            'cliente_id'=>$this->cliente_id,
            'fecha'=>$this->fecha,
            'importe'=>$this->importe,
            'estado'=>$this->estado == '' ? '0' : $this->estado,
            'observaciones'=>$this->observaciones,
        ]);

        $this->titulo='Factura:';
        $factura=ModelsFactura::find($i);
        $this->dispatchBrowserEvent('notify', $mensaje);
        if($nuevo) return redirect()->route('facturacion.edit',$factura->id);
    }
}
