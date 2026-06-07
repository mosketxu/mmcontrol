<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Idioma extends Model
{
    use HasFactory;

    protected $fillable = ['codigo','nombre',];

    public function productos(){return $this->hasMany(Producto::class, 'idioma', 'codigo');}

}
