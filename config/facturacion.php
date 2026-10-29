<?php

return [
    // Desde esta fecha el PDF de cada factura se genera una vez, se guarda y se sirve siempre el mismo.
    'cierre' => env('FACTURACION_CIERRE', '2027-01-01'),
];
