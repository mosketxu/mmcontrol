<?php

namespace App\Support;

use Illuminate\Support\Facades\DB;

/**
 * Filtros acumulativos: las sugerencias de cada combo de un listado salen de los registros que cumplen los DEMÁS filtros
 * activos (el propio filtro no se aplica, para poder cambiarlo). Así nunca se sugiere un valor que dejaría el listado vacío.
 * Uso desde las vistas de filtros: <x-buscador faceta="isbn" contexto="presupuestos" :tipo="$tipo" :filtros="$fx"> y
 * <x-combo faceta="cliente" ...>, con $fx = Facetas::desde($__data).
 */
class Facetas
{
    /** Variable de la vista => nombre normalizado del filtro. */
    private const VARS = [
        'search' => 'numero', 'filtroisbn' => 'isbn', 'filtroreferencia' => 'referencia', 'filtrocliente' => 'cliente',
        'filtroidioma' => 'idioma', 'filtroproveedor' => 'proveedor', 'filtroestado' => 'estado', 'filtrookexterno' => 'okexterno',
        'filtroresponsable' => 'responsable', 'filtrofacturado' => 'facturado', 'filtrolaminado' => 'laminado', 'filtroanyo' => 'anyo',
        'filtromes' => 'mes', 'filtroTipo' => 'tipof', 'filtronif' => 'nif', 'filtroproductoestado' => 'productoestado', 'filtrocaja' => 'caja',
    ];

    public static function desde(array $data): array
    {
        $fx = [];
        foreach (self::VARS as $var => $clave) {
            if (isset($data[$var]) && is_scalar($data[$var]) && (string) $data[$var] !== '' && (string) $data[$var] !== '0') {
                $fx[$clave] = (string) $data[$var];
            } elseif (isset($data[$var]) && $var === 'filtroestado' && (string) $data[$var] === '0') {
                $fx[$clave] = '0';
            }
        }
        return $fx;
    }

    public static function opciones(string $contexto, $tipo, string $campo, array $fx): array
    {
        try {
            [$q, $filtros, $campos] = self::definicion($contexto, $tipo);
            if (!isset($campos[$campo])) return [];
            foreach ($fx as $clave => $valor) {
                if ($clave === $campo || !isset($filtros[$clave])) continue;
                $filtros[$clave]($q, $valor);
            }
            [$colid, $collabel] = $campos[$campo];
            $filas = $q->whereNotNull($colid)->where($colid, '!=', '')->select(DB::raw("$colid as vid"), DB::raw("$collabel as vlabel"))->distinct()
                ->orderBy('vlabel', in_array($campo, ['numero']) ? 'desc' : 'asc')->limit(3000)->get();
            return $filas->map(fn ($f) => ['id' => trim((string) $f->vid), 'label' => trim((string) $f->vlabel)])->unique('id')->values()->all();
        } catch (\Throwable $e) {
            return [];
        }
    }

    private static function like($col)
    {
        return fn ($q, $v) => $q->where($col, 'like', '%' . $v . '%');
    }

    private static function igual($col)
    {
        return fn ($q, $v) => $q->where($col, $v);
    }

    private static function definicion(string $contexto, $tipo): array
    {
        switch ($contexto) {
            case 'presupuestos':
                $q = DB::table('presupuestos')
                    ->join('presupuesto_productos', 'presupuesto_productos.presupuesto_id', '=', 'presupuestos.id')
                    ->join('productos', 'presupuesto_productos.producto_id', '=', 'productos.id')
                    ->join('entidades as c', 'presupuestos.cliente_id', '=', 'c.id')
                    ->leftJoin('entidades as pv', 'presupuestos.proveedor_id', '=', 'pv.id')
                    ->leftJoin('idiomas as i', 'presupuestos.idioma_id', '=', 'i.id')
                    ->when($tipo, fn ($x) => $x->where('presupuestos.tipo', $tipo));
                return [$q, [
                    'numero' => self::like('presupuestos.id'), 'isbn' => self::like('productos.isbn'), 'referencia' => self::like('productos.referencia'),
                    'cliente' => self::igual('presupuestos.cliente_id'), 'proveedor' => self::igual('presupuestos.proveedor_id'),
                    'idioma' => self::igual('presupuestos.idioma_id'), 'estado' => self::igual('presupuestos.estado'),
                    'okexterno' => self::igual('presupuestos.okexterno'), 'responsable' => self::like('presupuestos.responsable'),
                    'anyo' => fn ($x, $v) => $x->whereYear('presupuestos.fechapresupuesto', $v),
                    'mes' => fn ($x, $v) => $x->whereMonth('presupuestos.fechapresupuesto', $v),
                ], [
                    'numero' => ['presupuestos.id', "CONCAT(presupuestos.id, ' · ', c.entidad)"], 'isbn' => ['productos.isbn', "CONCAT(productos.isbn, ' · ', productos.referencia)"],
                    'referencia' => ['productos.referencia', 'productos.referencia'], 'cliente' => ['c.id', 'c.entidad'],
                    'proveedor' => ['pv.id', 'pv.entidad'], 'idioma' => ['i.id', 'i.nombre'],
                ]];
            case 'pedidos':
                $q = DB::table('pedidos')
                    ->join('entidades as c', 'pedidos.cliente_id', '=', 'c.id')
                    ->leftJoin('pedido_productos', 'pedido_productos.pedido_id', '=', 'pedidos.id')
                    ->leftJoin('productos', 'pedido_productos.producto_id', '=', 'productos.id')
                    ->leftJoin('entidades as pv', 'pedidos.proveedor_id', '=', 'pv.id')
                    ->leftJoin('idiomas as i', 'pedidos.idioma_id', '=', 'i.id')
                    ->when($tipo, fn ($x) => $x->where('pedidos.tipo', $tipo));
                return [$q, [
                    'numero' => self::like('pedidos.id'), 'isbn' => self::like('productos.isbn'), 'referencia' => self::like('productos.referencia'),
                    'cliente' => self::igual('pedidos.cliente_id'), 'proveedor' => self::igual('pedidos.proveedor_id'),
                    'idioma' => self::igual('pedidos.idioma_id'), 'responsable' => self::like('pedidos.responsable'),
                    'facturado' => self::igual('pedidos.facturado'), 'laminado' => self::igual('pedidos.laminado_id'),
                    // «3» = Todos los estados; sin elegir, el listado enseña los «En curso» (0)
                    'estado' => fn ($x, $v) => $v === '3' ? $x : $x->where('pedidos.estado', $v),
                    'anyo' => fn ($x, $v) => $x->whereYear('pedidos.fechapedido', $v),
                    'mes' => fn ($x, $v) => $x->whereMonth('pedidos.fechapedido', $v),
                ], [
                    'numero' => ['pedidos.id', "CONCAT(pedidos.id, ' · ', c.entidad)"], 'isbn' => ['productos.isbn', "CONCAT(productos.isbn, ' · ', productos.referencia)"],
                    'referencia' => ['productos.referencia', 'productos.referencia'], 'cliente' => ['c.id', 'c.entidad'],
                    'proveedor' => ['pv.id', 'pv.entidad'], 'idioma' => ['i.id', 'i.nombre'], 'responsable' => ['pedidos.responsable', 'pedidos.responsable'],
                ]];
            case 'ofertas':
                $q = DB::table('ofertas')
                    ->join('entidades as c', 'ofertas.cliente_id', '=', 'c.id')
                    ->leftJoin('productos', 'ofertas.producto_id', '=', 'productos.id')
                    ->when($tipo, fn ($x) => $x->where('ofertas.tipo', $tipo));
                $colref = $tipo == '2' ? 'ofertas.descripcion' : 'productos.referencia';
                return [$q, [
                    'numero' => self::like('ofertas.id'), 'isbn' => self::like('productos.isbn'), 'referencia' => self::like($colref),
                    'cliente' => self::igual('ofertas.cliente_id'), 'estado' => self::igual('ofertas.estado'),
                    'anyo' => fn ($x, $v) => $x->whereYear('ofertas.fecha', $v), 'mes' => fn ($x, $v) => $x->whereMonth('ofertas.fecha', $v),
                ], [
                    'numero' => ['ofertas.id', "CONCAT(ofertas.id, ' · ', c.entidad)"], 'isbn' => ['productos.isbn', "CONCAT(productos.isbn, ' · ', productos.referencia)"],
                    'referencia' => [$colref, $colref], 'cliente' => ['c.id', 'c.entidad'],
                ]];
            case 'facturas':
                $q = DB::table('facturas')->join('entidades as c', 'facturas.cliente_id', '=', 'c.id');
                return [$q, [
                    'numero' => self::like('facturas.id'), 'cliente' => self::igual('facturas.cliente_id'), 'tipof' => self::igual('facturas.tipo'),
                    'estado' => self::igual('facturas.estado'),
                    'anyo' => fn ($x, $v) => $x->whereYear('facturas.fecha', $v), 'mes' => fn ($x, $v) => $x->whereMonth('facturas.fecha', $v),
                ], [
                    'numero' => ['facturas.id', "CONCAT(facturas.id, ' · ', c.entidad, ' · ', DATE_FORMAT(facturas.fecha, '%d/%m/%Y'))"], 'cliente' => ['c.id', 'c.entidad'],
                ]];
            case 'productos':
                $q = DB::table('productos')->leftJoin('entidades as c', 'productos.cliente_id', '=', 'c.id')->leftJoin('idiomas as i', 'productos.idioma_id', '=', 'i.id')
                    ->when($tipo, fn ($x) => $x->where('productos.tipo', $tipo));
                return [$q, [
                    'isbn' => self::like('productos.isbn'), 'referencia' => self::like('productos.referencia'), 'cliente' => self::igual('productos.cliente_id'),
                    'idioma' => self::igual('productos.idioma_id'), 'productoestado' => self::igual('productos.productoestado'), 'caja' => self::igual('productos.caja_id'),
                ], [
                    'isbn' => ['productos.isbn', "CONCAT(productos.isbn, ' · ', productos.referencia)"], 'referencia' => ['productos.referencia', 'productos.referencia'],
                    'cliente' => ['c.id', 'c.entidad'], 'idioma' => ['i.id', 'i.nombre'],
                ]];
            case 'entidades':
                $tipos = ['1' => [1, 2], '2' => [1, 2, 3], '3' => [2, 3], '4' => [4]][(string) $tipo] ?? null;
                $q = DB::table('entidades')->when($tipos, fn ($x) => $x->whereIn('entidades.entidadtipo_id', $tipos));
                return [$q, [
                    'numero' => self::like('entidades.entidad'), 'nif' => self::like('entidades.nif'), 'responsable' => self::like('entidades.responsable'),
                ], [
                    'numero' => ['entidades.entidad', 'entidades.entidad'], 'nif' => ['entidades.nif', "CONCAT(entidades.nif, ' · ', entidades.entidad)"],
                    'responsable' => ['entidades.responsable', 'entidades.responsable'],
                ]];
        }
        return [DB::table('productos'), [], []];
    }
}
