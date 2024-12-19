<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PedidoSubpedido extends Model
{
    use HasFactory;

    protected $table = 'pedido_subpedidos';

    // Campos asignables masivamente
    protected $fillable = ['pedido_id','referencia','unidades','otros','fecha_archivos','fecha_plotters','fecha_entrega'];

    /**
     * Relación con el modelo Pedido (muchos a uno).
     */
    public function pedido(){return $this->belongsTo(Pedido::class, 'pedido_id');}

}
