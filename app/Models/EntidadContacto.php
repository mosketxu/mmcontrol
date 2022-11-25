<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EntidadContacto extends Model
{
    protected $fillable = ['entidad_id','contacto_id','departamento','comentarios'];

    public function entidadcontacto()
    {
        return $this->belongsTo(Entidad::class,'contacto_id','id')->orderBy('entidad','ASC');
    }
}
