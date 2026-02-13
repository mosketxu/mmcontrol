<?php

namespace App\Http\Livewire\Producto;

use App\Enums\ProductoEstado;
use App\Models\{Entidad,Producto};
use Illuminate\Support\Facades\Storage;
use Livewire\WithPagination;


use Livewire\Component;

class Prods extends Component
{

    use WithPagination;

    // public $search='';
    public $filtroisbn='';
    public $filtroproductoestado='1';
    public $filtroreferencia='';
    public $filtrocliente='';
    public $filtromaterial='';
    public $filtroimpresion='';
    public $tipo;
    public $titulo;
    public $ordenarpor1='';
    public $orden1='';
    public $ordenarpor2='';
    public $orden2='';
    public $productosestado='1';

    protected $queryString=['filtroisbn','filtroproductoestado','filtroreferencia','filtrocliente','filtromaterial','filtroimpresion'];


    public Producto $producto;

    public function mount($tipo,$titulo,){
        $this->titulo=$titulo;
        $this->tipo=$tipo;
        if($tipo=='1'){
            $this->ordenarpor1='referencia';
            $this->orden1='asc';
            $this->ordenarpor2='';
            $this->orden2='';

        }else{
            $this->ordenarpor1='isbn';
            $this->orden1='asc';
            $this->ordenarpor2='referencia';
            $this->orden2='asc';
        }

        $this->productosestado=ProductoEstado::options();
    }

    public function render(){

        $this->producto= new Producto;
        $entidades=Entidad::orderBy('entidad')->get();
        $clientes=$entidades->whereIn('entidadtipo_id',['1','2','4']);

        $datos=Producto::query()
            ->with('cliente')
            ->orderBy($this->ordenarpor1,$this->orden1)
            ->when($this->ordenarpor2!='', function ($query){
                $query->orderBy($this->ordenarpor2,$this->orden2);
                });

        if($this->tipo) $datos->where('tipo',$this->tipo);
        if($this->filtroisbn) $datos->where('isbn', 'like', '%'.$this->filtroisbn.'%');
        if($this->filtroproductoestado) $datos->where('productoestado', $this->filtroproductoestado);
        if($this->filtroreferencia) $datos->where('referencia', 'like', '%'.$this->filtroreferencia.'%');
        if($this->filtrocliente) $datos->where('cliente_id',$this->filtrocliente);
        if($this->filtromaterial) $datos->search('productos.material',$this->filtromaterial);
        if($this->filtroimpresion) $datos->search('productos.impresion',$this->filtroimpresion);

        $productos=$datos->paginate(50);

        $vista= $this->tipo=='1' ? 'livewire.producto.prodseditorial' : 'livewire.producto.prodsotros';

        return view($vista,compact('productos','clientes'));
    }

        public function updatingFiltroisbn(){$this->resetPage();}
        public function updatingFiltroproductoestado(){$this->resetPage();}
        public function updatingFiltroreferencia(){$this->resetPage();}
        public function updatingFiltrocliente(){$this->resetPage();}
        public function updatingFiltromaterial(){$this->resetPage();}
        public function updatingFiltroimpresion(){$this->resetPage();}


    public function delete($productoId)
    {
        $existe=Storage::disk('fichasproducto')->exists($productoId);
        if ($existe) Storage::disk('fichasproducto')->deleteDirectory($productoId);

        $producto = Producto::find($productoId);
        if ($producto) {
            $producto->delete();
            $this->dispatchBrowserEvent('notify', 'El producto: '.$producto->referencia.' ha sido eliminado!');
        }
    }
}
