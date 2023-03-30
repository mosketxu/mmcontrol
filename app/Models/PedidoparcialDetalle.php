<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PedidoparcialDetalle extends Model
{
    use HasFactory;

    protected $fillable = ['parcial_id','concepto','cantidad','precio_ud','total'];

    public function parcial()
    {
        return $this->belongsTo(PedidoParcial::class,'parcial_id');
    }
}
