<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class ResetUserPassword extends Command
{
    protected $signature = 'user:reset-password
        {email : Email del usuario}
        {--password= : Nueva contrasena. Si se omite, se genera una temporal}
        {--name=Administrador : Nombre si hay que crear el usuario}
        {--create : Crea el usuario si no existe}
        {--admin : Asegura rol Admin y permisos principales}';

    protected $description = 'Restablece la contrasena de un usuario desde consola';

    public function handle(): int
    {
        $user = User::where('email', $this->argument('email'))->first();

        if (! $user) {
            if (! $this->option('create')) {
                $this->error('No existe ningun usuario con ese email. Usa --create para crearlo.');
                return self::FAILURE;
            }

            $user = User::create([
                'name' => $this->option('name'),
                'email' => $this->argument('email'),
                'password' => Hash::make(Str::random(16)),
            ]);
        }

        $password = $this->option('password') ?: Str::random(12).'A1!';

        $user->forceFill([
            'password' => Hash::make($password),
            'two_factor_secret' => null,
            'two_factor_recovery_codes' => null,
            'two_factor_confirmed_at' => null,
        ])->save();

        if ($this->option('admin')) {
            $this->ensureAdminAccess($user);
        }

        $this->info('Contrasena actualizada para: '.$user->email);
        $this->line('Nueva contrasena: '.$password);

        return self::SUCCESS;
    }

    private function ensureAdminAccess(User $user): void
    {
        $role = Role::firstOrCreate(['name' => 'Admin']);

        foreach ($this->adminPermissions() as $permissionName) {
            Permission::firstOrCreate(['name' => $permissionName])->assignRole($role);
        }

        $user->assignRole($role);
        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }

    private function adminPermissions(): array
    {
        return [
            'seguridad.index',
            'caracteristicas.index',
            'entidad.index',
            'entidad.edit',
            'producto.index',
            'producto.edit',
            'presupuesto.index',
            'presupuesto.edit',
            'pedido.index',
            'pedido.edit',
            'oferta.index',
            'oferta.edit',
            'facturacion.index',
            'facturacion.edit',
            'compra.index',
            'compra.edit',
            'user.index',
            'user.edit',
            'role.index',
            'role.edit',
        ];
    }
}
