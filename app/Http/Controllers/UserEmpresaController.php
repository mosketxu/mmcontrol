<?php

namespace App\Http\Controllers;

use App\Models\UserEmpresa;
use App\Http\Requests\StoreUserEmpresaRequest;
use App\Http\Requests\UpdateUserEmpresaRequest;

class UserEmpresaController extends Controller
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
     * @param  \App\Http\Requests\StoreUserEmpresaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserEmpresaRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UserEmpresa  $userEmpresa
     * @return \Illuminate\Http\Response
     */
    public function show(UserEmpresa $userEmpresa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\UserEmpresa  $userEmpresa
     * @return \Illuminate\Http\Response
     */
    public function edit(UserEmpresa $userEmpresa)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateUserEmpresaRequest  $request
     * @param  \App\Models\UserEmpresa  $userEmpresa
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserEmpresaRequest $request, UserEmpresa $userEmpresa)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UserEmpresa  $userEmpresa
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserEmpresa $userEmpresa)
    {
        //
    }
}
