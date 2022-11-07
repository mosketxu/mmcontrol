<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PedidoFacturacion extends Model
{
    use HasFactory;

    protected $table = 'pedido_facturaciones';

    public $incrementing = false;

    protected $fillable = ['id','pedido_id','cliente_id','fecha','cantidad','importe','estado','comentario'];

    public function pedido(){return $this->belongsTo(Pedido::class,'pedido_id');}
    public function cliente(){return $this->belongsTo(Entidad::class,'cliente_id');}
}
