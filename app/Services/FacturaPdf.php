<?php

namespace App\Services;

use App\Models\Factura;
use App\Models\FacturaDetalle;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

// PDF de factura versionado. La primera vez que se pide se genera y se guarda (versión actual: factura_ID.pdf).
// Después se sirve siempre el guardado mientras la factura no cambie. Si ha cambiado (cabecera, líneas o datos del cliente),
// quien puede editar elige entre la versión guardada y generar una nueva: la anterior se conserva como factura_ID_old_vN.pdf.
class FacturaPdf
{
    public function respuesta(Factura $factura, bool $puedeElegir = false, ?string $version = null)
    {
        $this->guardar($factura); // no hace nada si ya hay PDF guardado
        $factura->refresh();
        if ($puedeElegir && $version !== 'guardada' && $factura->pdfDesactualizado()) {
            $disco = Storage::disk('local');
            $base = preg_replace('/\.pdf$/', '', $factura->pdf_path);
            $antiguas = 0;
            while ($disco->exists($base.'_old_v'.($antiguas + 1).'.pdf')) $antiguas++;
            return response(view('facturacion.elegir_version', compact('factura', 'antiguas'))->render());
        }
        return response(Storage::disk('local')->get($factura->pdf_path), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="factura_'.$factura->id.'.pdf"',
        ]);
    }

    // Genera y guarda el PDF si aún no hay uno. Con $forzar sustituye el guardado (sin conservar el anterior: usar validar()).
    public function guardar(Factura $factura, bool $forzar = false): Factura
    {
        if ($factura->pdf_path && !$forzar && Storage::disk('local')->exists($factura->pdf_path)) {
            return $factura;
        }
        if ($factura->datos_congelados_at === null) {
            $factura->congelarDatosCliente();
        }
        $contenido = $this->render($factura);
        $ruta = 'facturas_pdf/'.substr((string) $factura->fecha, 0, 4).'/factura_'.$factura->id.'.pdf';
        Storage::disk('local')->put($ruta, $contenido);
        $factura->forceFill([
            'pdf_path' => $ruta,
            'pdf_sha256' => hash('sha256', $contenido),
            'pdf_huella' => $factura->huellaContenido(),
            'pdf_generado_at' => now(),
        ])->save();
        return $factura;
    }

    // Nueva versión: el PDF anterior se conserva como factura_ID_old_vN.pdf y se genera uno nuevo con los datos de ahora.
    public function validar(Factura $factura): Factura
    {
        $disco = Storage::disk('local');
        if ($factura->pdf_path && $disco->exists($factura->pdf_path)) {
            $base = preg_replace('/\.pdf$/', '', $factura->pdf_path);
            $n = 1;
            while ($disco->exists($base.'_old_v'.$n.'.pdf')) $n++;
            $disco->copy($factura->pdf_path, $base.'_old_v'.$n.'.pdf');
        }
        return $this->guardar($factura, true);
    }

    public function render(Factura $factura): string
    {
        $factura->loadMissing('facturadetalles', 'cliente', 'contacto');
        $totales = FacturaDetalle::where('factura_id', $factura->id)
            ->select('iva',
                DB::raw('SUM(subtotalsiniva) as subtotalsiniva'),
                DB::raw('SUM(subtotaliva) as subtotaliva'),
                DB::raw('SUM(subtotal) as subtotal'))
            ->groupBy('iva')
            ->get();
        $datos = $factura->datosCliente();

        $pdf = \PDF::loadView('facturacion.facturapdf', compact('factura', 'totales', 'datos'));
        $pdf->setPaper('a4', 'portrait');
        return $pdf->output();
    }
}
