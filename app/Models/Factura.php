<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Factura extends Model
{
    use HasFactory;

    protected $fillable = ['id','cliente_id','contacto_id','fecha','pedidocliente','importe','iva','total','estado','observaciones'];

    public function cliente(){return $this->belongsTo(Entidad::class,'cliente_id','id');}
    public function contacto(){return $this->belongsTo(Entidad::class,'contacto_id','id');}
    public function facturadetalles(){return $this->hasMany(FacturaDetalle::class,'factura_id');}

    public function getStatusColorAttribute(){
        return [
            '0'=>['gray-200','Sin Enviar'],
            '1'=>['red-500','Env. P.cobro'],
            '2'=>['green-500','Cobrada']
        ][$this->estado] ?? ['gray-100',''];
    }

    public function getFfacturaAttribute(){
        if ($this->fecha) {
            return Carbon::parse($this->fecha)->format('d/m/y');
        } else {
            return '';
        }
    }

    public function getFfactura4Attribute(){
        if ($this->fecha) {
            return Carbon::parse($this->fecha)->format('d/m/Y');
        } else {
            return '';
        }
    }

    public function scopeInYear($query, $year){
        return $query->whereBetween('fecha', [
            Carbon::create($year)->startOfYear(),
            Carbon::create($year)->endOfYear(),
        ]);
    }
}
