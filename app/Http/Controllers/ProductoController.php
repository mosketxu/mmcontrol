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
        $this->middleware('can:producto.index')->only('tipo','ficha');
        // $this->middleware('can:producto.index')->only('index','ficha');
        $this->middleware('can:producto.edit')->only('nuevo','edit','update');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function index()
    // {
    //     $tipo='';
    //     return view('producto.index',compact('tipo'));
    // }

    public function tipo($tipo){
        $titulo=$tipo=='1'? 'Productos Editoriales' : 'Productos Packaging y Propios';
        return view('producto.index',compact('tipo','titulo'));
    }

    public function nuevo($tipo){
        $titulo=$tipo=='1'? 'Nuevo producto Editorial' : 'Nuevo producto de Packaging/Propio';
        return view('producto.create',compact('tipo','titulo'));
    }

    public function archivos(Producto $producto, $ruta){
        return view('producto.archivos',compact('producto','ruta'));
    }

    public function ficha($prodId,$tipo,$tipopdf){
        $pdf = new Dompdf();
        $producto=Producto::with('cliente')->find($prodId);
        $pdf = \PDF::loadView('producto.fichapdf', compact('producto','tipo','tipopdf'));
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
        $tipo=$producto->tipo;
        $titulo=$tipo=='1'? 'Producto Editorial:' : 'Producto Packaging/Propio:';
        return view('producto.edit',compact('producto','tipo','titulo'));
    }

}
