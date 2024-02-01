<?php

namespace App\Http\Controllers;


use App\Models\Entidad;
use App\Models\Factura;
use App\Models\FacturaDetalle;
use App\Models\Mes;
use App\Models\Oferta;
use App\Models\Pedido;
use App\Models\Presupuesto;
use App\Models\Producto;
use App\Models\Responsable;
use App\Models\UserEmpresa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\DB;

class ClienteController extends Controller
{

    public function __construct(){
        // en las rutas cargo el can
        // $this->middleware('can:cliente.pedido.index');

    }

    // /**
    //  * Display a listing of the resource.
    //  *
    //  * @return \Illuminate\Http\Response
    //  */
    // public function index(){
    //     $cliente=Auth::user();
    //     return view('clientes.index',compact(['cliente']));
    // }

    public function entidadIndex(){
        $cliente=Auth::user();
        $empresascliente=UserEmpresa::where('user_id',$cliente->id)->pluck('entidad_id');
        $entidades=Entidad::query()
            ->with('entidadtipo')
            // ->filtrosEntidad($this->search, $this->filtroresponsable, $this->entidadtipo_id, $this->filtrofini, $this->filtroffin)
            ->whereIn('id',$empresascliente)
            ->orderBy('entidad')
            ->get();

        return view('clientes.entidad.index',compact('cliente','entidades'));
    }

    public function productotipo($tipo){
        $cliente=Auth::user();
        $titulo=$tipo=='1'? 'Productos Editoriales' : 'Productos Packaging y Propios';
        $titulo= $titulo . ' del cliente ' . $cliente->name ;
        return view('clientes.producto.index',compact('tipo','cliente','titulo'));
    }

    public function productoedit(Producto $producto){
        $tipo=$producto->tipo;
        $titulo=$tipo=='1'? 'Producto Editorial:' : 'Producto Packaging/Propio:';
        return view('clientes.producto.edit',compact('producto','tipo','titulo'));
    }

    public function productoarchivos(Producto $producto, $ruta){
        return view('clientes.producto.archivos',compact('producto','ruta'));
    }

    public function productoficha($prodId,$tipo,$tipopdf){
        $pdf = new Dompdf();
        $producto=Producto::with('cliente')->find($prodId);
        $pdf = \PDF::loadView('clientes.producto.fichapdf', compact('producto','tipo','tipopdf'));
        $pdf->setPaper('a4','portrait');
        return $pdf->stream('ficha.pdf'); //asi lo muestra por pantalla
    }

    public function ofertatipo($tipo){
        $titulo=$tipo=='1' ? 'Presupuesto MM Editorial':  'Presupuesto MM Packaging/Propios';
        return view('clientes.oferta.index',compact('tipo','titulo'));
    }

    public function ofertaeditar(Oferta $oferta,$ruta){
        $tipo=$oferta->tipo;
        $titulo=$tipo=='1' ? 'Presupuesto MM Editorial' : 'Presupuesto MM Packaging/Propios';
        return view('clientes.oferta.edit',compact('oferta','tipo','ruta','titulo'));
    }

    public function ofertaficha($ofertaId,$tipo){
        $pdf = new Dompdf();
        $oferta=Oferta::with('cliente','contacto','ofertaproducto','ofertadetalles')->find($ofertaId);
        $vista= $oferta->tipo=='1' ? 'oferta.ofertaeditorialpdf' : 'oferta.ofertaotrospdf';
        $pdf = \PDF::loadView($vista, compact('oferta'));
        $pdf->setPaper('a4','portrait');
        return $pdf->stream('oferta'.$ofertaId.'.pdf'); //asi lo muestra por pantalla
    }

    public function presupuestotipo($tipo,$ruta,Request $request ){
        $titulo=$tipo=='1' ? 'Presupuestos Editoriales' : 'Presupuestos Packaging/Propios';
        return view('clientes.presupuesto.index',compact(['tipo','ruta','titulo']));

    }

    public function presupuestoeditar(Presupuesto $presupuesto,$ruta){
        $tipo=$presupuesto->tipo;
        $titulo=$tipo=='1' ? 'Presupuesto Editorial' : 'Presupuesto Packaging/Propio';
        $escliente=Auth::user()->hasRole('Cliente') ? 'disabled' : '';

        return view('clientes.presupuesto.edit',compact('presupuesto','tipo','ruta','titulo','escliente'));
    }

    public function presupuestoPDF(Presupuesto $presupuesto){
        $proveedor=Entidad::find($presupuesto->proveedor_id);
        $cliente=Entidad::find($presupuesto->cliente_id);
        $pdf = new Dompdf();

        if($presupuesto->tipo=='1'){
            $producto=$presupuesto->presupuestoproductos->first()->producto;
            if($tipopdf='n')
            $pdf = \PDF::loadView('presupuestos.presupuestopdfeditorial', compact('presupuesto','producto','proveedor','cliente'));
            else
            $pdf = \PDF::loadView('presupuestos.presupuestopdfeditorial', compact('presupuesto','producto','proveedor','cliente'));
        }
        else{
            // $presupuesto=Presupuesto::with('presupuestoproductos','presupuestoprocesos')->where('id',$presupuesto->id)->first();
            $presupuesto=Presupuesto::with('presupuestoproductos','presupuestoprocesos')->find($presupuesto->id);
            $pdf = \PDF::loadView('presupuestos.presupuestopdfotros', compact('presupuesto','proveedor','cliente'));
        }

        $pdf->setPaper('a4','portrait');
        return $pdf->stream('presupuesto.pdf'); //asi lo muestra por pantalla
    }

    public function archivos(Presupuesto $presupuesto, $ruta){
        return view('presupuestos.archivos',compact('presupuesto','ruta'));
    }



    public function pedidotipo($tipo,$ruta,Request $request ){
        $search=$request->search;
        $filtroreferencia=$request->filtroreferencia;
        $filtroisbn=$request->filtroisbn;
        $filtroresponsable=$request->filtroresponsable == '0' ? '' : $request->filtroresponsable;

        $filtrocliente=$request->filtrocliente;
        $filtroproveedor=$request->filtroproveedor;
        if($request->filtroestado==''){
            $filtroestado='0';}
        elseif($request->filtroestado == '3'){
            $filtroestado='';
        }else{
            $filtroestado=$request->filtroestado;
        }
        $filtroestado=$request->filtroestado == '' ? '0' : $request->filtroestado;
        $filtrofacturado=$request->filtrofacturado;
        $filtroarchivos=$request->filtroarchivos;
        $filtroplotter=$request->filtroplotter;
        $filtroentrega=$request->filtroentrega;
        $filtroanyo=$request->filtroanyo;
        $filtromes=$request->filtromes;

        $empresascliente=UserEmpresa::where('user_id',Auth::user()->id)->pluck('entidad_id');

        $entidades=Entidad::whereIn('id',$empresascliente)->orderBy('entidad')->get();
        $clientes=$entidades->whereIn('entidadtipo_id',['1','2']);
        $proveedores=$entidades->whereIn('entidadtipo_id',['2','3']);
        $meses=Mes::orderBy('id')->get();
        $responsables=Responsable::all();
        $escliente=Auth::user()->hasRole('Cliente') ? 'disabled' : '';

        $pedidos= Pedido::query()
            ->with('cliente','proveedor')
            ->join('entidades','pedidos.cliente_id','=','entidades.id')
            ->leftjoin('pedido_productos','pedido_productos.pedido_id','=','pedidos.id')
            ->leftjoin('productos','pedido_productos.producto_id','=','productos.id')
            ->select('entidades.entidad as cli', 'entidades.nif','entidades.emailadm','productos.isbn as isbn','productos.referencia as ref','pedidos.*',)
            ->where('pedidos.tipo',$tipo)
            ->whereIn('pedidos.cliente_id',$empresascliente)
            ->search('pedidos.id',$search)
            ->when($filtroreferencia!='', function ($query) use($filtroreferencia) {$query->where('productos.referencia','like','%'.$filtroreferencia.'%');})
            ->when($filtroisbn!='', function ($query) use($filtroisbn) {$query->where('productos.isbn','like','%'.$filtroisbn.'%');})
            ->when($filtroresponsable!='', function ($query) use($filtroresponsable){$query->where('pedidos.responsable','like','%'.$filtroresponsable.'%');})
            ->when($filtrocliente!='', function ($query) use($filtrocliente) {$query->where('pedidos.cliente_id',$filtrocliente);})
            ->when($filtroproveedor!='', function ($query) use($filtroproveedor) {$query->where('pedidos.proveedor_id',$filtroproveedor);})
            ->when($filtroestado!='' && $filtroestado!='3', function ($query) use($filtroestado) {$query->where('pedidos.estado',$filtroestado);})
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


            return view('clientes.pedido.index',compact(['tipo','ruta','entidades','clientes','proveedores','meses','responsables','pedidos','escliente',
            'search','filtroreferencia','filtroisbn','filtroresponsable','filtrocliente','filtrocliente','filtroproveedor','filtroestado','filtrofacturado','filtroarchivos','filtroplotter','filtroentrega','filtroanyo','filtromes']));
    }

    public function pedidoeditar(Pedido $pedido,$ruta){
        $tipo=$pedido->tipo;
        $titulo=$tipo=='1' ? 'Pedido Editorial' : 'Pedido Packaging/Propio';
        $escliente=Auth::user()->hasRole('Cliente') ? 'disabled' : '';

        return view('clientes.pedido.edit',compact('pedido','tipo','ruta','titulo','escliente'));
    }


    public function facturacionindex(){
        return view('clientes.facturacion.index');
    }

    // public function facturacionedit($id)
    // {
    //     $factura=Factura::find($id);
    //     return view('clientes.facturacion.edit',compact('factura'));
    // }

    public function facturacionshow($id)
    {
        $factura=Factura::with('facturadetalles','cliente')->find($id);
        $totales = FacturaDetalle::where('factura_id',$factura->id)
        ->select('iva',
            DB::raw('SUM(subtotalsiniva) as subtotalsiniva'),
            DB::raw('SUM(subtotaliva) as subtotaliva'),
            DB::raw('SUM(subtotal) as subtotal'))
        ->groupBy("iva")
        ->get();

        $pdf = new Dompdf();

        $pdf = \PDF::loadView('facturacion.facturapdf', compact('factura','totales'));
        $pdf->setPaper('a4','portrait');
        return $pdf->stream('factura_'.$id.'.pdf'); //asi lo muestra por pantalla
    }
}
