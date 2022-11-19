<?php

use App\Http\Controllers\{RoleController, PedidoController, ProductoController, UserController,EntidadController,FacturacionController};
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
            return redirect()->route('pedido.tipo',['1','i']);
        } else {
            return redirect()->route('pedido.tipo',['1','i']);
        }
    })->name('dashboard');


    //Seguridad
    Route::get('/seguridad', function () {return view('seguridad.seguridad');})->middleware('can:seguridad.index')->name('seguridad');

    //administracion
    Route::get('/administracion/{tipo?}', function ($tipo = 'gramaje') {return view('seguridad.administracion',compact('tipo'));})->middleware('can:administracion.index')->name('administracion');

    Route::resource('roles', RoleController::class)->only(['edit','update'])->names('roles');

    //Users
    Route::resource('users', UserController::class)->except(['create'])->names('users'); //cuando es resource para aplicar seguridad can hay que hacerlo en el controller

    // Entidades
    Route::get('/entidad/contactos/{entidad}', [EntidadController::class, 'contactos'])->name('entidad.contactos');
    Route::get('/entidad/{entidad}/destinos/{ruta}', [EntidadController::class, 'destinos'])->name('entidad.destinos');
    Route::get('/entidad/nuevocontacto/{entidad}', [EntidadController::class, 'createcontacto'])->name('entidad.createcontacto');
    Route::get('entidad/{tipo}/tipo', [EntidadController::class,'tipo'])->middleware('can:entidad.index')->name('entidad.tipo'); //
    Route::get('entidad/{entidadtipo_id}/nueva', [EntidadController::class,'nueva'])->name('entidad.nueva');
    Route::resource('entidad', EntidadController::class)->only(['index','create', 'edit']); //cuando es resource para aplicar seguridad can hay que hacerlo en el controller


    // Producto
    Route::get('producto/{producto}/adjunto', [ProductoController::class,'adjunto'])->name('producto.adjunto');
    Route::get('producto/{prodId}/ficha/{tipo}', [ProductoController::class,'ficha'])->name('producto.ficha');
    Route::get('producto/{tipo}', [ProductoController::class,'tipo'])->middleware('can:producto.index')->name('producto.tipo');;
    Route::get('/producto/{producto}/archivos/{ruta}', [ProductoController::class, 'archivos'])->name('producto.archivos');
    Route::get('/producto/{tipo}/nuevo', [ProductoController::class, 'nuevo'])->name('producto.nuevo');
    Route::resource('producto', ProductoController::class);

    //Pedidos
    Route::get('/pedido/{pedido}/editar/{ruta}', [PedidoController::class, 'editar'])->name('pedido.editar');
    Route::get('/pedido/{pedido}/{ruta}/presupuesto/{pedidopresupuestoid}', [PedidoController::class, 'presupuesto'])->name('pedido.presupuesto');
    Route::get('/pedido/{pedido}/presupuestos/{ruta}', [PedidoController::class, 'presupuestos'])->name('pedido.presupuestos');
    Route::get('/pedido/{pedido}/retrasos/{ruta}', [PedidoController::class, 'retrasos'])->name('pedido.retrasos');
    Route::get('/pedido/{pedido}/incidencias/{ruta}', [PedidoController::class, 'incidencias'])->name('pedido.incidencias');
    Route::get('/pedido/{pedido}/parciales/{ruta}', [PedidoController::class, 'parciales'])->name('pedido.parciales');
    Route::get('/pedido/{pedido}/parciales/{ruta}/parcial/{parcialid}', [PedidoController::class, 'parcial'])->name('pedido.parcial');
    Route::get('/pedido/parcial/{parcialid}/albaran', [PedidoController::class, 'albaran'])->name('pedido.albaran');
    Route::get('/pedido/{pedido}/facturaciones/{ruta}', [PedidoController::class, 'facturaciones'])->name('pedido.facturaciones');
    Route::get('/pedido/{pedido}/distribuciones/{ruta}', [PedidoController::class, 'distribuciones'])->name('pedido.distribuciones');
    Route::get('/pedido/{pedido}/archivos/{ruta}', [PedidoController::class, 'archivos'])->name('pedido.archivos');
    Route::get('/pedido/{tipo}/nuevo', [PedidoController::class, 'nuevo'])->name('pedido.nuevo');
    Route::get('pedido/{tipo}/ruta/{ruta}', [PedidoController::class,'tipo'])->middleware('can:pedido.index')->name('pedido.tipo');;
    Route::resource('pedido', PedidoController::class);

    //Facturacion
    Route::resource('facturacion', FacturacionController::class);


});
