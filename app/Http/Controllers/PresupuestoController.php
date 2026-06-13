<?php

namespace App\Http\Controllers;

use App\Models\Entidad;
use App\Models\Presupuesto;
use App\Exports\PresupuestosExport;
use Dompdf\Dompdf;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;


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

    public function presupuestoPDF(Presupuesto $presupuesto,$reducido,$idioma){
        $presupuesto->loadMissing('idioma', 'presupuestoproductos.producto', 'presupuestoprocesos');
        // $idiomaPdf=strtoupper($presupuesto->idioma?->codigo ?? $idioma);
        $proveedor=Entidad::find($presupuesto->proveedor_id);
        $cliente=Entidad::find($presupuesto->cliente_id);
        $pdf = new Dompdf();

        app()->setLocale(strtolower($presupuesto->idioma?->nombre ?? 'es'));

        if($presupuesto->tipo=='1'){
            $producto=$presupuesto->presupuestoproductos->first()?->producto;
                if($reducido=='n')
                $pdf = \PDF::loadView('presupuestos.presupuestopdfeditorial', compact('presupuesto','producto','proveedor','cliente'));
                else
                $pdf = \PDF::loadView('presupuestos.presupuestopdfeditorial', compact('presupuesto','producto','proveedor','cliente'));
        }
        else{
            $producto = $presupuesto->presupuestoproductos->first()?->producto;
            $pdf = \PDF::loadView('presupuestos.presupuestopdfotros', compact('presupuesto','proveedor','cliente','producto'));
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

    public function exportPresupuesto(Request $request){
        $filters = [
            'tipo' => $request->input('tipo'),
            'search' => $request->input('search'),
            'anyo' => $request->input('filtroanyo'),
            'mes' => $request->input('filtromes'),
            'cliente' => $request->input('filtrocliente'),
            'idioma' => $request->input('filtroidioma'),
            'proveedor' => $request->input('filtroproveedor'),
            'responsable' => $request->input('filtroresponsable'),
            'referencia' => $request->input('filtroreferencia'),
            'isbn' => $request->input('filtroisbn'),
            'estado' => $request->input('filtroestado'),
            'okexterno' => $request->input('filtrookexterno'),
        ];

        return Excel::download(
            new PresupuestosExport($filters),
            'presupuestosimprenta.xlsx'
        );
    }
}
