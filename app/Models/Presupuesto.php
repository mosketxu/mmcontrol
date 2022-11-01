<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Presupuesto extends Model
{
    use HasFactory;

    protected $fillable = ['pedido_id','proveedor_id','producto_id','fecha','cantidad','importe','comentario'];

    public function pedido()
    {
        return $this->belongsTo(Pedido::class,'pedido_id');
    }
}
