<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Presupuesto extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $fillable=['id','tipo','cliente_id','responsable','contacto_id',
                    'proveedor_id','tirada','precio_ud','preciototal','facturadopor','fechapresupuesto',
                    'muestra','estado','espedido','uds_caja','otros'];

    public function cliente(){return $this->belongsTo(Entidad::class,'cliente_id','id')->withDefault(['entidad'=>'-']);}
    public function proveedor(){return $this->belongsTo(Entidad::class,'proveedor_id','id')->withDefault(['entidad'=>'-']);}
    public function contacto(){return $this->belongsTo(Entidad::class,'contacto_id','id')->withDefault(['entidad'=>'-']);}
    public function presupuestoproductos(){return $this->hasMany(PresupuestoProducto::class,'presupuesto_id','id');}

    public function getStatusColorAttribute(){
        return [
            '0'=>['gray-200','Enviado'],
            '1'=>['green-500','Aceptado'],
            '2'=>['red-500','Rechazado']
        ][$this->estado] ?? ['gray-100',''];
    }

    public function getFPresupuesto4Attribute()
    {
        if ($this->fechapresupuesto) {
            return Carbon::parse($this->fechapresupuesto)->format('d/m/Y');
        } else {
            return '';
        }
    }
}
