<?php

namespace Tests\Feature;

use App\Models\EntidadTipo;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use Tests\TestCase;

class SmokeTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }

    public function test_login_screen_renders(): void
    {
        $this->get('/login')->assertOk();
    }

    public function test_main_admin_screens_render(): void
    {
        $user = $this->adminUser();
        $this->seedMinimalCatalogs();

        $routes = [
            route('entidad.tipo', 1),
            route('producto.tipo', 1),
            route('producto.tipo', 2),
            route('presupuesto.tipo', [1, 'i']),
            route('presupuesto.tipo', [2, 'i']),
            route('pedido.tipo', [1, 'i']),
            route('pedido.tipo', [2, 'i']),
            route('oferta.tipo', 1),
            route('oferta.tipo', 2),
            route('facturacion.index'),
            route('compra.tipo', [1, 'i']),
            route('compra.tipo', [2, 'i']),
        ];

        foreach ($routes as $route) {
            $this->actingAs($user)
                ->get($route)
                ->assertOk();
        }
    }

    public function test_dashboard_redirects_for_admin(): void
    {
        $user = $this->adminUser();

        $this->actingAs($user)
            ->get(route('dashboard'))
            ->assertRedirect(route('seguridad'));
    }

    private function adminUser(): User
    {
        $permissions = [
            'seguridad.index',
            'entidad.index',
            'producto.index',
            'presupuesto.index',
            'pedido.index',
            'oferta.index',
            'facturacion.index',
            'compra.index',
        ];

        $role = Role::create(['name' => 'Admin']);

        foreach ($permissions as $permission) {
            Permission::findOrCreate($permission)->assignRole($role);
        }

        $user = User::factory()->create();
        $user->assignRole($role);

        return $user;
    }

    private function seedMinimalCatalogs(): void
    {
        EntidadTipo::query()->insert([
            [
                'id' => 1,
                'nombre' => 'Cliente',
                'nombrecorto' => 'Cli',
                'nombreplural' => 'Clientes',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'nombre' => 'Cliente/Proveedor',
                'nombrecorto' => 'Cli/Prov',
                'nombreplural' => 'Clientes/Proveedores',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'nombre' => 'Proveedor',
                'nombrecorto' => 'Prov',
                'nombreplural' => 'Proveedores',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 4,
                'nombre' => 'Contacto',
                'nombrecorto' => 'Cont',
                'nombreplural' => 'Contactos',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
