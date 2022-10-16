<?php

namespace App\Http\Controllers;

use App\Models\EntidadContacto;
use App\Http\Requests\StoreEntidadContactoRequest;
use App\Http\Requests\UpdateEntidadContactoRequest;

class EntidadContactoController extends Controller
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
     * @param  \App\Http\Requests\StoreEntidadContactoRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEntidadContactoRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\EntidadContacto  $entidadContacto
     * @return \Illuminate\Http\Response
     */
    public function show(EntidadContacto $entidadContacto)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\EntidadContacto  $entidadContacto
     * @return \Illuminate\Http\Response
     */
    public function edit(EntidadContacto $entidadContacto)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateEntidadContactoRequest  $request
     * @param  \App\Models\EntidadContacto  $entidadContacto
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateEntidadContactoRequest $request, EntidadContacto $entidadContacto)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EntidadContacto  $entidadContacto
     * @return \Illuminate\Http\Response
     */
    public function destroy(EntidadContacto $entidadContacto)
    {
        //
    }
}
