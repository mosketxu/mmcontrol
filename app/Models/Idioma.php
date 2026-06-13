<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Idioma extends Model
{
    use HasFactory;

    protected $fillable = ['codigo','nombre',];

    public function productos(){return $this->hasMany(Producto::class, 'idioma_id');}
    public function presupuestos(){return $this->hasMany(Presupuesto::class, 'idioma_id');}
    public function pedidos(){return $this->hasMany(Pedido::class, 'idioma_id');}

}
