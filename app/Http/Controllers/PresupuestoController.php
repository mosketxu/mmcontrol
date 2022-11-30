<?php

namespace App\Http\Controllers;

use App\Models\Entidad;
use App\Models\Presupuesto;
use App\Models\Producto;
use Carbon\Carbon;
use Dompdf\Dompdf;
use \PDF;

class PresupuestoController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:presupuesto.index')->only('tipo','presupuestoPDF');;
        $this->middleware('can:presupuesto.edit')->only('nuevo','editar','archivos');
    }

    public function tipo($tipo,$ruta){
        return view('presupuestos.index',compact(['tipo','ruta']));
    }

    public function nuevo($tipo,$ruta){
        return view('presupuestos.create',compact('tipo','ruta'));
    }

    public function presupuestoPDF(Presupuesto $presupuesto){
        if($presupuesto->tipo=='1'){
            $producto=$presupuesto->presupuestoproductos->first()->producto;
}
        else{
            dd('otros');
        }


        $proveedor=Entidad::find($presupuesto->proveedor_id);
        $cliente=Entidad::find($presupuesto->cliente_id);
        $pdf = new Dompdf();

        $pdf = \PDF::loadView('presupuestos.presupuestopdfeditorial', compact('presupuesto','producto','proveedor','cliente'));
        $pdf->setPaper('a4','portrait');
        return $pdf->stream('presupuesto.pdf'); //asi lo muestra por pantalla
    }

    public function editar(Presupuesto $presupuesto,$ruta){
        $tipo=$presupuesto->tipo;
        return view('presupuestos.edit',compact('presupuestos','tipo','ruta'));
    }

    public function archivos(Presupuesto $presupuesto, $ruta){
        return view('presupuestos.archivos',compact('presupuesto','ruta'));
    }
}
