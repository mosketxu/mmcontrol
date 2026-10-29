<?php

namespace App\Console\Commands;

use App\Models\Factura;
use Illuminate\Console\Command;

class FacturasDatosHistoricos extends Command
{
    protected $signature = 'facturas:datos-historicos {cliente : id del cliente (entidades.id)}
        {--hasta= : fecha de corte AAAA-MM-DD; se corrigen las facturas con fecha ANTERIOR a ella}
        {--entidad=} {--direccion=} {--cp=} {--localidad=} {--nif=} {--iban=} {--bic=} {--moneda=}
        {--aplicar : sin esta opción solo muestra lo que cambiaría}';
    protected $description = 'Corrige la foto de datos del cliente en sus facturas anteriores a una fecha de corte con los datos antiguos';

    private const CAMPOS = ['entidad','direccion','cp','localidad','nif','iban','bic','moneda'];

    public function handle()
    {
        $hasta = $this->option('hasta');
        if (!$hasta || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $hasta)) {
            $this->error('Falta --hasta=AAAA-MM-DD (las facturas con fecha anterior se corrigen).');
            return 1;
        }
        $nuevos = [];
        foreach (self::CAMPOS as $c) {
            if ($this->option($c) !== null) $nuevos['cli_'.$c] = $this->option($c);
        }
        if (!$nuevos) {
            $this->error('Indica al menos un dato antiguo (--direccion, --cp, --localidad...).');
            return 1;
        }
        $facturas = Factura::where('cliente_id', $this->argument('cliente'))
            ->where('fecha', '<', $hasta)->orderBy('fecha')->get();
        if ($facturas->isEmpty()) {
            $this->warn('Ninguna factura creada de ese cliente con fecha anterior a '.$hasta.'.');
            return 0;
        }
        $filas = [];
        $saltadas = 0;
        foreach ($facturas as $f) {
            $antes = collect(array_keys($nuevos))->map(fn($k) => $f->$k)->implode(' | ');
            $despues = implode(' | ', $nuevos);
            $filas[] = [$f->id, (string) $f->fecha, $antes, $despues];
            if ($this->option('aplicar')) {
                $f->forceFill($nuevos + ['datos_origen' => 'historico', 'datos_congelados_at' => $f->datos_congelados_at ?? now()])->save();
                // Con PDF ya guardado: nueva versión, la anterior queda como factura_ID_old_vN.pdf
                if ($f->pdf_path) app(\App\Services\FacturaPdf::class)->validar($f->fresh());
            }
        }
        $this->table(['Factura', 'Fecha', 'Antes', 'Después'], $filas);
        $this->info(count($filas).' factura(s) '.($this->option('aplicar') ? 'corregidas (las que tenían PDF guardado, con nueva versión y la anterior conservada).' : 'se corregirían (añade --aplicar).'));
        return 0;
    }
}
