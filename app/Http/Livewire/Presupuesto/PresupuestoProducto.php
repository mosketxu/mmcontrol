<?php

namespace App\Http\Livewire\Presupuesto;

use App\Models\{Producto,PresupuestoProducto as ModelsPresupuestoProducto,Presupuesto};
use Livewire\Component;

class PresupuestoProducto extends Component
{
    public $presupuesto;
    public $presupuesto_id;
    public $producto_id;
    public $orden='0';
    public $visible='1';
    public $tirada='0';
    public $precio_ud='0';
    public $preciototal='0';
    public $observaciones='';
    public $bloqueado=false;
    public $deshabilitado='';
    public $escliente='';

    protected function rules(){
        return [
            'presupuesto_id'=>'required',
            'producto_id'=>'required',
            'tirada'=>'required',
            'precio_ud'=>'nullable',
            'preciototal'=>'nullable',
            'observaciones'=>'nullable',
            'visible'=>'nullable',
            'orden'=>'nullable',
        ];
    }

    public function messages(){
        return [
            'presupuesto_id'=>'El presupuesto es necesario.',
            'producto_id'=>'El producto es necesario.',
            'tirada'=>'La cantidad es necesario.',
        ];
    }

    public function mount($presupuestoid,$deshabilitado){
        $this->presupuesto=Presupuesto::find($presupuestoid);
        $this->presupuesto_id=$presupuestoid;
        $this->deshabilitado= $deshabilitado;
        $this->escliente=Auth::user()->hasRole('Cliente') ? 'disabled' : '';
    }

    public function render(){
        $productos=Producto::where('tipo','2')->orderBy('referencia')->get();
        $presupproductos=ModelsPresupuestoProducto::where('presupuesto_id',$this->presupuesto_id)->get();
        return view('livewire.presupuesto.presupuesto-productootros',compact('productos','presupproductos'));
    }

    public function UpdatedProductoId(){
        if($this->producto_id!='') {
            $p=Producto::find($this->producto_id);
            $this->precio_ud=$p->preciocoste;
            $this->tirada=$p->cantidad;
            $this->preciototal=$p->precio_ud * $this->tirada;
        }else{
            $this->precio_ud='0';
            $this->tirada='0';
            $this->preciototal='0';
        }
    }

    public function UpdatedTirada(){ if($this->tirada=='') $this->tirada=='0'; $this->preciototal=$this->precio_ud * $this->tirada; }
    public function UpdatedPrecioUd(){ if($this->precio_ud=='') $this->precio_ud=='0'; $this->preciototal=$this->precio_ud * $this->tirada; }

    public function save(){
        if(!$this->tirada) $this->tirada=0;
        if(!$this->precio_ud) $this->precio_ud=0;
        if(!$this->preciototal) $this->preciototal=0;

        $this->validate();
        $pprod=ModelsPresupuestoProducto::create([
            'presupuesto_id'=>$this->presupuesto_id,
            'producto_id'=>$this->producto_id,
            'tirada'=>$this->tirada,
            'precio_ud'=>$this->precio_ud,
            'preciototal'=>$this->preciototal,
            'observaciones'=>$this->observaciones,
            'visible'=>$this->visible,
            'orden'=>$this->orden,
        ]);

        $this->producto_id='';
        $this->tirada='0';
        $this->precio_ud='0';
        $this->preciototal='0';
        $this->observaciones='';
        $this->visible='1';
        $this->orden='0';

        $this->dispatchBrowserEvent('notify', 'Guardado con éxito.');
    }

    public function delete($valorId)
    {
        $this->validate();

        $borrar = ModelsPresupuestoProducto::find($valorId);

        if ($borrar) {
            $borrar->delete();
            $this->dispatchBrowserEvent('notify', 'Línea eliminada!');
        }
    }

}
