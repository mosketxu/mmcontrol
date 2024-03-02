<?php

namespace App\Http\Controllers;

use App\Exports\PedidosExport;
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
use App\Models\UserEmpresa;
use Carbon\Carbon;
use Dompdf\Dompdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use \PDF;
use Maatwebsite\Excel\Facades\Excel;

use function PHPUnit\Framework\isNull;

class PedidoController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:pedido.index')->only('index');;
        $this->middleware('can:pedido.edit')->only('nuevo','editar','update','parcial');
    }

    public function tipo($tipo,$ruta,Request $request ){
        $search=$request->search;
        $filtroreferencia=$request->filtroreferencia;
        $filtroisbn=$request->filtroisbn;
        $filtroresponsable=$request->filtroresponsable == '0' ? '' : $request->filtroresponsable;

        $filtrocliente=$request->filtrocliente;
        $filtroproveedor=$request->filtroproveedor;

        if($request->filtroestado==''){$filtroestado='0';}
            elseif($request->filtroestado == '3'){$filtroestado='';}
                else{$filtroestado=$request->filtroestado;}

        $filtroestado=$request->filtroestado == '' ? '0' : $request->filtroestado;
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
            ->when($filtroestado!='0' && $filtroestado!='3', function ($query) use($filtroestado) {$query->where('pedidos.estado',$filtroestado);})
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
            ->groupBy('pedidos.id')
            ->paginate(30);

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

    public function export($tipo,$search,$filtroreferencia,$filtroisbn,$filtroresponsable,$filtrocliente,$filtroproveedor,$filtroanyo,$filtromes,$filtroestado,$filtrofacturado){

        $search=$search=='@' ? '' : $search;
        $filtroreferencia=$filtroreferencia=='@' ? '' : $filtroreferencia;
        $filtroisbn=$filtroisbn=='@' ? '' : $filtroisbn;
        $filtroresponsable=$filtroresponsable=='@' ? '' : $filtroresponsable;
        $filtrocliente=$filtrocliente=='@' ? '' : $filtrocliente;
        $filtroproveedor=$filtroproveedor=='@' ? '' : $filtroproveedor;
        $filtroanyo=$filtroanyo=='@' ? '' : $filtroanyo;
        $filtromes=$filtromes=='@' ? '' : $filtromes;
        $filtroestado=$filtroestado=='@' ? '' : $filtroestado;
        $filtrofacturado=$filtrofacturado=='@' ? '' : $filtrofacturado;


        if($tipo=='1')
            $pedidos= Pedido::query()
                ->join('entidades as clientes','pedidos.cliente_id','=','clientes.id')
                ->leftjoin('pedido_productos','pedido_productos.pedido_id','=','pedidos.id')
                ->leftjoin('productos','pedido_productos.producto_id','=','productos.id')
                ->leftjoin('entidades as imprenta','pedidos.proveedor_id','=','imprenta.id')
                ->select('clientes.id as entidadId','clientes.entidad as cliente',
                'pedidos.id','pedidos.descripcion','pedidos.responsable','imprenta.entidad as imprenta',
                'pedidos.facturadopor',
                'pedidos.fechapedido','pedidos.fechaarchivos','pedidos.ctrarchivos','pedidos.fechaplotter','pedidos.ctrplotter','pedidos.fechaentrega','pedidos.ctrentrega',
                'productos.isbn','productos.referencia',
                'pedidos.estado','pedidos.facturado','otros',
                )
                ->where('pedidos.tipo',$tipo)
                ->search('pedidos.id',$search)
                ->when($filtroreferencia!='', function ($query) use($filtroreferencia){
                    $query->where('productos.referencia','like','%'.$filtroreferencia.'%');
                })
                ->when($filtroisbn!='', function ($query) use($filtroisbn){
                    $query->where('productos.isbn','like','%'.$filtroisbn.'%');
                })
                ->when($filtroresponsable!='', function ($query) use($filtroresponsable){
                    $query->where('pedidos.responsable','like','%'.$filtroresponsable.'%');
                })
                ->when($filtrocliente!='', function ($query) use($filtrocliente){
                    $query->where('pedidos.cliente_id',$filtrocliente);
                    })
                ->when($filtroproveedor!='', function ($query) use($filtroproveedor){
                    $query->where('pedidos.proveedor_id',$filtroproveedor);
                    })
                ->when($filtroestado!='' && $filtroestado!='3', function ($query) use($filtroestado){
                    $query->where('pedidos.estado',$filtroestado);
                })
                ->when($filtrofacturado!='', function ($query) use($filtrofacturado){
                    $query->where('pedidos.facturado',$filtrofacturado);
                })
                ->searchYear('fechapedido',$filtroanyo)
                ->searchMes('fechapedido',$filtromes)
                ->orderBy('pedidos.fechapedido','desc')
                ->orderBy('pedidos.id','desc')
                ->groupBy('pedidos.id')
                ->get();
        else
            $pedidos= Pedido::query()
                ->join('entidades','pedidos.cliente_id','=','entidades.id')
                ->leftjoin('pedido_productos','pedido_productos.pedido_id','=','pedidos.id')
                ->leftjoin('productos','pedido_productos.producto_id','=','productos.id')
                ->select('entidades.id as entidadId','entidades.entidad',
                'pedidos.id','pedidos.descripcion','pedidos.responsable','pedidos.facturadopor',
                'pedidos.fechapedido','pedidos.fechaarchivos','pedidos.ctrarchivos','pedidos.fechaplotter','pedidos.ctrplotter','pedidos.fechaentrega','pedidos.ctrentrega','pedidos.tiradaprevista','pedidos.tiradareal',
                'productos.isbn','productos.referencia',
                'pedidos.estado','pedidos.facturado','otros',
                )
                ->where('pedidos.tipo',$tipo)
                ->search('pedidos.id',$search)
                ->when($filtroreferencia!='', function ($query) use($filtroreferencia){
                    $query->where('productos.referencia','like','%'.$filtroreferencia.'%');
                })
                ->when($filtroisbn!='', function ($query) use($filtroisbn){
                    $query->where('productos.isbn','like','%'.$filtroisbn.'%');
                })
                ->when($filtroresponsable!='', function ($query) use($filtroresponsable){
                    $query->where('pedidos.responsable','like','%'.$filtroresponsable.'%');
                })
                ->when($filtrocliente!='', function ($query) use($filtrocliente){
                    $query->where('pedidos.cliente_id',$filtrocliente);
                    })
                ->when($filtroproveedor!='', function ($query) use($filtroproveedor){
                    $query->where('pedidos.proveedor_id',$filtroproveedor);
                    })
                ->when($filtroestado!='' && $filtroestado!='3', function ($query) use($filtroestado){
                    $query->where('pedidos.estado',$filtroestado);
                })
                ->when($filtrofacturado!='', function ($query) use($filtrofacturado){
                    $query->where('pedidos.facturado',$filtrofacturado);
                })
                ->searchYear('fechapedido',$filtroanyo)
                ->searchMes('fechapedido',$filtromes)
                ->orderBy('pedidos.fechapedido','desc')
                ->orderBy('pedidos.id','desc')
                ->groupBy('pedidos.id')
                ->get();

        if(Auth::user()->hasRole('Cliente')){
            $empresascliente=UserEmpresa::where('user_id',Auth::user()->id)->pluck('entidad_id');
            $pedidos=$pedidos->whereIn('entidadId',$empresascliente);
        }

        return Excel::download(new PedidosExport($pedidos,$tipo), 'pedidos.xlsx');
    }
}
