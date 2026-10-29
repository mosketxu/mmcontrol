<?php

namespace App\Services;

use App\Models\Factura;
use App\Models\FacturaDetalle;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

// PDF de factura. Prefactura o factura aún modificable: se genera al momento. Factura creada y pasada la fecha de cierre
// (config/facturacion.php): se genera una vez, se guarda y siempre se sirve ese mismo fichero.
class FacturaPdf
{
    public function respuesta(Factura $factura)
    {
        if ($factura->estaCerrada()) {
            $this->guardar($factura);
            return response(Storage::disk('local')->get($factura->pdf_path), 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="factura_'.$factura->id.'.pdf"',
            ]);
        }
        return response($this->render($factura), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="factura_'.$factura->id.'.pdf"',
        ]);
    }

    // Genera y guarda el PDF si aún no hay uno. Con $forzar sustituye el guardado (solo para corregir a mano).
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
            'pdf_generado_at' => now(),
        ])->save();
        return $factura;
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
