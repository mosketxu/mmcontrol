<?php

namespace App\Http\Livewire\Compra;

Use App\Models\{Producto,Entidad};

use Livewire\Component;

class Compra extends Component
{
    public $compraid='';
    public $fecha='';
    public $proveedor_id='';
    public $descripcion='';
    public $producto_id='';
    public $precio='0';
    public $ud_precio='1';
    public $cantidad='1';
    public $total='0';
    public $observaciones='';

    public $tipo;
    public $titulo;
    public $ruta;

    public $filtroisbn;
    public $filtroreferencia;


    public $proveedores;
    public $producto='';
    public $productos;

    protected $listeners = [ 'refreshcompra'];

    public function refreshcompra(){
        $this->mount($this->compraid,$this->tipo,$this->ruta,$this->titulo);
        $this->render();
    }

    protected function rules(){
        return [
        'compraid'=>'required',
        'fecha'=>'date|required',
        'proveedor_id'=>'required',
        'descripcion'=>'nullable',
        'producto_id'=>'nullable',
        'precio'=>'nullable',
        'ud_precio'=>'required',
        'cantidad'=>'required',
        'total'=>'nullable',
        'observaciones'=>'nullable',
        ];
    }

    public function messages(){
        return [
            'compraid.required'=>'El número de compra es necesario',
            'proveedor_id.required'=>'El proveedor es necesario',
            'precio.required'=>'El precio es necesaria',
            'cantidad.required'=>'La cantidad es necesaria',
            'ud_precio.required'=>'La unidad precio es necesaria',
            'fecha.required'=>'La fecha del compra es necesaria',
            'fecha.date'=>'La fecha debe ser válida',
        ];
    }

        public function mount($compraid, $tipo, $ruta, $titulo){
        $this->titulo=$titulo;
        $this->tipo=$tipo;
        $this->ruta=$ruta;

        if ($compraid!='') {
            $compra=Compra::find($compraid);
            $this->tipo=$compra->tipo;
            $this->compraid=$compra->id;
            $this->fecha=$compra->fecha;
            $this->proveedor_id=$compra->proveedor_id;
            $this->descripcion=$compra->descripcion;
            $this->producto_id=$compra->producto_id;
            $this->precio=$compra->precio;
            $this->ud_precio=$compra->ud_precio;
            $this->cantidad=$compra->cantidad;
            $this->total=$compra->total;
            $this->observaciones=$compra->observaciones;
        }

        $this->productos = Producto::where('productoestado', '1')
            ->where('tipo', $this->tipo)
            ->orderBy('referencia', 'asc')
            ->get();

        $this->proveedores = Entidad::orderBy('entidad', 'asc')
            ->get();
    }

    public function render()
    {
        return view('livewire.compra.compra');
    }
}
