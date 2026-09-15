<?php

namespace App\Http\Controllers;

use App\Models\Oferta;
use App\Models\Producto;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use App\Exports\OfertasExport;

class OfertaController extends Controller
{

    public function __construct(){
        $this->middleware('can:oferta.index')->only('tipo','ficha');
        $this->middleware('can:producto.edit')->only('nuevo','editar');
    }

    public function tipo($tipo){
        $titulo=$tipo=='1' ? 'Presupuesto MM Editorial':  'Presupuesto MM Packaging/Propios';
        return view('oferta.index',compact('tipo','titulo'));
    }

    public function nuevo($tipo,$ruta){
        $titulo=$tipo=='1' ? 'Nuevo Presupuesto MM Editorial' : 'Nuevo Presupuesto MM Packaging/Propios';
        return view('oferta.create',compact('tipo','ruta','titulo'));
    }

    public function ficha($ofertaId,$tipo){
        if($tipo=='2'){
            // Packaging/Propios: varias líneas de producto, cada una con su propia
            // cantidad. La paginación del PDF es automática (ver ofertaotrospdf.blade.php),
            // no hace falta precalcular líneas/saltos de página aquí. Vale también para
            // ofertas antiguas de un solo producto: con una sola línea el resultado es
            // equivalente, y con varias (las había desde antes de este cambio) es la
            // única vista que las muestra todas — la antigua solo enseñaba una.
            $oferta=Oferta::with('cliente','contacto','ofertaproductos.producto.caja','ofertadetalles')->find($ofertaId);
            abort_if(!$oferta, 404);
            $pdf = \PDF::loadView('oferta.ofertaotrospdf', compact('oferta'));
            $pdf->setPaper('a4','portrait');
            return $pdf->stream('oferta'.$ofertaId.'.pdf');
        }

        // Editorial: un único producto por oferta, con cálculo de salto de página
        // dependiente de cuántas características tenga (número de líneas de cabecera).
        $oferta=Oferta::with('cliente','contacto','ofertaproducto','ofertadetalles')->find($ofertaId);
        abort_if(!$oferta, 404);
        $lineascabecera=1; //Ref que es fijo
        $p = $oferta->ofertaproducto ?? new Producto(['paginas' => '0']);
        $oferta->setRelation('ofertaproducto', $p);
        $lineascabecera += $p->formato!='' ? 1 : 0;
        $lineascabecera=$p->paginas!='0' ? $lineascabecera+1 : $lineascabecera;
        $lineascabecera=$p->materialinterior!='' ? $lineascabecera+1 : $lineascabecera;
        $lineascabecera=$p->materialcubierta!='' ? $lineascabecera+2 : $lineascabecera;
        $lineascabecera=$p->encuadernado!='' ? $lineascabecera+1 : $lineascabecera;
        $lineascabecera=$p->plastificado!='' ? $lineascabecera+1 : $lineascabecera;
        $lineascabecera=$p->descripsolapa!='' ? $lineascabecera+1 : $lineascabecera;
        $lineascabecera=$p->descripguardas!='' ? $lineascabecera+1 : $lineascabecera;
        $lineascabecera=$p->manipulacion!='' ? $lineascabecera+1 : $lineascabecera;
        $lineascabecera=$p->tipoimpresion!='' ? $lineascabecera+1 : $lineascabecera;
        $lineascabecera=$p->FSC!='' ? $lineascabecera+1 : $lineascabecera;
        $lineascabecera=$p->observaciones!='' ? $lineascabecera+2 : $lineascabecera;
        // el maximo de $lineasoferta serian 14;
        $lineasoferta=$oferta->ofertadetalles->count();
        $lineas=$lineasoferta + $lineascabecera;
        //para una sola pagina en editorial empieza a quedar mal con 19
        $limite=18;
        $salto = max(1, $limite - $lineascabecera);
        $primera=1;
        $cont=0;
        $controlsaltopag2=30;

        $pdf = \PDF::loadView('oferta.ofertaeditorialpdf', compact('oferta','lineascabecera','lineas','lineasoferta','salto','primera','cont','controlsaltopag2'));
        $pdf->setPaper('a4','portrait');
        return $pdf->stream('oferta'.$ofertaId.'.pdf'); //asi lo muestra por pantalla
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Oferta  $oferta
     * @return \Illuminate\Http\Response
     */
    public function edit(Oferta $oferta){
        $tipo=$oferta->tipo;
        return view('oferta.edit',compact('oferta','tipo'));
    }

    public function editar(Oferta $oferta,$ruta){
        $tipo=$oferta->tipo;
        $titulo=$tipo=='1' ? 'Presupuesto MM Editorial' : 'Presupuesto MM Packaging/Propios';
        return view('oferta.edit',compact('oferta','tipo','ruta','titulo'));
    }

    public function exportOferta(Request $request){

        $filters = [
            'tipo' => $request->input('tipo'),
            'search' => $request->input('search'),
            'anyo' => $request->input('filtroanyo'),
            'mes' => $request->input('filtromes'),
            'cliente' => $request->input('filtrocliente'),
            'contacto' => $request->input('filtrocontacto'),
            'referencia' => $request->input('filtroreferencia'),
            'isbn' => $request->input('filtroisbn'),
            'estado' => $request->input('filtroestado'),
        ];

        return Excel::download(
            new OfertasExport($filters),
            'presupuestosmilimetica.xlsx'
        );
    }

}
