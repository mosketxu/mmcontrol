<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfertaDetalle extends Model
{
    use HasFactory;

    protected $fillable=['oferta_id','orden','titulo','concepto','cantidad','importe','total','observaciones'];

    public function oferta(){return $this->belongsTo(Oferta::class,'oferta_id','id');}

}
