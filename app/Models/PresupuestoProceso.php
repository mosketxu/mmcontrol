<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PresupuestoProceso extends Model
{
    use HasFactory;

    protected $fillable=['presupuesto_id','proceso','descripcion','tirada','precio_ud','preciototal','orden','visible'];
    public function presupuesto(){return $this->belongsTo(Presupuesto::class,'presupuesto_id','id');}
}


