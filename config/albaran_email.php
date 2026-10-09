<?php

// Plantilla del email de albarán al proveedor. Marcadores: {albaran} {pedido} {cliente} {destino} {fecha} {referencia}
// PENDIENTE: sustituir el texto (y la estética en resources/views/emails/albaran.blade.php) por la plantilla de Mireia.
return [
    'asunto' => 'Albarán {albaran} - Pedido {pedido} - {cliente}',
    'cuerpo' => "Hola,\n\nOs enviamos adjunto el albarán {albaran} del pedido {pedido} ({referencia}) para entregar a:\n\n{destino}\n\nCualquier duda, quedamos a vuestra disposición.\n\nGracias y un saludo.",
];
