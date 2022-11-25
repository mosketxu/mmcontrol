<?php

namespace App\Http\Livewire\Pedido;

use Livewire\Component;

use App\Models\{ Pedido,Entidad, EntidadContacto, Mes};
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
    public $producto_id;
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

    public $showDeleteModal=false;
    public $showNewModal = false;
    public $showPDFModal=false;
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
            'otros'=>'nullable',
        ];
    }

    public function messages()
    {
        return [
            'pedido.required'=>'El número de pedido es necesario',
            'responsable.required'=>'El responsable del pedido es necesario',
            'cliente_id.required'=>'El cliente es necesario',
            'proveedor_id.nullable'=>'',
            'fechapedido.date'=>'La fecha del pedido debe ser válida',
            'fechapedido.required'=>'La fecha del pedido es necesaria',
            'fechaarchivos.date'=>'La fecha de los archivos debe ser válida',
            'fechaplotter.date'=>'La fecha del plotter debe ser válida',
            'fechaentrega.date'=>'La fecha de entrega debe ser válida',
            'fechaentrega.required'=>'La fecha de entrega es necesaria',
            'tiradaprevista.required'=>'La tirada prevista es necesaria',
            'tiradaprevista.numeric'=>'El valor de la tirada prevista debe ser numérico',
            'tiradareal.numeric'=>'El valor de la tirada real debe ser numérico',
            'preciocoste.numeric'=>'El valor del precio de compra debe ser numérico',
            'precioventa.numeric'=>'El valor del precio de venta  debe ser numérico',
            'preciototal.numeric'=>'El valor del precio total debe ser numérico',
        ];
    }

    public function mount($tipo)
    {
        $this->tipo=$tipo;
    }
    public function render()
    {
        $entidades=Entidad::orderBy('entidad')->get();
        $clientes=$entidades->whereIn('entidadtipo_id',['1','2']);
        $proveedores=$entidades->whereIn('entidadtipo_id',['2','3']);
        $meses=Mes::orderBy('id')->get();


        if($this->selectAll) $this->selectPageRows();
        $pedidos = $this->rows;
        return view('livewire.pedido.pedidos',compact('pedidos','clientes','proveedores','meses'));
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

    public function changeValor(Pedido $pedido,$campo,$valor)
    {
        $pedido->update([$campo=>$valor]);
        $this->dispatchBrowserEvent('notify', 'Actualizado con éxito.');
    }

    public function create(){
        $this->resetInputFields();
        $this->fechapedido=now()->format('Y-m-d');
        $this->openNewModal();
    }

    public function imprimir($pedido){
        $this->openPDFModal($pedido);
    }


    public function replicateRow(Pedido $pedido){
        dd('en proceso');
        // inicializo las vbles nuevas
        $this->fechapedido=now();
        $this->numpedido();
        // clono la cabecera del pedido
        $clone = $pedido->replicate()->fill([
            'fechapedido'=>$this->fechapedido,
            'pedido'=>$this->pedido,
        ]);
        $clone->save();
        $this->dispatchBrowserEvent('notify', 'pedidos copiado!');
    }


    public function openNewModal(){
        $this->showNewModal = true;
    }

    public function openPDFModal($pedido){
        dd('en proceso');
        $this->presupPDF=Pedido::find($pedido['id']);
        $this->showPDFModal = true;
    }

    public function closeNewModal(){
        $this->resetInputFields();
        $this->showNewModal = false;
    }

    private function resetInputFields(){
        dd('en proceso');
        $this->pedido='';
        $this->descripcion='';
        $this->entidad_id='';
        $this->solicitante_id='';
        $this->entidadcontacto_id='';
        $this->fechapedido='';
        $this->refgrafitex='';
        $this->refcliente='';
        $this->preciocoste='0';
        $this->precioventa='0';
        $this->preciototal='0';
        $this->tiradaprevista='0';
        $this->tiradareal='0';
        $this->ruta='';
        $this->fichero='';
        $this->estado='0';
        $this->observaciones='';
    }

    public function store(){
        dd('en proceso');
        if($this->representante_id=='') $this->representante_id= Auth()->user()->id;
        if($this->entidadcontacto_id=='') $this->entidadcontacto_id= null;

        $this->validate([
            'entidad_id' => 'required',
            'solicitante_id' => 'required|numeric',
            'entidadcontacto_id' => 'nullable|numeric',
            'descripcion' => 'required',
            'fechapedido' => 'required|date',
            'refgrafitex' => 'nullable',
            'refcliente' => 'nullable',
            'preciocoste' => 'nullable|numeric',
            'precioventa' => 'nullable|numeric',
            'incremento' => 'required|numeric',
            'estado' => 'required',
            'iva' => 'required',
        ]);

        $destino="editar";
        if(!$this->pedido){
            $this->numpedido();
            $destino="nuevo";
        }
        $pedido = Pedido::updateOrCreate(['id' => $this->pedido_id], [
            'pedido'=>$this->pedido,
            'descripcion'=>$this->descripcion,
            'entidad_id'=>$this->entidad_id,
            'entidadcontacto_id'=>$this->entidadcontacto_id,
            'solicitante_id'=>$this->solicitante_id,
            'fechapedido'=>$this->fechapedido,
            'refgrafitex'=>$this->refgrafitex,
            'refcliente'=>$this->refcliente,
            'precioventa'=>$this->precioventa,
            'preciocoste'=>$this->preciocoste,
            'unidades'=>$this->unidades,
            'incremento'=>$this->incremento,
            'iva'=>$this->iva,
            'ruta'=>$this->ruta,
            'fichero'=>$this->fichero,
            'estado'=>$this->estado,
            'observaciones'=>$this->observaciones,
        ]);


        $this->message='';
        $message="Prespuesto creado satisfactoriamente";

        session()->flash('message',$message);

        if($destino=="editar"){
            $this->closeNewModal();
            $this->resetInputFields();
        }else{
            return redirect()->route('pedido.edit',$pedido);
        }
    }

    public function edit($id) {
        dd('en proceso');
        $pedido = Pedido::findOrFail($id);
        $this->pedido=$pedido->pedido;
        $this->descripcion=$pedido->descripcion;
        $this->entidad_id=$pedido->entidad_id;
        $this->entidadcontacto_id=$pedido->entidadcontacto_id;
        $this->solicitante_id=$pedido->solicitante_id;
        $this->fechapedido=$pedido->fechapedido;
        $this->refgrafitex=$pedido->refgrafitex;
        $this->refcliente=$pedido->refcliente;
        $this->preciocoste=$pedido->preciocoste;
        $this->precioventa=$pedido->precioventa;
        $this->unidades=$pedido->unidades;
        $this->incremento=$pedido->incremento;
        $this->iva=$pedido->iva;
        $this->ruta=$pedido->ruta;
        $this->fichero=$pedido->fichero;
        $this->estado=$pedido->estado;
        $this->observaciones=$pedido->observaciones;
        $this->contactos=EntidadContacto::where('entidad_id',$this->entidad_id)->orderBy('contacto')->get();
        $this->openNewModal();
    }



    public function getRowsQueryProperty(){
        return Pedido::query()
            ->join('entidades','pedidos.cliente_id','=','entidades.id')
            ->join('productos','pedidos.producto_id','=','productos.id')
            ->select('pedidos.*', 'entidades.entidad', 'entidades.nif','entidades.emailadm','productos.isbn','productos.referencia')
            ->where('pedidos.tipo',$this->tipo)
            ->search('pedidos.id',$this->search)
            ->when($this->filtroreferencia!='', function ($query){
                $query->where('productos.referencia','like','%'.$this->filtroreferencia.'%');
            })
            ->when($this->filtroisbn!='', function ($query){
                $query->where('productos.isbn','like','%'.$this->filtroisbn.'%');
            })
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

            // ->paginate(5); solo contemplo la query, no el resultado. Luego pongo el resultado: get, paginate o lo que quiera
    }

    public function getRowsProperty(){
        return $this->rowsQuery->paginate(10);
    }

    public function exportSelected(){
        dd('en proceso');
    //toCsv es una macro a n AppServiceProvider
        return response()->streamDownload(function(){
            echo $this->selectedRowsQuery->toCsv();
        },'pedidos.csv');

        $this->dispatchBrowserEvent('notify', 'CSV pedidos descargado!');
    }

    public function deleteSelected(){
        $deleteCount = $this->selectedRowsQuery->count();
        $this->selectedRowsQuery->delete();
        $this->showDeleteModal = false;

        $this->dispatchBrowserEvent('notify', $deleteCount . ' pedidos eliminados!');
    }



    public function delete($pedidoId)
    {
        $pedido = Pedido::find($pedidoId);
        if ($pedido) {
            $pedido->delete();
            $this->dispatchBrowserEvent('notify', 'pedido borrado. ');
        }
    }

}
