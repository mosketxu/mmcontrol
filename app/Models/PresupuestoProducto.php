<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PresupuestoProducto extends Model
{
    use HasFactory;

    protected $fillable=['presupuesto_id','producto_id','tirada','precio_ud','preciototal','observaciones','orden','visible'];
    public function presupuesto(){return $this->belongsTo(Presupuesto::class,'presupuesto_id','id');}
    public function producto(){return $this->belongsTo(Producto::class,'producto_id','id');}

}
