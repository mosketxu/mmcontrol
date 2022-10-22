<?php

namespace App\Http\Controllers;

use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Spatie\Permission\Models\Permission;



class RoleController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:role.index')->only('index');
        $this->middleware('can:role.edit')->only('edit','update');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        $permissions=Permission::all();
        return view('seguridad.rolepermisos',compact('role','permissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        $role->permissions()->sync($request->get('permisos'));
            Artisan::call('cache:clear');
        return redirect()->route('roles.edit',$role)->with('info','Permisos Actualizados');

    }
}
