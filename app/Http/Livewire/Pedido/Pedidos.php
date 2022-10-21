<?php

namespace App\Http\Livewire\Pedido;

use Livewire\Component;

use App\Models\{ Pedido,Entidad, EntidadContacto, User};
use Livewire\WithPagination;
use App\Http\Livewire\DataTable\WithBulkActions;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class Pedidos extends Component
{
    use WithPagination, WithBulkActions;

    public $pedido;
    public $responsable_id;
    public $cliente_id;
    public $proveedor_id;
    public $producto_id;
    public $fechapedido;
    public $fechaarchivos;
    public $fechaplotter;
    public $fechaentrega;
    public $tiradaprevista;
    public $tiradareal;
    public $precio;
    public $preciototal;
    public $parcial;
    public $estado;
    public $facturado;
    public $cd_dvd;
    public $distribucion;
    public $cajas;
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

    public $showDeleteModal=false;
    public $showNewModal = false;
    public $showPDFModal=false;
    public $presupPDF='';

    protected function rules(){
        return [
            'pedido'=>'required',
            'responsable_id'=>'required',
            'cliente_id'=>'required',
            'proveedor_id'=>'nullable',
            'fechapedido'=>'required|date',
            'fechaarchivos'=>'nullable|date',
            'fechaplotter'=>'nullable|date',
            'fechaentrega'=>'required|date',
            'tiradaprevista'=>'required|numeric',
            'tiradareal'=>'nullable|numeric',
            'precio'=>'nullable|numeric',
            'preciototal'=>'nullable|numeric',
            'estado'=>'nullable',
            'facturado'=>'nullable',
            'cd_dvd'=>'nullable',
            'distribucion'=>'nullable',
            'cajas'=>'nullable',
            'incidencias'=>'nullable',
            'retardos'=>'nullable',
            'otros'=>'nullable',
        ];
    }

    public function messages()
    {
        return [
            'pedido.required'=>'El número de pedido es necesario',
            'responsable_id.required'=>'El responsable del pedido es necesario',
            'cliente_id.required'=>'El cliente es necesario',
            'proveedor_id.nullable'=>'',
            'fechapedido.date'=>'La fecha del pedido debe ser válida',
            'fechapedido.requiered'=>'La fecha del pedido es necesaria',
            'fechaarchivos.date'=>'La fecha de los archivos debe ser válida',
            'fechaplotter.date'=>'La fecha del plotter debe ser válida',
            'fechaentrega.date'=>'La fecha de entrega debe ser válida',
            'fechaentrega.requiered'=>'La fecha de entrega es necesaria',
            'tiradaprevista.required'=>'La tirada prevista es necesaria',
            'tiradaprevista.numeric'=>'El valor de la tirada prevista debe ser numérico',
            'tiradareal.numeric'=>'El valor de la tirada real debe ser numérico',
            'precio.numeric'=>'El valor del precio real debe ser numérico',
            'preciototal.numeric'=>'El valor del precio total real debe ser numérico',
        ];
    }


    public function render()
    {
        $entidades=Entidad::orderBy('entidad')->get();
        $clientes=$entidades->whereIn('entidadtipo_id',['2','3']);
        $proveedores=$entidades->whereIn('entidadtipo_id',['1','2']);
        $responsables=User::role('Milimetrica')->orderBy('name')->get();

        if($this->selectAll) $this->selectPageRows();
        $pedidos = $this->rows;

        return view('livewire.pedido.pedidos',compact('pedidos','clientes','proveedores','responsables'));
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
        $this->precioventa='0';
        $this->preciocoste='0';
        $this->unidades='0';
        $this->incremento='0';
        $this->iva='0.21';
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
        $this->pedido_id=$prpedidoid;
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

    public function numpedido()
    {
        $anyo= Carbon::parse($this->fechapedido)->year;
        $anyo2= Carbon::parse($this->fechapedido)->format('y');
        $p=Pedido::withTrashed()->whereYear('fechapedido', $anyo)->max('pedido') ;
        $this->prespedido ? $p + 1 : ($anyo2 * 100000 +1) ;
    }


    public function getRowsQueryProperty(){
        return Pedido::query()
            ->join('entidades','pedidos.cliente_id','=','entidades.id')
            ->join('productos','pedidos.producto_id','=','productos.id')
            ->select('pedidos.*', 'entidades.entidad', 'entidades.nif','entidades.emailadm','productos.isbn','productos.referencia')
            // ->when($this->entidad->id!='', function ($query){
            //     $query->where('entidad_id',$this->entidad->id);
            //     })
            // ->when($this->filtroclipro!='', function ($query){
            //     $query->where('entidad_id',$this->filtroclipro);
            //     })
            // ->when($this->filtrosolicitante!='', function ($query){
            //     $query->where('solicitante_id',$this->filtrosolicitante);
            //     })
            // ->when($this->filtroestado!='', function ($query){
            //     $query->where('pedidos.estado',$this->filtroestado);
            // })
            // ->when(Auth::user()->hasRole('Comercial'),function ($query){
            //     $query->when(!Auth::user()->hasRole('Admin'),function ($q){
            //     // $q->where('solicitante_id',Auth::user()->id);});
            //     $q->whereRelation('ent','comercial_id',Auth::user()->id)->get();
            //     ;});
            // })
            // ->when($this->search!='', function ($query){
            //     $query->where('entidades.entidad','like','%'.$this->search.'%')->orWhere('pedidos.pedido','like','%'.$this->search.'%');
            // })

            ->searchYear('fechapedido',$this->filtroanyo)
            ->searchMes('fechapedido',$this->filtromes)
            ->search('pedidos.referencia',$this->filtroreferencia)
            ->search('pedidos.isbn',$this->filtroisbn)
            ->search('pedidos.pedido',$this->search)
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
            $this->dispatchBrowserEvent('notify', 'pedido borrado, ');
        }
    }

}
