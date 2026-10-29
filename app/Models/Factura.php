<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Factura extends Model
{
    use HasFactory;

    public const ESTADOS = [
        '0' => ['gray-200', 'Sin Enviar'],
        '1' => ['red-200', 'Env. P.cobro'],
        '2' => ['green-200', 'Cobrada'],
    ];

    protected $fillable = ['id','cliente_id','contacto_id','fecha','fechavencimiento','pedidocliente','importe','iva','total','estado','tipo','observaciones','validada_at'];

    protected $casts = ['validada_at' => 'datetime', 'datos_congelados_at' => 'datetime', 'pdf_generado_at' => 'datetime'];

    public function cliente(){return $this->belongsTo(Entidad::class,'cliente_id','id');}
    public function contacto(){return $this->belongsTo(Entidad::class,'contacto_id','id');}
    public function facturadetalles(){return $this->hasMany(FacturaDetalle::class,'factura_id');}

    // Prefactura = borrador (aún sin «Crear factura»).
    public function esPrefactura(){ return $this->validada_at === null; }

    // Factura creada y ya pasada la fecha de cierre: no se puede modificar.
    public function estaCerrada(){
        return $this->validada_at !== null && now()->gte(Carbon::parse(config('facturacion.cierre'))->startOfDay());
    }

    // Huella del contenido que sale en el PDF (cabecera, líneas y datos del cliente). No cuenta el estado de cobro.
    public function huellaContenido(){
        $cab=collect($this->only(['cliente_id','contacto_id','fecha','fechavencimiento','pedidocliente','importe','iva','total','tipo','observaciones',
            'cli_entidad','cli_direccion','cli_cp','cli_localidad','cli_nif','cli_iban','cli_bic','cli_moneda']))->map(fn($v)=>(string)$v)->all();
        $lineas=$this->facturadetalles()->orderBy('id')->get()->map(fn($d)=>collect($d->only(['pedido_id','concepto','cantidad','importe','iva',
            'subtotalsiniva','subtotaliva','subtotal','orden','visible','observaciones']))->map(fn($v)=>(string)$v)->all())->all();
        return sha1(json_encode([$cab,$lineas]));
    }

    // PDF ya fijado y la factura se ha modificado después: el PDF guardado no refleja los cambios hasta validarla.
    public function pdfDesactualizado(){
        return $this->pdf_path && $this->pdf_huella && $this->pdf_huella !== $this->huellaContenido();
    }

    // Foto de los datos del cliente con los que sale la factura (se toma al crearla o al cambiar de cliente).
    public function congelarDatosCliente($origen='emision'){
        $c=$this->cliente()->first();
        $cb=$c ? $c->cuentaBancaria : null;
        $this->forceFill([
            'cli_entidad'=>$c->entidad ?? null, 'cli_direccion'=>$c->direccion ?? null, 'cli_cp'=>$c->cp ?? null,
            'cli_localidad'=>$c->localidad ?? null, 'cli_nif'=>$c->nif ?? null,
            'cli_iban'=>$cb->iban ?? null, 'cli_bic'=>$cb->bic ?? null, 'cli_moneda'=>$cb->moneda ?? null,
            'datos_origen'=>$origen, 'datos_congelados_at'=>now(),
        ])->save();
    }

    // Datos del cliente para el PDF: la foto si existe; si no, los del cliente en vivo.
    public function datosCliente(){
        if($this->datos_congelados_at){
            return (object)['entidad'=>$this->cli_entidad,'direccion'=>$this->cli_direccion,'cp'=>$this->cli_cp,
                'localidad'=>$this->cli_localidad,'nif'=>$this->cli_nif,
                'iban'=>$this->cli_iban,'bic'=>$this->cli_bic,'moneda'=>$this->cli_moneda];
        }
        $c=$this->cliente; $cb=$c ? $c->cuentaBancaria : null;
        return (object)['entidad'=>$c->entidad ?? null,'direccion'=>$c->direccion ?? null,'cp'=>$c->cp ?? null,
            'localidad'=>$c->localidad ?? null,'nif'=>$c->nif ?? null,
            'iban'=>$cb->iban ?? null,'bic'=>$cb->bic ?? null,'moneda'=>$cb->moneda ?? null];
    }

    public function getStatusColorAttribute(){
        return self::ESTADOS[$this->estado] ?? ['gray-100',''];
    }

    public function getFacturaTipoAttribute(){
        return [
            '1'=>['gray-200','Editorial'],
            '2'=>['red-200','Packaging'],
            '3'=>['green-200','Propios']
        ][$this->tipo] ?? ['gray-100',''];
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

    public function getFfacturavtoAttribute(){
        if ($this->fechavencimiento) {
            return Carbon::parse($this->fechavencimiento)->format('d/m/y');
        } else {
            return '';
        }
    }

    public function getFfacturavto4Attribute(){
        if ($this->fechavencimiento) {
            return Carbon::parse($this->fechavencimiento)->format('d/m/Y');
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
