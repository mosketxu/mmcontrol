<?php

namespace App\Helpers;

use App\Models\Compra;
use Illuminate\Support\Facades\DB;

class CompraHelper
{
    public static function siguienteNumero(int $tipo, $fecha = null):array
    {
        // $fecha = $fecha ?? now();
        $fecha = $fecha ? \Carbon\Carbon::parse($fecha) : now();
        $anyo = $fecha->year;


        return DB::transaction(function () use ($anyo, $tipo) {

        $ultimo = Compra::where('anyo', $anyo)
            ->where('tipo', $tipo)
            ->lockForUpdate() // 🔐 evita duplicados concurrentes
            ->max('numero');

        $siguiente = ($ultimo ?? 0) + 1;

            return [
                'anyo'   => $anyo,
                'numero' => $siguiente,
                'codigo' => self::formatearCodigo($anyo, $siguiente, $tipo),
            ];
        });
    }

    public static function formatearCodigo(int $anyo, int $numero,int $tipo):string{
        if($tipo==='1')
            return sprintf('CO-ED-%d-%03d', $anyo, $numero);
        else
            return sprintf('CO-PK-%d-%03d', $anyo, $numero);
    }
}
