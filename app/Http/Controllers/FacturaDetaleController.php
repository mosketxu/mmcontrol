<?php

namespace App\Http\Controllers;

use App\Models\FacturaDetale;
use App\Http\Requests\StoreFacturaDetaleRequest;
use App\Http\Requests\UpdateFacturaDetaleRequest;

class FacturaDetaleController extends Controller
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
     * @param  \App\Http\Requests\StoreFacturaDetaleRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreFacturaDetaleRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\FacturaDetale  $facturaDetale
     * @return \Illuminate\Http\Response
     */
    public function show(FacturaDetale $facturaDetale)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\FacturaDetale  $facturaDetale
     * @return \Illuminate\Http\Response
     */
    public function edit(FacturaDetale $facturaDetale)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateFacturaDetaleRequest  $request
     * @param  \App\Models\FacturaDetale  $facturaDetale
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateFacturaDetaleRequest $request, FacturaDetale $facturaDetale)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FacturaDetale  $facturaDetale
     * @return \Illuminate\Http\Response
     */
    public function destroy(FacturaDetale $facturaDetale)
    {
        //
    }
}
