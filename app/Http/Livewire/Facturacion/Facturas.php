<?php

namespace App\Http\Livewire\Facturacion;

use App\Models\{Entidad,Factura, Mes};
use Livewire\Component;


use Livewire\WithPagination;
use App\Http\Livewire\DataTable\WithBulkActions;

class Facturas extends Component
{
    use WithPagination, WithBulkActions;

    public $facturaid;
    public $cliente_id;
    public $fecha ;
    public $fechavencimiento ;
    public $importe='0';
    public $estado='0';
    public $observaciones;

    public $search='';
    public $filtroanyo='';
    public $filtromes='';
    public $filtrocliente='';
    public $filtroestado='';
    public $filtroFi='';
    public $filtroFf='';

    public $message;



    protected function rules(){
        return [
            'estado'=>'nullable',
        ];
    }


    public function render(){
        // $facturas=Factura::orderBy('id')->get();
        $clientes=Entidad::orderBy('entidad')->whereIn('entidadtipo_id',['1','2'])->get();
        $meses=Mes::orderBy('id')->get();

        if($this->selectAll) $this->selectPageRows();
        $facturas = $this->rows;

        return view('livewire.facturacion.facturas',compact('facturas','clientes','meses'));
    }

    public function updatingSearch(){$this->resetPage();}
    public function updatingFiltroanyo(){$this->resetPage();}
    public function updatingFiltromes(){$this->resetPage();}
    public function updatingFiltrocliente(){$this->resetPage();}
    public function updatingFiltroestado(){$this->resetPage();}
    public function updatingFiltroFi(){$this->resetPage();}
    public function updatingFiltroFf(){$this->resetPage();}

    public function changeValor(Factura $factura,$campo,$valor){
        $factura->update([$campo=>$valor]);
        $this->dispatchBrowserEvent('notify', 'Actualizada con éxito.');
    }

    public function getRowsQueryProperty(){
        return Factura::query()
            ->join('entidades','facturas.cliente_id','=','entidades.id')
            ->select('facturas.*', 'entidades.entidad', 'entidades.nif','entidades.emailadm')
            ->search('facturas.id',$this->search)
            ->when($this->filtrocliente!='', function ($query){
                $query->where('facturas.cliente_id',$this->filtrocliente);
                })
            ->when($this->filtroestado!='', function ($query){
                $query->where('facturas.estado',$this->filtroestado);
            })
            ->when($this->filtroFi && !$this->filtroFf, function ($query) {
                $query->where('fecha','>=', $this->filtroFi);
            })
            ->when(!$this->filtroFi && $this->filtroFf, function ($query) {
                $query->where('fecha','<=', $this->filtroFf);
            })
            ->when($this->filtroFi && $this->filtroFf, function ($query) {
                $query->whereBetween('fecha', [$this->filtroFi, $this->filtroFf]);
            })
            ->searchYear('fecha',$this->filtroanyo)
            ->searchMes2('fecha',$this->filtromes)
            ->orderBy('facturas.fecha','desc')
            ->orderBy('facturas.id','desc');

            // ->paginate(5); solo contemplo la query, no el resultado. Luego pongo el resultado: get, paginate o lo que quiera
        }

            public function getRowsProperty(){
                return $this->rowsQuery->get();
            }

            public function exportSelected(){
                dd('en proceso');
            //toCsv es una macro a n AppServiceProvider
                return response()->streamDownload(function(){
                    echo $this->selectedRowsQuery->toCsv();
                },'facturas.csv');

                $this->dispatchBrowserEvent('notify', 'CSV facturas descargado!');
            }

            public function deleteSelected(){
                $deleteCount = $this->selectedRowsQuery->count();
                $this->selectedRowsQuery->delete();
                $this->showDeleteModal = false;

                $this->dispatchBrowserEvent('notify', $deleteCount . ' facturas eliminados!');
            }



            public function delete($facturaId)
            {
                $factura = Factura::find($facturaId);
                if ($factura) {
                    $factura->delete();
                    $this->dispatchBrowserEvent('notify', 'factura borrado, ');
                }
            }
}
