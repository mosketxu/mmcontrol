<?php

namespace App\Http\Controllers;

use App\Models\Entidad;
use App\Models\Pedido;
use App\Models\Presupuesto;
use App\Models\Producto;
use Carbon\Carbon;
use Dompdf\Dompdf;
use \PDF;

class PresupuestoController extends Controller
{

    public function __construct(){
        $this->middleware('can:presupuesto.index')->only('tipo','presupuestoPDF');;
        $this->middleware('can:presupuesto.edit')->only('nuevo','editar','archivos');
    }

    public function tipo($tipo,$ruta){
        $titulo=$tipo=='1' ? 'Presupuestos Editoriales' : 'Presupuestos Packaging/Propios';
        return view('presupuestos.index',compact(['tipo','ruta','titulo']));
    }

    public function nuevo($tipo,$ruta){
        $titulo=$tipo=='1' ? 'Nuevo Presupuesto Editorial' : 'Nuevo Presupuesto Packaging/Propio';
        return view('presupuestos.create',compact('tipo','ruta','titulo'));
    }

    public function presupuestoPDF(Presupuesto $presupuesto){
        $proveedor=Entidad::find($presupuesto->proveedor_id);
        $cliente=Entidad::find($presupuesto->cliente_id);
        $pdf = new Dompdf();

        if($presupuesto->tipo=='1'){
            $producto=$presupuesto->presupuestoproductos->first()->producto;
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

    public function editar(Presupuesto $presupuesto,$ruta){
        $tipo=$presupuesto->tipo;
        $titulo=$tipo=='1' ? 'Presupuesto Editorial' : 'Presupuesto Packaging/Propios';
        return view('presupuestos.edit',compact('presupuesto','tipo','ruta','titulo'));
    }

    public function archivos(Presupuesto $presupuesto, $ruta){
        return view('presupuestos.archivos',compact('presupuesto','ruta'));
    }

}
