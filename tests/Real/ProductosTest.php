<?php

namespace Tests\Real;

use App\Models\Producto;
use Livewire\Livewire;

/** Productos: duplicar crea una copia (con sus procesos) y el borrado de la lista elimina solo ese producto. */
class ProductosTest extends RealTestCase
{
    public function test_duplicar_y_borrar(): void
    {
        $p = Producto::where('tipo', 1)->firstOrFail();
        $n = Producto::count();

        $this->post(route('producto.duplicar', $p))->assertRedirect();
        $this->assertSame($n + 1, Producto::count());
        $copia = Producto::latest('id')->first();
        $this->assertNotSame($p->id, $copia->id);
        $this->assertStringEndsWith('(copia)', $copia->isbn);
        $this->assertSame($p->procesos()->count(), $copia->procesos()->count());

        Livewire::test('producto.prods', ['tipo' => 1, 'titulo' => 'P'])->call('delete', $copia->id);
        $this->assertSame($n, Producto::count());
        $this->assertNotNull(Producto::find($p->id), 'el original no se toca');
    }
}
