<?php

namespace App\Http\Controllers;

use App\Models\Entidad;
use App\Models\Mes;
use App\Models\Pedido;
use App\Models\PedidoArchivo;
use App\Models\PedidoDistribucion;
use App\Models\PedidoIncidencia;
use App\Models\PedidoparcialDetalle;
use App\Models\PedidoParcial;
use App\Models\PedidoPresupuesto;
use App\Models\PedidoProducto;
use App\Models\PedidoRetraso;
use App\Models\Producto;
use App\Models\Responsable;
use Carbon\Carbon;
use Dompdf\Dompdf;
use Illuminate\Http\Request;
use \PDF;

use function PHPUnit\Framework\isNull;

class PedidoController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:pedido.index')->only('index');;
        $this->middleware('can:pedido.edit')->only('nuevo','editar','update','parcial');
    }

    // public function contadores()
    // {
    //     $pedidos=Pedido::get();
    //     foreach ($pedidos as $pedido) {
    //         //archivos
    //         $archivos=PedidoArchivo::where('pedido_id',$pedido->id)->count();
    //         if($archivos>0) $pedido->update(['hayArchivos'=>$archivos]);
    //         //incidencias
    //         $Incidencias=PedidoIncidencia::where('pedido_id',$pedido->id)->count();
    //         if($Incidencias>0) $pedido->update(['hayIncidencias'=>$Incidencias]);
    //         //retrasos
    //         $Retrasos=PedidoRetraso::where('pedido_id',$pedido->id)->count();
    //         if($Retrasos>0) $pedido->update(['hayRetrasos'=>$Retrasos]);
    //         //distribuciones
    //         $Distribuciones=PedidoDistribucion::where('pedido_id',$pedido->id)->count();
    //         if($Distribuciones>0) $pedido->update(['hayDistribuciones'=>$Distribuciones]);
    //         //parciales
    //         $Parciales=PedidoParcial::where('pedido_id',$pedido->id)->count();
    //         if($Parciales>0) $pedido->update(['hayParciales'=>$Parciales]);
    //     }
    //     dd('fin');
    // }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function index(){
    //     $tipo='';
    //     return view('pedidos.index',compact('tipo'));
    // }

    public function tipo($tipo,$ruta,Request $request ){

        $search=$request->search;
        $filtroreferencia=$request->filtroreferencia;
        $filtroisbn=$request->filtroisbn;
        $filtroresponsable=$request->filtroresponsable == '0' ? '' : $request->filtroresponsable;

        $filtrocliente=$request->filtrocliente;
        $filtroproveedor=$request->filtroproveedor;
        $filtroestado=$request->filtroestado;
        $filtrofacturado=$request->filtrofacturado;
        $filtroarchivos=$request->filtroarchivos;
        $filtroplotter=$request->filtroplotter;
        $filtroentrega=$request->filtroentrega;
        $filtroanyo=$request->filtroanyo;
        $filtromes=$request->filtromes;


        $entidades=Entidad::orderBy('entidad')->get();
        $clientes=$entidades->whereIn('entidadtipo_id',['1','2']);
        $proveedores=$entidades->whereIn('entidadtipo_id',['2','3']);
        $meses=Mes::orderBy('id')->get();
        $responsables=Responsable::all();

        // ''creo que la consulta es igual revisar cuando funcione
        $pedidos= Pedido::query()
            ->with('cliente','proveedor')
            ->join('entidades','pedidos.cliente_id','=','entidades.id')
            ->leftjoin('pedido_productos','pedido_productos.pedido_id','=','pedidos.id')
            ->leftjoin('productos','pedido_productos.producto_id','=','productos.id')
            ->select('entidades.entidad as cli', 'entidades.nif','entidades.emailadm','productos.isbn as isbn','productos.referencia as ref','pedidos.*',)
            ->where('pedidos.tipo',$tipo)
            ->search('pedidos.id',$search)
            ->when($filtroreferencia!='', function ($query) use($filtroreferencia) {$query->where('productos.referencia','like','%'.$filtroreferencia.'%');})
            ->when($filtroisbn!='', function ($query) use($filtroisbn) {$query->where('productos.isbn','like','%'.$filtroisbn.'%');})
            ->when($filtroresponsable!='', function ($query) use($filtroresponsable){$query->where('pedidos.responsable','like','%'.$filtroresponsable.'%');})
            ->when($filtrocliente!='', function ($query) use($filtrocliente) {$query->where('pedidos.cliente_id',$filtrocliente);})
            ->when($filtroproveedor!='', function ($query) use($filtroproveedor) {$query->where('pedidos.proveedor_id',$filtroproveedor);})
            ->when($filtroestado!='', function ($query) use($filtroestado) {$query->where('pedidos.estado',$filtroestado);})
            ->when($filtrofacturado!='', function ($query) use($filtrofacturado) {$query->where('pedidos.facturado',$filtrofacturado);})
            ->when($filtroarchivos!='', function ($query) use($filtroarchivos) {$query->where('pedidos.ctrarchivos',$filtroarchivos);})
            ->when($filtroplotter!='', function ($query) use($filtroplotter) {$query->where('pedidos.ctrplotter',$filtroplotter);})
            ->when($filtroentrega!='', function ($query) use($filtroentrega) {$query->where('pedidos.ctrentrega',$filtroentrega);})
            ->searchYear('fechapedido',$filtroanyo)
            ->searchMes('fechapedido',$filtromes)
            ->orderBy('pedidos.estado','asc')
            ->orderBy('entidades.entidad','asc')
            ->orderBy('pedidos.fechaentrega','asc')
            ->orderBy('pedidos.id','desc')
            ->get();

        // if($tipo=="1"){
        //     $pedidos= Pedido::query()
        //     ->with('cliente','proveedor')
        //     ->join('entidades','pedidos.cliente_id','=','entidades.id')
        //     ->leftjoin('pedido_productos','pedido_productos.pedido_id','=','pedidos.id')
        //     ->leftjoin('productos','pedido_productos.producto_id','=','productos.id')
        //     ->select('entidades.entidad as cli', 'entidades.nif','entidades.emailadm','productos.isbn as isbn','productos.referencia as ref','pedidos.*',)
        //     ->where('pedidos.tipo',$tipo)
        //     ->search('pedidos.id',$search)
        //     ->when($filtroreferencia!='', function ($query) use($filtroreferencia) {$query->where('productos.referencia','like','%'.$filtroreferencia.'%');})
        //     ->when($filtroisbn!='', function ($query) use($filtroisbn) {$query->where('productos.isbn','like','%'.$filtroisbn.'%');})
        //     ->when($filtroresponsable!='', function ($query) use($filtroresponsable){$query->where('pedidos.responsable','like','%'.$filtroresponsable.'%');})
        //     ->when($filtrocliente!='', function ($query) use($filtrocliente) {$query->where('pedidos.cliente_id',$filtrocliente);})
        //     ->when($filtroproveedor!='', function ($query) use($filtroproveedor) {$query->where('pedidos.proveedor_id',$filtroproveedor);})
        //     ->when($filtroestado!='', function ($query) use($filtroestado) {$query->where('pedidos.estado',$filtroestado);})
        //     ->when($filtrofacturado!='', function ($query) use($filtrofacturado) {$query->where('pedidos.facturado',$filtrofacturado);})
        //     ->when($filtroarchivos!='', function ($query) use($filtroarchivos) {$query->where('pedidos.ctrarchivos',$filtroarchivos);})
        //     ->when($filtroplotter!='', function ($query) use($filtroplotter) {$query->where('pedidos.ctrplotter',$filtroplotter);})
        //     ->when($filtroentrega!='', function ($query) use($filtroentrega) {$query->where('pedidos.ctrentrega',$filtroentrega);})
        //     ->searchYear('fechapedido',$filtroanyo)
        //     ->searchMes('fechapedido',$filtromes)
        //     ->orderBy('pedidos.estado','asc')
        //     ->orderBy('entidades.entidad','asc')
        //     ->orderBy('pedidos.fechaentrega','asc')
        //     ->orderBy('pedidos.id','desc')
        //     ->get();
        // }else{
        //     $pedidos= Pedido::query()
        //     ->with('cliente','proveedor')
        //     ->join('entidades','pedidos.cliente_id','=','entidades.id')
        //     ->leftjoin('pedido_productos','pedido_productos.pedido_id','=','pedidos.id')
        //     ->leftjoin('productos','pedido_productos.producto_id','=','productos.id')
        //     ->select('entidades.entidad as cli', 'entidades.nif','entidades.emailadm','pedidos.*',)
        //     ->where('pedidos.tipo',$tipo)
        //     ->search('pedidos.id',$search)
        //     ->when($filtroreferencia!='', function ($query) use($filtroreferencia) {$query->where('productos.referencia','like','%'.$filtroreferencia.'%');})
        //     ->when($filtroisbn!='', function ($query) use($filtroisbn) {$query->where('productos.isbn','like','%'.$filtroisbn.'%');})
        //     ->when($filtroresponsable!='', function ($query) use($filtroresponsable) {$query->where('pedidos.responsable','like','%'.$filtroresponsable.'%');})
        //     ->when($filtrocliente!='', function ($query) use($filtrocliente) {$query->where('pedidos.cliente_id',$filtrocliente);})
        //     ->when($filtroproveedor!='', function ($query) use($filtroproveedor) {$query->where('pedidos.proveedor_id',$filtroproveedor);})
        //     ->when($filtroestado!='', function ($query) use($filtroestado) {$query->where('pedidos.estado',$filtroestado);})
        //     ->when($filtrofacturado!='', function ($query) use($filtrofacturado) {$query->where('pedidos.facturado',$filtrofacturado);})
        //     ->when($filtroarchivos!='', function ($query) use($filtroarchivos) {$query->where('pedidos.ctrarchivos',$filtroarchivos);})
        //     ->when($filtroplotter!='', function ($query)use($filtroplotter){$query->where('pedidos.ctrplotter',$filtroplotter);})
        //     ->when($filtroentrega!='', function ($query) use($filtroentrega) {$query->where('pedidos.ctrentrega',$filtroentrega);})
        //     ->searchYear('fechapedido',$filtroanyo)
        //     ->searchMes('fechapedido',$filtromes)
        //     ->orderBy('pedidos.estado','asc')
        //     ->orderBy('entidades.entidad','asc')
        //     ->orderBy('pedidos.fechaentrega','asc')
        //     ->orderBy('pedidos.id','desc')
        //     ->groupBy('pedidos.id','pedidos.tipo')
        //     ->get();

        //     // dd($pedidos);
        // }
        return view('pedidos.index',compact(['tipo','ruta','entidades','clientes','proveedores','meses','responsables','pedidos',
        'search','filtroreferencia','filtroisbn','filtroresponsable','filtrocliente','filtrocliente','filtroproveedor','filtroestado','filtrofacturado','filtroarchivos','filtroplotter','filtroentrega','filtroanyo','filtromes']));
    }

    public function nuevo($tipo,$ruta){
        $titulo=$tipo=='1' ? 'Nuevo Pedido Editorial' : 'Nuevo Pedido Packaging/Propios';
        return view('pedidos.create',compact('tipo','ruta','titulo'));
    }

    public function ficha($pedId,$tipo){
        $pdf = new Dompdf();
        $pedido=Pedido::with('cliente')->find($pedId);
        $pdf = \PDF::loadView('pedidos.fichapdf', compact('pedido'));
        $pdf->setPaper('a4','portrait');
        return $pdf->stream('ficha.pdf'); //asi lo muestra por pantalla
    }

    public function albaran($pedidoid,$ruta,$parcialid){
        $parcial=PedidoParcial::find($parcialid);
        $pedido=Pedido::find($parcial->pedido_id);
        $entidad=Entidad::find($pedido->cliente_id);
        $detalles=PedidoparcialDetalle::where('parcial_id',$parcialid)->get();
        $pdf = new Dompdf();

        $pdf = \PDF::loadView('pedidos.albaranpdf', compact('pedido','parcial','entidad','detalles'));
        $pdf->setPaper('a4','portrait');
        return $pdf->stream('albaran.pdf'); //asi lo muestra por pantalla
    }

    public function entrada($pedidoid,$tipo,$ruta){
        $pdf = new Dompdf();
        if($tipo=='1'){
            $vista='pedidos.fichaentradaeditorialpdf';
            $productos=PedidoProducto::where('pedido_id',$pedidoid)->first()->producto;
            $pedido=Pedido::with('cliente','contacto','distribuciones')->find($pedidoid);
            $pdf = \PDF::loadView($vista, compact('pedido','productos'));
        }else{
            $vista='pedidos.fichaentradaotrospdf';
            $pedido=Pedido::with('cliente','contacto','pedidoproductos','pedidoprocesos')->find($pedidoid);
            // dd($pedido->pedidoproductos);
            $pedidoproductos=PedidoProducto::where('pedido_id',$pedidoid)->pluck('producto_id');
            $productos=Producto::whereIn('id',$pedidoproductos)->get();
            $pdf = \PDF::loadView($vista, compact('pedido','productos'));
        }
        $pdf->setPaper('a4','portrait');
        return $pdf->stream('pedido.pdf'); //asi lo muestra por pantalla
    }

    // public function presupuesto(Pedido $pedido,$ruta,$pedidopresupuestoid){
    //     $presupuesto=PedidoPresupuesto::find($pedidopresupuestoid);
    //     $producto=Producto::find($pedido->producto_id);
    //     $proveedor=Entidad::find($presupuesto->proveedor_id);
    //     $cliente=Entidad::find($pedido->cliente_id);
    //     $pdf = new Dompdf();
    //     $fecha=Carbon::parse($presupuesto->fecha)->format('d/m/Y');


    //     $pdf = \PDF::loadView('pedidos.presupuestopdf', compact('pedido','presupuesto','producto','proveedor','cliente','fecha'));
    //     $pdf->setPaper('a4','portrait');
    //     return $pdf->stream('presupuesto.pdf'); //asi lo muestra por pantalla
    // }

    public function editar(Pedido $pedido,$ruta){
        $tipo=$pedido->tipo;
        $titulo=$tipo=='1' ? 'Pedido Editorial' : 'Pedido Packaging/Propio';
        return view('pedidos.edit',compact('pedido','tipo','ruta','titulo'));
    }

    public function parciales(Pedido $pedido, $ruta){
        return view('pedidos.parciales',compact('pedido','ruta'));
    }

    public function parcial(Pedido $pedido, $ruta,$parcialid){
        $tipo=$pedido->tipo;
        return view('pedidos.parcial',compact('pedido','ruta','parcialid','tipo'));
    }

    public function archivos(Pedido $pedido, $ruta){
        return view('pedidos.archivos',compact('pedido','ruta'));
    }

    public function incidencias(Pedido $pedido, $ruta){
        return view('pedidos.incidencias',compact('pedido','ruta'));
    }

    public function retrasos(Pedido $pedido, $ruta){
        return view('pedidos.retrasos',compact('pedido','ruta'));
    }

    public function distribuciones(Pedido $pedido, $ruta){
        return view('pedidos.distribuciones',compact('pedido','ruta'));
    }
}
