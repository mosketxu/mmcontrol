<?php

namespace App\Http\Livewire\Clientes;

use Livewire\Component;

use App\Models\{ Entidad, Mes, Oferta, UserEmpresa};
use Livewire\WithPagination;
use App\Http\Livewire\DataTable\WithBulkActions;
use Illuminate\Support\Facades\Auth;

class ClienteOfertas extends Component
{

    use WithPagination, WithBulkActions;

    public $search='';
    public $filtroanyo='';
    public $filtromes='';
    public $filtrocliente='';
    public $filtrocontacto='';
    public $filtroreferencia='';
    public $filtroisbn='';
    public $filtroestado='';
    public $escliente='';
    public $entidadescliente;
    // public $cliente;


    public $tipo='';

    public function mount($tipo){
        $this->tipo=$tipo;
        // $this->cliente=Auth::user();
        $this->escliente=Auth::user()->hasRole('Cliente')? 'disabled' :'';
        $this->entidadescliente=UserEmpresa::where('user_id',Auth::user()->id)->pluck('entidad_id');

    }

    public function render(){
        $clientes=Entidad::whereIn('entidadtipo_id',['1','2'])
        ->orderBy('entidad')
        ->get();
        $meses=Mes::orderBy('id')->get();

        if($this->selectAll) $this->selectPageRows();
        $ofertas = $this->rows;
        return view('livewire.clientes.oferta.cliente-ofertas',compact('ofertas','clientes','meses'));
    }

    public function updatingSearch(){$this->resetPage();}
    public function updatingFiltroanyo(){$this->resetPage();}
    public function updatingFiltromes(){$this->resetPage();}
    public function updatingFiltrocliente(){$this->resetPage();}
    public function updatingFiltroreferencia(){$this->resetPage();}
    public function updatingFiltroestado(){$this->resetPage();}

    public function getRowsQueryProperty(){
        if($this->tipo=='1')
            return Oferta::query()
                ->with('cliente','contacto')
                ->join('entidades','ofertas.cliente_id','=','entidades.id')
                ->join('productos','ofertas.producto_id','=','productos.id')
                ->select('ofertas.*', 'entidades.entidad', 'entidades.emailadm','productos.isbn','productos.referencia')
                ->whereIn('ofertas.cliente_id',$this->entidadescliente)
                ->where('ofertas.tipo',$this->tipo)
                ->search('ofertas.id',$this->search)
                ->when($this->filtroreferencia!='', function ($query){
                    $query->where('productos.referencia','like','%'.$this->filtroreferencia.'%');
                })
                ->when($this->filtroisbn!='', function ($query){
                    $query->where('productos.isbn','like','%'.$this->filtroisbn.'%');
                })
                ->when($this->filtrocliente!='', function ($query){
                    $query->where('ofertas.cliente_id',$this->filtrocliente);
                    })
                ->when($this->filtroestado!='', function ($query){
                    $query->where('ofertas.estado',$this->filtroestado);
                })
                ->searchYear('fecha',$this->filtroanyo)
                ->searchMes('fecha',$this->filtromes)
                ->orderBy('ofertas.id','desc')
                ->orderBy('ofertas.fecha','desc');
        else
            return Oferta::query()
            ->whereIn('ofertas.cliente_id',$this->entidadescliente)
            ->with('cliente','contacto')
            ->join('entidades','ofertas.cliente_id','=','entidades.id')
            ->select('ofertas.*', 'entidades.entidad', 'entidades.emailadm')
            ->where('ofertas.tipo',$this->tipo)
            ->search('ofertas.id',$this->search)
            ->when($this->filtroreferencia!='', function ($query){
                $query->where('ofertas.descripcion','like','%'.$this->filtroreferencia.'%');
            })
            ->when($this->filtrocliente!='', function ($query){
                $query->where('ofertas.cliente_id',$this->filtrocliente);
                })
            ->when($this->filtroestado!='', function ($query){
                $query->where('ofertas.estado',$this->filtroestado);
            })
            ->searchYear('fecha',$this->filtroanyo)
            ->searchMes('fecha',$this->filtromes)
            ->orderBy('ofertas.id','desc')
            ->orderBy('ofertas.fecha','desc');

            // ->paginate(5); solo contemplo la query, no el resultado. Luego pongo el resultado: get, paginate o lo que quiera
    }

    public function getRowsProperty(){
        return $this->rowsQuery->get();
    }
}
