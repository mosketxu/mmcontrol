<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EntidadDestino extends Model
{
    use HasFactory;

    protected $fillable = ['entidad_id','destino','atencion','direccion','localidad','cp','horario','tfno','observaciones'];

    public function entidad(){return $this->belongsTo(Entidad::class,'entidad_id','id');}


}
