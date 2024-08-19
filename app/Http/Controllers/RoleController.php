<?php

namespace App\Http\Controllers;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Routing\Controllers\Middleware;



class RoleController extends Controller
{

/*     public function __construct()
    {
        $this->middleware('permission:Delete Role', ['only'=>['destroy']]);
        $this->middleware('permission:Update Role', ['only'=>['update', 'edit']]);
    } */

    public static function middleware(): array {
    return [
        // examples with aliases, pipe-separated names, guards, etc:
        /* 'role_or_permission:manager|edit articles', */
        new Middleware('permission:view role', only: ['index']),
        new Middleware('permission:Create Role', only: ['create', 'store', 'givePermission', 'updatePermissionToRole']),
        new Middleware('permission:Update Role', only: ['update', 'edit']),
        new Middleware('permission:Delete Role', only: ['destroy']),
        
/*         new Middleware(\Spatie\Permission\Middleware\RoleMiddleware::using('manager'), except:['show']),
        new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('delete records,api'), only:['destroy']), */
        ];
    }

    public function index(){
        $roles = Role::get();
        return view('role-permission.role.index', [
            'roles' => $roles 
        ]);
    }

    public function create(){
        return view('role-permission.role.create');
    }

    public function store(Request $request){
        $request->validate([
            'name' => ['required', 'string', 'unique:roles,name']
        ]);

        Role::create([
            'name' => $request->name 
        ]);

        return redirect('roles')->with('status', 'Role added successfully');
    }

    public function edit(Role $role){
        return view('role-permission.role.edit', [
            'role' => $role
        ]);
    }

    public function update(Request $request, Role $role){
        $request->validate([
            'name' => ['required', 'string', 'unique:roles,name,' . $role->id]
        ]);

        $role->update([
            'name' => $request->name 
        ]);

        return redirect('roles')->with('status', 'Role updated successfully');
    }

    public function destroy($roleId){
        $role = Role::find($roleId);
        $role->delete();
        return redirect('roles')->with('status', 'Role deleted successfully');
    }

    public function givePermission($roleId){
        $permissions = Permission::get();
        $role = Role::findOrFail($roleId);
        return view('role-permission.role.add-permission', [
            'role' => $role,
            'permissions' => $permissions
        ]);
    }

    public function updatePermissionToRole(Request $request, $roleId){
        $request->validate([
            'permissions' => 'required|array',
        ]);

        $role = Role::findOrFail($roleId);
        $role->syncPermissions($request->permissions);

        return redirect()->back()->with('status', 'Permissions updated successfully');
    }
}