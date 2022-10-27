<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PedidoArchivo extends Model
{
    use HasFactory;

    protected $fillable = ['pedido_id','nombrearchivooriginal','archivo','comentario'];

    public function pedido()
    {
        return $this->belongsTo(Pedido::class,'pedido_id');
    }
}
