<?php

namespace App\Http\Controllers;

use App\Models\PedidoArchivo;
use App\Http\Requests\StorePedidoArchivoRequest;
use App\Http\Requests\UpdatePedidoArchivoRequest;

class PedidoArchivoController extends Controller
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
     * @param  \App\Http\Requests\StorePedidoArchivoRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePedidoArchivoRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PedidoArchivo  $pedidoArchivo
     * @return \Illuminate\Http\Response
     */
    public function show(PedidoArchivo $pedidoArchivo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PedidoArchivo  $pedidoArchivo
     * @return \Illuminate\Http\Response
     */
    public function edit(PedidoArchivo $pedidoArchivo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePedidoArchivoRequest  $request
     * @param  \App\Models\PedidoArchivo  $pedidoArchivo
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePedidoArchivoRequest $request, PedidoArchivo $pedidoArchivo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PedidoArchivo  $pedidoArchivo
     * @return \Illuminate\Http\Response
     */
    public function destroy(PedidoArchivo $pedidoArchivo)
    {
        //
    }
}
