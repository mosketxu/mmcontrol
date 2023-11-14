<?php

namespace App\Http\Livewire\Presupuesto;

use App\Models\PresupuestoProducto;
use App\Models\Producto;
use Illuminate\Support\Facades\Auth;

use Livewire\Component;

class PresupuestoProductos extends Component
{

    public $presupuesto_id;
    public $pproductoid='';
    public $pproducto;
    public $producto_id;
    public $orden;
    public $visible;
    public $tirada;
    public $precio_ud;
    public $preciototal;
    public $observaciones='';

    public $bloqueado=false;
    public $deshabilitado='';
    public $escliente='';

    protected $listeners = [ 'refreshpprod'];


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

    public function mount($pproducto,$deshabilitado){
        $this->pproducto=$pproducto;
        $this->pproductoid=$pproducto->id;
        $this->presupuesto_id=$pproducto->presupuesto_id;
        $this->producto_id=$pproducto->producto_id;
        $this->orden=$pproducto->orden;
        $this->visible=$pproducto->visible;
        $this->tirada=$pproducto->tirada;
        $this->precio_ud=$pproducto->precio_ud;
        $this->preciototal=$pproducto->preciototal;
        $this->observaciones=$pproducto->observaciones;
        $this->deshabilitado=$deshabilitado;
        $this->escliente=Auth::user()->hasRole('Cliente') ? 'disabled' : '';
    }

    public function render(){

        $productos=Producto::where('tipo','2')->orderBy('referencia')->get();

        return view('livewire.presupuesto.presupuesto-productosotros',compact('productos'));
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
        $this->save();
    }

    public function UpdatedTirada(){ if($this->tirada=='') $this->tirada=='0'; $this->preciototal=$this->precio_ud * $this->tirada;  }
    public function UpdatedPrecioUd(){ if($this->precio_ud=='') $this->precio_ud=='0'; $this->preciototal=$this->precio_ud * $this->tirada; ; }

    public function save(){
        if(!$this->tirada) $this->tirada=0;
        if(!$this->precio_ud) $this->precio_ud=0;
        if(!$this->preciototal) $this->preciototal=0;

        $this->validate();
        $pprod=PresupuestoProducto::updateOrCreate([
            'id'=>$this->pproductoid
            ],
            [
            'presupuesto_id'=>$this->presupuesto_id,
            'producto_id'=>$this->producto_id,
            'tirada'=>$this->tirada,
            'precio_ud'=>$this->precio_ud,
            'preciototal'=>$this->preciototal,
            'observaciones'=>$this->observaciones,
            'visible'=>$this->visible,
            'orden'=>$this->orden,
        ]);
        $this->dispatchBrowserEvent('notify', 'Guardado con éxito.');

        $this->emit('refresh');
    }

    public function delete($valorId)
    {
        $this->validate();

        $borrar = PresupuestoProducto::find($valorId);

        if ($borrar) {
            $borrar->delete();
            $this->dispatchBrowserEvent('notify', 'Línea eliminada!');
        }

        $this->emit('refreshpresupuesto');

    }

}

