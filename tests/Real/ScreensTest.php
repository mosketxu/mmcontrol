<?php

namespace Tests\Real;

use App\Models\Compra;
use App\Models\Entidad;
use App\Models\Factura;
use App\Models\Oferta;
use App\Models\Pedido;
use App\Models\Presupuesto;
use App\Models\Producto;

/** Todas las pantallas se abren con datos reales (listados, fichas, edición, archivos...). */
class ScreensTest extends RealTestCase
{
    public static function listados(): array
    {
        return [
            'entidades' => ['entidad.tipo', [1]], 'entidades2' => ['entidad.tipo', [2]],
            'productos editorial' => ['producto.tipo', [1]], 'productos otros' => ['producto.tipo', [2]],
            'presupuestos editorial' => ['presupuesto.tipo', [1, 'i']], 'presupuestos otros' => ['presupuesto.tipo', [2, 'i']],
            'pedidos editorial' => ['pedido.tipo', [1, 'i']], 'pedidos otros' => ['pedido.tipo', [2, 'i']],
            'compras editorial' => ['compra.tipo', [1, 'i']], 'compras otros' => ['compra.tipo', [2, 'i']],
            'ofertas 1' => ['oferta.tipo', [1]], 'ofertas 2' => ['oferta.tipo', [2]],
            'facturacion' => ['facturacion.index', []],
        ];
    }

    /** @dataProvider listados */
    public function test_listados_se_abren(string $ruta, array $params): void
    {
        $this->abrir(route($ruta, $params));
    }

    public function test_fichas_con_registro_real(): void
    {
        $p = Producto::where('tipo', 1)->firstOrFail();
        $pr = Presupuesto::where('tipo', 1)->latest('id')->firstOrFail();
        $pe = Pedido::latest('id')->firstOrFail();
        $e = Entidad::firstOrFail();
        $f = Factura::latest('id')->firstOrFail();
        $c = Compra::latest('id')->first();
        $o = Oferta::latest('id')->first();

        $urls = [
            route('producto.edit', $p), route('producto.archivos', [$p, 'i']),
            route('presupuesto.editar', [$pr->id, 'i']), route('presupuesto.archivos', [$pr->id, 'i']),
            route('pedido.editar', [$pe->id, 'i']), route('pedido.archivos', [$pe->id, 'i']),
            route('pedido.parciales', [$pe->id, 'i']), route('pedido.tareas', [$pe->id, 'i']),
            route('entidad.edit', $e), route('entidad.contactos', $e), route('entidad.destinos', [$e->id, 'i']), route('entidad.acciones', [$e->id, 'i']),
            route('facturacion.edit', $f->id), route('facturacion.show', $f->id),
        ];
        if ($c) { $urls[] = route('compra.editar', [$c->id, 'i']); }
        if ($o) { $urls[] = route('oferta.editar', [$o->id, 'i']); }

        foreach ($urls as $u) {
            $this->abrir($u);
        }
    }

    public function test_exportaciones_con_filtros_en_la_query_string(): void
    {
        foreach ([
            route('pedido.export', ['tipo' => 1, 'filtroanyo' => '2026', 'filtromes' => '10']),
            route('pedido.export', ['tipo' => 2]),
            route('producto.export'), route('presupuesto.export'), route('oferta.export'), route('entidad.export'),
        ] as $u) {
            $this->withoutExceptionHandling();
            $r = $this->get($u);
            $this->assertSame(200, $r->getStatusCode(), $u);
        }
    }

    /** GET que debe dar 200; si falla, el mensaje trae la excepción real (no solo «500»). */
    private function abrir(string $url): void
    {
        $this->withoutExceptionHandling();
        try {
            $r = $this->get($url);
        } catch (\Throwable $e) {
            $tr=''; foreach (array_slice($e->getTrace(), 0, 30) as $t) { $tr .= "\n   ".basename($t['file'] ?? '').':'.($t['line'] ?? '').' '.($t['function'] ?? ''); } $this->fail("$url -> ".get_class($e).': '.substr($e->getMessage(), 0, 300).' @ '.basename($e->getFile()).':'.$e->getLine().(getenv('TRAZA') ? $tr : ''));
        }
        $this->assertSame(200, $r->getStatusCode(), "$url devolvió ".$r->getStatusCode());
    }
}
