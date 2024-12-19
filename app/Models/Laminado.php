<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laminado extends Model
{
    use HasFactory;

    protected $fillable = ['name','descripcion',];
    public function pedidos(){return $this->hasMany(Pedido::class);}
}
