<?php

namespace Tests\Real;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

/**
 * Base de la suite «real»: BD local copia de producción, todo dentro de una transacción que se deshace.
 * Se niega a correr si la BD no es local (nunca contra producción ni contra el VPS).
 */
abstract class RealTestCase extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();
        $host = config('database.connections.'.config('database.default').'.host');
        if ($host !== '127.0.0.1' || (string) config('database.connections.mysql.port') !== '3307' || config('database.connections.mysql.database') !== 't') {
            $this->fail("La suite real solo corre contra la BD privada de pruebas (127.0.0.1:3307, base t; ver tests/preparar_bd.sh).");
        }
        $this->actingAs(User::findOrFail(1));
    }
}
