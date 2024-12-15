<?php

namespace App\Http\Livewire\Clientes;

use Livewire\Component;
use Livewire\WithPagination;
use App\Http\Livewire\DataTable\WithBulkActions;
use App\Models\{Entidad,Factura, Mes, UserEmpresa};
use Illuminate\Support\Facades\Auth;

class ClienteFacturas extends Component
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
    public $filtrotipo='';

    public $message;

    protected $queryString=['search','filtroanyo','filtromes','filtrocliente','filtroestado','filtroFi','filtroFf','filtrotipo'];


    protected function rules(){
        return [
            'estado'=>'nullable',
        ];
    }

    public function render(){
        $empresascliente=UserEmpresa::where('user_id',Auth::user()->id)->pluck('entidad_id');


        $clientes=Entidad::orderBy('entidad')
            ->whereIn('entidadtipo_id',['1','2'])
            ->whereIn('id',$empresascliente)
            ->get();
        $meses=Mes::orderBy('id')->get();

        if($this->selectAll) $this->selectPageRows();
        $facturas = $this->rows;

        return view('livewire.clientes.cliente-facturas',compact('facturas','clientes','meses'));
    }

    public function getRowsQueryProperty(){
        $empresascliente=UserEmpresa::where('user_id',Auth::user()->id)->pluck('entidad_id');

        return Factura::query()
            ->join('entidades','facturas.cliente_id','=','entidades.id')
            ->select('facturas.*', 'entidades.entidad', 'entidades.nif','entidades.emailadm')
            ->whereIn('facturas.cliente_id',$empresascliente)
            ->search('facturas.id',$this->search)
            ->when($this->filtrocliente!='', function ($query){
                $query->where('facturas.cliente_id',$this->filtrocliente);
                })
            ->when($this->filtroestado!='', function ($query){
                $query->where('facturas.estado',$this->filtroestado);
            })
            ->when($this->filtrotipo!='', function ($query){
                $query->where('facturas.tipo',$this->filtrotipo);
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
        }

    public function getRowsProperty(){

            return $this->rowsQuery->get();
    }
}
