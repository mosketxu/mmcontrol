<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PedidoParcial extends Model
{
    use HasFactory;

    protected $table = 'paises';

    protected $fillable = ['pedido_id','fecha','cantidad'];

    public function pedido()
    {
        return $this->belongsTo(Pedido::class,'pedido_id');
    }

}
