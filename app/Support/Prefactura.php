<?php

namespace App\Support;

use Carbon\Carbon;

/**
 * El programa aún no está homologado para emitir facturas: desde la fecha indicada
 * (config('facturacion.prefactura_desde'), por defecto 2027-01-01) los documentos se llaman
 * «Prefactura» en pantallas, PDF, mensajes y exportaciones. Antes de esa fecha no cambia nada.
 * Se puede adelantar con FACTURACION_PREFACTURA_DESDE=AAAA-MM-DD en el .env.
 */
class Prefactura
{
    public static function activa(): bool
    {
        return now()->gte(Carbon::parse(config('facturacion.prefactura_desde', '2027-01-01'))->startOfDay());
    }

    /** Cambia «Factura/factura/FACTURA/Facturación» por su forma «pre» si el modo está activo. */
    public static function t($texto)
    {
        if (!is_string($texto) || !self::activa()) return $texto;
        return preg_replace(
            ['/\bFacturaci(ó|o)n\b/u', '/\bFacturad([oa]s?)\b/u', '/\bfacturad([oa]s?)\b/u', '/\bfactura(r|rá)\b/u', '/\bfacturaci(ó|o)n\b/u', '/\bFRA\b/u', '/\bFra\b/u', '/\bFACTURA(S?)\b/u', '/\bFactura(s?)\b/u', '/\bfactura(s?)\b/u'],
            ['Prefacturaci$1n', 'Prefacturad$1', 'prefacturad$1', 'prefactura$1', 'prefacturaci$1n', 'PREFACTURA', 'Prefactura', 'PREFACTURA$1', 'Prefactura$1', 'prefactura$1'],
            $texto
        );
    }
}

