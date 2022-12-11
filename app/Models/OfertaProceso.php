<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfertaProceso extends Model
{
    use HasFactory;
    protected $fillable=['oferta_id','proceso','descripcion','tirada','precio_ud','preciototal','orden','visible'];
    public function pedido(){return $this->belongsTo(Oferta::class,'oferta_id','id');}
}
