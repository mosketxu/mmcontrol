<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Carbon;

class CompraAlbaran extends Model
{
    use HasFactory;

    protected $table = 'compra_albaranes';

    protected $fillable = ['compra_id','fecha','cantidad','importe','comentario','destino','atencion','direccion','cp','localidad','horario','telefono','observaciones'];

    public function compra(){return $this->belongsTo(Compra::class,'compra_id');}
    public function albarandetalles(){return $this->hasMany(PedidoparcialDetalle::class,'parcial_id');}

    public function getFfechaAttribute(){
        if ($this->fecha) {
            return Carbon::parse($this->fecha)->format('d/m/Y');
        } else {
            return '';
        }
    }
}
