<?php

return [
    // Desde esta fecha las facturas ya creadas (no prefacturas) no se pueden modificar.
    'cierre' => env('FACTURACION_CIERRE', '2027-01-01'),
    // Desde esta fecha los documentos se llaman «Prefactura» (el programa aún no emite facturas homologadas).
    'prefactura_desde' => env('FACTURACION_PREFACTURA_DESDE', '2027-01-01'),
];
