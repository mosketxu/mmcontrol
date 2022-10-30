<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;
    protected $table = 'productos';

    protected $fillable=['cliente_id','tipo','isbn','referencia','preciocoste','tirada','formato','FSC','materialinterior','tintainterior',
    'gramajeinterior','paginas','materialcubierta','tintacubierta','gramajecubierta','plastificado','solapa','descripsolapa','guardas','descripguardas',
    'cd','descripcd','novedad','descripnovedad','caja','udxcaja','especiflogistica','precioventa','observaciones'];

    public function cliente(){return $this->belongsTo(Entidad::class,'cliente_id','id')->withDefault(['entidad'=>'-']);}
    public function proveedor(){return $this->belongsTo(Entidad::class,'proveedor_id','id')->withDefault(['entidad'=>'-']);}
}

