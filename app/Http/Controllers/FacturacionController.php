<?php

namespace App\Http\Controllers;

use App\Models\Factura;
use App\Models\FacturaDetalle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Dompdf\Dompdf;


class FacturacionController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:facturacion.index')->only('index','show');
        $this->middleware('can:facturacion.edit')->only('create');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('facturacion.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('facturacion.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $factura=Factura::find($id);
        return view('facturacion.edit',compact('factura'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
