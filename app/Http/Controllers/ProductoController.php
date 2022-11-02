<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\Storage;

use \PDF;
// use Barryvdh\DomPDF\Facade as PDF;

class ProductoController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:producto.index')->only('index','ficha');
        $this->middleware('can:producto.edit')->only('nuevo','edit','update');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tipo='';
        return view('producto.index',compact('tipo'));
    }

    public function tipo($tipo)
    {
        return view('producto.index',compact('tipo'));
    }

    public function nuevo($tipo)
    {
        return view('producto.create',compact('tipo'));
    }

    public function adjunto(Producto $producto){

        $existe=Storage::disk('fichasproducto')->exists($producto->adjunto);
        if ($existe)
            // return Storage::disk('fichasproducto')->url($producto->adjunto);
            return redirect(Storage::disk('fichasproducto')->url($producto->adjunto));
            // return Storage::disk('fichasproducto')->url($producto->adjunto);
            // return Storage::disk('fichasproducto')->download($producto->adjunto);
    }

    public function ficha($prodId,$tipo)
    {
        $pdf = new Dompdf();
        $producto=Producto::with('cliente')->find($prodId);
        $pdf = \PDF::loadView('producto.fichapdf', compact('producto'));
        $pdf->setPaper('a4','portrait');
        return $pdf->stream('ficha.pdf'); //asi lo muestra por pantalla
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function edit(Producto $producto)
    {
        return view('producto.edit',compact('producto'));
    }

}
