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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function tipo($tipo)
    {
        return view('oferta.index',compact('tipo'));
    }

    public function nuevo($tipo,$ruta)
    {
        return view('oferta.create',compact('tipo','ruta'));
    }

    public function ficha($ofertaId,$tipo)
    {
        $pdf = new Dompdf();
        $oferta=Oferta::with('cliente','contacto','ofertadetalles')->find($ofertaId);
        if($oferta->tipo=='1')
            $pdf = \PDF::loadView('oferta.ofertaeditorialpdf', compact('oferta'));
        else
            $pdf = \PDF::loadView('oferta.ofertaeotrospdf', compact('oferta'));
        $pdf->setPaper('a4','portrait');
        return $pdf->stream('oferta'.$ofertaId.'.pdf'); //asi lo muestra por pantalla
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Oferta  $oferta
     * @return \Illuminate\Http\Response
     */
    public function show(Oferta $oferta)
    {
        //
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
        return view('oferta.edit',compact('oferta','tipo','ruta'));
    }
}
