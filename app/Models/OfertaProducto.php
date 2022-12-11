<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfertaProducto extends Model
{
    use HasFactory;

    protected $fillable=['oferta_id','producto_id','tirada','precio_ud','preciototal','observaciones','orden','visible'];
    public function oferta(){return $this->belongsTo(Oferta::class,'oferta_id','id');}
    public function producto(){return $this->belongsTo(Producto::class,'producto_id','id');}
}
