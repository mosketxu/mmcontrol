<?php

namespace App\Http\Controllers;

use App\Models\Entidad;
use App\Models\Producto;
use App\Models\UserEmpresa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Dompdf\Dompdf;

class ClienteController extends Controller
{

    public function __construct(){
        $this->middleware('can:cliente.producto.index');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $cliente=Auth::user();
        return view('clientes.index',compact(['cliente']));
    }

    public function entidadIndex(){
        $cliente=Auth::user();
        $empresascliente=UserEmpresa::where('user_id',$cliente->id)->pluck('entidad_id');
        $entidades=Entidad::query()
            ->with('entidadtipo')
            // ->filtrosEntidad($this->search, $this->filtroresponsable, $this->entidadtipo_id, $this->filtrofini, $this->filtroffin)
            ->whereIn('id',$empresascliente)
            ->orderBy('entidad')
            ->get();

        return view('clientes.entidad.index',compact('cliente','entidades'));
    }

    public function productotipo($tipo){
        $cliente=Auth::user();
        $titulo=$tipo=='1'? 'Productos Editoriales' : 'Productos Packaging y Propios';
        $titulo= $titulo . ' del cliente ' . $cliente->name ;
        return view('clientes.producto.index',compact('tipo','cliente','titulo'));
    }

    public function productoedit(Producto $producto){
        $tipo=$producto->tipo;
        $titulo=$tipo=='1'? 'Producto Editorial:' : 'Producto Packaging/Propio:';
        return view('clientes.producto.edit',compact('producto','tipo','titulo'));
    }

    public function productoarchivos(Producto $producto, $ruta){
        return view('clientes.producto.archivos',compact('producto','ruta'));
    }

    public function productoficha($prodId,$tipo,$tipopdf){
        $pdf = new Dompdf();
        $producto=Producto::with('cliente')->find($prodId);
        $pdf = \PDF::loadView('clientes.producto.fichapdf', compact('producto','tipo','tipopdf'));
        $pdf->setPaper('a4','portrait');
        return $pdf->stream('ficha.pdf'); //asi lo muestra por pantalla
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
