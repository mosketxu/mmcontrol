<?php

namespace App\Http\Livewire\Pedido;

use Livewire\Component;

use App\Models\{ Pedido,Entidad, Mes};
use Illuminate\Support\Facades\Storage;
use Livewire\WithPagination;
use App\Http\Livewire\DataTable\WithBulkActions;

class Pedidos extends Component
{
    use WithPagination, WithBulkActions;

    public $pedido;
    public $tipo;
    public $responsable;
    public $cliente_id;
    public $proveedor_id;
    // public $producto_id;
    public $fechapedido;
    public $fechaarchivos;
    public $fechaplotter;
    public $fechaentrega;
    public $tiradaprevista;
    public $tiradareal;
    public $preciocoste;
    public $precioventa;
    public $preciototal;
    public $parcial;
    public $estado;
    public $facturado;
    public $distribucion;
    public $uds_caja;
    public $incidencias;
    public $retardos;
    public $transporte;
    public $otros;

    public $search='';
    public $filtroanyo='';
    public $filtromes='';
    public $filtrocliente='';
    public $filtroproveedor='';
    public $filtroresponsable='';
    public $filtroreferencia='';
    public $filtroisbn='';
    public $filtroestado='';
    public $filtrofacturado='';

    public $message;
    public $destino='0';

    public $presupPDF='';

    protected function rules(){
        return [
            'pedido'=>'required',
            'responsable'=>'required',
            'cliente_id'=>'required',
            'proveedor_id'=>'nullable',
            'fechapedido'=>'required|date',
            'fechaarchivos'=>'nullable|date',
            'fechaplotter'=>'nullable|date',
            'fechaentrega'=>'required|date',
            'tiradaprevista'=>'required|numeric',
            'tiradareal'=>'nullable|numeric',
            'preciocoste'=>'nullable|numeric',
            'precioventa'=>'nullable|numeric',
            'preciototal'=>'nullable|numeric',
            'estado'=>'nullable',
            'facturado'=>'nullable',
            'distribucion'=>'nullable',
            'uds_caja'=>'nullable',
            'incidencias'=>'nullable',
            'retardos'=>'nullable',
            'transporte'=>'nullable',
            'otros'=>'nullable',
        ];
    }

    public function messages(){
        return [
            'pedido.required'=>'El n??mero de pedido es necesario',
            'responsable.required'=>'El responsable del pedido es necesario',
            'cliente_id.required'=>'El cliente es necesario',
            'fechapedido.date'=>'La fecha del pedido debe ser v??lida',
            'fechapedido.required'=>'La fecha del pedido es necesaria',
            'fechaarchivos.date'=>'La fecha de los archivos debe ser v??lida',
            'fechaplotter.date'=>'La fecha del plotter debe ser v??lida',
            'fechaentrega.date'=>'La fecha de entrega debe ser v??lida',
            'fechaentrega.required'=>'La fecha de entrega es necesaria',
            'tiradaprevista.required'=>'La tirada prevista es necesaria',
            'tiradaprevista.numeric'=>'El valor de la tirada prevista debe ser num??rico',
            'tiradareal.numeric'=>'El valor de la tirada real debe ser num??rico',
            'preciocoste.numeric'=>'El valor del precio de compra debe ser num??rico',
            'precioventa.numeric'=>'El valor del precio de venta  debe ser num??rico',
            'preciototal.numeric'=>'El valor del precio total debe ser num??rico',
        ];
    }

    public function mount($tipo){
        $this->tipo=$tipo;
    }

    public function render(){
        $entidades=Entidad::orderBy('entidad')->get();
        $clientes=$entidades->whereIn('entidadtipo_id',['1','2']);
        $proveedores=$entidades->whereIn('entidadtipo_id',['2','3']);
        $meses=Mes::orderBy('id')->get();

        if($this->selectAll) $this->selectPageRows();
        $pedidos = $this->rows;
        // dd($pedidos);
        $vista=$this->tipo=='1' ? 'livewire.pedido.pedidoseditorial': 'livewire.pedido.pedidosotros';
        return view($vista,compact('pedidos','clientes','proveedores','meses'));
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
    public function updatingFiltrofacturado(){$this->resetPage();}

    public function changeValor(Pedido $pedido,$campo,$valor){
        $pedido->update([$campo=>$valor]);
        $this->dispatchBrowserEvent('notify', 'Actualizado con ??xito.');
    }

    public function getRowsQueryProperty(){

        // return Pedido::query()
        return Pedido::query()
            ->join('entidades','pedidos.cliente_id','=','entidades.id')
            ->join('pedido_productos','pedido_productos.pedido_id','=','pedidos.id')
            ->join('productos','pedido_productos.producto_id','=','productos.id')
            ->select('pedidos.*', 'entidades.entidad', 'entidades.nif','entidades.emailadm','productos.isbn','productos.referencia')
            ->where('pedidos.tipo',$this->tipo)
            ->search('pedidos.id',$this->search)
            ->when($this->filtroreferencia!='', function ($query){
                $query->where('productos.referencia','like','%'.$this->filtroreferencia.'%');
            })
            // ->when($this->filtroisbn!='', function ($query){
            //     $query->where('productos.isbn','like','%'.$this->filtroisbn.'%');
            // })
            ->when($this->filtroresponsable!='', function ($query){
                $query->where('pedidos.responsable','like','%'.$this->filtroresponsable.'%');
            })
            ->when($this->filtrocliente!='', function ($query){
                $query->where('pedidos.cliente_id',$this->filtrocliente);
                })
            ->when($this->filtroproveedor!='', function ($query){
                $query->where('pedidos.proveedor_id',$this->filtroproveedor);
                })
            ->when($this->filtroestado!='', function ($query){
                $query->where('pedidos.estado',$this->filtroestado);
            })
            ->when($this->filtrofacturado!='', function ($query){
                $query->where('pedidos.facturado',$this->filtrofacturado);
            })
            ->searchYear('fechapedido',$this->filtroanyo)
            ->searchMes('fechapedido',$this->filtromes)
            ->orderBy('pedidos.fechapedido','desc')
            ->orderBy('pedidos.id','desc');

            // dd('llego');
            // ->paginate(5); solo contemplo la query, no el resultado. Luego pongo el resultado: get, paginate o lo que quiera
    }

    public function getRowsProperty(){
        return $this->rowsQuery->paginate(10);
    }

    public function delete($pedidoId){

        $existe=Storage::disk('archivospedido')->exists($pedidoId);
        if ($existe) Storage::disk('archivospedido')->deleteDirectory($pedidoId);

        $pedido = Pedido::find($pedidoId);
        if ($pedido) {
            $pedido->delete();
            $this->dispatchBrowserEvent('notify', 'pedido borrado. ');
        }
    }
}
