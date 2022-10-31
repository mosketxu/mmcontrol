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
    'cd','descripcd','novedad','descripnovedad','caja','udxcaja','especiflogistica','precioventa','observaciones'];

    public function cliente(){return $this->belongsTo(Entidad::class,'cliente_id','id')->withDefault(['entidad'=>'-']);}
    public function proveedor(){return $this->belongsTo(Entidad::class,'proveedor_id','id')->withDefault(['entidad'=>'-']);}
    // public function fmto(){return $this->belongsTo(Formato::class,'formato_id','id')->withDefault(['name'=>'-']);}
    // public function materialinterior(){return $this->belongsTo(Material::class,'materialinterior_id','id')->withDefault(['name'=>'-']);}
    // public function tintainterior(){return $this->belongsTo(Tinta::class,'tintainterior_id','id')->withDefault(['name'=>'-']);}
    // public function gramajeinterior(){return $this->belongsTo(Gramaje::class,'gramajeinterior_id','id')->withDefault(['name'=>'-']);}
    // public function materialcubierta(){return $this->belongsTo(Material::class,'materialcubierta_id','id')->withDefault(['name'=>'-']);}
    // public function tintacubierta(){return $this->belongsTo(Tinta::class,'tintacubierta_id','id')->withDefault(['name'=>'-']);}
    // public function gramajecubierta(){return $this->belongsTo(Gramaje::class,'gramajecubierta_id','id')->withDefault(['name'=>'-']);}
    // public function plastificado(){return $this->belongsTo(Plastificado::class,'plastificado_id','id')->withDefault(['name'=>'-']);}
    // public function encuadernado(){return $this->belongsTo(Encuadernacion::class,'encuadernado_id','id')->withDefault(['name'=>'-']);}
    // public function caja(){return $this->belongsTo(Caja::class,'caja_id','id')->withDefault(['name'=>'-']);}
}

