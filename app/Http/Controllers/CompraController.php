<?php

namespace App\Http\Controllers;

use App\Models\Compra;
use App\Models\Entidad;
use App\Models\Mes;
use Illuminate\Http\Request;

class CompraController extends Controller
{
    public function __construct(){
        $this->middleware('can:compra.index')->only('index');;
        $this->middleware('can:compra.edit')->only('nuevo','editar','update','parcial');
    }

    public function tipo($tipo,$ruta,Request $request ){

        $search=$request->search;
        $provedor=$request->provedor;
        $filtroproveedor=$request->filtroproveedor;
        $filtroarchivos=$request->filtroarchivos;
        $filtroanyo=$request->filtroanyo;
        $filtromes=$request->filtromes;

        $proveedores=Entidad::orderBy('entidad')->get();
        $meses=Mes::orderBy('id')->get();

        $compras= Compra::query()
            ->with('proveedor','productos')
            ->where('compras.tipo',$tipo)
            ->search('compras.id',$search)
            ->when($filtroproveedor!='', function ($query) use($filtroproveedor) {$query->where('compras.proveedor_id',$filtroproveedor);})
            ->searchYear('fecha',$filtroanyo)
            ->searchMes('fecha',$filtromes)
            ->orderBy('compras.fechaentrega','asc')
            ->orderBy('compras.id','desc')
            ->groupBy('compras.id')
            ->paginate(30);

        return view('compras.index',compact(['tipo','ruta','compras','proveedores','meses',
        'search','filtroproveedor','filtroanyo','filtromes']));
    }

}
