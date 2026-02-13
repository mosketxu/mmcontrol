<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Caja extends Model
{
    use HasFactory;

    protected $fillable = ['name','descripcion','familia','tipo'];

    public function caja(){return $this->hasMany(Producto::class);}


}
