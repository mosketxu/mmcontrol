<?php

namespace App\Http\Controllers;

use App\Models\Oferta;
use Dompdf\Dompdf;
use Dompdf\Options;

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
        $oferta=Oferta::with('cliente','contacto','ofertaproducto','ofertadetalles')->find($ofertaId);
        $lineascabecera=1; //Ref que es fijo
        if($tipo=='1'){
            $lineascabecera=$oferta->ofertaproducto->formato!='' ? $lineascabecera+1 : $lineascabecera;
            $lineascabecera=$oferta->ofertaproducto->paginas!='0' ? $lineascabecera+1 : $lineascabecera;
            $lineascabecera=$oferta->ofertaproducto->materialinterior!='' ? $lineascabecera+1 : $lineascabecera;
            $lineascabecera=$oferta->ofertaproducto->materialcubierta!='' ? $lineascabecera+2 : $lineascabecera;
            $lineascabecera=$oferta->ofertaproducto->encuadernado!='' ? $lineascabecera+1 : $lineascabecera;
            $lineascabecera=$oferta->ofertaproducto->plastificado!='' ? $lineascabecera+1 : $lineascabecera;
            $lineascabecera=$oferta->ofertaproducto->descripsolapa!='' ? $lineascabecera+1 : $lineascabecera;
            $lineascabecera=$oferta->ofertaproducto->descripguardas!='' ? $lineascabecera+1 : $lineascabecera;
            $lineascabecera=$oferta->ofertaproducto->manipulacion!='' ? $lineascabecera+1 : $lineascabecera;
            $lineascabecera=$oferta->ofertaproducto->tipoimpresion!='' ? $lineascabecera+1 : $lineascabecera;
            $lineascabecera=$oferta->ofertaproducto->FSC!='' ? $lineascabecera+1 : $lineascabecera;
            $lineascabecera=$oferta->ofertaproducto->observaciones!='' ? $lineascabecera+2 : $lineascabecera;
            // el maximo de $lineasoferta serian 14;
            $lineasoferta=$oferta->ofertadetalles->count();
            $lineas=$lineasoferta + $lineascabecera;
            //para una sola pagina en editorial empieza a quedar mal con 19
            $limite=18;
            $salto=$limite-$lineascabecera;
            $primera=1;
            $cont=0;
            $controlsaltopag2=30;
        }elseif($tipo='2'){
            $lineascabecera=$oferta->material!='' ? $lineascabecera+1 : $lineascabecera;
            $lineascabecera=$oferta->medidas!='' ? $lineascabecera+1 : $lineascabecera;
            $lineascabecera=$oferta->impresion!='' ? $lineascabecera+1 : $lineascabecera;
            $lineascabecera=($oferta->manipulacion!='' && $oferta->manipulacion!='-') ? $lineascabecera+1 : $lineascabecera;
            $lineascabecera=$oferta->embalaje!='' ? $lineascabecera+1 : $lineascabecera;
            $lineascabecera=$oferta->transporte!='' ? $lineascabecera+1 : $lineascabecera;

            $lineasoferta=$oferta->ofertaprocesos->count();
            $lineas=$lineasoferta + $lineascabecera;
            $limite=20;
            $salto=$limite-$lineascabecera;

            $paginas = ceil($lineas / $limite);
            $pagina=0;
            // dd($salto,$lineascabecera,$limite);
            // $salto=4;
            $primera=1;
            $cont=0;
            $controlsaltopag2=30;
        }

        // dd($isSinglePage);
        // $isLastPage = true; // Siempre se pasa como verdadero para la última página

        $pdf = new Dompdf();
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);
        $pdf->setOptions($options);

        $vista= $oferta->tipo=='1' ? 'oferta.ofertaeditorialpdf' : 'oferta.ofertaotrospdf';
        // $pdf = \PDF::loadView($vista, compact('oferta','isSinglePage', 'isLastPage'));
        if($tipo=='1')
            $pdf = \PDF::loadView('oferta.ofertaeditorialpdf', compact('oferta','lineascabecera','lineas','lineasoferta','lineascabecera','salto','primera','cont','controlsaltopag2'));
        else
            $pdf = \PDF::loadView('oferta.ofertaotrospdf', compact('oferta','lineascabecera','lineas','lineasoferta','lineascabecera','salto','paginas','pagina','primera','cont','controlsaltopag2'));
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
}
