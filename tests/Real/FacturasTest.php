<?php

namespace Tests\Real;

use App\Models\Entidad;
use App\Models\Factura;
use App\Models\FacturaDetalle;
use Livewire\Livewire;

/** Facturas: numeración por año sin reutilizar números, nunca se sobrescribe una existente, IVA por defecto y totales. */
class FacturasTest extends RealTestCase
{
    private function cliente(): Entidad
    {
        return Entidad::whereIn('entidadtipo_id', [1, 2])->where('pais_id', 'ES')->firstOrFail();
    }

    private function nueva(string $fecha)
    {
        return Livewire::test('facturacion.factura', ['facturaid' => ''])
            ->set('cliente_id', $this->cliente()->id)->set('fecha', $fecha)->set('tipo', '1')->call('save');
    }

    public function test_una_factura_nueva_toma_el_siguiente_numero_y_no_toca_las_existentes(): void
    {
        $antes = Factura::whereBetween('id', [2600000, 2699999])->orderBy('id')->get()->map->getAttributes()->all();
        $max = Factura::whereBetween('id', [2600000, 2699999])->max('id');

        $t = $this->nueva('2026-11-13');

        $this->assertSame($max + 1, (int) $t->facturaid, 'debe ser el correlativo del año +1');
        $this->assertNotNull(Factura::find($max + 1));
        $despues = Factura::whereBetween('id', [2600000, 2699999])->where('id', '<=', $max)->orderBy('id')->get()->map->getAttributes()->all();
        $this->assertSame($antes, $despues, 'ninguna factura existente puede cambiar');
    }

    public function test_dos_altas_seguidas_dan_numeros_distintos(): void
    {
        $a = (int) $this->nueva('2026-11-13')->facturaid;
        $b = (int) $this->nueva('2026-11-13')->facturaid;
        $this->assertSame($a + 1, $b);
    }

    public function test_cambio_de_anio_sigue_el_correlativo_sin_reiniciar(): void
    {
        $previo = Factura::where('id', '<', 2700000)->max('id');
        $t = $this->nueva('2027-01-05');
        $this->assertSame(2700000 + ($previo % 100000) + 1, (int) $t->facturaid);
    }

    public function test_iva_por_defecto_cero_fuera_de_espana_y_21_en_espana(): void
    {
        $extranjero = Entidad::whereIn('entidadtipo_id', [1, 2])->whereNotNull('pais_id')->where('pais_id', '!=', 'ES')->where('pais_id', '!=', '')->firstOrFail();
        $es = $this->cliente();
        foreach ([[$extranjero, '0.00'], [$es, '0.21']] as [$ent, $esperado]) {
            $f = Factura::where('cliente_id', $ent->id)->first();
            if (! $f) { $this->markTestIncomplete("sin facturas de {$ent->entidad}"); continue; }
            $t = Livewire::test('facturacion.fdetalle', ['facturaid' => $f->id, 'deshabilitado' => '']);
            $this->assertSame($esperado, $t->iva, "IVA por defecto de {$ent->entidad} ({$ent->pais_id})");
        }
    }

    public function test_totales_de_las_facturas_recuperadas_cuadran_con_sus_lineas(): void
    {
        foreach ([2602756, 2602757] as $id) {
            $f = Factura::findOrFail($id);
            $importe = FacturaDetalle::where('factura_id', $id)->sum('importe');
            $this->assertEqualsWithDelta((float) $f->importe, (float) $importe, 0.01, "importe de $id");
            $this->assertEqualsWithDelta((float) $f->total, (float) $f->importe + (float) $f->iva, 0.01, "total de $id");
        }
    }
}
