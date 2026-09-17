<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CuentaBancaria extends Model
{
    use HasFactory;

    protected $table = 'cuentas_bancarias';

    protected $fillable = ['iban', 'bic', 'moneda', 'es_defecto'];

    protected $casts = [
        'es_defecto' => 'boolean',
    ];

    public function entidades()
    {
        return $this->hasMany(Entidad::class);
    }
}
