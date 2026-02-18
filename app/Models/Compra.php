<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    use HasFactory;
    protected $table = 'compras';

    protected $fillable=['id','tipo','fecha','proveedor_id','descripcion','producto_id','precio','ud_precio','cantidad','total','observaciones'];

    public function proveedor(){return $this->belongsTo(Entidad::class,'proveedor_id','id')->withDefault(['entidad'=>'-']);}

    public function archivos(){return $this->hasMany(CompraArchivo::class,'compra_id','id');}
    public function albaran(){return $this->hasMany(CompraAlbaran::class,'compra_id','id');}
    public function distribucion(){return $this->hasMany(CompraDistribucion::class,'compra_id','id');}


    }
