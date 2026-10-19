<?php

namespace App\Support;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

/**
 * Sugerencias de los buscadores de los listados (x-buscador sugerir="..."). Un solo sitio para todos.
 * Devuelve [['id'=>valor que se pone en el filtro, 'label'=>texto que se ve], ...]. Cache corta para no consultar en cada pintado.
 */
class Sugerencias
{
    public static function de(string $clave, $tipo = null): array
    {
        return Cache::remember("sugerencias.$clave.$tipo", 300, function () use ($clave, $tipo) {
            try {
                return self::calcular($clave, $tipo);
            } catch (\Throwable $e) {
                return [];
            }
        });
    }

    private static function calcular(string $clave, $tipo): array
    {
        switch ($clave) {
            case 'anyos':
                return collect(range((int) date('Y') + 1, 2018))->map(fn ($a) => ['id' => (string) $a, 'label' => (string) $a])->all();
            case 'isbn':
                return DB::table('productos')->when($tipo, fn ($q) => $q->where('tipo', $tipo))->whereNotNull('isbn')->where('isbn', '!=', '')
                    ->orderBy('isbn')->get(['isbn', 'referencia'])
                    ->map(fn ($p) => ['id' => $p->isbn, 'label' => $p->isbn . ' · ' . $p->referencia])->all();
            case 'referencia':
                return DB::table('productos')->when($tipo, fn ($q) => $q->where('tipo', $tipo))->whereNotNull('referencia')->where('referencia', '!=', '')
                    ->orderBy('referencia')->distinct()->pluck('referencia')
                    ->map(fn ($r) => ['id' => $r, 'label' => $r])->all();
            case 'presupuesto':
            case 'pedido':
            case 'oferta':
                $tabla = $clave . 's';
                return DB::table($tabla)->join('entidades', "$tabla.cliente_id", '=', 'entidades.id')
                    ->when($tipo, fn ($q) => $q->where("$tabla.tipo", $tipo))
                    ->orderByDesc("$tabla.id")->limit(3000)->get(["$tabla.id", 'entidades.entidad'])
                    ->map(fn ($r) => ['id' => (string) $r->id, 'label' => $r->id . ' · ' . $r->entidad])->all();
            case 'desc-pedido':
            case 'desc-oferta':
                $tabla = $clave === 'desc-pedido' ? 'pedidos' : 'ofertas';
                return DB::table($tabla)->when($tipo, fn ($q) => $q->where('tipo', $tipo))->whereNotNull('descripcion')->where('descripcion', '!=', '')
                    ->orderBy('descripcion')->distinct()->pluck('descripcion')->map(fn ($r) => ['id' => $r, 'label' => $r])->all();
        }
        return [];
    }
}
