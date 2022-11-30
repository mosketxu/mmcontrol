<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PedidoProducto extends Model
{
    use HasFactory;

    use HasFactory;

    protected $fillable=['pedido_id','producto_id','tirada','precio_ud','preciototal'];
    public function pedido(){return $this->belongsTo(Pedido::class,'pedido_id','id');}
    public function producto(){return $this->belongsTo(Producto::class,'producto_id','id');}

}
