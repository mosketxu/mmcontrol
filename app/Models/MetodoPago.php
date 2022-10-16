<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MetodoPago extends Model
{
    use HasFactory;

    protected $fillable = ['nombre','nombrecorto'];

    public $incrementing = false;
    public $timestamps = false;

    public function entidades()
    {
        return $this->hasMany(Entidad::class);
    }
}
