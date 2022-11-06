<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductoArchivo extends Model
{
    use HasFactory;

    protected $fillable = ['producto_id','nombrearchivooriginal','archivo','comentario'];

    public function producto()
    {
        return $this->belongsTo(Pedido::class,'producto_id');
    }
}
