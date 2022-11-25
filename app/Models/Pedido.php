<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Carbon;

class Pedido extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $fillable=['id','tipo','responsable','cliente_id','pedidocliente','oferta_id','contacto_id','facturadopor_id','proveedor_id','producto_id','fechapedido','fechaarchivos','fechaplotter','fechaentrega',
                        'tiradaprevista','tiradareal','precio','preciototal','parcial','muestra','pruebacolor','estado','facturado','uds_caja','otros'
                        ];

    public function cliente(){return $this->belongsTo(Entidad::class,'cliente_id','id')->withDefault(['entidad'=>'-']);}
    public function proveedor(){return $this->belongsTo(Entidad::class,'proveedor_id','id')->withDefault(['entidad'=>'-']);}
    public function contacto(){return $this->belongsTo(Entidad::class,'contacto_id','id')->withDefault(['entidad'=>'-']);}
    public function producto(){return $this->belongsTo(Producto::class,'producto_id','id');}

    public function parciales(){return $this->hasMany(PedidoParcial::class,'pedido_id','id');}
    public function archivos(){return $this->hasMany(PedidoArchivo::class,'pedido_id','id');}
    public function incidencias(){return $this->hasMany(PedidoIncidencia::class,'pedido_id','id');}
    public function presupuestos(){return $this->hasMany(PedidoPresupuesto::class,'pedido_id','id');}
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
            '0'=>['red-500','No'],
            '1'=>['green-500','Sí'],
            '2'=>['yellow-400','Parcial']
        ][$this->facturado] ?? ['gray-100',''];
    }



    public function getRutaficheroAttribute()
    {
        return $this->ruta.'/'.$this->fichero;
    }

    public function scopeImprimirpedido()
    {
        $pedido=Pedido::with('entidad')->find($this->id);

        $pdf = \PDF::loadView('pedido.pedidopdf', compact(['pedido']));

        Storage::put('public/'.$pedido->ruta.'/'.$pedido->fichero, $pdf->output());

        return $pdf->download($pedido->fichero);
    }

    public function getFPedidoAttribute()
    {
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
}
