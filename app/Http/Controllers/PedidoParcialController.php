<?php

namespace App\Http\Controllers;

use App\Models\PedidoParcial;
use App\Http\Requests\StorePedidoParcialRequest;
use App\Http\Requests\UpdatePedidoParcialRequest;

class PedidoParcialController extends Controller
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
     * @param  \App\Http\Requests\StorePedidoParcialRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePedidoParcialRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PedidoParcial  $pedidoParcial
     * @return \Illuminate\Http\Response
     */
    public function show(PedidoParcial $pedidoParcial)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PedidoParcial  $pedidoParcial
     * @return \Illuminate\Http\Response
     */
    public function edit(PedidoParcial $pedidoParcial)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePedidoParcialRequest  $request
     * @param  \App\Models\PedidoParcial  $pedidoParcial
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePedidoParcialRequest $request, PedidoParcial $pedidoParcial)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PedidoParcial  $pedidoParcial
     * @return \Illuminate\Http\Response
     */
    public function destroy(PedidoParcial $pedidoParcial)
    {
        //
    }
}
