<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Http\Requests\StoreProductoRequest;
use App\Http\Requests\UpdateProductoRequest;

class ProductoController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:producto.index')->only('index');
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
