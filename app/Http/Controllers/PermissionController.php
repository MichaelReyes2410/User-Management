<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Illuminate\Routing\Controllers\Middleware;

class PermissionController extends Controller
{
    public static function middleware(): array {
        return [
            // examples with aliases, pipe-separated names, guards, etc:
            /* 'role_or_permission:manager|edit articles', */
            new Middleware('permission:view permission', only: ['index']),
            new Middleware('permission:Create Permission', only: ['create', 'store']),
            new Middleware('permission:Update Permission', only: ['update', 'edit']),
            new Middleware('permission:Delete Permission', only: ['destroy']),
            
    /*         new Middleware(\Spatie\Permission\Middleware\RoleMiddleware::using('manager'), except:['show']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('delete records,api'), only:['destroy']), */
            ];
        }

    
    public function index(){
        $permissions = Permission::all();
     //   return view('role-permission.permission.index', compact('permissions'));
        return view('role-permission.permission.index', [
            'permissions' => $permissions 
        ]);
    }

    public function create(){
        return view('role-permission.permission.create');
    }

    public function store(Request $request){
        $request->validate([
            'name' => ['required', 'string', 'unique:permissions,name']
        ]);

        Permission::create([
            'name' => $request->name 
        ]);

        return redirect('permissions')->with('status', 'Added successfully');
    }

    public function edit(Permission $permission){
     //   return view('role-permission.permission.edit', compact('permission'));
        return view('role-permission.permission.edit', [
            'permission' => $permission
        ]);
    }

    public function update(Request $request, Permission $permission){
        $request->validate([
            'name' => ['required', 'string', 'unique:permissions,name,' . $permission->id]
        ]);

        $permission->update([
            'name' => $request->name 
        ]);

        return redirect('permissions')->with('status', 'Updated successfully');
    }

    public function destroy($permissionId){
        $permission = Permission::find($permissionId);
        $permission->delete();
        return redirect('permissions')->with('status', 'Deleted successfully');
    }
}
