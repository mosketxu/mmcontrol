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
    public static function de(string $clave, $tipo = null, $contexto = null): array
    {
        return Cache::remember("sugerencias.$clave.$tipo.$contexto", 300, function () use ($clave, $tipo, $contexto) {
            try {
                return self::calcular($clave, $tipo, $contexto);
            } catch (\Throwable $e) {
                return [];
            }
        });
    }

    /** Productos que aparecen de verdad en el listado ($contexto), para no sugerir valores que dejarían el listado vacío. */
    private static function productos($tipo, $contexto)
    {
        $q = DB::table('productos')->select('productos.isbn', 'productos.referencia')->distinct();
        switch ($contexto) {
            case 'presupuestos':
                return $q->join('presupuesto_productos', 'presupuesto_productos.producto_id', '=', 'productos.id')
                    ->join('presupuestos', 'presupuestos.id', '=', 'presupuesto_productos.presupuesto_id')
                    ->when($tipo, fn ($x) => $x->where('presupuestos.tipo', $tipo));
            case 'pedidos':
                return $q->join('pedido_productos', 'pedido_productos.producto_id', '=', 'productos.id')
                    ->join('pedidos', 'pedidos.id', '=', 'pedido_productos.pedido_id')
                    ->when($tipo, fn ($x) => $x->where('pedidos.tipo', $tipo));
            case 'ofertas':
                return $q->join('ofertas', 'ofertas.producto_id', '=', 'productos.id')
                    ->when($tipo, fn ($x) => $x->where('ofertas.tipo', $tipo));
            case 'compras':
                return $q->join('compras', 'compras.producto_id', '=', 'productos.id');
        }
        return $q->when($tipo, fn ($x) => $x->where('productos.tipo', $tipo));
    }

    private static function calcular(string $clave, $tipo, $contexto = null): array
    {
        switch ($clave) {
            case 'anyos':
                return collect(range((int) date('Y') + 1, 2018))->map(fn ($a) => ['id' => (string) $a, 'label' => (string) $a])->all();
            case 'isbn':
                return self::productos($tipo, $contexto)->whereNotNull('productos.isbn')->where('productos.isbn', '!=', '')
                    ->orderBy('productos.isbn')->get()
                    ->map(fn ($p) => ['id' => $p->isbn, 'label' => $p->isbn . ' · ' . $p->referencia])->all();
            case 'referencia':
                return self::productos($tipo, $contexto)->whereNotNull('productos.referencia')->where('productos.referencia', '!=', '')
                    ->orderBy('productos.referencia')->get()->pluck('referencia')->map(fn ($r) => trim($r))->unique()
                    ->map(fn ($r) => ['id' => $r, 'label' => $r])->values()->all();
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
