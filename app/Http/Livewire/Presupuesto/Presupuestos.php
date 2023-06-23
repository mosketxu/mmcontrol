<?php

namespace App\Http\Livewire\Presupuesto;

use App\Models\{Entidad,Mes, Pedido, Presupuesto};
use Illuminate\Support\Facades\Storage;
use Livewire\WithPagination;
use App\Http\Livewire\DataTable\WithBulkActions;

use Livewire\Component;

class Presupuestos extends Component
{
    use WithPagination, WithBulkActions;

    public $presupuesto;
    public $espedido;
    public $estado;

    public $search='';
    public $filtroanyo='';
    public $filtromes='';
    public $filtrocliente='';
    public $filtroproveedor='';
    public $filtroresponsable='';
    public $filtroisbn='';
    public $filtroreferencia='';
    public $filtroestado='';

    public $message;
    public $tipo;
    public $titulo;

    public function mount($tipo,$titulo){
        $this->tipo=$tipo;
        $this->titulo=$titulo;
    }

    protected function rules(){
        return [
            'presupuesto.espedido'=>'nullable',
            'presupuesto.estado'=>'nullable',
        ];
    }
    public function render(){
        $entidades=Entidad::orderBy('entidad')->get();
        $clientes=$entidades->whereIn('entidadtipo_id',['1','2']);
        $proveedores=$entidades->whereIn('entidadtipo_id',['2','3']);
        $meses=Mes::orderBy('id')->get();

        if($this->selectAll) $this->selectPageRows();
        $presupuestos = $this->rows;
        // dd($presupuestos->where('id','2300659'));
        $view=$this->tipo=='1' ? 'livewire.presupuesto.presupuestoseditorial' : 'livewire.presupuesto.presupuestosotros' ;
        return view($view,compact('presupuestos','clientes','proveedores','meses'));
    }

    public function updatingSearch(){$this->resetPage();}
    public function updatingFiltroanyo(){$this->resetPage();}
    public function updatingFiltromes(){$this->resetPage();}
    public function updatingFiltrocliente(){$this->resetPage();}
    public function updatingFiltroproveedor(){$this->resetPage();}
    public function updatingFiltroresponsable(){$this->resetPage();}
    public function updatingFiltroreferencia(){$this->resetPage();}
    public function updatingFiltroisbn(){$this->resetPage();}
    public function updatingFiltroestado(){$this->resetPage();}


    public function changeValor(Presupuesto $presupuesto,$campo,$valor){
        $presupuesto->update([$campo=>$valor]);
        $this->dispatchBrowserEvent('notify', 'Actualizado con éxito.');
    }

    public function changeEspedido(Presupuesto $presupuesto,$espedido){
        $presupuesto->espedido= $presupuesto->espedido=='1' ? '0' : '1';
        $presupuesto->update(['espedido'=>$presupuesto->espedido]);
        $this->dispatchBrowserEvent('notify', 'Actualizado con éxito.');
    }

    public function getRowsQueryProperty(){
        if($this->tipo=='1')
        return Presupuesto::query()
            ->with('cliente','proveedor')
            ->join('entidades','presupuestos.cliente_id','=','entidades.id')
            ->join('presupuesto_productos','presupuesto_productos.presupuesto_id','=','presupuestos.id')
            ->join('productos','presupuesto_productos.producto_id','=','productos.id')
            ->select('presupuestos.*', 'entidades.entidad', 'entidades.nif','entidades.emailadm','productos.isbn','productos.referencia')
            ->where('presupuestos.tipo',$this->tipo)
            ->search('presupuestos.id',$this->search)
            ->when($this->filtroreferencia!='', function ($query){
                $query->where('productos.referencia','like','%'.$this->filtroreferencia.'%');
            })
            ->when($this->filtroisbn!='', function ($query){
                $query->where('productos.isbn','like','%'.$this->filtroisbn.'%');
            })
            ->when($this->filtroresponsable!='', function ($query){
                $query->where('presupuestos.responsable','like','%'.$this->filtroresponsable.'%');
            })
            ->when($this->filtrocliente!='', function ($query){
                $query->where('presupuestos.cliente_id',$this->filtrocliente);
                })
            ->when($this->filtroproveedor!='', function ($query){
                $query->where('presupuestos.proveedor_id',$this->filtroproveedor);
                })
            ->when($this->filtroestado!='', function ($query){
                $query->where('presupuestos.estado',$this->filtroestado);
            })
            ->searchYear('fechapresupuesto',$this->filtroanyo)
            ->searchMes('fechapresupuesto',$this->filtromes)
            ->orderBy('presupuestos.id','desc')
            ->groupBy('presupuestos.id');
        else
        return Presupuesto::query()
            ->join('entidades','presupuestos.cliente_id','=','entidades.id')
            // ->join('presupuesto_productos','presupuesto_productos.presupuesto_id','=','presupuestos.id')
            // ->join('productos','presupuesto_productos.producto_id','=','productos.id')
            ->select('presupuestos.*', 'entidades.entidad', 'entidades.nif','entidades.emailadm')
            ->where('presupuestos.tipo',$this->tipo)
            ->search('presupuestos.id',$this->search)
            ->when($this->filtroreferencia!='', function ($query){
                $query->where('productos.referencia','like','%'.$this->filtroreferencia.'%');
            })
            ->when($this->filtroisbn!='', function ($query){
                $query->where('productos.isbn','like','%'.$this->filtroisbn.'%');
            })
            ->when($this->filtroresponsable!='', function ($query){
                $query->where('presupuestos.responsable','like','%'.$this->filtroresponsable.'%');
            })
            ->when($this->filtrocliente!='', function ($query){
                $query->where('presupuestos.cliente_id',$this->filtrocliente);
                })
            ->when($this->filtroestado!='', function ($query){
                $query->where('presupuestos.estado',$this->filtroestado);
            })
            ->searchYear('fechapresupuesto',$this->filtroanyo)
            ->searchMes('fechapresupuesto',$this->filtromes)
            ->orderBy('presupuestos.id','desc');
    }

    public function getRowsProperty(){
        return $this->rowsQuery->get();
    }

    public function delete($presupuestoId){
        $existe=Storage::disk('archivospresupuesto')->exists($presupuestoId);
        if ($existe) Storage::disk('archivospresupuesto')->deleteDirectory($presupuestoId);

        $pedidocount=Pedido::where('presupuesto_id',$presupuestoId)->count();
        if($pedidocount>0)
            $this->dispatchBrowserEvent('notifyred', 'Este presupuesto tiene un pedido asociado. No se puede eliminar. ');
        else{
            $presupuesto = Presupuesto::find($presupuestoId);
            if ($presupuesto) {
                $presupuesto->delete();
                $this->dispatchBrowserEvent('notify', 'presupuesto borrado. ');
            }
        }
    }

}
