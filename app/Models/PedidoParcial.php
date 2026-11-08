<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Carbon;

class PedidoParcial extends Model
{
    use HasFactory;

    protected $table = 'pedido_parciales';

    protected $fillable = ['pedido_id','fecha','cantidad','importe','comentario','destino','atencion','direccion','cp','localidad','horario','telefono','observaciones'];

    public function pedido(){return $this->belongsTo(Pedido::class,'pedido_id');}
    public function parcialdetalles(){return $this->hasMany(PedidoparcialDetalle::class,'parcial_id');}

    // Precio unidad del pedido para una línea del albarán: producto del pedido con la misma referencia (o el único producto);
    // si el producto no tiene precio, el precio del pedido. Sin productos en el pedido: el precio del pedido. 0 = no se sabe.
    public function precioDelPedido($concepto){
        $pedido=$this->pedido;
        if(!$pedido) return 0;
        $pps=$pedido->pedidoproductos()->with('producto')->orderBy('orden')->orderBy('id')->get();
        if($pps->isEmpty()) return (float)$pedido->precio;
        $pp=$pps->first(function($x) use($concepto){
            $ref=trim((string)optional($x->producto)->referencia);
            return $ref!=='' && stripos((string)$concepto,$ref)===0;
        });
        if(!$pp && $pps->count()===1) $pp=$pps->first();
        if(!$pp) return 0;
        return (float)$pp->precio_ud>0 ? (float)$pp->precio_ud : (float)$pedido->precio;
    }

    public function facturadetalles(){return $this->hasMany(FacturaDetalle::class,'parcial_id');}

    // Líneas del albarán aún sin pasar a ninguna factura (cuenta solo las que tienen vínculo por línea).
    public function lineasPendientes(){
        return $this->parcialdetalles()->whereDoesntHave('facturadetalle');
    }

    // 'no' | 'parcial' | 'total'
    public function estadoFacturacion(){
        $tot=$this->parcialdetalles()->count();
        if(!$tot) return 'no';
        $fact=$tot-$this->lineasPendientes()->count();
        return $fact==0 ? 'no' : ($fact==$tot ? 'total' : 'parcial');
    }

    public function getFfechaAttribute(){
        if ($this->fecha) {
            return Carbon::parse($this->fecha)->format('d/m/Y');
        } else {
            return '';
        }
    }

}
