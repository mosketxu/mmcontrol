<?php

use App\Http\Controllers\{RoleController, PedidoController, ProductoController, UserController,EntidadController,FacturacionController, OfertaController, PresupuestoController,ClienteController,MailController};
use App\Models\UserEmpresa;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::middleware(['auth:sanctum',config('jetstream.auth_session'),'verified'])->group(function () {
    // Route::get('/dashboard', function () {return view('dashboard');})->name('dashboard');
    Route::get('/dashboard', function () {
        if (Auth::user()->hasRole('Admin')) {
            return redirect()->route('seguridad');
        } elseif (Auth::user()->hasRole('Gestor')) {
            return redirect()->route('presupuesto.tipo',['1','i']);
        } elseif (Auth::user()->hasRole('Cliente')) {
            // return redirect()->route('cliente.pedido.tipo',['1','i']);
            return redirect()->route('cliente.entidad.index'    );
        } else {
            return redirect()->route('presupuesto.tipo',['1','i']);
        }
    })->name('dashboard');


    //Seguridad
    Route::get('/seguridad', function () {return view('seguridad.seguridad');})->middleware('can:seguridad.index')->name('seguridad');

    //caracteristicas
    Route::get('/caracteristicas/{tipo?}', function ($tipo = 'gramaje') {return view('seguridad.caracteristicas',compact('tipo'));})->middleware('can:caracteristicas.index')->name('caracteristicas');

    //Roles
    Route::resource('roles', RoleController::class)->only(['edit','update'])->names('roles');

    //Users
    Route::resource('users', UserController::class)->except(['create'])->names('users'); //cuando es resource para aplicar seguridad can hay que hacerlo en el controller


    // Entidades
    Route::get('/entidad/editar/{entidad}', [EntidadController::class, 'edita'])->name('entidad.edita');
    Route::get('/entidad/contactos/{entidad}', [EntidadController::class, 'contactos'])->name('entidad.contactos');
    Route::get('/entidad/{entidad}/destinos/{ruta}', [EntidadController::class, 'destinos'])->name('entidad.destinos');
    Route::get('/entidad/nuevocontacto/{entidad}', [EntidadController::class, 'createcontacto'])->name('entidad.createcontacto');
    Route::get('entidad/{tipo}/tipo', [EntidadController::class,'tipo'])->middleware('can:entidad.index')->name('entidad.tipo'); //
    Route::get('entidad/{entidadtipo_id}/nueva', [EntidadController::class,'nueva'])->name('entidad.nueva');
    Route::resource('entidad', EntidadController::class)->only(['index','create', 'edit']); //cuando es resource para aplicar seguridad can hay que hacerlo en el controller


    // Producto
    // Route::get('producto/{producto}/adjunto', [ProductoController::class,'adjunto'])->name('producto.adjunto');
    Route::get('producto/{prodId}/ficha/{tipo}/{tipopdf}', [ProductoController::class,'ficha'])->name('producto.ficha');
    Route::get('producto/{tipo}', [ProductoController::class,'tipo'])->middleware('can:producto.index')->name('producto.tipo');
    Route::get('/producto/{producto}/archivos/{ruta}', [ProductoController::class, 'archivos'])->name('producto.archivos');
    Route::get('/producto/{tipo}/nuevo', [ProductoController::class, 'nuevo'])->name('producto.nuevo');
    Route::resource('producto', ProductoController::class);

    //Presupuestos
    Route::get('presupuesto/{tipo}/ruta/{ruta}', [PresupuestoController::class,'tipo'])->middleware('can:presupuesto.index')->name('presupuesto.tipo');
    Route::get('/presupuesto/{tipo}/nuevo/{ruta}', [PresupuestoController::class, 'nuevo'])->name('presupuesto.nuevo');
    Route::get('/presupuesto/{presupuesto}/pdf', [PresupuestoController::class, 'presupuestoPDF'])->name('presupuesto.presupuestoPDF');
    Route::get('/presupuesto/{presupuesto}/editar/{ruta}', [PresupuestoController::class, 'editar'])->name('presupuesto.editar');
    Route::get('/presupuesto/{presupuesto}/archivos/{ruta}', [PresupuestoController::class, 'archivos'])->name('presupuesto.archivos');

    //Pedidos
    // Route::get('/pedido/contadores', [PedidoController::class, 'contadores'])->name('pedido.contadores');
    Route::get('/pedido/{tipo}/{search?}/{fref?}/{fisbn?}/{fresp?}/{fcli?}/{fprov?}/{fanyo?}/{fmes?}/{festado?}/{ffact?}/export', [PedidoController::class, 'export'])->name('pedido.export');
    Route::get('/pedido/{pedido}/entrada/{tipo}/{ruta}', [PedidoController::class, 'entrada'])->name('pedido.entrada');
    Route::get('/pedido/{pedido}/editar/{ruta}', [PedidoController::class, 'editar'])->name('pedido.editar');
    Route::get('/pedido/{pedido}/retrasos/{ruta}', [PedidoController::class, 'retrasos'])->name('pedido.retrasos');
    Route::get('/pedido/{pedido}/incidencias/{ruta}', [PedidoController::class, 'incidencias'])->name('pedido.incidencias');
    Route::get('/pedido/{pedido}/parciales/{ruta}', [PedidoController::class, 'parciales'])->name('pedido.parciales');
    Route::get('/pedido/{pedido}/parciales/{ruta}/parcial/{parcialid}', [PedidoController::class, 'parcial'])->name('pedido.parcial');
    Route::get('/pedido/parcial/{pedidoid}/{ruta}/albaran/{parcialid}', [PedidoController::class, 'albaran'])->name('pedido.albaran');
    Route::get('/pedido/{pedido}/facturaciones/{ruta}', [PedidoController::class, 'facturaciones'])->name('pedido.facturaciones');
    Route::get('/pedido/{pedido}/distribuciones/{ruta}', [PedidoController::class, 'distribuciones'])->name('pedido.distribuciones');
    Route::get('/pedido/{pedido}/archivos/{ruta}', [PedidoController::class, 'archivos'])->name('pedido.archivos');
    Route::get('/pedido/{tipo}/nuevo/{ruta}', [PedidoController::class, 'nuevo'])->name('pedido.nuevo');
    Route::get('pedido/{tipo}/ruta/{ruta}', [PedidoController::class,'tipo'])->middleware('can:pedido.index')->name('pedido.tipo');
    Route::resource('pedido', PedidoController::class);

    //Facturacion
    Route::resource('facturacion', FacturacionController::class);

    //Oferta
    Route::get('/oferta/{oferta}/editar/{ruta}', [OfertaController::class, 'editar'])->name('oferta.editar');
    Route::get('oferta/{ofertaId}/ficha/{tipo}', [OfertaController::class,'ficha'])->name('oferta.ficha');
    Route::get('/oferta/{tipo}/nuevo/{ruta}', [OfertaController::class, 'nuevo'])->name('oferta.nuevo');
    Route::get('oferta/{tipo}', [OfertaController::class,'tipo'])->middleware('can:oferta.index')->name('oferta.tipo');
    Route::resource('oferta', OfertaController::class);

    //Cliente
        // Entidades a las que accede el usuario invitado
        Route::get('cliente/entidad/index', [ClienteController::class,'entidadIndex'])->middleware('can:cliente.entidad.index')->name('cliente.entidad.index');

        // Productos a las que accede el usuario invitado
        Route::get('cliente/producto/{tipo}', [ClienteController::class,'productotipo'])->middleware('can:cliente.producto.index')->name('cliente.producto.tipo');
        Route::get('cliente/producto/{producto}/edit', [ClienteController::class,'productoedit'])->middleware('can:cliente.producto.index')->name('cliente.producto.edit');
        Route::get('cliente/producto/{prodId}/ficha/{tipo}/{tipopdf}', [ClienteController::class,'productoficha'])->middleware('can:cliente.producto.index')->name('cliente.producto.ficha');
        Route::get('cliente/producto/{producto}/archivos/{ruta}', [ClienteController::class, 'productoarchivos'])->middleware('can:cliente.producto.index')->name('cliente.producto.archivos');

        // Presupuestos a las que accede el usuario invitado
        Route::get('cliente/presupuesto/{tipo}/ruta/{ruta}', [ClienteController::class,'presupuestotipo'])->middleware('can:cliente.presupuesto.index')->name('cliente.presupuesto.tipo');
        Route::get('cliente/presupuesto/{presupuesto}/editar/{ruta}', [ClienteController::class, 'presupuestoeditar'])->middleware('can:cliente.presupuesto.index')->name('cliente.presupuesto.editar');
        Route::get('cliente/presupuesto/{presupuesto}/pdf', [ClienteController::class, 'presupuestoPDF'])->name('cliente.presupuesto.presupuestoPDF');



        // Ofertas a las que accede el usuario invitado
        Route::get('cliente/oferta/{tipo}', [ClienteController::class,'ofertatipo'])->middleware('can:cliente.oferta.index')->name('cliente.oferta.tipo');
        Route::get('cliente/oferta/{oferta}/editar/{ruta}', [ClienteController::class, 'ofertaeditar'])->middleware('can:cliente.oferta.index')->name('cliente.oferta.editar');
        Route::get('cliente/oferta/{ofertaId}/ficha/{tipo}', [ClienteController::class,'ofertaficha'])->name('cliente.oferta.ficha');

        // Pedidos a las que accede el usuario invitado
        Route::get('cliente/pedido/{tipo}/ruta/{ruta}', [ClienteController::class,'pedidotipo'])->middleware('can:cliente.pedido.index')->name('cliente.pedido.tipo');
        Route::get('cliente/pedido/{pedido}/editar/{ruta}', [ClienteController::class, 'pedidoeditar'])->middleware('can:cliente.pedido.index')->name('cliente.pedido.editar');

        // Facturas a las que accede el usuario invitado
        Route::get('cliente/facturacion', [ClienteController::class,'facturacionindex'])->middleware('can:cliente.facturacion.index')->name('cliente.facturacion.index');
        // Route::get('cliente/facturacion/{factura}/edit', [ClienteController::class,'facturacionedit'])->middleware('can:cliente.facturacion.index')->name('cliente.facturacion.edit');
        Route::get('cliente/facturacion/{factura}/show', [ClienteController::class,'facturacionshow'])->middleware('can:cliente.facturacion.index')->name('cliente.facturacion.show');

    // Correo
        Route::get('sendemail',[MailController::class,'sendEmail']);

    });
