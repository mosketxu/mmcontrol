<?php

namespace App\Http\Livewire\Oferta;

use Livewire\Component;

use App\Models\{ Entidad, EntidadContacto, Mes, Oferta};
use Livewire\WithPagination;
use App\Http\Livewire\DataTable\WithBulkActions;

class Ofertas extends Component
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

    public $tipo='';

    public function mount($tipo)
    {
        $this->tipo=$tipo;
    }

    public function render(){
        // $ofertas=Oferta::with('contacto','cliente')->orderBy('id')->get();
        $clientes=Entidad::whereIn('entidadtipo_id',['1','2'])->orderBy('entidad')->get();
        $meses=Mes::orderBy('id')->get();

        if($this->selectAll) $this->selectPageRows();
        $ofertas = $this->rows;
        return view('livewire.oferta.ofertas',compact('ofertas','clientes','meses'));
    }

    public function updatingSearch(){$this->resetPage();}
    public function updatingFiltroanyo(){$this->resetPage();}
    public function updatingFiltromes(){$this->resetPage();}
    public function updatingFiltrocliente(){$this->resetPage();}
    public function updatingFiltroreferencia(){$this->resetPage();}
    public function updatingFiltroestado(){$this->resetPage();}

    public function changeValor(Oferta $oferta,$campo,$valor)
    {
        $oferta->update([$campo=>$valor]);
        $this->dispatchBrowserEvent('notify', 'Actualizado con éxito.');
    }

    public function getRowsQueryProperty(){
        return Oferta::query()
            ->with('cliente','contacto')
            ->join('entidades','ofertas.cliente_id','=','entidades.id')
            ->select('ofertas.*', 'entidades.entidad', 'entidades.emailadm')
            ->where('ofertas.tipo',$this->tipo)
            ->search('ofertas.id',$this->search)
            ->when($this->filtroreferencia!='', function ($query){
                $query->where('ofertas.referencia','like','%'.$this->filtroreferencia.'%');
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

    public function deleteSelected(){
        $deleteCount = $this->selectedRowsQuery->count();
        $this->selectedRowsQuery->delete();
        $this->showDeleteModal = false;

        $this->dispatchBrowserEvent('notify', $deleteCount . ' ofertas eliminadas!');
    }



    public function delete($ofertaId)
    {
        $oferta = Oferta::find($ofertaId);
        if ($oferta) {
            $oferta->delete();
            $this->dispatchBrowserEvent('notify', 'oferta borrada. ');
        }
    }

}
