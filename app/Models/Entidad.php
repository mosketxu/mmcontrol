<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class Entidad extends Model
{
    use HasFactory;
    protected $table = 'entidades';
    protected $fillable=['entidad','entidadtipo_id','responsable','direccion','cp','localidad','provincia_id','pais_id',
                        'nif','tfno','emailgral','emailadm','emailaux','web',
                        'banco1','iban1','banco2','iban2',
                        'vencimientofechafactura','credito','empresacredito','importecredito','vigenciacredito',
                        'metodopago_id','diavencimiento','observaciones'];

    public function pais(){ return $this->belongsTo(Pais::class);}
    public function provincia(){return $this->belongsTo(Provincia::class);}
    public function metodopago(){return $this->belongsTo(MetodoPago::class);}
    public function contactos(){return $this->hasMany(EntidadContacto::class,'contacto_id');}
    public function destinos(){return $this->hasMany(EntidadDestino::class);}
    public function entidadtipo(){return $this->belongsTo(EntidadTipo::class);}
    public function productos(){return $this->hasMany(Producto::class,'cliente_id');}
    public function presupuestos(){return $this->hasMany(Presupuesto::class,'cliente_id');}
    public function ofertas(){return $this->hasMany(Oferta::class,'cliente_id');}


    public function scopeFiltrosEntidad(Builder $query, $search, $filtroresponsable, $entidadtipo_id,$fini,$ffin) : Builder
    {
        //creo que ya no lo uso porque meto las v
        return $query ->search('entidad',$search)
        ->when($filtroresponsable!='', function ($query) use($filtroresponsable){
            $query->where('responsable','like','%'.$filtroresponsable.'%');
        })
        //  para el valor 0 no pongo condicion, salen todos
        ->when($entidadtipo_id=='1', function ($query){
            $query->whereIn('entidadtipo_id',[1,2]);
        })
        ->when($entidadtipo_id=='2', function ($query){
            $query->whereIn('entidadtipo_id',[1,2,3]);
        })
        ->when($entidadtipo_id=='3', function ($query){
            $query->whereIn('entidadtipo_id',[2,3]);
        })
        ->when($entidadtipo_id=='4', function ($query){
            $query->where('entidadtipo_id','4');
        })
        ->when($fini && !$ffin, function ($query) use($fini){
            $query->where('created_at','>=', $fini);
        })
        ->when(!$fini && $ffin, function ($query) use($ffin){
            $query->where('created_at','<=', $ffin);
        })
        ->when($fini && $ffin, function ($query) use($fini,$ffin){
            $query->whereBetween('created_at', [$fini, $ffin]);
        })
        ->orSearch('nif',$search);
    }

    public function getFechacliAttribute()
    {
        if ($this->created_at) {
            return Carbon::parse($this->created_at)->format('d-m-Y');
        } else {
            return '';
        }
    }
}
