<?php

// Función global pf(): nombre «Prefactura» según la fecha (ver App\Support\Prefactura).
if (!function_exists('pf')) {
    function pf($texto) { return \App\Support\Prefactura::t($texto); }
}
