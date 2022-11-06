<?php

namespace App\Http\Controllers;

use App\Models\ProductoArchivo;
use App\Http\Requests\StoreProductoArchivoRequest;
use App\Http\Requests\UpdateProductoArchivoRequest;

class ProductoArchivoController extends Controller
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
     * @param  \App\Http\Requests\StoreProductoArchivoRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductoArchivoRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProductoArchivo  $productoArchivo
     * @return \Illuminate\Http\Response
     */
    public function show(ProductoArchivo $productoArchivo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProductoArchivo  $productoArchivo
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductoArchivo $productoArchivo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProductoArchivoRequest  $request
     * @param  \App\Models\ProductoArchivo  $productoArchivo
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductoArchivoRequest $request, ProductoArchivo $productoArchivo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProductoArchivo  $productoArchivo
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductoArchivo $productoArchivo)
    {
        //
    }
}
