<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PresupuestoArchivo extends Model
{
    use HasFactory;

    protected $fillable = ['presupuesto_id','nombrearchivooriginal','archivo','comentario'];

    public function presupuesto()
    {
        return $this->belongsTo(Presupuesto::class,'presupuesto_id');
    }
}
