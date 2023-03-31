<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FacturaDetalle extends Model
{
    use HasFactory;

    protected $fillable = ['id','factura_id','pedido_id','importe','cantidad','subtotalsiniva','subtotaliva','subtotal','concepto','iva','orden','visible','observaciones'];

    public function factura(){return $this->belongsTo(Factura::class,'factura_id','id');}
    public function pedido(){return $this->belongsTo(Pedido::class,'factura_id');}


}
