<?php

namespace App\Http\Livewire\Compra;

Use App\Models\{Compra as ModelsCompra, Producto,Entidad};
Use App\Helpers\CompraHelper;
use Livewire\Component;
use Carbon\Carbon;

class Compra extends Component
{
    public $compra_id=null;    // id real en la DB
    public $compraid='';    // Número correlativo
    public $anyo = '';    // Código completo tipo CO-ED-2026-001
    public $codigo = '';    // Código completo tipo CO-ED-2026-001
    public $fecha='';
    public $fechaentrega='';
    public $proveedor_id='';
    public $descripcion='';
    public $productoid='';
    public $precio='0';
    public $ud_precio='1';
    public $cantidad='1';
    public $total='0';
    public $observaciones='';

    public $tipo;
    public $titulo;
    public $ruta;

    public $filtroisbn='';
    public $filtroreferencia='';

    public $nuevaCompra = false;

    public $proveedores;
    public $productos;

    protected $listeners = [ 'refreshcompra'];

    public function refreshcompra(){
        $this->mount($this->compraid, $this->tipo, $this->ruta, $this->titulo);
        // $this->render();
    }

    protected function rules(){
        return [
        'compraid'=>'required',
        'fecha'=>'required|date',
        'fechaentrega'=>'nullable|date',
        'proveedor_id'=>'required',
        'descripcion'=>'nullable',
        'productoid'=>'nullable',
        'precio'=>'nullable|numeric',
        'ud_precio'=>'nullable|numeric',
        'cantidad'=>'nullable|numeric',
        'total'=>'nullable|numeric',
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
            'fechaentrega.date'=>'La fecha entrega debe ser válida',
        ];
    }

        public function mount($compraid=null, int $tipo, $ruta, $titulo){
        $this->titulo=$titulo;
        $this->tipo=$tipo;
        $this->ruta=$ruta;

        //Edicion
        if ($compraid) {
            $compra=ModelsCompra::find($compraid);

            if($compra){
                $this->compra_id=$compra->id; //id real
                $this->compraid=$compra->numero; //numero secuencial sin saltos
                $this->codigo = CompraHelper::formatearCodigo($compra->fecha->year, $compra->id, $compra->tipo);
                $this->fecha = $compra->fecha->format('Y-m-d');
                $this->fechaentrega = $compra->fechaentrega->format('Y-m-d');
                $this->proveedor_id = $compra->proveedor_id;
                $this->descripcion = $compra->descripcion;
                $this->productoid = $compra->productoid;
                $this->precio = $compra->precio;
                $this->ud_precio = $compra->ud_precio;
                $this->cantidad = $compra->cantidad;
                $this->total = $compra->total;
                $this->observaciones = $compra->observaciones;
                $this->tipo = $compra->tipo;
            }
        }else{
            //Nuevo
            $numcompra = CompraHelper::siguienteNumero($this->tipo, $this->fecha);
            $this->compraid = $numcompra['numero'];
            $this->codigo = $numcompra['codigo'];
            $this->anyo     = $numcompra['anyo'];
            $this->fecha = now()->format('Y-m-d');
            $this->nuevaCompra = true; // marca como nueva
            $this->compra_id = null;
        }

        $this->cargarProveedoresYProductos();
    }

    public function render(){
        return view('livewire.compra.compra');
    }

    public function updatedFiltroisbn(){$this->cargarProductos();}

    public function updatedFiltroreferencia(){$this->cargarProductos();}

    // -------------------------
    // Actualización de fecha → recalcula número y código
    // -------------------------
    public function updatedFecha(){
        $data = CompraHelper::siguienteNumero($this->tipo, $this->fecha);
        $this->compraid = $data['numero'];
        $this->codigo = $data['codigo'];
    }

    // -------------------------
    // Actualización de totales
    // -------------------------
    public function updatedPrecio()
    {
        $this->precio = $this->precio ?: 0;
        $this->calcularTotal();
    }

    public function updatedCantidad()
    {
        $this->cantidad = $this->cantidad ?: 1;
        $this->calcularTotal();
    }

    public function updatedTotal()
    {
        $this->total = $this->total ?: 0;
    }

    // -------------------------
    // Helpers internos
    // -------------------------
    private function cargarProveedoresYProductos(){
        $this->proveedores = Entidad::orderBy('entidad', 'asc')->get();
        $this->cargarProductos();
    }

    private function cargarProductos(){
        $this->productos = Producto::where('productoestado', '1')
            ->where('tipo', $this->tipo)
            ->when($this->filtroisbn, fn($q) => $q->where('isbn', 'like', "%{$this->filtroisbn}%"))
            ->when($this->filtroreferencia, fn($q) => $q->where('referencia', 'like', "%{$this->filtroreferencia}%"))
            ->orderBy('referencia', 'asc')
            ->get();
    }

    public function productoSeleccionado(){
        if($this->productoid){
            $producto = Producto::find($this->productoid);
            if($producto){
                $this->precio = $producto->precio ?? 0;
                $this->ud_precio = $producto->ud_precio ?? 1;
                $this->calcularTotal();
            }
        }
    }

    // Recalcula total automáticamente
    public function calcularTotal(){
        $this->cantidad = $this->cantidad ?: 1; // por seguridad
        $this->precio = $this->precio ?: 0;
        $this->total = $this->precio * $this->cantidad;
    }

public function save(){
    $this->validate();

    $mensaje = $this->compraid ? 'Compra actualizada satisfactoriamente' : 'Compra creada satisfactoriamente';

    if (!$this->compraid) {
        $numcompra = CompraHelper::siguienteNumero($this->tipo, $this->fecha);
        $this->compraid = $numcompra['numero'];
        $this->codigo   = $numcompra['codigo'];
        $this->anyo     = $numcompra['anyo'];
    }

    $data = [
        'tipo'         => $this->tipo,
        'anyo'         => $this->anyo,
        'numero'       => $this->compraid,
        'codigo'       => $this->codigo,
        'fecha'        => $this->fecha,
        'fechaentrega' => $this->fechaentrega ?? null,
        'proveedor_id' => $this->proveedor_id,
        'descripcion'  => $this->descripcion,
        'producto_id'  => $this->productoid,
        'precio'       => $this->precio,
        'ud_precio'    => $this->ud_precio,
        'cantidad'     => $this->cantidad,
        'total'        => $this->total,
        'observaciones'=> $this->observaciones,
    ];


    if ($this->compra_id) {
        // editar
        $compra = ModelsCompra::find($this->compra_id);
        if($compra){
            $compra->update($data);
        }
    } else {
        // nueva compra
        $compra = ModelsCompra::create($data);
        $this->compra_id = $compra->id; // guardamos el id real para futuras ediciones
    }

    $this->dispatchBrowserEvent('notify', $mensaje);

    // NO hacemos redirect, nos quedamos en la página
}
}
