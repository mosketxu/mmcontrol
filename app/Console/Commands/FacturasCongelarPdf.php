<?php

namespace App\Console\Commands;

use App\Models\Factura;
use App\Services\FacturaPdf;
use Illuminate\Console\Command;

class FacturasCongelarPdf extends Command
{
    protected $signature = 'facturas:congelar-pdf {--id= : solo esta factura} {--antes-de-cierre : generar también si aún no ha llegado la fecha de cierre (pruebas)} {--forzar : regenerar aunque ya haya PDF guardado}';
    protected $description = 'Genera y guarda el PDF fijo de las facturas creadas una vez pasada la fecha de cierre';

    public function handle(FacturaPdf $servicio)
    {
        $cierre = \Carbon\Carbon::parse(config('facturacion.cierre'))->startOfDay();
        if (now()->lt($cierre) && !$this->option('antes-de-cierre')) {
            $this->line('Aún no ha llegado la fecha de cierre ('.$cierre->format('d/m/Y').'): nada que hacer.');
            return 0;
        }
        $q = Factura::whereNotNull('validada_at');
        if ($this->option('id')) $q->where('id', $this->option('id'));
        if (!$this->option('forzar')) $q->whereNull('pdf_path');
        $n = 0;
        $q->orderBy('id')->chunkById(100, function ($facturas) use ($servicio, &$n) {
            foreach ($facturas as $f) {
                $servicio->guardar($f, (bool) $this->option('forzar'));
                $n++;
            }
        });
        $this->info("$n PDF generados y guardados.");
        return 0;
    }
}
