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
        $p = $oferta->ofertaproducto;
        if($tipo=='1'){
            // $lineascabecera=$oferta->ofertaproducto->formato!='' ? $lineascabecera+1 : $lineascabecera;
            $lineascabecera += ($p && $p->formato!='') ? 1 : 0;
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
            $salto = max(1, $limite - $lineascabecera);
            $primera=1;
            $cont=0;
            $controlsaltopag2=30;
        }elseif($tipo=='2'){
            $p = $oferta->ofertaproducto ?? null;

            // el maximo de $lineasoferta serian 17;
            $limite = 18;
            $lineas = 0;
            $lineasoferta = 0;
            $salto=0;
            $controlsaltopag2 = 30;

            $hayCaja = false;
            $hayNido = false;
            $bloques = [];
            $countbloques = 0;

            if($p){
                $hayCaja = $p->caja_id!='' || $p->medidas!='' || $p->desarrollocaja!='' || $p->material!='' || $p->gramajecaja!='' || $p->impresion!='' || $p->acabadocaja!='';
                $hayNido = $p->medidasnido!='' || $p->materialnido!='' || $p->impresionnido!='';
                if($p->procesospack!='') {$bloques['Procesos'] = nl2br(e($p->procesospack));}
                if($p->manipulacion!='') {$bloques['Manipulación'] = nl2br(e($p->manipulacion));}
                if($p->observaciones!='') {$bloques['Observaciones'] = nl2br(e($p->observaciones));}
                $countbloques = count($bloques);

                if($p->isbn != '' || $p->referencia != '') $lineascabecera++;
                if($p->caja_id != '') $lineascabecera++;
                if($p->medidas != '') $lineascabecera++;
                if($p->desarrollocaja != '') $lineascabecera++;
                if($p->material != '') $lineascabecera++;
                if($p->gramajecaja != '') $lineascabecera++;
                if($p->impresion != '') $lineascabecera++;
                if($p->acabadocaja != '') $lineascabecera++;
                if($p->medidasnido != '') $lineascabecera++;
                if($p->materialnido != '') $lineascabecera++;
                if($p->impresionnido != '') $lineascabecera++;
                if($p->procesospack != '') $lineascabecera += 2;
                if($p->manipulacion != '') $lineascabecera += 2;
                if($p->observaciones != '') $lineascabecera += 2;
                // $salto=$limite-$lineascabecera;

                $primera=1;
                $cont=0;
                $controlsaltopag2=30;
                $lineasoferta=$oferta->ofertadetalles->count();
                $lineas=$lineasoferta + $lineascabecera;
                // $salto=$limite-$lineascabecera;
                // $salto=$limite-$lineas;
                $salto = max(1, $limite-$lineas);
                }else{
                    $lineas = $oferta->ofertadetalles->count() + $lineascabecera;
                    $salto = max(1, $limite-$lineas);
            }

            $paginas = $limite ? ceil($lineas / $limite) : 1;
            $pagina=0;
            $primera=1;
            $cont=0;
        }

        // $pdf = new Dompdf();
        // $options = new Options();
        // $options->set('isHtml5ParserEnabled', true);
        // $options->set('isRemoteEnabled', true);
        // $pdf->setOptions($options);

        // $vista= $oferta->tipo=='1' ? 'oferta.ofertaeditorialpdf' : 'oferta.ofertaotrospdf';
        if($tipo=='1')
            $pdf = \PDF::loadView('oferta.ofertaeditorialpdf', compact('oferta','lineascabecera','lineas','lineasoferta','salto','primera','cont','controlsaltopag2'));
        else
            $pdf = \PDF::loadView('oferta.ofertaotrospdf', compact('oferta','lineascabecera','lineas','lineasoferta','salto','paginas','pagina','primera','cont','controlsaltopag2','p','hayCaja','hayNido','bloques','countbloques'));
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
