<?php

use App\Http\Controllers\{RoleController, PedidoController};
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
    Route::get('/dashboard', function () {return view('dashboard');})->name('dashboard');
    Route::get('/pedidos', function () {
        if (Auth::user()->hasRole('Usuario')) {
            return redirect()->route('dashboard');
        } elseif (Auth::user()->hasRole('Gestion')) {
            return redirect()->route('pedidos.index');
        } else {
            return redirect()->route('pedidos.index');
        }
    })->name('pedidos');

    //Seguridad
    Route::get('/seguridad', function () {return view('seguridad');})->name('seguridad');

    // Route::resource('roles', RoleController::class)->names('roles');
    // Route::get('administracion', [AdministracionController::class,'index'])->middleware('can:administracion')->name('administracion.index');

    //Users
    // Route::resource('users', UserController::class)->names('users'); //cuando es resource para aplicar seguridad can hay que hacerlo en el controller

    //Pedidos
    Route::resource('pedido', PedidoController::class);

});
