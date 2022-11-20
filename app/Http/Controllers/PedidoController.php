<?php

namespace App\Http\Controllers;

use App\Models\Entidad;
use App\Models\Pedido;
use App\Models\PedidoparcialDetalle;
use App\Models\PedidoParcial;
use App\Models\PedidoPresupuesto;
use App\Models\Producto;
use Carbon\Carbon;
use Dompdf\Dompdf;
use \PDF;


class PedidoController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:pedido.index')->only('index');;
        $this->middleware('can:pedido.edit')->only('nuevo','editar','update','parcial');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tipo='';

        return view('pedidos.index',compact('tipo'));

    }

    public function tipo($tipo,$ruta)
    {
        return view('pedidos.index',compact(['tipo','ruta']));
    }

    public function nuevo($tipo,$ruta)
    {
        return view('pedidos.create',compact('tipo','ruta'));
    }

    public function ficha($pedId,$tipo)
    {
        $pdf = new Dompdf();
        $pedido=Pedido::with('cliente')->find($pedId);
        $pdf = \PDF::loadView('pedidos.fichapdf', compact('pedido'));
        $pdf->setPaper('a4','portrait');
        return $pdf->stream('ficha.pdf'); //asi lo muestra por pantalla
    }

    public function albaran($pedidoid,$ruta,$parcialid)
    {
        $parcial=PedidoParcial::find($parcialid);
        $pedido=Pedido::find($parcial->pedido_id);
        $entidad=Entidad::find($pedido->cliente_id);
        $detalles=PedidoparcialDetalle::where('parcial_id',$parcialid)->get();
        $pdf = new Dompdf();

        $pdf = \PDF::loadView('pedidos.albaranpdf', compact('pedido','parcial','entidad','detalles'));
        $pdf->setPaper('a4','portrait');
        return $pdf->stream('albaran.pdf'); //asi lo muestra por pantalla
    }

    public function presupuesto(Pedido $pedido,$ruta,$pedidopresupuestoid)
    {
        $presupuesto=PedidoPresupuesto::find($pedidopresupuestoid);
        $producto=Producto::find($pedido->producto_id);
        $proveedor=Entidad::find($presupuesto->proveedor_id);
        $cliente=Entidad::find($pedido->cliente_id);
        $pdf = new Dompdf();
        $fecha=Carbon::parse($presupuesto->fecha)->format('d/m/Y');


        $pdf = \PDF::loadView('pedidos.presupuestopdf', compact('pedido','presupuesto','producto','proveedor','cliente','fecha'));
        $pdf->setPaper('a4','portrait');
        return $pdf->stream('presupuesto.pdf'); //asi lo muestra por pantalla
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pedido  $pedido
     * @return \Illuminate\Http\Response
     */
    public function editar(Pedido $pedido,$ruta)
    {
        $tipo=$pedido->tipo;
        return view('pedidos.edit',compact('pedido','tipo','ruta'));
    }

    public function parciales(Pedido $pedido, $ruta)
    {
        return view('pedidos.parciales',compact('pedido','ruta'));
    }

    public function parcial(Pedido $pedido, $ruta,$parcialid)
    {
        return view('pedidos.parcial',compact('pedido','ruta','parcialid'));
    }

    public function facturaciones(Pedido $pedido, $ruta)
    {
        return view('pedidos.facturaciones',compact('pedido','ruta'));
    }

    public function archivos(Pedido $pedido, $ruta)
    {
        return view('pedidos.archivos',compact('pedido','ruta'));
    }

    public function incidencias(Pedido $pedido, $ruta)
    {
        return view('pedidos.incidencias',compact('pedido','ruta'));
    }

    public function retrasos(Pedido $pedido, $ruta)
    {
        return view('pedidos.retrasos',compact('pedido','ruta'));
    }

    public function distribuciones(Pedido $pedido, $ruta)
    {
        return view('pedidos.distribuciones',compact('pedido','ruta'));
    }

    public function presupuestos(Pedido $pedido, $ruta)
    {
        return view('pedidos.presupuesto',compact('pedido','ruta'));
    }

}
