<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Routing\Controllers\Middleware;

class UserController extends Controller
{
    public static function middleware(): array {
        return [
            // examples with aliases, pipe-separated names, guards, etc:
            /* 'role_or_permission:manager|edit articles', */
            new Middleware('permission:view user', only: ['index']),
            new Middleware('permission:create user', only: ['create', 'store']),
            new Middleware('permission:update user', only: ['update', 'edit']),
            new Middleware('permission:	delete user', only: ['destroy']),
            
    /*         new Middleware(\Spatie\Permission\Middleware\RoleMiddleware::using('manager'), except:['show']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('delete records,api'), only:['destroy']), */
            ];
        }
    public function index(){
        $users = User::get(); 
        return view('role-permission.user.index', [
            'users' => $users
        ]);
    }

/*     public function create(){
        $roles = Role::pluck('name', 'id'); // Pluck 'id' as the key and 'name' as the value
        return view('role-permission.user.create', [
            'roles' => $roles
        ]);
    } */

    public function create(){
        $roles = Role::pluck('name', 'id'); // Pluck 'id' as the key and 'name' as the value
        return view('role-permission.user.create', [
            'roles' => $roles
        ]);
    }

/*     public function store(Request $request){
        $request->validate([
            'name' => ['required', 'string', 'unique:roles,name'],
            'email' => ['required', 'string', 'unique:users,email'],
            'password' => ['required', 'string'],
            'roles' => ['required']
        ]);

        $user = User::create([ 
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        $user->syncRoles($request->roles);
        return redirect('/users')->with('status', 'User added successfully');
    } */

    public function store(Request $request){
        $request->validate([
            'name' => ['required', 'string', 'unique:users,name'],
            'email' => ['required', 'string', 'unique:users,email'],
            'password' => ['required', 'string'],
            'roles' => ['required', 'array'],
        ]);
    
        $user = User::create([ 
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        $user->syncRoles($request->roles); // Sync roles using their IDs
        return redirect('/users')->with('status', 'User added successfully');
    }

    public function edit(User $user){
        $roles = Role::pluck('name', 'name')->all();
        $userRoles = $user->roles->pluck('name', 'name')->all();  
        return view('role-permission.user.edit', [   
            'user' => $user,
            'roles' => $roles,  // Fixed key name to 'roles'
            'userRoles' => $userRoles
        ]);
    }

    public function update(Request $request, User $user){
        $request->validate([
            'name' => ['required', 'string'],
            'email' => ['required', 'string'],
            'password' => ['nullable', 'string'], 
            'roles' => ['required']
        ]);

        $data = [
            'name' => $request->name, 
            'email' => $request->email,
        ];

        if (!empty($request->password)) {
            $data = array_merge($data, [
                'password' => Hash::make($request->password),
            ]);
        }

        $user->update($data);
        $user->syncRoles($request->roles);

        return redirect('users')->with('status', 'User updated successfully');
    }

    public function destroy($id){
    $user = User::findOrFail($id);

    // Optional: Check if the user can be deleted (e.g., not deleting an admin)
    if ($user->hasRole('admin')) {
        return redirect()->back()->with('error', 'Cannot delete admin users.');
    }

    $user->delete();

    return redirect('users')->with('status', 'User deleted successfully');
    }     

    }   
