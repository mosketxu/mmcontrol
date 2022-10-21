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
    protected $fillable=['entidad','entidadtipo_id','responsable_id','direccion','cp','localidad','provincia_id','pais_id',
                        'nif','tfno','emailgral','emailadm','emailaux','web','idioma',
                        'banco1','iban1','banco2','iban2','banco3','iban3','factor',
                        'metodopago_id','diafactura','diavencimiento',
                        'cuentactblepro','cuentactblecli','observaciones','estado','password'];

    public function pais(){ return $this->belongsTo(Pais::class);}
    public function provincia(){return $this->belongsTo(Provincia::class);}
    public function metodopago(){return $this->belongsTo(MetodoPago::class);}
    public function contactos(){return $this->hasMany(EntidadContacto::class)->withDefault(['contacto'=>'-']);}
    public function entidadtipo(){return $this->belongsTo(EntidadTipo::class);}
    // public function pedidos(){return $this->hasMany(Pedido::class);}
    // public function presupuestos(){return $this->hasMany(Presupuesto::class);}
    // public function presuplindetalleproveedor(){return $this->hasMany(PresupuestoLineaDetalle::class);}
    // public function productos(){return $this->hasMany(Producto::class);}
    // public function movimientos(){return $this->belongsTo(StockMovimiento::class);}
    public function responsable(){return $this->belongsTo(User::class,'responsable_id')->withDefault(['name'=>'-']);}


    public function scopeFiltrosEntidad(Builder $query, $search, $filtroresponsable, $entidadtipo_id,$fini,$ffin) : Builder
    {
        return $query ->search('entidad',$search)
        ->when($filtroresponsable!='', function ($query) use($filtroresponsable){
            $query->where('responsable_id',$filtroresponsable);
        })
        ->when($entidadtipo_id=='1', function ($query){
            $query->whereIn('entidadtipo_id',[1,3]);
        })
        ->when($entidadtipo_id=='2', function ($query){
            $query->whereIn('entidadtipo_id',[2,3]);
        })
        ->when($entidadtipo_id=='4', function ($query){
            $query->where('entidadtipo_id','4');
        })
        ->when(Auth::user()->hasRole('Responsable') ,function ($query){
            $query->where('responsable_id',Auth::user()->id);
        })
        ->when($fini && !$ffin, function ($query) use($fini){
            $query->where('fechacliente','>=', $fini);
        })
        ->when(!$fini && $ffin, function ($query) use($ffin){
            $query->where('fechacliente','<=', $ffin);
        })
        ->when($fini && $ffin, function ($query) use($fini,$ffin){
            $query->whereBetween('fechacliente', [$fini, $ffin]);
        })
        ->orSearch('nif',$search);
    }

    public function getFechacliAttribute()
    {
        if ($this->fechacliente) {
            return Carbon::parse($this->fechacliente)->format('d-m-Y');
        } else {
            return '';
        }
    }
}
