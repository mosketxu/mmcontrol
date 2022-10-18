<?php

namespace App\Http\Livewire\Producto;

use App\Models\{Entidad,Producto};
use Illuminate\Support\Facades\Storage;
use Livewire\WithPagination;


use Livewire\Component;

class Prods extends Component
{

    use WithPagination;

    // public $search='';
    public $filtroisbn='';
    public $filtroreferencia='';
    public $filtrocliente='';
    public $filtroproveedor='';

    public Producto $producto;

    public function render()
    {
        $this->producto= new Producto;
        $provs = array('2','3');
        $clis = array('1','3');

        $entidades=Entidad::orderBy('entidad')->get();
        $clientes=$entidades->whereIn('entidadtipo_id',['2','3']);
        $proveedores=$entidades->whereIn('entidadtipo_id',['1','2']);

        $productos=Producto::query()
            ->with('cliente','proveedor')
            ->when($this->filtroisbn!='', function ($query){
                $query->where('isbn', 'like', '%'.$this->filtroisbn.'%');
                })
            ->when($this->filtroreferencia!='', function ($query){
                $query->where('referencia', 'like', '%'.$this->filtroreferencia.'%');
                })
            ->when($this->filtrocliente!='', function ($query){
                $query->where('cliente_id',$this->filtrocliente);
                })
            ->when($this->filtroproveedor!='', function ($query){
                $query->where('proveedor_id',$this->filtroproveedor);
                })
            ->orderBy('referencia','asc')
            ->paginate(15);

            return view('livewire.producto.prods',compact('productos','proveedores','clientes'));
    }

    public function updatingFiltroisbn(){$this->resetPage();}
    public function updatingFiltroreferencia(){$this->resetPage();}
    public function updatingFiltrocliente(){$this->resetPage();}
    public function updatingFiltroproveedor(){$this->resetPage();}

    public function presentaPDF(Producto $producto){
        $existe=Storage::disk('fichasproducto')->exists($producto->fichaproducto);
        if ($existe)
            return Storage::disk('fichasproducto')->download($producto->fichaproducto);
    }

    public function delete($productoId)
    {
        $producto = Producto::find($productoId);
        if ($producto) {
            $producto->delete();
            $this->dispatchBrowserEvent('notify', 'El producto: '.$producto->referencia.' ha sido eliminado!');
        }
    }
}
