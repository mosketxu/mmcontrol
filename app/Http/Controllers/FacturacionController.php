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
        $this->middleware('can:facturacion.edit')->only('create','validarPdf');
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
    // «Generar nueva versión» del PDF: el anterior queda como factura_ID_old_vN.pdf y se muestra el nuevo.
    public function validarPdf($id)
    {
        $factura = Factura::findOrFail($id);
        $servicio = app(\App\Services\FacturaPdf::class);
        if ($factura->pdf_path) {
            $servicio->validar($factura);
        }
        return $servicio->respuesta($factura->fresh(), false);
    }

    public function show($id)
    {
        return app(\App\Services\FacturaPdf::class)->respuesta(Factura::findOrFail($id), auth()->user()->can('facturacion.edit'), request('version'));
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
