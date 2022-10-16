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
        $admin=Role::where('name','Admin');
        $gestion=Role::where('name','Gestion');
        $usuario=Role::where('name','Milimetrica');

        // \DB::table('permissions')->delete();

        // Users
        // Permission::create(['name'=>'user.index'])->syncRoles($admin,$gestion);
        // Permission::create(['name'=>'user.create'])->syncRoles($admin,$gestion);
        // Permission::create(['name'=>'user.edit'])->syncRoles($admin,$gestion);
        // Permission::create(['name'=>'user.update'])->syncRoles($admin,$gestion);
        // Permission::create(['name'=>'user.delete'])->syncRoles($admin,$gestion);

        // Roles
        // Permission::create(['name'=>'role.index'])->syncRoles($admin,$gestion);
        // Permission::create(['name'=>'role.create'])->syncRoles($admin,$gestion);
        // Permission::create(['name'=>'role.edit'])->syncRoles($admin,$gestion);
        // Permission::create(['name'=>'role.update'])->syncRoles($admin,$gestion);
        // Permission::create(['name'=>'role.delete'])->syncRoles($admin,$gestion);

        // Permisos
        // Permission::create(['name'=>'permiso.index'])->syncRoles($admin,$gestion);
        // Permission::create(['name'=>'permiso.create'])->syncRoles($admin,$gestion);
        // Permission::create(['name'=>'permiso.edit'])->syncRoles($admin,$gestion);
        // Permission::create(['name'=>'permiso.update'])->syncRoles($admin,$gestion);
        // Permission::create(['name'=>'permiso.delete'])->syncRoles($admin,$gestion);

        // Seguridad
        // Permission::create(['name'=>'seguridad.index'])->syncRoles($admin,$gestion);
        // Permission::create(['name'=>'seguridad.create'])->syncRoles($admin,$gestion);
        // Permission::create(['name'=>'seguridad.edit'])->syncRoles($admin,$gestion);
        // Permission::create(['name'=>'seguridad.update'])->syncRoles($admin,$gestion);
        // Permission::create(['name'=>'seguridad.delete'])->syncRoles($admin,$gestion);

        // Entidades
        // Permission::create(['name'=>'entidad.index'])->syncRoles($admin,$gestion,$usuario);
        // Permission::create(['name'=>'entidad.create'])->syncRoles($admin,$gestion,$usuario);
        // Permission::create(['name'=>'entidad.edit'])->syncRoles($admin,$gestion,$usuario);
        // Permission::create(['name'=>'entidad.update'])->syncRoles($admin,$gestion,$usuario);
        // Permission::create(['name'=>'entidad.delete'])->syncRoles($admin,$gestion,$usuario);

        // Entidades contactos
        // Permission::create(['name'=>'entidadcontacto.index'])->syncRoles($admin,$gestion,$usuario);
        // Permission::create(['name'=>'entidadcontacto.create'])->syncRoles($admin,$gestion,$usuario);
        // Permission::create(['name'=>'entidadcontacto.edit'])->syncRoles($admin,$gestion,$usuario);
        // Permission::create(['name'=>'entidadcontacto.update'])->syncRoles($admin,$gestion,$usuario);
        // Permission::create(['name'=>'entidadcontacto.delete'])->syncRoles($admin,$gestion,$usuario);

        // // Pedidos
        // Permission::create(['name'=>'pedido.index','description'=>'Lista todos los pedidos del sistema'])->syncRoles($admin,$gestion);
        // Permission::create(['name'=>'pedido.create','description'=>'Permite Crear un pedido'])->syncRoles($admin,$gestion);
        // Permission::create(['name'=>'pedido.edit','description'=>'Permite Editar un pedido'])->syncRoles($admin,$gestion);
        // Permission::create(['name'=>'pedido.update','description'=>'Permite Actualizar un pedido'])->syncRoles($admin,$gestion);
        // Permission::create(['name'=>'pedido.delete','description'=>'Permite Borrar un pedido'])->syncRoles($admin,$gestion);

        // // PeticionStock
        // Permission::create(['name'=>'stockpeticion.index','description'=>'Lista todas las peticiones de stock del sistema'])->syncRoles($admin,$gestion,$usuario);
        // Permission::create(['name'=>'stockpeticion.create','description'=>'Permite Crear una Peticion de stock'])->syncRoles($admin,$gestion,$usuario);
        // Permission::create(['name'=>'stockpeticion.edit','description'=>'Permite Editar una Peticion de stock'])->syncRoles($admin,$gestion,$usuario);
        // Permission::create(['name'=>'stockpeticion.update','description'=>'Permite Actualizar una Peticion de stock'])->syncRoles($admin,$gestion,$usuario);
        // Permission::create(['name'=>'stockpeticion.delete','description'=>'Permite Borrar una Peticion de stock'])->syncRoles($admin,$gestion,$usuario);

        // // Stock
        // Permission::create(['name'=>'stock.index','description'=>'Lista el stock del sistema'])->syncRoles($admin,$gestion,$usuario);
        // Permission::create(['name'=>'stock.create','description'=>'Permite Crear un movimiento en el stock'])->syncRoles($admin,$gestion,$usuario);
        // Permission::create(['name'=>'stock.edit','description'=>'Permite Editar un movimiento del stock'])->syncRoles($admin,$gestion,$usuario);
        // Permission::create(['name'=>'stock.update','description'=>'Permite Actualizar un movimiento del stock'])->syncRoles($admin,$gestion,$usuario);
        // Permission::create(['name'=>'stock.delete','description'=>'Permite Borrar un movimiento del stock'])->syncRoles($admin,$gestion,$usuario);

        // // Productos
        // Permission::create(['name'=>'producto.index','description'=>'Lista todos los productos del sistema'])->syncRoles($admin,$gestion);
        // Permission::create(['name'=>'producto.create','description'=>'Permite Crear un producto'])->syncRoles($admin,$gestion);
        // Permission::create(['name'=>'producto.edit','description'=>'Permite Editar una producto'])->syncRoles($admin,$gestion);
        // Permission::create(['name'=>'producto.update','description'=>'Permite Actualizar una producto'])->syncRoles($admin,$gestion);
        // Permission::create(['name'=>'producto.delete','description'=>'Permite Borrar un producto'])->syncRoles($admin,$gestion);

        // //Presupuestos
        // Permission::create(['name'=>'presupuesto.index','description'=>'Lista todos los presupuestos del sistema'])->syncRoles($admin,$comercial);
        // Permission::create(['name'=>'presupuesto.create','description'=>'Permite Crear un presupuesto'])->syncRoles($admin,$comercial);
        // Permission::create(['name'=>'presupuesto.edit','description'=>'Permite Editar una presupuesto'])->syncRoles($admin,$comercial);
        // Permission::create(['name'=>'presupuesto.update','description'=>'Permite Actualizar una presupuesto'])->syncRoles($admin,$comercial);
        // Permission::create(['name'=>'presupuesto.delete','description'=>'Permite Borrar un presupuesto'])->syncRoles($admin,$comercial);

        // //otros
        // Permission::create(['name'=>'dash','description'=>'Acceder al Dashboard'])->syncRoles($admin,$gestion);
        // Permission::create(['name'=>'dash.1','description'=>'Acceder al Dashboard'])->syncRoles($admin,$gestion);
        // Permission::create(['name'=>'dash.2','description'=>'Acceder al Dashboard'])->syncRoles($admin,$gestion);
        // Permission::create(['name'=>'dash.3','description'=>'Acceder al Dashboard'])->syncRoles($admin,$gestion);
        // Permission::create(['name'=>'dash.4','description'=>'Acceder al Dashboard'])->syncRoles($admin,$gestion);



    }
}
