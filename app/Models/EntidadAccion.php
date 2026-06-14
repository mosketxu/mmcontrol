<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EntidadAccion extends Model
{
    use HasFactory;

    protected $table = 'entidad_acciones';

    protected $fillable = [
        'entidad_id',
        'contacto_id',
        'nombre',
        'accion',
        'descripcion',
        'fechaaccion',
        'proximaaccion',
    ];

    protected $casts = [
        'fechaaccion' => 'date',
    ];

    public function entidad()
    {
        return $this->belongsTo(Entidad::class, 'entidad_id', 'id');
    }

    public function contacto()
    {
        return $this->belongsTo(EntidadContacto::class, 'contacto_id', 'id');
    }
}
