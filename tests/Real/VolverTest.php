<?php

namespace Tests\Real;

use Tests\TestCase;

/** Guardia: ningún botón «Volver» va a una ruta fija (se perderían los filtros de la lista); todos usan volverLista(). */
class VolverTest extends TestCase
{
    public function test_todos_los_botones_volver_usan_volverLista(): void
    {
        $malos = [];
        $it = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator(resource_path('views')));
        foreach ($it as $f) {
            if (! $f->isFile() || ! str_ends_with($f->getFilename(), '.php')) continue;
            foreach (file($f->getPathname()) as $n => $linea) {
                if (str_contains($linea, "__('Volver')") && str_contains($linea, 'location.href') && ! str_contains($linea, '{{--') && ! str_contains($linea, 'volverLista')) {
                    $malos[] = str_replace(resource_path('views').'/', '', $f->getPathname()).':'.($n + 1);
                }
            }
        }
        $this->assertSame([], $malos, 'Botones «Volver» con ruta fija: '.implode(', ', $malos));
    }

    public function test_el_layout_define_volverLista(): void
    {
        $layout = file_get_contents(resource_path('views/layouts/app.blade.php'));
        $this->assertStringContainsString('window.volverLista', $layout);
    }
}
