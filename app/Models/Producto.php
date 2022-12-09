<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;
    protected $table = 'productos';

    protected $fillable=['cliente_id','tipo','isbn','referencia','preciocoste','tirada','formato','FSC','materialinterior','tintainterior',
    'gramajeinterior','paginas','materialcubierta','tintacubierta','gramajecubierta','plastificado','encuadernado','solapa','descripsolapa','guardas','descripguardas',
    'cd','descripcd','novedad','descripnovedad','caja_id','udxcaja','especiflogistica','precioventa',
    'material','medidas','troquel','impresion','observaciones'];

    public function cliente(){return $this->belongsTo(Entidad::class,'cliente_id','id')->withDefault(['entidad'=>'-']);}
    public function proveedor(){return $this->belongsTo(Entidad::class,'proveedor_id','id')->withDefault(['entidad'=>'-']);}
    public function archivos(){return $this->hasMany(ProductoArchivo::class,'producto_id','id');}
    public function procesos(){return $this->hasMany(ProductoProceso::class,'producto_id','id');}
    public function ofertas(){return $this->hasMany(Oferta::class,'producto_id','id');}
    public function caja(){return $this->belongsTo(Caja::class,'caja_id','id');}

}

