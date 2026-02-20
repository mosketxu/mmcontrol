<?php

namespace App\Http\Livewire\Compra;

use App\Models\{Entidad,Mes, Compra};
use Illuminate\Support\Facades\Storage;
use Livewire\WithPagination;
use App\Http\Livewire\DataTable\WithBulkActions;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;


class Compras extends Component{

    use WithPagination, WithBulkActions;

    public $compra;

    public $search='';
    public $filtroanyo='';
    public $filtromes='';
    public $filtroproveedor='';
    public $filtroisbn='';
    public $filtroreferencia='';

    public $message;
    public $tipo;
    public $titulo;

     public function mount($compra, $tipo){
        $this->tipo=$tipo;

        $this->titulo='no llega';
    }

    // protected function rules(){
    //     return [
    //     ];
    // }


    public function render(){
        $compras=Compra::with('producto','proveedor')
        ->where('compras.tipo',$this->tipo)
        ->search('compras.numero',$this->search)
        ->search('compras.codigo',$this->search)
        ->when($this->filtroreferencia!='', function ($query){
            $query->where('productos.referencia','like','%'.$this->filtroreferencia.'%');
        })
        ->when($this->filtroisbn!='', function ($query){
            $query->where('productos.isbn','like','%'.$this->filtroisbn.'%');
        })
        // ->orderBy('entidad')
        ->paginate(30);
        $proveedores=Entidad::orderBy('entidad')->get();
        $meses=Mes::orderBy('id')->get();

        return view('livewire.compra.compras',compact('compras','proveedores','meses'));
    }

    public function updatingSearch(){$this->resetPage();}
    public function updatingFiltroanyo(){$this->resetPage();}
    public function updatingFiltromes(){$this->resetPage();}
    public function updatingFiltroproveedor(){$this->resetPage();}
    public function updatingFiltroreferencia(){$this->resetPage();}
    public function updatingFiltroisbn(){$this->resetPage();}
}
