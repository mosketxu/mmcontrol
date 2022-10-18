<?php

use App\Http\Controllers\{RoleController, PedidoController, ProductoController, UserController,EntidadController,EntidadContactoController};
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
        return redirect()->route('entidad.tipo','2');
    })->name('dashboard');

    // Route::get('/pedidos', function () {
    //     if (Auth::user()->hasRole('Usuario')) {
    //         return redirect()->route('dashboard');
    //     } elseif (Auth::user()->hasRole('Gestion')) {
    //         return redirect()->route('pedidos.index');
    //     } else {
    //         return redirect()->route('pedidos.index');
    //     }
    // })->name('pedidos');

    //Seguridad
    Route::get('/seguridad', function () {return view('seguridad.seguridad');})->middleware('can:seguridad.index')->name('seguridad');

    Route::resource('roles', RoleController::class)->only(['edit','update'])->names('roles');

    //Users
    Route::resource('users', UserController::class)->except(['create'])->names('users'); //cuando es resource para aplicar seguridad can hay que hacerlo en el controller

    // Entidades
    Route::get('entidad/{tipo}/tipo', [EntidadController::class,'tipo'])->middleware('can:entidad.index')->name('entidad.tipo'); //
    Route::get('entidad/{entidadtipo_id}/nueva', [EntidadController::class,'nueva'])->name('entidad.nueva');
    Route::resource('entidad', EntidadController::class)->only(['index','create', 'edit']); //cuando es resource para aplicar seguridad can hay que hacerlo en el controller

    //Entidades contacto
    Route::get('entidadcontacto/{entidad}/nuevo', [EntidadContactoController::class,'nuevo'])->name('entidadcontacto.nuevo');
    Route::resource('entidadcontacto', EntidadContactoController::class)->only(['show','edit','store']);

    // Producto
    Route::resource('producto', ProductoController::class);

    //Pedidos
    Route::resource('pedido', PedidoController::class);



});
