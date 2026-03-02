<?php

namespace App\Http\Livewire\Clientes;

use App\Enums\ProductoEstado;
use App\Models\{Caja,Entidad,Producto, UserEmpresa};
use Illuminate\Support\Facades\Storage;
use Livewire\WithPagination;


use Livewire\Component;

class ClienteProds extends Component
{

    use WithPagination;

    // public $search='';
    public $filtroisbn='';
    public $filtroproductoestado='';
    public $filtroreferencia='';
    public $filtrocliente='';
    public $filtromaterial='';
    public $filtroimpresion='';
    public $filtrocaja='';
    public $tipo;
    public $titulo;
    public $cliente;
    public $ordenarpor1='';
    public $orden1='';
    public $ordenarpor2='';
    public $orden2='';
    public $productosestado='1';

    protected $queryString=['filtroisbn','filtroproductoestado','filtroreferencia','filtrocliente','filtromaterial','filtroimpresion','filtrocaja','ordenarpor1','orden1','ordenarpor2','orden2'];


    public Producto $producto;

    public function mount($tipo,$cliente,$titulo)
    {
        $this->cliente=$cliente;
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
        $entidadescliente=UserEmpresa::where('user_id',$this->cliente->id)->get();
         $cajas=Caja::where('tipo',$this->tipo)->orderBy('name')->get();

        $entidades=Entidad::orderBy('entidad')
        ->whereIn('id',$entidadescliente->pluck('entidad_id'))
        ->get();
        $clientes=$entidades->whereIn('entidadtipo_id',['1','2']);
        $productos=Producto::query()
            ->with('cliente')
            ->whereIn('cliente_id',$entidadescliente->pluck('entidad_id'))
            ->when($this->tipo!='', function ($query){
                $query->where('tipo',$this->tipo);
                })
            ->when($this->filtroisbn!='', function ($query){
                $query->where('isbn', 'like', '%'.$this->filtroisbn.'%');
                })
            ->when($this->filtroproductoestado!='', function ($query){
                $query->where('productoestado',$this->filtroproductoestado);
                })
            ->when($this->filtroreferencia!='', function ($query){
                $query->where('referencia', 'like', '%'.$this->filtroreferencia.'%');
                })
            ->when($this->filtrocliente!='', function ($query){
                $query->where('cliente_id',$this->filtrocliente);
                })
            ->search('productos.material',$this->filtromaterial)
            ->search('productos.impresion',$this->filtroimpresion)
            ->search('productos.caja_id',$this->filtrocaja)
            ->orderBy($this->ordenarpor1,$this->orden1)
            ->when($this->ordenarpor2!='', function ($query){
                $query->orderBy($this->ordenarpor2,$this->orden2);
                })
            ->get();

        $vista= $this->tipo=='1' ? 'livewire.clientes.producto.prodseditorial-cliente' : 'livewire.clientes.producto.prodsotros-cliente';

        return view($vista,compact('productos','clientes','cajas'));
    }

    public function updatingFiltroisbn(){$this->resetPage();}
    public function updatingFiltroproductoestado(){$this->resetPage();}
    public function updatingFiltroreferencia(){$this->resetPage();}
    public function updatingFiltrocliente(){$this->resetPage();}
    public function updatingFiltromaterial(){$this->resetPage();}
    public function updatingFiltroimpresion(){$this->resetPage();}
    public function updatingFiltrocaja(){$this->resetPage();}
}
