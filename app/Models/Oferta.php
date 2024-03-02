        <?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Oferta extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $fillable=['id','cliente_id','contacto_id','tipo','descripcion','fecha','producto_id','manipulacion'
    ,'acabado','material','medidas','impresion','embalaje','transporte','troquel','entrega','observaciones','estado'];

    public function ofertadetalles(){return $this->hasMany(OfertaDetalle::class,'oferta_id','id');}
    public function ofertaproductos(){return $this->hasMany(OfertaProducto::class,'oferta_id','id');}
    public function ofertaprocesos(){return $this->hasMany(OfertaProceso::class,'oferta_id','id');}
    public function cliente( ){return $this->belongsTo(Entidad::class,'cliente_id','id')->withDefault(['entidad'=>'-']);}
    public function ofertaproducto(){return $this->belongsTo(Producto::class,'producto_id','id');}
    public function contacto(){return $this->belongsTo(Entidad::class,'contacto_id','id')->withDefault(['entidad'=>'-']);}


    public function getStatusColorAttribute(){
        return [
            '0'=>['gray-200','En Espera'],
            '1'=>['green-500','Aceptada'],
            '2'=>['red-500','Rechazada']
        ][$this->estado] ?? ['gray-100',''];
    }

    public function getFfechaAttribute(){
        if ($this->fecha) {
            return Carbon::parse($this->fecha)->format('d/m/Y');
        } else {
            return '';
        }
    }

    public function getFfecha2Attribute(){
        if ($this->fecha) {
            return Carbon::parse($this->fecha)->format('d/m/y');
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
