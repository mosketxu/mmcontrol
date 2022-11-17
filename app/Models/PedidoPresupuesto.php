<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PedidoPresupuesto extends Model
{
    use HasFactory;

    protected $fillable = ['pedido_id','proveedor_id','fecha','cantidad','importe','comentario','tipo'];

    public function pedido()
    {
        return $this->belongsTo(Pedido::class,'pedido_id');
        return $this->belongsTo(Pedido::class,'pedido_id');
        return $this->hasMany(Producto::class,'producto_id');
    }
}
