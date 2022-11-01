<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PedidoIncidencia extends Model
{
    protected $table = 'pedido_incidencias';

    protected $fillable = ['pedido_id','fecha','cantidad','importe','comentario','tipo'];

    public function pedido()
    {
        return $this->belongsTo(Pedido::class,'pedido_id');
    }
}
