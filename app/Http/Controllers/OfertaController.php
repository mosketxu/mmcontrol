<?php

namespace App\Http\Controllers;

use App\Models\Oferta;
use Dompdf\Dompdf;

class OfertaController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:oferta.index')->only('tipo','ficha');
        $this->middleware('can:producto.edit')->only('nuevo','editar');
    }

    public function tipo($tipo)
    {
        $titulo=$tipo=='1' ? 'Presupuesto Editorial':  'Presupuesto Packaging/Propios';
        return view('oferta.index',compact('tipo','titulo'));
    }

    public function nuevo($tipo,$ruta)
    {
        $titulo=$tipo=='1' ? 'Nuevo Presupuesto Editorial' : 'Nuevo Presupuesto Packaging/Propios';
        return view('oferta.create',compact('tipo','ruta','titulo'));
    }

    public function ficha($ofertaId,$tipo){

        $pdf = new Dompdf();
        $oferta=Oferta::with('cliente','contacto','ofertaproducto','ofertadetalles')->find($ofertaId);
        $vista= $oferta->tipo=='1' ? 'oferta.ofertaeditorialpdf' : 'oferta.ofertaotrospdf';
        $pdf = \PDF::loadView($vista, compact('oferta'));
        $pdf->setPaper('a4','portrait');
        return $pdf->stream('oferta'.$ofertaId.'.pdf'); //asi lo muestra por pantalla
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Oferta  $oferta
     * @return \Illuminate\Http\Response
     */
    public function edit(Oferta $oferta)
    {
        $tipo=$oferta->tipo;
        return view('oferta.edit',compact('oferta','tipo'));

    }

    public function editar(Oferta $oferta,$ruta)
    {
        $tipo=$oferta->tipo;
        $titulo=$tipo=='1' ? 'Presupuesto Editorial' : 'Presupuesto Packaging/Propios';
        return view('oferta.edit',compact('oferta','tipo','ruta','titulo'));
    }
}
