<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PedidoRetraso extends Model
{
    use HasFactory;

    protected $fillable = ['pedido_id','fecha','cantidad','importe','comentario','tipo'];

    public function pedido()
    {
        return $this->belongsTo(Pedido::class,'pedido_id');
    }
}
