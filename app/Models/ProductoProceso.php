<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductoProceso extends Model
{
    use HasFactory;

    protected $fillable = ['producto_id','proceso','descripcion'];

    public function producto()
    {
        return $this->belongsTo(Producto::class,'producto_id');
    }

}

