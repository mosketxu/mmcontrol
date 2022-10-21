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
        $admin=Role::where('id','1');
        $gestor=Role::where('id','2');
        $milimetrica=Role::where('id','3');

        // \DB::table('permissions')->delete();

        // Users
        // Permission::create(['name'=>'user.index'])->syncRoles($admin,$gestor);
        // Permission::create(['name'=>'user.create'])->syncRoles($admin,$gestor);
        // Permission::create(['name'=>'user.edit'])->syncRoles($admin,$gestor);
        // Permission::create(['name'=>'user.update'])->syncRoles($admin,$gestor);
        // Permission::create(['name'=>'user.delete'])->syncRoles($admin,$gestor);

        // Roles
        // Permission::create(['name'=>'role.index'])->syncRoles($admin,$gestor);
        // Permission::create(['name'=>'role.create'])->syncRoles($admin,$gestor);
        // Permission::create(['name'=>'role.edit'])->syncRoles($admin,$gestor);
        // Permission::create(['name'=>'role.update'])->syncRoles($admin,$gestor);
        // Permission::create(['name'=>'role.delete'])->syncRoles($admin,$gestor);

        // Permisos
        // Permission::create(['name'=>'permiso.index'])->syncRoles($admin,$gestor);
        // Permission::create(['name'=>'permiso.create'])->syncRoles($admin,$gestor);
        // Permission::create(['name'=>'permiso.edit'])->syncRoles($admin,$gestor);
        // Permission::create(['name'=>'permiso.update'])->syncRoles($admin,$gestor);
        // Permission::create(['name'=>'permiso.delete'])->syncRoles($admin,$gestor);

        // Seguridad
        // Permission::create(['name'=>'seguridad.index'])->syncRoles($admin,$gestor);
        // Permission::create(['name'=>'seguridad.create'])->syncRoles($admin,$gestor);
        // Permission::create(['name'=>'seguridad.edit'])->syncRoles($admin,$gestor);
        // Permission::create(['name'=>'seguridad.update'])->syncRoles($admin,$gestor);
        // Permission::create(['name'=>'seguridad.delete'])->syncRoles($admin,$gestor);

        // Entidades
        // Permission::create(['name'=>'entidad.index'])->syncRoles($admin,$gestor,$usuario);
        // Permission::create(['name'=>'entidad.create'])->syncRoles($admin,$gestor,$usuario);
        // Permission::create(['name'=>'entidad.edit'])->syncRoles($admin,$gestor,$usuario);
        // Permission::create(['name'=>'entidad.update'])->syncRoles($admin,$gestor,$usuario);
        // Permission::create(['name'=>'entidad.delete'])->syncRoles($admin,$gestor,$usuario);

        // Entidades contactos
        // Permission::create(['name'=>'entidadcontacto.index'])->syncRoles($admin,$gestor,$usuario);
        // Permission::create(['name'=>'entidadcontacto.create'])->syncRoles($admin,$gestor,$usuario);
        // Permission::create(['name'=>'entidadcontacto.edit'])->syncRoles($admin,$gestor,$usuario);
        // Permission::create(['name'=>'entidadcontacto.update'])->syncRoles($admin,$gestor,$usuario);
        // Permission::create(['name'=>'entidadcontacto.delete'])->syncRoles($admin,$gestor,$usuario);

        // Productos
        // Permission::create(['name'=>'producto.index'])->syncRoles($admin,$gestor,$usuario);
        // Permission::create(['name'=>'producto.create'])->syncRoles($admin,$gestor,$usuario);
        // Permission::create(['name'=>'producto.edit'])->syncRoles($admin,$gestor,$usuario);
        // Permission::create(['name'=>'producto.update'])->syncRoles($admin,$gestor,$usuario);
        // Permission::create(['name'=>'producto.delete'])->syncRoles($admin,$gestor,$usuario);

        // // Pedidos
        // Permission::create(['name'=>'pedido.index','description'=>'Lista todos los pedidos del sistema'])->syncRoles($admin,$gestor);
        // Permission::create(['name'=>'pedido.create','description'=>'Permite Crear un pedido'])->syncRoles($admin,$gestor);
        // Permission::create(['name'=>'pedido.edit','description'=>'Permite Editar un pedido'])->syncRoles($admin,$gestor);
        // Permission::create(['name'=>'pedido.update','description'=>'Permite Actualizar un pedido'])->syncRoles($admin,$gestor);
        // Permission::create(['name'=>'pedido.delete','description'=>'Permite Borrar un pedido'])->syncRoles($admin,$gestor);


        // // Productos
        // Permission::create(['name'=>'producto.index','description'=>'Lista todos los productos del sistema'])->syncRoles($admin,$gestor);
        // Permission::create(['name'=>'producto.create','description'=>'Permite Crear un producto'])->syncRoles($admin,$gestor);
        // Permission::create(['name'=>'producto.edit','description'=>'Permite Editar una producto'])->syncRoles($admin,$gestor);
        // Permission::create(['name'=>'producto.update','description'=>'Permite Actualizar una producto'])->syncRoles($admin,$gestor);
        // Permission::create(['name'=>'producto.delete','description'=>'Permite Borrar un producto'])->syncRoles($admin,$gestor);

        // //Presupuestos
        // Permission::create(['name'=>'presupuesto.index','description'=>'Lista todos los presupuestos del sistema'])->syncRoles($admin,$comercial);
        // Permission::create(['name'=>'presupuesto.create','description'=>'Permite Crear un presupuesto'])->syncRoles($admin,$comercial);
        // Permission::create(['name'=>'presupuesto.edit','description'=>'Permite Editar una presupuesto'])->syncRoles($admin,$comercial);
        // Permission::create(['name'=>'presupuesto.update','description'=>'Permite Actualizar una presupuesto'])->syncRoles($admin,$comercial);
        // Permission::create(['name'=>'presupuesto.delete','description'=>'Permite Borrar un presupuesto'])->syncRoles($admin,$comercial);

        // //otros
        // Permission::create(['name'=>'dash','description'=>'Acceder al Dashboard'])->syncRoles($admin,$gestor);
        // Permission::create(['name'=>'dash.1','description'=>'Acceder al Dashboard'])->syncRoles($admin,$gestor);
        // Permission::create(['name'=>'dash.2','description'=>'Acceder al Dashboard'])->syncRoles($admin,$gestor);
        // Permission::create(['name'=>'dash.3','description'=>'Acceder al Dashboard'])->syncRoles($admin,$gestor);
        // Permission::create(['name'=>'dash.4','description'=>'Acceder al Dashboard'])->syncRoles($admin,$gestor);



    }
}
