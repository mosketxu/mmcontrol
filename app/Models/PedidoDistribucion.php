<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PedidoDistribucion extends Model
{
    use HasFactory;

    protected $table = 'pedido_distribuciones';

    protected $fillable = ['pedido_id','fecha','cantidad','importe','comentario'];

    public function pedido()
    {
        return $this->belongsTo(Pedido::class,'pedido_id');
    }

}
