<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Carbon;

class Pedido extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $fillable=['id','tipo','cliente_id','descripcion','responsable','presupuesto_id','pedidocliente','oferta_id','contacto_id',
                    'proveedor_id','facturadopor','fechapedido','fechaarchivos','ctrarchivos','fechaplotter','ctrplotter','fechaentrega','ctrentrega',
                        'tiradaprevista','tiradareal','precio','preciototal','parcial','muestra','pruebacolor','estado','facturado','caja_id','uds_caja',
                        'transporte','otros'];

    public function cliente(){return $this->belongsTo(Entidad::class,'cliente_id','id')->withDefault(['entidad'=>'-']);}
    public function presupuesto(){return $this->belongsTo(Presupuesto::class,'presupuesto_id','id');}
    public function proveedor(){return $this->belongsTo(Entidad::class,'proveedor_id','id')->withDefault(['entidad'=>'-']);}
    public function contacto(){return $this->belongsTo(Entidad::class,'contacto_id','id')->withDefault(['entidad'=>'-']);}
    public function caja(){return $this->belongsTo(Caja::class,'caja_id','id')->withDefault(['caja'=>'']);}
    public function pedidoproductos(){return $this->hasMany(PedidoProducto::class,'pedido_id','id');}
    public function pedidoprocesos(){return $this->hasMany(PedidoProceso::class,'pedido_id','id');}

    public function parciales(){return $this->hasMany(PedidoParcial::class,'pedido_id','id');}
    public function archivos(){return $this->hasMany(PedidoArchivo::class,'pedido_id','id');}
    public function incidencias(){return $this->hasMany(PedidoIncidencia::class,'pedido_id','id');}
    public function retrasos(){return $this->hasMany(PedidoRetraso::class,'pedido_id','id');}
    public function distribuciones(){return $this->hasMany(PedidoDistribucion::class,'pedido_id','id');}
    public function facturadetalles(){return $this->hasMany(facturadetalle::class,'pedido_id','id');}


    public function getStatusColorAttribute(){
        return [
            '0'=>['gray-200','En curso'],
            '1'=>['green-500','Finalizado'],
            '2'=>['red-500','Anulado']
        ][$this->estado] ?? ['gray-100',''];
    }

    public function getFacturadoColorAttribute(){
        return [
            '0'=>['text-gray-300','text-gray-500'],
            '1'=>['text-green-500','text-green-800'],
            '2'=>['text-blue-500','text-blue-800']
        ][$this->facturado] ?? ['text-gray-300',''];
    }

    public function getIncidenciasColorAttribute(){
        $hay=$this->incidencias->count()> '0' ? '1' : '0';
        return [
            '0'=>['text-gray-300','text-gray-500'],
            '1'=>['text-red-500','text-red-800'],
        ][$hay] ?? ['gray-500',''];
    }

    public function getRetrasosColorAttribute(){
        $hay=$this->retrasos->count()> '0' ? '1' : '0';
        return [
            '0'=>['text-gray-300','text-gray-500'],
            '1'=>['text-red-500','text-red-800'],
        ][$hay] ?? ['gray-500',''];
    }

    public function getParcialesColorAttribute(){
        $hay=$this->parciales->count()> '0' ? '1' : '0';
        return [
            '0'=>['text-gray-300','text-gray-500'],
            '1'=>['text-pink-500','text-pink-800'],
        ][$hay] ?? ['gray-500',''];
    }

    public function getDistribucionesColorAttribute(){
        $hay=$this->distribuciones->count()> '0' ? '1' : '0';
        return [
            '0'=>['text-gray-300','text-gray-500'],
            '1'=>['text-orange-500','text-orange-800'],
        ][$hay] ?? ['gray-500',''];
    }

    public function getArchivosColorAttribute(){
        $hay=$this->archivos->count()> '0' ? '1' : '0';
        return [
            '0'=>['text-gray-300','text-gray-500'],
            '1'=>['text-green-500','text-green-800'],
        ][$hay] ?? ['gray-500',''];
    }

    public function getCtrlArchivosColorAttribute(){
        return [
            '0'=>['text-red-500','text-red-500'],
            '1'=>['text-green-500','text-green-800'],
        ][$this->ctrarchivos] ?? ['text-red-500','text-red-500'];
    }

    public function getCtrlPlotterColorAttribute(){
        return [
            '0'=>['text-red-500','text-red-500'],
            '1'=>['text-green-500','text-green-800'],
        ][$this->ctrplotter] ?? ['text-red-500',''];
    }

    public function getCtrlEntregaColorAttribute(){
        return [
            '0'=>['text-red-500','text-red-500'],
            '1'=>['text-green-500','text-green-800'],
        ][$this->ctrentrega] ?? ['text-red-500',''];
    }

    public function getRutaficheroAttribute(){
        return $this->ruta.'/'.$this->fichero;
    }

    public function scopeImprimirpedido(){
        $pedido=Pedido::with('entidad')->find($this->id);
        $pdf = \PDF::loadView('pedido.pedidopdf', compact(['pedido']));
        Storage::put('public/'.$pedido->ruta.'/'.$pedido->fichero, $pdf->output());
        return $pdf->download($pedido->fichero);
    }

    public function getFPedidoAttribute(){
        if ($this->fechapedido) {
            return Carbon::parse($this->fechapedido)->format('d/m/y');
        } else {
            return '';
        }
    }

    public function getFPedido4Attribute(){
        if ($this->fechapedido) {
            return Carbon::parse($this->fechapedido)->format('d/m/Y');
        } else {
            return '';
        }
    }

    public function getFArchivosAttribute(){
        if ($this->fechaarchivos) {
            return Carbon::parse($this->fechaarchivos)->format('d/m/y');
        } else {
            return '';
        }
    }

    public function getFArchivos4Attribute(){
        if ($this->fechaarchivos) {
            return Carbon::parse($this->fechaarchivos)->format('d/m/Y');
        } else {
            return '';
        }
    }

    public function getFPlotterAttribute(){
        if ($this->fechaplotter) {
            return Carbon::parse($this->fechaplotter)->format('d/m/y');
        } else {
            return '';
        }
    }

    public function getFPlotter4Attribute(){
        if ($this->fechaplotter) {
            return Carbon::parse($this->fechaplotter)->format('d/m/Y');
        } else {
            return '';
        }
    }

    public function getFEntregaAttribute(){
        if ($this->fechaentrega) {
            return Carbon::parse($this->fechaentrega)->format('d/m/y');
        } else {
            return '';
        }
    }

    public function getFEntrega4Attribute(){
        if ($this->fechaentrega) {
            return Carbon::parse($this->fechaentrega)->format('d/m/Y');
        } else {
            return '';
        }
    }

    public function getStatusAttribute(){
        return [
            '0'=>['text-blue-500','Curso'],
            '1'=>['text-green-500','Fin.'],
            '2'=>['text-red-500','Canc.']
        ][$this->estado] ?? ['text-gray-100','-'];
    }

    public function getFactuAttribute(){
        return [
            '0'=>['text-red-500','No'],
            '1'=>['text-green-500','Sí.'],
            '2'=>['text-blue-500','Parcial'],
        ][$this->estado] ?? ['text-gray-100','-'];
    }

    public function scopeInYear($query, $year){
        return $query->whereBetween('fechapedido', [
            Carbon::create($year)->startOfYear(),
            Carbon::create($year)->endOfYear(),
        ]);
    }
}
