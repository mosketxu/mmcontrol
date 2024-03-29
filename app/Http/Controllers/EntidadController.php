<?php

namespace App\Http\Controllers;

use App\Models\Entidad;

class EntidadController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:entidad.index')->only('index');
        $this->middleware('can:entidad.edit')->only('edit','update');
    }

    public function index()
    {
        $entidadtipo_id='0';
        return view('entidad.index',compact('entidadtipo_id'));
    }

    public function tipo($entidadtipo_id)
    {
        $entidadtipo_id= !in_array($entidadtipo_id, ['0','1','2','3','4']) ? '0' : $entidadtipo_id;

        return view('entidad.index',compact('entidadtipo_id'));
    }

    public function nueva($entidadtipo_id)
    {
        return view('entidad.create',compact('entidadtipo_id'));
    }

    public function edit(Entidad $entidad){
        $entidadtipoId = $entidad->entidadtipo_id;
        return view('entidad.edit',compact('entidad','entidadtipoId'));
    }


    public function contactos(Entidad $entidad)
    {
        return view('entidad.contactos',compact('entidad'));
    }

    public function destinos(Entidad $entidad,$ruta)
    {
        return view('entidad.destinos',compact('entidad','ruta'));
    }

    public function createcontacto($contactoId)
    {
        $contacto=Entidad::find($contactoId);
        return view('entidad.createcontacto',compact('contacto'));
    }


}
