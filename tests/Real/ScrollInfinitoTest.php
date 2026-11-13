<?php

namespace Tests\Real;

use Livewire\Livewire;

/** Scroll infinito: el primer lote es de 50, cada «cargarMas» añade otro lote y un filtro vuelve al primero. Nunca se cargan todos a la vez. */
class ScrollInfinitoTest extends RealTestCase
{
    public static function listas(): array
    {
        return [
            'productos editorial' => ['producto.prods', ['tipo' => 1, 'titulo' => 'P'], 'filtroreferencia'],
            'productos otros' => ['producto.prods', ['tipo' => 2, 'titulo' => 'P'], 'filtroreferencia'],
            'presupuestos editorial' => ['presupuesto.presupuestos', ['tipo' => 1, 'titulo' => 'P'], 'filtroreferencia'],
            'presupuestos otros' => ['presupuesto.presupuestos', ['tipo' => 2, 'titulo' => 'P'], 'filtroreferencia'],
        ];
    }

    private function mostrando(string $html): array
    {
        $this->assertSame(1, preg_match('/Mostrando (\d+) de (\d+) resultados/', $html, $m), 'falta el contador «Mostrando N de M»');
        return [(int) $m[1], (int) $m[2]];
    }

    /** @dataProvider listas */
    public function test_carga_por_lotes_y_se_reinicia_al_filtrar(string $componente, array $args, string $filtro): void
    {
        $t = Livewire::test($componente, $args);
        [$n0, $total] = $this->mostrando($t->payload['effects']['html']);
        $this->assertLessThanOrEqual(50, $n0, 'el primer lote no puede pasar de 50');
        $this->assertSame(min(50, $total), $n0);
        $this->assertSame($total > 50, str_contains($t->payload['effects']['html'], 'scroll-infinito-'), 'el aviso de «cargar más» sale solo si quedan registros');

        if ($total > 50) {
            $t->call('cargarMas');
            $this->assertSame(min(100, $total), $this->mostrando($t->payload['effects']['html'])[0]);
            $this->assertSame(100, $t->cantidad);

            $t->set($filtro, 'a');   // un filtro vuelve al primer lote
            $this->assertSame(50, $t->cantidad);
        }
    }

    public function test_el_ultimo_lote_no_muestra_mas(): void
    {
        $t = Livewire::test('producto.prods', ['tipo' => 2, 'titulo' => 'P']);   // otros: pocos registros
        for ($i = 0; $i < 6; $i++) {
            $t->call('cargarMas');
        }
        $html = $t->payload['effects']['html'] ?? '';
        $this->assertStringNotContainsString('Cargar más', $html);
    }
}
