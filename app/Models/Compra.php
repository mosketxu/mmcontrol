<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Compra extends Model
{
    use HasFactory;
    protected $table = 'compras';

    protected $fillable=['id','tipo','anyo','numero','codigo','fecha','fechaentrega','proveedor_id','descripcion','producto_id','precio','ud_precio','cantidad','total','observaciones'];

    protected $casts = [
        'fecha' => 'date',
        'fechaentrega' => 'date',
    ];

    public function scopeInYear($query, $year){
        return $query->whereBetween('fecha', [
            Carbon::create($year)->startOfYear(),
            Carbon::create($year)->endOfYear(),
        ]);
    }

    public function proveedor(){return $this->belongsTo(Entidad::class,'proveedor_id','id')->withDefault(['entidad'=>'-']);}
    public function producto(){return $this->belongsTo(Producto::class, 'producto_id');}

    public function archivos(){return $this->hasMany(CompraArchivo::class,'compra_id','id');}
    public function albaran(){return $this->hasMany(CompraAlbaran::class,'compra_id','id');}
    public function distribucion(){return $this->hasMany(CompraDistribucion::class,'compra_id','id');}

    // Colores de los iconos del menu de compra (compras/compra-menu.blade.php),
    // mismo patron visual que Pedido::get*ColorAttribute() pero comprobando la
    // relacion directamente en vez de columnas "hay*" (compras no las tiene).
    public function getAlbaranescolorAttribute(){
        return $this->albaran()->exists()
            ? ['text-orange-500','text-orange-800']
            : ['text-gray-300','text-gray-500'];
    }

    public function getDistribucionescolorAttribute(){
        return $this->distribucion()->exists()
            ? ['text-blue-500','text-blue-800']
            : ['text-gray-300','text-gray-500'];
    }

    public function getArchivoscolorAttribute(){
        return $this->archivos()->exists()
            ? ['text-green-500','text-green-800']
            : ['text-gray-300','text-gray-500'];
    }
    }
