<?php

namespace App\Http\Controllers;

use App\Models\{EntidadContacto, Entidad};

class EntidadContactoController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:entidadcontacto.index')->only('show');
        $this->middleware('can:entidadcontacto.edit')->only('edit','nuevo');
    }

    public function nuevo(Entidad $entidad)
    {
        return view('entidad.contactonuevo',compact(['entidad']));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\EntidadContacto  $entidadContacto
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('entidad.contactos',compact(['id']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $contacto=EntidadContacto::find($id);
        $entidad=Entidad::find($contacto->entidad_id);
        return view('entidad.contacto',compact(['contacto','entidad']));
    }
}
