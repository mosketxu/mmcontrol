<?php

namespace App\Console\Commands;

use App\Models\Factura;
use App\Services\FacturaPdf;
use Illuminate\Console\Command;

class FacturasCongelarPdf extends Command
{
    protected $signature = 'facturas:congelar-pdf {--id= : solo esta factura} {--forzar : regenerar aunque ya haya PDF guardado}';
    protected $description = 'Genera y guarda la primera versión del PDF de las facturas que aún no tienen ninguno';

    public function handle(FacturaPdf $servicio)
    {
        $q = Factura::query();
        if ($this->option('id')) $q->where('id', $this->option('id'));
        if (!$this->option('forzar')) $q->whereNull('pdf_path');
        $n = 0;
        $q->orderBy('id')->chunkById(100, function ($facturas) use ($servicio, &$n) {
            foreach ($facturas as $f) {
                $servicio->guardar($f, (bool) $this->option('forzar'));
                $n++;
                usleep(150000); // no cargar el servidor
            }
        });
        $this->info("$n PDF generados y guardados.");
        return 0;
    }
}
