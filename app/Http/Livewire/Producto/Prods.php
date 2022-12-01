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
    public $tipo;

    public Producto $producto;

    public function render()
    {
        if($this->tipo=='1') $titulo="Libros Editorial";
        else $titulo="Productos Packagind/Propios";

        $this->producto= new Producto;

        $entidades=Entidad::orderBy('entidad')->get();
        $clientes=$entidades->whereIn('entidadtipo_id',['1','2']);

        $productos=Producto::query()
            ->with('cliente')
            ->when($this->tipo!='', function ($query){
                $query->where('tipo',$this->tipo);
                })
            ->when($this->filtroisbn!='', function ($query){
                $query->where('isbn', 'like', '%'.$this->filtroisbn.'%');
                })
            ->when($this->filtroreferencia!='', function ($query){
                $query->where('referencia', 'like', '%'.$this->filtroreferencia.'%');
                })
            ->when($this->filtrocliente!='', function ($query){
                $query->where('cliente_id',$this->filtrocliente);
                })
            ->orderBy('referencia','asc')
            ->paginate(15);

            return view('livewire.producto.prods',compact('productos','clientes','titulo'));
    }

    public function updatingFiltroisbn(){$this->resetPage();}
    public function updatingFiltroreferencia(){$this->resetPage();}
    public function updatingFiltrocliente(){$this->resetPage();}

    // public function presentaAdjunto(Producto $producto){
    //     $existe=Storage::disk('fichasproducto')->exists($producto->adjunto);
    //     if ($existe)
    //         return Storage::disk('fichasproducto')->download($producto->adjunto);
    // }

    public function delete($productoId)
    {
        $producto = Producto::find($productoId);
        if ($producto) {
            $producto->delete();
            $this->dispatchBrowserEvent('notify', 'El producto: '.$producto->referencia.' ha sido eliminado!');
        }
    }
}
