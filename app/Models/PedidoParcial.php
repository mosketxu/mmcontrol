<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Carbon;

class PedidoParcial extends Model
{
    use HasFactory;

    protected $table = 'pedido_parciales';

    protected $fillable = ['pedido_id','fecha','cantidad','importe','comentario','destino','atencion','direccion','cp','localidad','horario','telefono','observaciones'];

    public function pedido(){return $this->belongsTo(Pedido::class,'pedido_id');}
    public function parcialdetalles(){return $this->hasMany(PedidoparcialDetalle::class,'parcial_id');}

    public function getFfechaAttribute(){
        if ($this->fecha) {
            return Carbon::parse($this->fecha)->format('d/m/Y');
        } else {
            return '';
        }
    }

}
