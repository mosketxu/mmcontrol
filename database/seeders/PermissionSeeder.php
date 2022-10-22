<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin=Role::find('1');
        $gestor=Role::find('2');
        $milimetrica=Role::find('3');
        // dd($admin . '-'. $gestor .'-'.$milimetrica);
        // \\DB::table('permissions')->delete();

        // Users
        Permission::create(['name'=>'user.index'])->syncRoles($admin, $gestor);
        Permission::create(['name'=>'user.create'])->syncRoles($admin, $gestor);
        Permission::create(['name'=>'user.edit'])->syncRoles($admin, $gestor);
        Permission::create(['name'=>'user.update'])->syncRoles($admin, $gestor);
        Permission::create(['name'=>'user.delete'])->syncRoles($admin, $gestor);

        // Roles
        Permission::create(['name'=>'role.index'])->syncRoles($admin, $gestor);
        Permission::create(['name'=>'role.create'])->syncRoles($admin, $gestor);
        Permission::create(['name'=>'role.edit'])->syncRoles($admin, $gestor);
        Permission::create(['name'=>'role.update'])->syncRoles($admin, $gestor);
        Permission::create(['name'=>'role.delete'])->syncRoles($admin, $gestor);

        // Permisos
        Permission::create(['name'=>'permiso.index'])->syncRoles($admin, $gestor);
        Permission::create(['name'=>'permiso.create'])->syncRoles($admin, $gestor);
        Permission::create(['name'=>'permiso.edit'])->syncRoles($admin, $gestor);
        Permission::create(['name'=>'permiso.update'])->syncRoles($admin, $gestor);
        Permission::create(['name'=>'permiso.delete'])->syncRoles($admin, $gestor);

        // Seguridad
        Permission::create(['name'=>'seguridad.index'])->syncRoles($admin, $gestor);
        Permission::create(['name'=>'seguridad.create'])->syncRoles($admin, $gestor);
        Permission::create(['name'=>'seguridad.edit'])->syncRoles($admin, $gestor);
        Permission::create(['name'=>'seguridad.update'])->syncRoles($admin, $gestor);
        Permission::create(['name'=>'seguridad.delete'])->syncRoles($admin, $gestor);

        // Entidades
        Permission::create(['name'=>'entidad.index'])->syncRoles($admin, $gestor, $milimetrica);
        Permission::create(['name'=>'entidad.create'])->syncRoles($admin, $gestor, $milimetrica);
        Permission::create(['name'=>'entidad.edit'])->syncRoles($admin, $gestor, $milimetrica);
        Permission::create(['name'=>'entidad.update'])->syncRoles($admin, $gestor, $milimetrica);
        Permission::create(['name'=>'entidad.delete'])->syncRoles($admin, $gestor, $milimetrica);

        // Entidades contactos
        Permission::create(['name'=>'entidadcontacto.index'])->syncRoles($admin, $gestor, $milimetrica);
        Permission::create(['name'=>'entidadcontacto.create'])->syncRoles($admin, $gestor, $milimetrica);
        Permission::create(['name'=>'entidadcontacto.edit'])->syncRoles($admin, $gestor, $milimetrica);
        Permission::create(['name'=>'entidadcontacto.update'])->syncRoles($admin, $gestor, $milimetrica);
        Permission::create(['name'=>'entidadcontacto.delete'])->syncRoles($admin, $gestor, $milimetrica);

        // Productos
        Permission::create(['name'=>'producto.index'])->syncRoles($admin, $gestor, $milimetrica);
        Permission::create(['name'=>'producto.create'])->syncRoles($admin, $gestor, $milimetrica);
        Permission::create(['name'=>'producto.edit'])->syncRoles($admin, $gestor, $milimetrica);
        Permission::create(['name'=>'producto.update'])->syncRoles($admin, $gestor, $milimetrica);
        Permission::create(['name'=>'producto.delete'])->syncRoles($admin, $gestor, $milimetrica);
    }
}
