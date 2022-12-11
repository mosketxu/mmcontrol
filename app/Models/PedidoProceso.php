<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PedidoProceso extends Model
{
    use HasFactory;

    protected $fillable=['pedido_id','proceso','descripcion','tirada','precio_ud','preciototal','orden','visible'];
    public function pedido(){return $this->belongsTo(Pedido::class,'pedido_id','id');}
}
