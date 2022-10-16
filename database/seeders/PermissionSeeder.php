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
        $admin=Role::find(1);
        $gestion=Role::find(2);
        $usuario=Role::find(3);

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
        Permission::create(['name'=>'permiso.index'])->syncRoles($admin,$gestion);
        Permission::create(['name'=>'permiso.create'])->syncRoles($admin,$gestion);
        Permission::create(['name'=>'permiso.edit'])->syncRoles($admin,$gestion);
        Permission::create(['name'=>'permiso.update'])->syncRoles($admin,$gestion);
        Permission::create(['name'=>'permiso.delete'])->syncRoles($admin,$gestion);
        // Permission::create(['name'=>'permiso.index','description'=>'Lista todos los permisos del sistema'])->syncRoles($admin,$gestion);
        // Permission::create(['name'=>'permiso.create','description'=>'Permite Crear un permiso'])->syncRoles($admin,$gestion);
        // Permission::create(['name'=>'permiso.edit','description'=>'Permite Editar una permiso'])->syncRoles($admin,$gestion);
        // Permission::create(['name'=>'permiso.update','description'=>'Permite Actualizar una permiso'])->syncRoles($admin,$gestion);
        // Permission::create(['name'=>'permiso.delete','description'=>'Permite Borrar un permiso'])->syncRoles($admin,$gestion);

        // Permission::create(['name'=>'user.index','description'=>'Lista todos los usuarios del sistema'])->syncRoles($admin,$gestion);
        // Permission::create(['name'=>'user.create','description'=>'Permite Crear un usuario'])->syncRoles($admin,$gestion);
        // Permission::create(['name'=>'user.edit','description'=>'Permite Editar un usuario'])->syncRoles($admin,$gestion);
        // Permission::create(['name'=>'user.update','description'=>'Permite Actualizar un usuario'])->syncRoles($admin,$gestion);
        // Permission::create(['name'=>'user.delete','description'=>'Permite Borrar un usuario'])->syncRoles($admin,$gestion);

        // // Entidades
        // Permission::create(['name'=>'entidad.index','description'=>'Lista todos las entidades del sistema'])->syncRoles($admin,$gestion);
        // Permission::create(['name'=>'entidad.create','description'=>'Permite Crear una entidad'])->syncRoles($admin,$gestion);
        // Permission::create(['name'=>'entidad.edit','description'=>'Permite Editar una entidad'])->syncRoles($admin,$gestion);
        // Permission::create(['name'=>'entidad.update','description'=>'Permite Actualizar una entidad'])->syncRoles($admin,$gestion);
        // Permission::create(['name'=>'entidad.delete','description'=>'Permite Borrar una entidad'])->syncRoles($admin,$gestion);

        // // Entidades contactos
        // Permission::create(['name'=>'entidadcontacto.index','description'=>'Lista todos los contactos de las entidades del sistema'])->syncRoles($admin,$gestion,$comercial);
        // Permission::create(['name'=>'entidadcontacto.create','description'=>'Permite Crear un contacto'])->syncRoles($admin,$gestion,$comercial);
        // Permission::create(['name'=>'entidadcontacto.edit','description'=>'Permite Editar un contacto'])->syncRoles($admin,$gestion,$comercial);
        // Permission::create(['name'=>'entidadcontacto.update','description'=>'Permite Actualizar un contacto'])->syncRoles($admin,$gestion,$comercial);
        // Permission::create(['name'=>'entidadcontacto.delete','description'=>'Permite Borrar un contacto'])->syncRoles($admin,$gestion,$comercial);

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

        // // Roles
        // Permission::create(['name'=>'role.index','description'=>'Lista todos los roles del sistema'])->syncRoles($admin,$gestion);
        // Permission::create(['name'=>'role.create','description'=>'Permite Crear un rol'])->syncRoles($admin,$gestion);
        // Permission::create(['name'=>'role.edit','description'=>'Permite Editar un rol'])->syncRoles($admin,$gestion);
        // Permission::create(['name'=>'role.update','description'=>'Permite Actualizar un rol'])->syncRoles($admin,$gestion);
        // Permission::create(['name'=>'role.delete','description'=>'Permite Borrar un rol'])->syncRoles($admin,$gestion);

        // // Permisos
        // Permission::create(['name'=>'permiso.index','description'=>'Lista todos los permisos del sistema'])->syncRoles($admin,$gestion);
        // Permission::create(['name'=>'permiso.create','description'=>'Permite Crear un permiso'])->syncRoles($admin,$gestion);
        // Permission::create(['name'=>'permiso.edit','description'=>'Permite Editar una permiso'])->syncRoles($admin,$gestion);
        // Permission::create(['name'=>'permiso.update','description'=>'Permite Actualizar una permiso'])->syncRoles($admin,$gestion);
        // Permission::create(['name'=>'permiso.delete','description'=>'Permite Borrar un permiso'])->syncRoles($admin,$gestion);

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

        // Permission::create(['name'=>'administracion','description'=>'Acceder a tablas de administracion'])->syncRoles($admin,$gestion);
        // Permission::create(['name'=>'administracion.1','description'=>'Acceder a tablas de administracion'])->syncRoles($admin,$gestion);
        // Permission::create(['name'=>'administracion.2','description'=>'Acceder a tablas de administracion'])->syncRoles($admin,$gestion);
        // Permission::create(['name'=>'administracion.3','description'=>'Acceder a tablas de administracion'])->syncRoles($admin,$gestion);
        // Permission::create(['name'=>'administracion.4','description'=>'Acceder a tablas de administracion'])->syncRoles($admin,$gestion);


    }
}
