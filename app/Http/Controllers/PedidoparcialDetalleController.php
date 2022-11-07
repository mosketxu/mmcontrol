<?php

namespace App\Http\Controllers;

use App\Models\Pedido\PedidoparcialDetalle;
use App\Http\Requests\StorePedidoparcialDetalleRequest;
use App\Http\Requests\UpdatePedidoparcialDetalleRequest;

class PedidoparcialDetalleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePedidoparcialDetalleRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePedidoparcialDetalleRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pedido\PedidoparcialDetalle  $pedidoparcialDetalle
     * @return \Illuminate\Http\Response
     */
    public function show(PedidoparcialDetalle $pedidoparcialDetalle)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pedido\PedidoparcialDetalle  $pedidoparcialDetalle
     * @return \Illuminate\Http\Response
     */
    public function edit(PedidoparcialDetalle $pedidoparcialDetalle)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePedidoparcialDetalleRequest  $request
     * @param  \App\Models\Pedido\PedidoparcialDetalle  $pedidoparcialDetalle
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePedidoparcialDetalleRequest $request, PedidoparcialDetalle $pedidoparcialDetalle)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pedido\PedidoparcialDetalle  $pedidoparcialDetalle
     * @return \Illuminate\Http\Response
     */
    public function destroy(PedidoparcialDetalle $pedidoparcialDetalle)
    {
        //
    }
}
