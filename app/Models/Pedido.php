<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Carbon;



class Pedido extends Model
{
    use HasFactory;

    protected $dates = ['deleted_at'];

    protected $fillable=['pedido','responsable_id','cliente_id','proveedor_id','producto_id','fechapedido','fechaarchivos','fechaplotter','fechaentrega',
                        'tiradaprevista','tiradareal','parcial','estado','facturado','cd_dvd','distribucion','cajas','incidencias','retardos','otros'
                        ];

    public function cliente(){return $this->belongsTo(Entidad::class,'cliente_id','id');}
    public function proveedor(){return $this->belongsTo(Entidad::class,'proveedor_id','id');}
    public function responsable(){return $this->belongsTo(User::class,'responsable_id','id');}

    public function getFechapedAttribute(){return Carbon::parse($this->fechapedido)->format('d-m-Y');}
    public function getFechaarchAttribute(){return Carbon::parse($this->fechaarchivos)->format('d-m-Y');}
    public function getFechaplotdAttribute(){return Carbon::parse($this->fechaplotter)->format('d-m-Y');}
    public function getFechaentredAttribute(){return Carbon::parse($this->fechaentrega)->format('d-m-Y');}

    public function getStatusColorAttribute()
    {
        return [
            '0'=>['gray','En curso'],
            '1'=>['green','Finalizado'],
            '2'=>['red','Anulado']
        ][$this->estado] ?? ['gray',''];
    }



    public function getRutaficheroAttribute()
    {
        return $this->ruta.'/'.$this->fichero;
    }

    public function scopeImprimirpedido()
    {
        $pedido=Pedido::with('entidad')->find($this->id);

        $pdf = \PDF::loadView('pedido.pedidopdf', compact(['pedido']));

        Storage::put('public/'.$pedido->ruta.'/'.$pedido->fichero, $pdf->output());

        return $pdf->download($pedido->fichero);
    }
}
