<?php

namespace App\Http\Controllers;

use App\Models\Pedido;

class PedidoController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:pedido.index');
        $this->middleware('can:pedido.edit')->only('edit','update','parcial');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pedidos.index');

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pedidos.create');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pedido  $pedido
     * @return \Illuminate\Http\Response
     */
    public function edit(Pedido $pedido)
    {
        return view('pedidos.edit',compact('pedido'));
    }

    public function parciales(Pedido $pedido, $ruta)
    {
    return view('pedidos.parciales',compact('pedido','ruta'));
    }

    public function facturaciones(Pedido $pedido, $ruta)
    {
        return view('pedidos.facturaciones',compact('pedido','ruta'));
    }

    public function archivos(Pedido $pedido, $ruta)
    {
        return view('pedidos.archivos',compact('pedido','ruta'));
    }
}
