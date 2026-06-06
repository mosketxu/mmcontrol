<?php

namespace App\Http\Controllers;

use App\Models\Entidad;
use App\Exports\EntidadesExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class EntidadController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:entidad.index')->only('index');
        $this->middleware('can:entidad.edit')->only('edita','update');
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
        $ruta = url()->previous();
        // dd($ruta);
        return view('entidad.contactos',compact('entidad','ruta'));
    }

    public function destinos(Entidad $entidad,$ruta)
    {
        return view('entidad.destinos',compact('entidad','ruta'));
    }

    // public function createcontacto($contactoId)
    public function createContacto(Entidad $entidad)
    {
        // $contacto=Entidad::find($contactoId);
        // $contacto = Entidad::findOrFail($contactoId); // 404 automático
        $contacto=$entidad;
        return view('entidad.createcontacto',compact('contacto'));
    }

    public function exportEntidad(Request $request)
    {
        return Excel::download(
            new EntidadesExport(
                $request->search,
                $request->filtroresponsable,
                $request->entidadtipo_id,
                $request->filtrofini,
                $request->filtroffin,
                $request->ordenarpor ?? 'entidad',
                $request->orden ?? 'asc'
            ),
            'entidades.xlsx'
        );
}

}
